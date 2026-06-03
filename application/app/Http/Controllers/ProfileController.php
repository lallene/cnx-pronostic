<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function updateGamingProfile(Request $request)
    {
        $request->validate([
            'pseudo' => 'required|string|max:30|unique:users,pseudo,' . auth()->id(),
            'avatar' => 'required|string|max:255',
        ]);

        $user = auth()->user();

        $user->update([
            'pseudo' => $request->pseudo,
            'avatar' => $request->avatar,
        ]);

        return back()->with(
            'success',
            'Profil joueur mis à jour avec succès.'
        );
    }
}
