<?php

namespace App\Http\Controllers;

use App\Models\Matche;
use App\Models\Resultat;
use Illuminate\Http\Request;
use App\Services\GamificationService;
use Illuminate\Support\Facades\Artisan;


class ResultatController extends Controller
{
    public function index()
    {
        $matches = Matche::with('resultats')->get();

        return view('resultat.index', compact('matches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'match_id' => 'required|exists:matches,id',
            'resultat' => 'required|string',
        ]);

        Resultat::updateOrCreate(
            ['match_id' => $request->match_id],
            [
                'resultat' => $request->resultat,
                'admin_id' => auth('admin')->id(),
            ],
        );

        app(GamificationService::class)->processMatch((int) $request->match_id);

        return back()->with('success', 'Résultat enregistré et gamification mise à jour.');
    }

    public function resultatsData(Request $request)
    {
        $query = Matche::with('resultats')->orderBy('match_date', 'asc');

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
                return '
                    <div class="match-box">

                        <div class="team-block">

                            ' .
                    ($match->home_team_avatar ? '<img src="' . asset($match->home_team_avatar) . '" class="team-logo">' : '') .
                    '

                            <span class="team-name">
                                ' .
                    e($match->home_team) .
                    '
                            </span>

                        </div>

                        <div class="match-center">

                            <strong>VS</strong>

                            <small>
                                ' .
                    \Carbon\Carbon::parse($match->match_date)->locale('fr')->isoFormat('dddd D MMMM YYYY HH:mm') .
                    '
                            </small>

                            <em>' .
                    e($match->competition ?? $match->phase) .
                    '</em>

                        </div>

                        <div class="team-block">

                            ' .
                    ($match->away_team_avatar ? '<img src="' . asset($match->away_team_avatar) . '" class="team-logo">' : '') .
                    '

                            <span class="team-name">
                                ' .
                    e($match->away_team) .
                    '
                            </span>

                        </div>

                    </div>
                ';
            })

            ->addColumn('resultat', function ($match) {
                if ($match->resultats->isNotEmpty()) {
                    $html = '';

                    foreach ($match->resultats as $result) {
                        $logo = '';

                        if ($result->resultat == $match->home_team) {
                            $logo = '<img src="' . asset($match->home_team_avatar) . '">';
                        }

                        if ($result->resultat == $match->away_team) {
                            $logo = '<img src="' . asset($match->away_team_avatar) . '">';
                        }

                        $label = $result->resultat == 'Null' ? 'Match nul' : e($result->resultat);

                        $html .=
                            '
                            <div class="result-badge">
                                ' .
                            $logo .
                            '
                                ' .
                            $label .
                            '
                            </div>
                        ';
                    }

                    return $html;
                }

                return '
                    <span class="no-result">
                        Pas de résultat
                    </span>
                ';
            })

            ->addColumn('action', function ($match) {
                if (now()->greaterThan($match->match_date) && $match->resultats->isEmpty()) {
                    return '
                        <form
                            action="' .
                        route('resultats.store') .
                        '"
                            method="POST"
                            class="resultat-form ajax-result-form"
                        >

                            ' .
                        csrf_field() .
                        '

                            <input
                                type="hidden"
                                name="match_id"
                                value="' .
                        $match->id .
                        '"
                            >

                            <select
                                name="resultat"
                                class="result-select"
                            >
                                <option value="' .
                        e($match->home_team) .
                        '">
                                    ' .
                        e($match->home_team) .
                        '
                                </option>

                                <option value="Null">
                                    Match nul
                                </option>

                                <option value="' .
                        e($match->away_team) .
                        '">
                                    ' .
                        e($match->away_team) .
                        '
                                </option>
                            </select>

                            <button
                                type="button"
                                class="btn-validate ajax-result-btn"
                            >
                                Valider
                            </button>

                        </form>
                    ';
                }

                if ($match->resultats->isNotEmpty()) {
                    $resultat = $match->resultats->first();

                    return '
                        <form
                            action="' .
                        route('resultats.destroy', $resultat->id) .
                        '"
                            method="POST"
                            class="delete-result-form"
                        >
                            ' .
                        csrf_field() .
                        '
                            ' .
                        method_field('DELETE') .
                        '

                            <button
                                type="button"
                                class="btn-delete-result ajax-delete-result-btn"
                            >
                                Supprimer résultat
                            </button>
                        </form>
                    ';
                }

                return '
                    <button
                        type="button"
                        class="btn-finished"
                        disabled
                    >
                        Fin
                    </button>
                ';
            })

            ->filter(function ($query) use ($request) {
                $search = $request->input('search.value');

                if ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('home_team', 'like', "%{$search}%")
                            ->orWhere('away_team', 'like', "%{$search}%")
                            ->orWhere('competition', 'like', "%{$search}%")
                            ->orWhere('phase', 'like', "%{$search}%");
                    });
                }
            })

            ->rawColumns(['match', 'resultat', 'action'])

            ->make(true);
    }

    public function destroy($id)
    {
        $resultat = Resultat::findOrFail($id);

        $matchId = $resultat->match_id;

        $resultat->delete();

        app(\App\Services\GamificationService::class)->rebuildScores();

        return back()->with('success', 'Résultat supprimé et scores recalculés.');
    }
}
