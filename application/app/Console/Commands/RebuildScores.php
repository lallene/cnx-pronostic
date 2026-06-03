<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Prediction;
use App\Models\UserScore;

class RebuildScores extends Command
{
    protected $signature = 'scores:rebuild';

    protected $description = 'Rebuild all leaderboard scores';

   public function handle()
{
    \App\Models\UserScore::truncate();

    $users = \App\Models\User::all();

    foreach ($users as $user) {

        $correct = \App\Models\Prediction::join(
                'resultats',
                'predictions.match_id',
                '=',
                'resultats.match_id'
            )
            ->where('predictions.user_id', $user->id)
            ->whereColumn('predictions.prediction', 'resultats.resultat')
            ->count();

        $total = \App\Models\Prediction::where('user_id', $user->id)
            ->count();

        $points = \App\Models\Prediction::join(
                'resultats',
                'predictions.match_id',
                '=',
                'resultats.match_id'
            )
            ->join(
                'matches',
                'predictions.match_id',
                '=',
                'matches.id'
            )
            ->where('predictions.user_id', $user->id)
            ->whereColumn('predictions.prediction', 'resultats.resultat')
            ->sum(
                \Illuminate\Support\Facades\DB::raw(
                    '3 * COALESCE(matches.coefficient, 1)'
                )
            );

        \App\Models\UserScore::create([
            'user_id' => $user->id,
            'points' => $points,
            'correct_predictions' => $correct,
            'total_predictions' => $total,
        ]);
    }

    $scores = \App\Models\UserScore::join(
            'users',
            'user_scores.user_id',
            '=',
            'users.id'
        )
        ->orderByDesc('user_scores.points')
        ->orderByDesc('users.xp')
        ->orderByDesc('users.best_streak')
        ->orderBy('users.lose_streak')
        ->orderBy('users.name')
        ->select('user_scores.*')
        ->get();

    foreach ($scores as $index => $score) {
        \App\Models\UserScore::where('id', $score->id)
            ->update([
                'rank' => $index + 1,
            ]);
    }

    app(\App\Services\GamificationService::class)
        ->rebuildServiceScores();

    $this->info('Scores and ranks rebuilt successfully.');
}
}
