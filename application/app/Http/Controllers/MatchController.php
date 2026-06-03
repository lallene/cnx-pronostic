<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matche;
use App\Models\Team;
use App\Models\Prediction;
use App\Models\Resultat;
use App\Models\Badge;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class MatchController extends Controller
{
    public function index()
    {
        $matches = Matche::orderBy('match_date', 'asc')->get();
        $teams = Team::orderBy('name', 'asc')->get();

        return view('match.index', compact('matches', 'teams'));
    }

    public function create(Request $request)
    {
        $request->validate(
            [
                'home_team' => 'required|string|different:away_team',
                'away_team' => 'required|string',
                'match_date' => 'required|date|after_or_equal:now',
                'phase' => 'required|string',
            ],
            [
                'home_team.different' => "L'équipe domicile et l'équipe extérieure doivent être différentes.",
                'match_date.after_or_equal' => "La date du match ne peut pas être antérieure à aujourd'hui.",
            ],
        );

        $homeTeam = Team::where('name', $request->home_team)->firstOrFail();
        $awayTeam = Team::where('name', $request->away_team)->firstOrFail();

        Matche::create([
            'home_team' => $homeTeam->name,
            'away_team' => $awayTeam->name,
            'home_team_avatar' => $homeTeam->avatar,
            'away_team_avatar' => $awayTeam->avatar,
            'match_date' => $request->match_date,
            'competition' => 'Coupe du Monde 2026',
            'phase' => $request->phase,
        ]);

        return redirect()->route('matches.index')->with('success', 'Match créé avec succès.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'home_team' => 'required|string|exists:teams,name',
            'away_team' => 'required|string|exists:teams,name|different:home_team',
            'match_date' => 'required|date',
            'phase' => 'required|string|max:255',
        ]);

        $match = Matche::findOrFail($id);

        $homeTeam = Team::where('name', $request->home_team)->firstOrFail();
        $awayTeam = Team::where('name', $request->away_team)->firstOrFail();

        $match->update([
            'home_team' => $homeTeam->name,
            'away_team' => $awayTeam->name,
            'home_team_avatar' => $homeTeam->avatar,
            'away_team_avatar' => $awayTeam->avatar,
            'match_date' => $request->match_date,
            'phase' => $request->phase,
        ]);

        return redirect()->route('matches.index')->with('success', 'Match mis à jour avec succès.');
    }

    public function delete($id)
    {
        $match = Matche::findOrFail($id);
        $match->delete();

        return redirect()->route('matches.index')->with('success', 'Match supprimé avec succès.');
    }

    public function pronostics()
    {
        $avatar_null = 'matchnull.webp';
        $user_id = auth()->id();

        $users = $this->getClassementByPhase(null);
        $Nbreusers = User::count();

        $userRank = $users->search(fn($u) => $u->id === $user_id);
        $userRank = $userRank !== false ? $userRank + 1 : null;

        $userPoints = $users->firstWhere('id', $user_id)->points ?? 0;

        $matches = Matche::with('resultat')->orderBy('match_date', 'asc')->get();

        $Nbrematches = $matches->count();
        $match_joue = Prediction::where('user_id', $user_id)->count();

        $gamificationEvents = \App\Models\GamificationEvent::where('user_id', auth()->id())
            ->where('seen', false)
            ->latest()
            ->get();

        \App\Models\GamificationEvent::where('user_id', auth()->id())
            ->where('seen', false)
            ->update(['seen' => true]);

        return view('match.pronostics', [
            'matches' => $matches,
            'nbre_matches' => $Nbrematches,
            'points' => $userPoints,
            'match_joue' => $match_joue,
            'classement' => $userRank,
            'users' => $users,
            'avatar_null' => $avatar_null,
            'user_id' => $user_id,
            'Nbreusers' => $Nbreusers,
            'gamificationEvents' => $gamificationEvents,
        ]);
    }

    public function classement()
    {
        $avatar_null = 'matchnull.webp';
        $user_id = auth()->id();

        $users = User::query()->join('user_scores', 'users.id', '=', 'user_scores.user_id')->select('users.*', 'user_scores.points', 'user_scores.rank')->orderBy('user_scores.rank')->limit(3)->get();

        $myRanking = User::query()->join('user_scores', 'users.id', '=', 'user_scores.user_id')->where('users.id', $user_id)->select('users.*', 'user_scores.points', 'user_scores.rank')->first();

        $userRank = $myRanking->rank ?? null;
        $userPoints = $myRanking->points ?? 0;

        $Nbreusers = User::count();

        $matches = Matche::with('resultat')->get();

        $Nbrematches = $matches->count();

        $match_joue = Prediction::where('user_id', $user_id)->count();

        $classementServices = $this->getClassementServices(null);

        return view('match.classement', [
            'matches' => $matches,
            'nbre_matches' => $Nbrematches,
            'points' => $userPoints,
            'match_joue' => $match_joue,
            'classement' => $userRank,
            'users' => $users,
            'myRanking' => $myRanking,
            'avatar_null' => $avatar_null,
            'user_id' => $user_id,
            'Nbreusers' => $Nbreusers,
            'classementServices' => $classementServices,
        ]);
    }

    public function classementadmin()
    {
        $avatar_null = 'matchnull.webp';
        $user_id = auth()->id();

        $usersGlobal = $this->getClassementByPhase(null);
        $usersPhaseGroupes = $this->getClassementByPhase('phase_groupes');
        $usersHuitiemes = $this->getClassementByPhase('huitiemes');
        $usersQuarts = $this->getClassementByPhase('quarts');
        $usersDemis = $this->getClassementByPhase('demi_finales');
        $usersTroisiemePlace = $this->getClassementByPhase('troisieme_place');
        $usersFinale = $this->getClassementByPhase('finale');

        $userRank = $usersGlobal->search(fn($u) => $u->id === $user_id);
        $userRank = $userRank !== false ? $userRank + 1 : null;

        $userPoints = $usersGlobal->firstWhere('id', $user_id)->points ?? 0;

        $matches = Matche::with('resultat')->get();
        $Nbrematches = $matches->count();
        $match_joue = Prediction::where('user_id', $user_id)->count();

        return view('resultat.classement', [
            'matches' => $matches,
            'nbre_matches' => $Nbrematches,
            'points' => $userPoints,
            'match_joue' => $match_joue,
            'classement' => $userRank,
            'users' => $usersGlobal,
            'usersGlobal' => $usersGlobal,
            'usersPhaseGroupes' => $usersPhaseGroupes,
            'usersHuitiemes' => $usersHuitiemes,
            'usersQuarts' => $usersQuarts,
            'usersDemis' => $usersDemis,
            'usersTroisiemePlace' => $usersTroisiemePlace,
            'usersFinale' => $usersFinale,
            'avatar_null' => $avatar_null,
            'user_id' => $user_id,
        ]);
    }

    private function getClassementByPhase($phase = null)
    {
        if ($phase !== null) {
            return $this->getClassementByPhaseCalculated($phase);
        }

        return User::with(['badges', 'score'])
            ->join('user_scores', 'users.id', '=', 'user_scores.user_id')
            ->orderBy('user_scores.rank')
            ->select('users.*', 'user_scores.points as points', 'user_scores.rank as rank')
            ->get()
            ->values();
    }

    private function getClassementByPhaseCalculated($phase)
    {
        $users = User::with('badges')->get();

        return $users
            ->map(function ($user) use ($phase) {
                $points = 0;

                $predictions = Prediction::with('match.resultat')->where('user_id', $user->id)->get();

                foreach ($predictions as $prediction) {
                    $match = $prediction->match;

                    if (!$match || !$match->resultat) {
                        continue;
                    }

                    if ($match->phase !== $phase) {
                        continue;
                    }

                    if ((string) $prediction->prediction === (string) $match->resultat->resultat) {
                        $points += 3;
                    }
                }

                $user->points = $points;
                $user->level = floor(($user->xp ?? 0) / 100) + 1;

                return $user;
            })
            ->sortByDesc('points')
            ->values();
    }
    public function calculatePoints()
    {
        return DB::table('predictions')->join('resultats', 'predictions.match_id', '=', 'resultats.match_id')->join('users', 'predictions.user_id', '=', 'users.id')->whereColumn('predictions.prediction', '=', 'resultats.resultat')->select('predictions.user_id', DB::raw('count(*) * 3 as points'), 'users.name', 'users.projet_service', 'users.fonction')->groupBy('predictions.user_id', 'users.name', 'users.projet_service', 'users.fonction')->orderByDesc('points')->get();
    }

    public function calculatePointsQuart()
    {
        return $this->calculatePoints();
    }

    public function calculatePointsDemi()
    {
        return $this->calculatePointsByDate('2024-07-08', '2024-07-12');
    }

    public function calculatePointsFinale()
    {
        return $this->calculatePointsByDate('2024-07-13', '2024-07-16');
    }

    private function calculatePointsByDate($startDate, $endDate)
    {
        return DB::table('predictions')
            ->join('resultats', 'predictions.match_id', '=', 'resultats.match_id')
            ->join('users', 'predictions.user_id', '=', 'users.id')
            ->join('matches', 'predictions.match_id', '=', 'matches.id')
            ->whereColumn('predictions.prediction', '=', 'resultats.resultat')
            ->whereBetween('matches.match_date', [$startDate, $endDate])
            ->select('predictions.user_id', DB::raw('count(*) * 3 as points'), 'users.name', 'users.projet_service', 'users.fonction')
            ->groupBy('predictions.user_id', 'users.name', 'users.projet_service', 'users.fonction')
            ->orderByDesc('points')
            ->orderBy('predictions.updated_at')
            ->get();
    }

    private function getClassementServicesCalculated($phase = null)
    {
        $matchesQuery = Matche::whereHas('resultat');

        if ($phase !== null) {
            $matchesQuery->where('phase', $phase);
        }

        $matchIds = $matchesQuery->pluck('id');
        $nbMatchesJoues = $matchIds->count();

        if ($nbMatchesJoues === 0) {
            return collect();
        }

        return DB::table('users')
            ->leftJoin('predictions', function ($join) use ($matchIds) {
                $join->on('users.id', '=', 'predictions.user_id')->whereIn('predictions.match_id', $matchIds);
            })
            ->leftJoin('resultats', 'predictions.match_id', '=', 'resultats.match_id')
            ->whereNotNull('users.projet_service')
            ->select('users.projet_service as service', DB::raw('COUNT(DISTINCT users.id) as nb_users'), DB::raw('COUNT(DISTINCT predictions.user_id) as participants'), DB::raw('COUNT(predictions.id) as total_pronostics'), DB::raw('SUM(CASE WHEN predictions.prediction = resultats.resultat THEN 1 ELSE 0 END) as correct_predictions'))
            ->groupBy('users.projet_service')
            ->get()
            ->map(function ($service) use ($nbMatchesJoues) {
                $points = $service->correct_predictions * 3;
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

    private function getClassementServices($phase = null)
    {
        if ($phase !== null) {
            return $this->getClassementServicesCalculated($phase);
        }

        return \App\Models\ServiceScore::orderBy('rank')->get()->map(fn($score) => (object) $score->toArray());
    }

    public function classementJoueursData(Request $request)
    {
        $maxPoints = \App\Models\UserScore::max('points') ?? 1;

        $query = User::query()->with('badges')->join('user_scores', 'users.id', '=', 'user_scores.user_id')->select('users.id', 'users.name', 'users.pseudo', 'users.avatar', 'users.projet_service', 'users.fonction', 'users.xp', 'users.level', 'users.current_streak', 'users.best_streak', 'users.lose_streak', 'user_scores.points', 'user_scores.rank');

        return datatables()
            ->of($query)
            ->filter(function ($query) use ($request) {
                $search = $request->input('search.value');

                if ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('users.name', 'like', "%{$search}%")
                            ->orWhere('users.pseudo', 'like', "%{$search}%")
                            ->orWhere('users.projet_service', 'like', "%{$search}%")
                            ->orWhere('users.fonction', 'like', "%{$search}%");
                    });
                }
            })
            ->order(function ($query) {
                $query->orderBy('user_scores.rank');
            })
            ->addColumn('joueur', function ($user) {
                $avatar = $user->avatar_url ?? asset('avatars/avatar.webp');
                $pseudo = $user->pseudo ?? $user->name;
                $me = $user->id === auth()->id() ? '<span class="wc-player-you">Moi</span>' : '';

                return '
                <div class="wc-player-cell">
                    <img src="' .
                    e($avatar) .
                    '" class="wc-player-avatar-img" loading="lazy" decoding="async" alt="Avatar">
                    <div class="wc-player-content">
                        <div class="wc-player-name">
                            ' .
                    e($pseudo) .
                    ' ' .
                    $me .
                    '
                        </div>

                        <div class="wc-player-realname">
                            ' .
                    e($user->name) .
                    '
                        </div>

                        <div class="wc-player-meta">
                            ⭐ Niveau ' .
                    e($user->level ?? 1) .
                    '
                            · ⚡ ' .
                    e($user->xp ?? 0) .
                    ' XP
                            · 🔥 ' .
                    e($user->current_streak ?? 0) .
                    '
                        </div>
                    </div>
                </div>
            ';
            })
            ->addColumn('progression', function ($user) use ($maxPoints) {
                $pct = $maxPoints > 0 ? round(($user->points / $maxPoints) * 100) : 0;

                if ($pct > 100) {
                    $pct = 100;
                }

                return '
                <div class="wc-progress-wrap">
                    <div class="wc-progress-bar-bg">
                        <div class="wc-progress-bar-fill" style="width: ' .
                    e($pct) .
                    '%;"></div>
                    </div>

                    <div class="wc-progress-bottom">
                        <span class="wc-progress-pct">' .
                    e($pct) .
                    '%</span>
                    </div>
                </div>
            ';
            })
            ->rawColumns(['joueur', 'progression'])
            ->make(true);
    }

    public function classementServicesData()
    {
        $query = \App\Models\ServiceScore::query()->select('rank', 'service', 'participants', 'nb_users', 'nb_matches_joues', 'total_pronostics', 'points', 'participation_ratio', 'precision_ratio', 'global_score')->orderBy('rank');

        return datatables()
            ->of($query)
            ->addColumn('participants_display', function ($service) {
                return $service->participants . '/' . $service->nb_users;
            })
            ->addColumn('participation_display', function ($service) {
                return $service->participation_ratio . '%';
            })
            ->addColumn('precision_display', function ($service) {
                return $service->precision_ratio . '%';
            })
            ->addColumn('score_display', function ($service) {
                return '<strong>' . $service->global_score . '%</strong>';
            })
            ->rawColumns(['score_display'])
            ->make(true);
    }

    public function classementMonServiceData(Request $request)
    {
        $currentUser = auth()->user();

        $query = User::query()->join('user_scores', 'users.id', '=', 'user_scores.user_id')->where('users.projet_service', $currentUser->projet_service)->select('users.id', 'users.name', 'users.pseudo', 'users.avatar', 'users.projet_service', 'users.fonction', 'users.xp', 'users.level', 'users.current_streak', 'users.best_streak', 'users.lose_streak', 'user_scores.points', 'user_scores.rank')->orderBy('user_scores.rank');

        return datatables()
            ->of($query)

            ->filter(function ($query) use ($request) {
                $search = $request->input('search.value');

                if ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('users.name', 'like', "%{$search}%")
                            ->orWhere('users.pseudo', 'like', "%{$search}%")
                            ->orWhere('users.fonction', 'like', "%{$search}%");
                    });
                }
            })

            ->addColumn('joueur', function ($user) {
                $avatar = $user->avatar ? asset($user->avatar) : asset('avatars/avatar.webp');

                $pseudo = $user->pseudo ?? $user->name;

                $me = $user->id === auth()->id() ? '<span class="wc-player-you">Moi</span>' : '';

                return '
                <div class="wc-player-cell">

                    <img
                        src="' .
                    e($avatar) .
                    '"
                        class="wc-player-avatar-img"
                        loading="lazy"
                        decoding="async"
                    >

                    <div class="wc-player-content">

                        <div class="wc-player-name">
                            ' .
                    e($pseudo) .
                    ' ' .
                    $me .
                    '
                        </div>

                        <div class="wc-player-realname">
                            ' .
                    e($user->name) .
                    '
                        </div>

                        <div class="wc-player-meta">
                            ⭐ Niveau ' .
                    e($user->level ?? 1) .
                    '
                            · ⚡ ' .
                    e($user->xp ?? 0) .
                    ' XP
                            · 🔥 ' .
                    e($user->current_streak ?? 0) .
                    '
                        </div>

                    </div>

                </div>
            ';
            })

            ->rawColumns(['joueur'])

            ->make(true);
    }

    public function matchesData(Request $request)
    {
        $userId = auth()->id();

        $query = Matche::with([
            'predictions' => function ($q) use ($userId) {
                $q->where('user_id', $userId);
            },
            'resultats',
        ])
            ->withCount('resultats')
            ->orderByRaw('CASE WHEN resultats_count = 0 THEN 0 ELSE 1 END')
            ->orderBy('match_date', 'asc');

        $search = $request->input('search.value');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('home_team', 'like', "%{$search}%")
                    ->orWhere('away_team', 'like', "%{$search}%")
                    ->orWhere('phase', 'like', "%{$search}%");
            });
        }

        return datatables()
            ->of($query)

            ->addColumn('match', function ($match) {
                $homeAvatar = $match->home_team_avatar ? asset($match->home_team_avatar) : null;

                $awayAvatar = $match->away_team_avatar ? asset($match->away_team_avatar) : null;

                return '
                <div class="cnx-match-cell">

                    <div class="cnx-team-block">
                        ' .
                    ($homeAvatar ? '<img src="' . e($homeAvatar) . '" class="cnx-team-avatar" loading="lazy" decoding="async">' : '<div class="cnx-team-avatar-ph">⚽</div>') .
                    '

                        <div class="cnx-team-name">
                            ' .
                    e($match->home_team) .
                    '
                        </div>
                    </div>

                    <div class="cnx-vs-block">
                        <span class="cnx-vs-text">VS</span>

                        <span class="cnx-match-date">
                                ' .
                    \Carbon\Carbon::parse($match->match_date)->format('D d/m · H:i') .
                    '
                        </span>

                       <span class="cnx-phase-badge">
                            ' .
                    e($match->phase) .
                    '
                        </span>

                        <span class="cnx-coeff-badge coeff-' .
                    $match->coefficient .
                    '">
                            🔥 x' .
                    $match->coefficient .
                    '
                        </span>
                    </div>

                    <div class="cnx-team-block">
                        ' .
                    ($awayAvatar ? '<img src="' . e($awayAvatar) . '" class="cnx-team-avatar" loading="lazy" decoding="async">' : '<div class="cnx-team-avatar-ph">⚽</div>') .
                    '

                        <div class="cnx-team-name">
                            ' .
                    e($match->away_team) .
                    '
                        </div>
                    </div>

                </div>
                  ';
            })

            ->addColumn('prediction', function ($match) {
                $prediction = $match->predictions->first();

                if (!$prediction) {
                    return '<span class="cnx-no-prediction">—</span>';
                }

                $homeAvatar = $match->home_team_avatar ? asset($match->home_team_avatar) : null;

                $awayAvatar = $match->away_team_avatar ? asset($match->away_team_avatar) : null;

                $predAvatar = null;

                if ($prediction->prediction == $match->home_team) {
                    $predAvatar = $homeAvatar;
                } elseif ($prediction->prediction == $match->away_team) {
                    $predAvatar = $awayAvatar;
                }

                if ($prediction->prediction == 'Null') {
                    return '
                <div class="cnx-pred-display">

                    <img
                        src="' .
                        asset('avatars/null.webp') .
                        '"
                        class="cnx-null-avatar"
                    >

                    <span class="cnx-pred-name">
                        Nul
                    </span>

                </div>
                ';
                }

                return '
                    <div class="cnx-pred-display">

                        ' .
                    ($predAvatar
                        ? '<img src="' .
                            e($predAvatar) .
                            '"
                                    class="cnx-pred-avatar"
                                    loading="lazy"
                                    decoding="async">'
                        : '') .
                    '

                        <span class="cnx-pred-name">
                            ' .
                    e($prediction->prediction) .
                    '
                        </span>

                    </div>
                ';
            })

            ->addColumn('play', function ($match) {
                $prediction = $match->predictions->first();
                $currentPrediction = $prediction->prediction ?? '0';

                if (now()->lessThan($match->match_date) && $match->resultats->isEmpty()) {
                    return '
                    <div class="cnx-pred-form">

                        <select
                            name="predictions[' .
                        $match->id .
                        ']"
                            form="bulkPredictionForm"
                            class="cnx-select bulk-select"
                            data-match-id="' .
                        $match->id .
                        '"
                        >
                            <option value="0">Sélectionner</option>

                            <option value="' .
                        e($match->home_team) .
                        '" ' .
                        ($currentPrediction === $match->home_team ? 'selected' : '') .
                        '>
                                ' .
                        e($match->home_team) .
                        '
                            </option>

                            <option value="Null" ' .
                        ($currentPrediction === 'Null' ? 'selected' : '') .
                        '>
                                Nul
                            </option>

                            <option value="' .
                        e($match->away_team) .
                        '" ' .
                        ($currentPrediction === $match->away_team ? 'selected' : '') .
                        '>
                                ' .
                        e($match->away_team) .
                        '
                            </option>
                        </select>

                        <form
                            action="' .
                        route('predictions.store') .
                        '"
                            method="POST"
                            class="cnx-single-form"
                            data-match-id="' .
                        $match->id .
                        '"
                            style="display:flex;"
                        >
                            ' .
                        csrf_field() .
                        '

                            <input type="hidden" name="match_id" value="' .
                        $match->id .
                        '">

                            <input
                                type="hidden"
                                name="prediction"
                                id="single-prediction-' .
                        $match->id .
                        '"
                                value="' .
                        e($currentPrediction) .
                        '"
                            >

                            <button
                                type="button"
                                class="cnx-btn-ok btn-single-save"
                                data-match-id="' .
                        $match->id .
                        '"
                            >
                                OK
                            </button>
                        </form>

                    </div>
                ';
                }

                return '
                    <button class="cnx-btn-done" disabled>
                        ' .
                    ($match->resultats->isNotEmpty() ? 'Résultat publié' : 'Terminé') .
                    '
                    </button>
                ';
            })

            ->addColumn('result', function ($match) {
                $prediction = $match->predictions->first();
                $coefficient = $match->coefficient ?? 1;
                $pointsEarned = 0;
                $isCorrect = false;

                if ($match->resultats->isEmpty()) {
                    return '
            <div class="cnx-result-display">
                <span class="cnx-no-result">En attente</span>
                <span class="cnx-point-info pending">
                    Gain possible : +' .
                        3 * $coefficient .
                        ' pts
                </span>
            </div>
        ';
                }

                $result = $match->resultats->first();

                if ($prediction) {
                    $isCorrect = (string) $prediction->prediction === (string) $result->resultat;
                    $pointsEarned = $isCorrect ? 3 * $coefficient : 0;
                }

                $homeAvatar = $match->home_team_avatar ? asset($match->home_team_avatar) : null;
                $awayAvatar = $match->away_team_avatar ? asset($match->away_team_avatar) : null;

                $label = $result->resultat === 'Null' ? 'Nul' : e($result->resultat);
                $avatar = null;

                if ($result->resultat === 'Null') {
                    $avatar = asset('avatars/null.webp');
                } elseif ($result->resultat === $match->home_team) {
                    $avatar = $homeAvatar;
                } elseif ($result->resultat === $match->away_team) {
                    $avatar = $awayAvatar;
                }

                return '
        <div class="cnx-result-display">

            ' .
                    ($avatar
                        ? '
                <img src="' .
                            e($avatar) .
                            '"
                     class="' .
                            ($result->resultat === 'Null' ? 'cnx-null-avatar' : 'cnx-result-avatar') .
                            '"
                     loading="lazy"
                     decoding="async">
            '
                        : '') .
                    '

            <span class="cnx-result-name">
                ' .
                    $label .
                    '
            </span>

            <span class="' .
                    ($isCorrect ? 'cnx-badge-correct' : 'cnx-badge-wrong') .
                    '">
                ' .
                    ($isCorrect ? '✓ Bon pronostic' : '✗ Raté') .
                    '
            </span>

            <div class="cnx-point-box">
                <span class="cnx-point-main">
                    +' .
                    $pointsEarned .
                    ' pts
                </span>

                <small>
                    Base 3 × coeff x' .
                    $coefficient .
                    '
                </small>
            </div>

        </div>
    ';
            })

            ->rawColumns(['match', 'prediction', 'play', 'result'])

            ->make(true);
    }

    public function adminMatchesData(Request $request)
    {
        $query = Matche::with('resultat')->orderBy('match_date', 'desc');

        $search = $request->input('search.value');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('home_team', 'like', "%{$search}%")
                    ->orWhere('away_team', 'like', "%{$search}%")
                    ->orWhere('phase', 'like', "%{$search}%")
                    ->orWhere('competition', 'like', "%{$search}%");
            });
        }

        return datatables()
            ->eloquent($query)
            ->addColumn('match', function ($match) {
                $homeAvatar = $match->home_team_avatar ? asset($match->home_team_avatar) : null;

                $awayAvatar = $match->away_team_avatar ? asset($match->away_team_avatar) : null;

                return '
                    <div class="wc-match-cell">
                        ' .
                    ($homeAvatar ? '<img src="' . e($homeAvatar) . '" class="wc-match-flag">' : '<div class="wc-match-flag-placeholder">⚽</div>') .
                    '
                        <span class="wc-match-team">' .
                    e($match->home_team) .
                    '</span>
                        <span class="wc-match-vs">VS</span>
                        <span class="wc-match-team">' .
                    e($match->away_team) .
                    '</span>
                        ' .
                    ($awayAvatar ? '<img src="' . e($awayAvatar) . '" class="wc-match-flag">' : '<div class="wc-match-flag-placeholder">⚽</div>') .
                    '
                    </div>
                ';
            })
            ->addColumn('date_phase', function ($match) {
                return '
                    <div class="wc-date-cell">
                        <div class="wc-date-main">
                            ' .
                    \Carbon\Carbon::parse($match->match_date)->locale('fr')->isoFormat('ddd D MMM YYYY · HH:mm') .
                    '
                        </div>
                        <span class="wc-phase-tag">' .
                    e($match->competition ?? $match->phase) .
                    '</span>
                    </div>
                ';
            })
            ->addColumn('actions', function ($match) {
                $hasResult = $match->resultat ? true : false;

                if ($hasResult) {
                    return '
                        <div class="wc-actions">
                            <button type="button" class="wc-btn-edit" disabled>🔒 Modifier</button>
                            <button type="button" class="wc-btn-delete" disabled>🔒 Suppr.</button>
                        </div>
                    ';
                }

                return '
                    <div class="wc-actions">
                        <button type="button" class="wc-btn-edit" onclick="openEditModal(' .
                    $match->id .
                    ')">
                            ✏ Modifier
                        </button>

                        <form action="' .
                    route('matches.delete', ['id' => $match->id]) .
                    '" method="POST" style="display:inline;">
                            ' .
                    csrf_field() .
                    method_field('DELETE') .
                    '
                            <button type="submit" class="wc-btn-delete" onclick="return confirm(\'Supprimer ce match ?\')">
                                ✕ Suppr.
                            </button>
                        </form>
                    </div>
                ';
            })
            ->rawColumns(['match', 'date_phase', 'actions'])
            ->make(true);
    }

    public function classementData(Request $request)
    {
        $phase = $request->phase;

        $query = User::query()->join('user_scores', 'users.id', '=', 'user_scores.user_id')->select('users.*', 'user_scores.points', 'user_scores.rank');

        if ($phase && $phase !== 'global') {
            $query->whereHas('predictions.match', function ($q) use ($phase) {
                if ($phase === 'phase_groupes') {
                    $q->where('phase', 'Phase de groupes');
                } else {
                    $q->where('phase', $phase);
                }
            });
        }

        return datatables()
            ->eloquent($query)

            ->filter(function ($query) use ($request) {
                $search = $request->input('search.value');

                if ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('users.name', 'like', "%{$search}%")
                            ->orWhere('users.pseudo', 'like', "%{$search}%")
                            ->orWhere('users.projet_service', 'like', "%{$search}%")
                            ->orWhere('users.fonction', 'like', "%{$search}%");
                    });
                }
            })

            ->order(function ($query) {
                $query->orderBy('user_scores.rank')->orderByDesc('user_scores.points')->orderByDesc('users.xp')->orderByDesc('users.best_streak')->orderBy('users.lose_streak')->orderBy('users.name');
            })

            ->addColumn('rank_badge', function ($user) {
                $class = match (true) {
                    $user->rank == 1 => 'wc-rank-1',
                    $user->rank == 2 => 'wc-rank-2',
                    $user->rank == 3 => 'wc-rank-3',
                    default => 'wc-rank-other',
                };

                return '
                <div class="wc-rank-badge ' .
                    $class .
                    '">
                    ' .
                    $user->rank .
                    '
                </div>
            ';
            })

            ->addColumn('joueur', function ($user) {
                $avatar = $user->avatar ? asset($user->avatar) : asset('avatars/avatar.webp');

                return '
                <div class="wc-player-cell">

                    <img
                        src="' .
                    $avatar .
                    '"
                        class="wc-player-avatar-img"
                    >

                    <div class="wc-player-content">

                        <div class="wc-player-name">
                            ' .
                    e($user->pseudo ?? $user->name) .
                    '
                        </div>

                        <div class="wc-player-realname">
                            ' .
                    e($user->name) .
                    '
                        </div>

                    </div>

                </div>
            ';
            })

            ->addColumn('progression', function ($user) {
                $maxPoints = \App\Models\UserScore::max('points') ?? 1;

                $pct = $maxPoints > 0 ? round(($user->points / $maxPoints) * 100) : 0;

                return '
                <div class="wc-progress-wrap">

                    <div class="wc-progress-bar-bg">

                        <div
                            class="wc-progress-bar-fill"
                            style="width:' .
                    $pct .
                    '%;"
                        ></div>

                    </div>

                    <div class="wc-progress-bottom">
                        <span class="wc-progress-pct">
                            ' .
                    $pct .
                    '%
                        </span>
                    </div>

                </div>
            ';
            })

            ->rawColumns(['rank_badge', 'joueur', 'progression'])

            ->make(true);
    }

    public function classementStats()
    {
        $user = auth()->user()->fresh();

        $myRanking = User::join('user_scores', 'users.id', '=', 'user_scores.user_id')->where('users.id', $user->id)->select('user_scores.points', 'user_scores.rank')->first();

        return response()
            ->json([
                'match_joue' => Prediction::where('user_id', $user->id)->count(),
                'nbre_matches' => Matche::count(),
                'points' => $myRanking->points ?? 0,
                'classement' => $myRanking->rank ?? null,
                'nbre_users' => User::count(),
                'xp' => $user->xp ?? 0,
                'current_streak' => $user->current_streak ?? 0,
                'best_streak' => $user->best_streak ?? 0,
                'lose_streak' => $user->lose_streak ?? 0,
            ])
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    }


        public function guide()
    {
        $badges = Badge::orderBy('category')->get();
        return view('match.guide', compact('badges'));
    }
}
