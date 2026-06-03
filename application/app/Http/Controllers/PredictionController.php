<?php

namespace App\Http\Controllers;

use App\Models\Prediction;
use App\Models\Matche;
use App\Models\Team;

use Illuminate\Http\Request;

class PredictionController extends Controller
{
    public function index()
    {

        $predictions = Prediction::with('match')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        $matches = Matche::where('match_date', '>', now())
            ->orderBy('match_date', 'asc')
            ->get();

        $teams = Team::orderBy('name')->get();

        return view('match.index', [
            'predictions' => $predictions,
            'matches' => $matches,
            'teams' => $teams,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'match_id' => 'required|exists:matches,id',
            'prediction' => 'required|string|max:255',
        ]);

        $match = Matche::findOrFail($request->match_id);

        if (now()->greaterThanOrEqualTo($match->match_date)) {
            return redirect()
                ->back()
                ->with('error', 'Ce match est déjà commencé ou terminé.');
        }

        Prediction::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'match_id' => $match->id,
            ],
            [
                'prediction' => $request->prediction,
            ]
        );

        return redirect()
            ->back()
            ->with('success', 'Pronostic enregistré avec succès.');
    }

    public function bulkStore(Request $request)
    {
        $request->validate([
            'predictions' => 'required|array',
            'predictions.*' => 'nullable|string',
        ]);

        $userId = auth()->id();

        foreach ($request->predictions as $matchId => $prediction) {
            if (!$prediction || $prediction === '0') {
                continue;
            }

            $match = Matche::find($matchId);

            if (!$match) {
                continue;
            }

            if (now()->greaterThanOrEqualTo($match->match_date)) {
                continue;
            }

            Prediction::updateOrCreate(
                [
                    'user_id' => $userId,
                    'match_id' => $matchId,
                ],
                [
                    'prediction' => $prediction,
                ]
            );
        }

        return redirect()->back()->with('success', 'Vos pronostics ont été enregistrés avec succès.');
    }
}