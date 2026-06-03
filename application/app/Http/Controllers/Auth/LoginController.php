<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{

    // Login universel
    public function login(Request $request)
    {
        // Vérifie si l'utilisateur existe pour savoir si c'est sa première connexion
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Adresse e-mail ou informations incorrectes'
            ]);
        }

        // 🔹 Première connexion : password_first_connection = 1
        if ($user->password_first_connection) {
            // Validation uniquement pour email + id_wd
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $user = User::where('email', $request->email)
                        ->where('id_wd', $request->password)
                        ->first();

            if (!$user) {
                return back()->withErrors(['email' => 'Email ou ID WD incorrect']);
            }

            // Connexion temporaire
            Auth::login($user);

            // Redirige vers changement de mot de passe
            return redirect()->route('password.force.change');
        }

        // 🔹 Connexion normale après première connexion
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/pronostics');
        }

        return back()->withErrors([
            'email' => 'Mot de passe incorrect'
        ]);
    }


public function loginWithoutPassword(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'id_wd' => 'required',
    ]);

    $user = User::where('email', $request->email)
                ->where('id_wd', $request->id_wd)
                ->first();

    if (!$user) {
        return redirect('/login')
            ->withErrors(['email' => 'Adresse e-mail ou identifiant incorrect']);
    }

    // Connexion sans mot de passe
    Auth::login($user);

    // PREMIÈRE CONNEXION
    if ($user->password_first_connection) {
        return redirect()->route('password.force.change');
    }

    // Connexion normale
    return redirect()->intended('/pronostics');
}

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return  redirect('/login');
    }

}
