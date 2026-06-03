<?php

namespace App\Http\Controllers;

use App\Models\Duel;
use App\Models\Matche;
use App\Models\User;
use App\Models\Prediction;

use Illuminate\Http\Request;

class DuelController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | PAGE DUELS
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $users = $this->getClassementByPhase(null);
        $Nbreusers = User::count();

        $user_id = auth()->id();

        $userRank = $users->search(fn($u) => $u->id === $user_id);
        $userRank = $userRank !== false ? $userRank + 1 : null;

        $userPoints = $users->firstWhere('id', $user_id)->points ?? 0;
        $matches = Matche::with('resultat')->orderBy('match_date', 'asc')->get();

        $Nbrematches = $matches->count();
        $match_joue = Prediction::where('user_id', $user_id)->count();

        $userId = auth()->id();

        $duels = Duel::with(['challenger', 'opponent', 'match'])
            ->where(function ($query) use ($userId) {
                $query->where('challenger_id', $userId)->orWhere('opponent_id', $userId);
            })
            ->latest()
            ->get();

        $users = User::orderBy('name')->get();

        $matches = Matche::where('match_date', '>', now())->whereDoesntHave('resultats')->orderBy('match_date')->get();

        return view('match.duels', [
            'duels' => $duels,
            'users' => $users,
            'matches' => $matches,
            'nbre_matches' => $Nbrematches,
            'points' => $userPoints,

            'match_joue' => $match_joue,
            'classement' => $userRank,

            'user_id' => $user_id,
            'Nbreusers' => $Nbreusers,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | CRÉER UN DUEL
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'opponent_id' => 'required|exists:users,id',
            'match_id' => 'required|exists:matches,id',
            'xp_bet' => 'required|integer|min:5',
            'prediction' => 'required|string',
        ]);

        $challenger = auth()->user();

        $opponent = User::findOrFail($request->opponent_id);

        $match = Matche::findOrFail($request->match_id);

        if ($match->resultats()->exists()) {
            return back()->with('error', 'Impossible de lancer un duel sur un match qui a déjà un résultat.');
        }

        if ($challenger->id === $opponent->id) {
            return back()->with('error', 'Vous ne pouvez pas vous défier vous-même.');
        }

        /*
        |--------------------------------------------------------------------------
        | Vérification XP
        |--------------------------------------------------------------------------
        */
        if (($challenger->xp ?? 0) < $request->xp_bet) {
            return back()->with('error', 'XP insuffisant pour lancer ce duel.');
        }

        /*
        |--------------------------------------------------------------------------
        | Match déjà commencé
        |--------------------------------------------------------------------------
        */
        if (now()->greaterThanOrEqualTo($match->match_date)) {
            return back()->with('error', 'Impossible de lancer un duel sur un match commencé.');
        }

        /*
        |--------------------------------------------------------------------------
        | Duel déjà existant
        |--------------------------------------------------------------------------
        */
        $existingDuel = Duel::where('match_id', $match->id)
            ->where(function ($query) use ($challenger, $opponent) {
                $query
                    ->where(function ($q) use ($challenger, $opponent) {
                        $q->where('challenger_id', $challenger->id)->where('opponent_id', $opponent->id);
                    })
                    ->orWhere(function ($q) use ($challenger, $opponent) {
                        $q->where('challenger_id', $opponent->id)->where('opponent_id', $challenger->id);
                    });
            })
            ->whereIn('status', ['pending', 'accepted'])
            ->exists();

        if ($existingDuel) {
            return back()->with('error', 'Un duel existe déjà entre vous pour ce match.');
        }

        /*
        |--------------------------------------------------------------------------
        | Création duel
        |--------------------------------------------------------------------------
        */
        Duel::create([
            'challenger_id' => $challenger->id,
            'opponent_id' => $opponent->id,
            'match_id' => $match->id,
            'xp_bet' => $request->xp_bet,
            'challenger_prediction' => $request->prediction,
            'status' => 'pending',
        ]);

        return back()->with('success', '⚔️ Duel envoyé avec succès.');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCEPTER DUEL
    |--------------------------------------------------------------------------
    */
    public function accept(Request $request, Duel $duel)
    {
        if ($duel->opponent_id !== auth()->id()) {
            abort(403);
        }

        if ($duel->status !== 'pending') {
            return back()->with('error', 'Ce duel n’est plus disponible.');
        }

        $request->validate([
            'prediction' => 'required|string',
        ]);

        $opponent = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Vérification XP adversaire
        |--------------------------------------------------------------------------
        */
        if (($opponent->xp ?? 0) < $duel->xp_bet) {
            return back()->with('error', 'XP insuffisant pour accepter ce duel.');
        }

        $duel->update([
            'status' => 'accepted',
            'opponent_prediction' => $request->prediction,
        ]);

        return back()->with('success', '🔥 Duel accepté.');
    }

    /*
    |--------------------------------------------------------------------------
    | REFUSER DUEL
    |--------------------------------------------------------------------------
    */
    public function refuse(Duel $duel)
    {
        if ($duel->opponent_id !== auth()->id()) {
            abort(403);
        }

        if ($duel->status !== 'pending') {
            return back()->with('error', 'Ce duel n’est plus disponible.');
        }

        $duel->update([
            'status' => 'refused',
        ]);

        return back()->with('success', '❌ Duel refusé.');
    }

    private function getClassementByPhase($phase = null)
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

                    if ($phase !== null && $match->phase !== $phase) {
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
            ->sort(function ($a, $b) {
                // 1. Points
                if ($a->points !== $b->points) {
                    return $b->points <=> $a->points;
                }

                // 2. XP
                if (($a->xp ?? 0) !== ($b->xp ?? 0)) {
                    return ($b->xp ?? 0) <=> ($a->xp ?? 0);
                }

                // 3. Meilleure série
                if (($a->best_streak ?? 0) !== ($b->best_streak ?? 0)) {
                    return ($b->best_streak ?? 0) <=> ($a->best_streak ?? 0);
                }

                // 4. Moins de mauvaise série
                if (($a->lose_streak ?? 0) !== ($b->lose_streak ?? 0)) {
                    return ($a->lose_streak ?? 0) <=> ($b->lose_streak ?? 0);
                }

                // 5. Nom alphabétique
                return strcmp($a->name, $b->name);
            })
            ->values();
    }

    public function searchUsers(Request $request)
    {
        $search = $request->get('q');

        $users = User::where('id', '!=', auth()->id())
            ->where(function ($query) use ($search) {
                $query
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('pseudo', 'like', "%{$search}%")
                    ->orWhere('projet_service', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->limit(20)
            ->get();

        return response()->json(
            $users->map(function ($user) {
                return [
                    'id' => $user->id,
                    'text' => ($user->pseudo ?? $user->name) . ' (' . ($user->projet_service ?? 'Sans service') . ')',
                ];
            }),
        );
    }

    public function duelsData(Request $request)
    {
        $userId = auth()->id();

        $query = Duel::with(['challenger', 'opponent', 'match'])
            ->where(function ($q) use ($userId) {
                $q->where('challenger_id', $userId)->orWhere('opponent_id', $userId);
            })
            ->latest();

        return datatables()
            ->of($query)

            ->addColumn('card', function ($duel) {
                $creatorAvatar = $duel->creator->avatar ? asset($duel->creator->avatar) : asset('avatars/default.webp');

                $opponentAvatar = $duel->opponent->avatar ? asset($duel->opponent->avatar) : asset('avatars/default.webp');

                $statusClass = strtolower($duel->status);

                return '

        <div class="duel-item" data-status="' .
                    e($statusClass) .
                    '">

            <div class="duel-inner">

                <div class="duel-player">

                    <div class="duel-avatar-wrap">

                        <img src="' .
                    $creatorAvatar .
                    '"
                             class="duel-avatar">

                        <div class="duel-avatar-ring"></div>

                    </div>

                    <div>

                        <div class="duel-name">
                            ' .
                    e($duel->creator->name) .
                    '
                        </div>

                        <div class="duel-service">
                            ' .
                    e($duel->creator->projet_service) .
                    '
                        </div>

                        <div class="duel-bet-tag">
                            ⚡ ' .
                    $duel->creator->xp .
                    ' XP
                        </div>

                    </div>

                </div>

                <div class="duel-vs">
                    VS
                </div>

                <div class="duel-player right">

                    <div>

                        <div class="duel-name">
                            ' .
                    e($duel->opponent->name) .
                    '
                        </div>

                        <div class="duel-service">
                            ' .
                    e($duel->opponent->projet_service) .
                    '
                        </div>

                        <div class="duel-bet-tag">
                            ⚡ ' .
                    $duel->opponent->xp .
                    ' XP
                        </div>

                    </div>

                    <div class="duel-avatar-wrap">

                        <img src="' .
                    $opponentAvatar .
                    '"
                             class="duel-avatar">

                        <div class="duel-avatar-ring"></div>

                    </div>

                </div>

            </div>

            <div class="duel-meta">

                <div class="duel-match-info">

                    <div class="duel-match-icon">
                        ⚽
                    </div>

                    <div>

                        <div class="duel-match-teams">
                            ' .
                    e($duel->match->home_team) .
                    '
                            vs
                            ' .
                    e($duel->match->away_team) .
                    '
                        </div>

                        <div class="duel-match-date">
                            ' .
                    \Carbon\Carbon::parse($duel->match->match_date)->format('d/m/Y H:i') .
                    '
                        </div>

                    </div>

                </div>

                <div class="duel-jackpot">
                    🏆 Jackpot :
                    <strong>' .
                    $duel->xp_bet * 2 .
                    ' XP</strong>
                </div>

            </div>

            <div class="duel-preds">

                <div class="duel-pred-box">

                    <div class="duel-pred-label">
                        Pronostic
                    </div>

                    <div class="duel-pred-content">

                        <div class="duel-pred-value">
                            ' .
                    e($duel->creator_prediction) .
                    '
                        </div>

                    </div>

                </div>

                <div class="duel-pred-sep">
                    VS
                </div>

                <div class="duel-pred-box">

                    <div class="duel-pred-label">
                        Adversaire
                    </div>

                    <div class="duel-pred-content">

                        <div class="duel-pred-value">
                            ' .
                    e($duel->opponent_prediction ?? 'En attente') .
                    '
                        </div>

                    </div>

                </div>

            </div>

            <div class="duel-actions-row">

                <span class="status-pill ' .
                    $statusClass .
                    '">
                    ' .
                    strtoupper($duel->status) .
                    '
                </span>

            </div>

        </div>
        ';
            })

            ->rawColumns(['card'])

            ->make(true);
    }

    public function data(Request $request)
{
    $userId = auth()->id();

    $query = Duel::with([
            'challenger',
            'opponent',
            'match',
        ])
        ->where(function ($q) use ($userId) {
            $q->where('challenger_id', $userId)
              ->orWhere('opponent_id', $userId);
        })
        ->latest();

    return datatables()
        ->of($query)
        ->addColumn('card', function ($duel) {

            $challengerAvatar = $duel->challenger->avatar
                ? asset($duel->challenger->avatar)
                : asset('avatars/default.webp');

            $opponentAvatar = $duel->opponent->avatar
                ? asset($duel->opponent->avatar)
                : asset('avatars/default.webp');

            return '
                <div class="duel-item" data-status="' . e($duel->status) . '">

                    <div class="duel-inner">

                        <div class="duel-player">
                            <div class="duel-avatar-wrap">
                                <img src="' . $challengerAvatar . '" class="duel-avatar">
                                <div class="duel-avatar-ring"></div>
                            </div>

                            <div>
                                <div class="duel-name">' . e($duel->challenger->name) . '</div>
                                <div class="duel-service">' . e($duel->challenger->projet_service) . '</div>
                                <div class="duel-bet-tag">⚡ ' . $duel->challenger->xp . ' XP</div>
                            </div>
                        </div>

                        <div class="duel-vs">VS</div>

                        <div class="duel-player right">
                            <div>
                                <div class="duel-name">' . e($duel->opponent->name) . '</div>
                                <div class="duel-service">' . e($duel->opponent->projet_service) . '</div>
                                <div class="duel-bet-tag">⚡ ' . $duel->opponent->xp . ' XP</div>
                            </div>

                            <div class="duel-avatar-wrap">
                                <img src="' . $opponentAvatar . '" class="duel-avatar">
                                <div class="duel-avatar-ring"></div>
                            </div>
                        </div>

                    </div>

                    <div class="duel-meta">
                        <div class="duel-match-info">
                            <div class="duel-match-icon">⚽</div>
                            <div>
                                <div class="duel-match-teams">
                                    ' . e($duel->match->home_team) . ' vs ' . e($duel->match->away_team) . '
                                </div>
                                <div class="duel-match-date">
                                    ' . \Carbon\Carbon::parse($duel->match->match_date)->format('d/m/Y H:i') . '
                                </div>
                            </div>
                        </div>

                        <div class="duel-jackpot">
                            🏆 Jackpot : <strong>' . ($duel->xp_bet * 2) . ' XP</strong>
                        </div>
                    </div>

                    <div class="duel-preds">
                        <div class="duel-pred-box">
                            <div class="duel-pred-label">Challenger</div>
                            <div class="duel-pred-value">' . e($duel->challenger_prediction ?? '—') . '</div>
                        </div>

                        <div class="duel-pred-sep">VS</div>

                        <div class="duel-pred-box">
                            <div class="duel-pred-label">Adversaire</div>
                            <div class="duel-pred-value">' . e($duel->opponent_prediction ?? 'En attente') . '</div>
                        </div>
                    </div>

                    <div class="duel-actions-row">
                        <span class="status-pill ' . e($duel->status) . '">
                            ' . strtoupper($duel->status) . '
                        </span>
                    </div>

                </div>
            ';
        })
        ->rawColumns(['card'])
        ->make(true);
}
}
