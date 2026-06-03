<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;


class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::query()->orderBy('name');

            return DataTables::of($users)
                ->make(true);
        }

        return view('users.index');
    }

    public function onlineUsers()
    {
        $activeUsers = User::where('last_activity', '>=', Carbon::now()->subMinutes(5))->get();
        return view('online-users', compact('activeUsers'));
    }

    public function onlineUsersCount()
    {
        $activeUsersCount = User::where('last_activity', '>=', Carbon::now()->subMinutes(5))->count();
        return response()->json(['activeUsersCount' => $activeUsersCount]);
    }

    public function showForceChangePassword()
    {
        if (!Auth::check() || !Auth::user()->password_first_connection) {
            return redirect('/login');
        }

        return view('auth.force-change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'pseudo' => 'required|string|max:30|unique:users,pseudo,' . Auth::id(),
            'avatar' => 'required|string|max:255',
            'password' => 'required|min:7|confirmed',
        ]);

        $user = Auth::user();

        $user->update([
            'pseudo' => $request->pseudo,
            'avatar' => $request->avatar,
            'password' => Hash::make($request->password),
            'password_first_connection' => false,
        ]);

        Auth::logout();

        return redirect('/login')->with(
            'success',
            'Profil configuré avec succès. Connectez-vous avec votre nouveau mot de passe.'
        );
    }

    public function importPaste(Request $request)
    {
        $request->validate([
            'excel_data' => 'required|string'
        ]);

        $rows = preg_split("/\r\n|\n|\r/", trim($request->excel_data));

        $imported = 0;
        $skipped = 0;

        foreach ($rows as $row) {

            $columns = preg_split("/\t/", trim($row));

            if (count($columns) < 6) {
                $skipped++;
                continue;
            }

            $idWd = trim($columns[0]);
            $name = trim($columns[1]);
            $email = trim($columns[2]);
            $projetService = trim($columns[3]);
            $fonction = trim($columns[4]);
            $manager = trim($columns[5]);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $skipped++;
                continue;
            }


            \App\Models\User::updateOrCreate(
                [
                    'email' => $email
                ],
                [@
                    'id_wd' => $idWd,
                    'name' => $name,
                    'avatar' => 'avatars/avatar.webp',
                    'projet_service' => $projetService,
                    'fonction' => $fonction,
                    'manager' => $manager,
                    'password' => Hash::make('password123'),
                    'xp' => 100,
                    'level' => 1,
                    'current_streak' => 0,
                    'best_streak' => 0,
                ]
            );

            $imported++;
        }

        return redirect()
            ->back()
            ->with('success', "Importation terminée : {$imported} utilisateur(s) importé(s), {$skipped} ligne(s) ignorée(s).");
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'Utilisateur supprimé avec succès.');
    }

    public function update(Request $request, $id)
    {
    
        $request->validate([
            'id_wd'          => 'required|string|max:191',
            'name'           => 'required|string|max:191',
            'email'          => 'required|email|max:191|unique:users,email,' . $id,
            'projet_service' => 'required|string|max:191',
            'fonction'       => 'required|string|max:191',
            'manager'        => 'required|string|max:191',
        ]);

        $user = User::findOrFail($id);


        dd($user);

        $user->id_wd = $request->id_wd;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->projet_service = $request->projet_service;
        $user->fonction = $request->fonction;
        $user->manager = $request->manager;

        $user->save();

        return redirect('/admin/users')
            ->with('success', 'Utilisateur modifié avec succès.');
    }

        public function resetPassword($id)
    {
        $user = User::findOrFail($id);

        $user->password_first_connection = true;

        $user->save();

        return response()->json([
            'success' => true
        ]);
    }

}
