<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\Duel;
use App\Models\GamificationEvent;
use App\Models\Prediction;
use App\Models\Resultat;
use App\Models\User;
use App\Models\ServiceScore;
use Illuminate\Support\Facades\Cache;

class GamificationService
{
    public function processMatch(int $matchId): void
    {
        $result = Resultat::where('match_id', $matchId)->first();

        if (!$result) {
            return;
        }

        $predictions = Prediction::with('user')->where('match_id', $matchId)->where('gamification_processed', false)->get();

        foreach ($predictions as $prediction) {
            $user = $prediction->user;

            if (!$user) {
                continue;
            }

            $isCorrect = (string) $prediction->prediction === (string) $result->resultat;

            if ($isCorrect) {
                
                $coefficient = $prediction->matche->coefficient ?? 1;
                $xpGain = 10 * $coefficient;

                $user->current_streak = ($user->current_streak ?? 0) + 1;
                $user->best_streak = max($user->best_streak ?? 0, $user->current_streak);
                $user->lose_streak = 0;

                if ($user->current_streak >= 3) {
                    $xpGain += 5;
                }

                if ($user->current_streak >= 5) {
                    $xpGain += 10;
                }

                $user->xp = ($user->xp ?? 0) + $xpGain;

                GamificationEvent::create([
                    'user_id' => $user->id,
                    'type' => 'xp',
                    'title' => 'Bon pronostic',
                    'message' => 'Tu as gagné ' . $xpGain . ' XP grâce à ton bon pronostic.',
                    'xp' => $xpGain,
                    'points' => 3,
                ]);
            } else {
                $user->lose_streak = ($user->lose_streak ?? 0) + 1;
                $user->best_lose_streak = max($user->best_lose_streak ?? 0, $user->lose_streak);
                $user->current_streak = 0;
            }

            $user->level = floor(($user->xp ?? 0) / 100) + 1;
            $user->save();

            $this->refreshUserScore($user);

            $prediction->gamification_processed = true;
            $prediction->save();

            $this->assignBadges($user);
        }

        $this->processDuels($matchId);
        $this->refreshRanks();
        $this->refreshServiceScores();
        Cache::forget('classement_global');
        Cache::forget('classement_services');
        Cache::forget('matches_with_results');
    }

    private function assignBadges(User $user): void
    {
        $correctPredictions = Prediction::join('resultats', 'predictions.match_id', '=', 'resultats.match_id')->where('predictions.user_id', $user->id)->whereColumn('predictions.prediction', 'resultats.resultat')->count();

        $totalPredictions = Prediction::where('user_id', $user->id)->where('gamification_processed', true)->count();

        $badges = [
            'first_win' => $correctPredictions >= 1,
            'five_wins' => $correctPredictions >= 5,
            'ten_wins' => $correctPredictions >= 10,
            'twenty_wins' => $correctPredictions >= 20,

            'streak_3' => ($user->current_streak ?? 0) >= 3,
            'streak_5' => ($user->current_streak ?? 0) >= 5,
            'streak_10' => ($user->current_streak ?? 0) >= 10,

            'cold_3' => ($user->lose_streak ?? 0) >= 3,
            'cold_5' => ($user->lose_streak ?? 0) >= 5,

            'rookie' => ($user->xp ?? 0) >= 50,
            'expert' => ($user->xp ?? 0) >= 250,
            'legend' => ($user->xp ?? 0) >= 500,

            'participation_10' => $totalPredictions >= 10,
            'participation_50' => $totalPredictions >= 50,
        ];

        foreach ($badges as $key => $condition) {
            if (!$condition) {
                continue;
            }

            $badge = Badge::where('condition_key', $key)->first();

            if (!$badge) {
                continue;
            }

            $alreadyOwned = $user->badges()->where('badge_id', $badge->id)->exists();

            if (!$alreadyOwned) {
                $user->badges()->attach($badge->id);

                GamificationEvent::create([
                    'user_id' => $user->id,
                    'type' => 'badge',
                    'title' => 'Badge débloqué',
                    'message' => 'Tu as débloqué le badge ' . $badge->icon . ' ' . $badge->name,
                ]);
            }
        }

        $this->assignServiceBadge($user);
    }

    private function assignServiceBadge(User $user): void
    {
        if (!$user->projet_service) {
            return;
        }

        $topUserId = User::where('projet_service', $user->projet_service)->orderByDesc('xp')->value('id');

        if ($topUserId !== $user->id) {
            return;
        }

        $badge = Badge::where('condition_key', 'service_mvp')->first();

        if (!$badge) {
            return;
        }

        $alreadyOwned = $user->badges()->where('badge_id', $badge->id)->exists();

        if (!$alreadyOwned) {
            $user->badges()->attach($badge->id);

            GamificationEvent::create([
                'user_id' => $user->id,
                'type' => 'badge',
                'title' => 'MVP Service',
                'message' => 'Tu es devenu MVP de ton service.',
            ]);
        }
    }

    private function processDuels(int $matchId): void
    {
        $result = Resultat::where('match_id', $matchId)->first();

        if (!$result) {
            return;
        }

        $duels = Duel::where('match_id', $matchId)->where('status', 'accepted')->whereNull('winner_id')->get();

        foreach ($duels as $duel) {
            $challengerWin = (string) $duel->challenger_prediction === (string) $result->resultat;
            $opponentWin = (string) $duel->opponent_prediction === (string) $result->resultat;

            if ($challengerWin && !$opponentWin) {
                $winner = User::find($duel->challenger_id);
                $loser = User::find($duel->opponent_id);
            } elseif ($opponentWin && !$challengerWin) {
                $winner = User::find($duel->opponent_id);
                $loser = User::find($duel->challenger_id);
            } else {
                $duel->update([
                    'status' => 'resolved',
                ]);

                continue;
            }

            if (!$winner || !$loser) {
                continue;
            }

            $winnerXpGain = $duel->xp_bet * 2;
            $loserXpLoss = min($loser->xp ?? 0, $duel->xp_bet);

            $winner->increment('xp', $winnerXpGain);
            $loser->decrement('xp', $loserXpLoss);

            $winner->update([
                'level' => floor(($winner->fresh()->xp ?? 0) / 100) + 1,
            ]);

            $loser->update([
                'level' => floor(($loser->fresh()->xp ?? 0) / 100) + 1,
            ]);

            GamificationEvent::create([
                'user_id' => $winner->id,
                'type' => 'duel_win',
                'title' => 'Duel remporté',
                'message' => 'Tu as remporté le duel et gagné ' . $winnerXpGain . ' XP.',
                'xp' => $winnerXpGain,
            ]);

            GamificationEvent::create([
                'user_id' => $loser->id,
                'type' => 'duel_loss',
                'title' => 'Duel perdu',
                'message' => 'Tu as perdu ' . $loserXpLoss . ' XP en duel.',
                'xp' => -$loserXpLoss,
            ]);

            $duel->update([
                'status' => 'resolved',
                'winner_id' => $winner->id,
            ]);
        }
    }

    private function refreshUserScore(User $user): void
    {
        $correct = Prediction::join('resultats', 'predictions.match_id', '=', 'resultats.match_id')->where('predictions.user_id', $user->id)->whereColumn('predictions.prediction', 'resultats.resultat')->count();

        $total = Prediction::where('user_id', $user->id)->count();

        $points = Prediction::join('resultats', 'predictions.match_id', '=', 'resultats.match_id')->join('matches', 'predictions.match_id', '=', 'matches.id')->where('predictions.user_id', $user->id)->whereColumn('predictions.prediction', 'resultats.resultat')->sum(\Illuminate\Support\Facades\DB::raw('3 * COALESCE(matches.coefficient,1)'));

        \App\Models\UserScore::updateOrCreate(
            ['user_id' => $user->id],
            [
                'points' => $points,
                'correct_predictions' => $correct,
                'total_predictions' => $total,
            ],
        );
    }

    private function refreshRanks(): void
    {
        $scores = \App\Models\UserScore::query()->join('users', 'user_scores.user_id', '=', 'users.id')->orderByDesc('user_scores.points')->orderByDesc('users.xp')->orderByDesc('users.best_streak')->orderBy('users.lose_streak')->orderBy('users.name')->orderBy('users.id')->select('user_scores.*')->get();

        foreach ($scores as $index => $score) {
            \App\Models\UserScore::where('id', $score->id)->update([
                'rank' => $index + 1,
            ]);
        }
    }
    private function refreshServiceScores(): void
    {
        ServiceScore::truncate();

        $services = $this->calculateServiceScores();

        foreach ($services as $index => $service) {
            ServiceScore::create([
                'service' => $service->service,
                'nb_users' => $service->nb_users,
                'participants' => $service->participants,
                'nb_matches_joues' => $service->nb_matches_joues,
                'total_pronostics' => $service->total_pronostics,
                'correct_predictions' => $service->correct_predictions,
                'points' => $service->points,
                'participation_ratio' => $service->participation_ratio,
                'precision_ratio' => $service->precision_ratio,
                'global_score' => $service->global_score,
                'rank' => $index + 1,
            ]);
        }
    }

    private function calculateServiceScores()
    {
        $matchIds = \App\Models\Matche::whereHas('resultat')->pluck('id');
        $nbMatchesJoues = $matchIds->count();

        if ($nbMatchesJoues === 0) {
            return collect();
        }

        return \Illuminate\Support\Facades\DB::table('users')
            ->leftJoin('predictions', function ($join) use ($matchIds) {
                $join->on('users.id', '=', 'predictions.user_id')->whereIn('predictions.match_id', $matchIds);
            })
            ->leftJoin('resultats', 'predictions.match_id', '=', 'resultats.match_id')
            ->leftJoin('matches', 'predictions.match_id', '=', 'matches.id')
            ->whereNotNull('users.projet_service')
            ->select(
                'users.projet_service as service',

                \Illuminate\Support\Facades\DB::raw('COUNT(DISTINCT users.id) as nb_users'),

                \Illuminate\Support\Facades\DB::raw('COUNT(DISTINCT predictions.user_id) as participants'),

                \Illuminate\Support\Facades\DB::raw('COUNT(predictions.id) as total_pronostics'),

                \Illuminate\Support\Facades\DB::raw(
                    'SUM(
                    CASE
                        WHEN predictions.prediction = resultats.resultat
                        THEN 1
                        ELSE 0
                    END
                ) as correct_predictions',
                ),

                \Illuminate\Support\Facades\DB::raw(
                    'SUM(
                    CASE
                        WHEN predictions.prediction = resultats.resultat
                        THEN (3 * COALESCE(matches.coefficient,1))
                        ELSE 0
                    END
                ) as weighted_points',
                ),
            )
            ->groupBy('users.projet_service')
            ->get()
            ->map(function ($service) use ($nbMatchesJoues) {
                $points = $service->weighted_points;

                $possiblePronostics = $service->nb_users * $nbMatchesJoues;

                $participationRatio = $possiblePronostics > 0 ? round(($service->total_pronostics / $possiblePronostics) * 100, 2) : 0;

                $precisionRatio = $service->total_pronostics > 0 ? round(($service->correct_predictions / $service->total_pronostics) * 100, 2) : 0;

                $globalScore = round($precisionRatio * 0.7 + $participationRatio * 0.3, 2);

                return (object) [
                    'service' => $service->service,
                    'nb_users' => $service->nb_users,
                    'participants' => $service->participants,
                    'nb_matches_joues' => $nbMatchesJoues,
                    'total_pronostics' => $service->total_pronostics,
                    'correct_predictions' => $service->correct_predictions,
                    'points' => $points,
                    'participation_ratio' => $participationRatio,
                    'precision_ratio' => $precisionRatio,
                    'global_score' => $globalScore,
                ];
            })
            ->sortByDesc('global_score')
            ->values();
    }

    public function rebuildServiceScores(): void
    {
        $this->refreshServiceScores();
    }

    public function rebuildScores(): void
    {
        \Illuminate\Support\Facades\Artisan::call('scores:rebuild');
    }
}
