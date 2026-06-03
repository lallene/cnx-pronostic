<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\PredictionController;
use App\Http\Controllers\ResultatController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DuelController;

/*
|--------------------------------------------------------------------------
| PUBLIC USER AUTH
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes([
    'register' => false,
]);

Route::post('/login', [LoginController::class, 'login'])
    ->name('login');

Route::post('/logout-user', function () {
    Auth::guard('web')->logout();

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/login');
})->name('logout.user');

/*
|--------------------------------------------------------------------------
| USER ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/change-password', [UserController::class, 'showForceChangePassword'])
        ->name('password.force.change');

    Route::post('/change-password', [UserController::class, 'updatePassword'])
        ->name('password.force.update');

    Route::get('/guide', [MatchController::class, 'guide'])
        ->name('guide');

    Route::get('/classement/stats', [MatchController::class, 'classementStats'])
        ->name('classement.stats');
});

Route::middleware(['auth', 'force.password'])->group(function () {
    Route::get('/home', [MatchController::class, 'pronostics'])
        ->name('home');

    Route::get('/classement', [MatchController::class, 'classement'])
        ->name('classement');

    Route::get('/matches/data', [MatchController::class, 'matchesData'])
        ->name('matches.data');

    Route::get('/online-users', [UserController::class, 'onlineUsers'])
        ->name('online.users');

    Route::get('/online-users-count', [UserController::class, 'onlineUsersCount'])
        ->name('online.users.count');

    Route::get('/predictions', [PredictionController::class, 'index'])
        ->name('pronostics.index');

    Route::post('/predictions/store', [PredictionController::class, 'store'])
        ->name('predictions.store');

    Route::post('/predictions/bulk-store', [PredictionController::class, 'bulkStore'])
        ->name('predictions.bulkStore');

    Route::get('/duels', [DuelController::class, 'index'])
        ->name('duels');

    Route::get('/duels/search-users', [DuelController::class, 'searchUsers'])
        ->name('duels.searchUsers');

    Route::get('/duels/data', [DuelController::class, 'data'])
        ->name('duels.data');

    Route::post('/duels/store', [DuelController::class, 'store'])
        ->name('duels.store');

    Route::post('/duels/{duel}/accept', [DuelController::class, 'accept'])
        ->name('duels.accept');

    Route::post('/duels/{duel}/refuse', [DuelController::class, 'refuse'])
        ->name('duels.refuse');

    Route::put('/profile/gaming', [ProfileController::class, 'updateGamingProfile'])
        ->name('profile.gaming.update');

    Route::get('/classement/joueurs/data', [MatchController::class, 'classementJoueursData'])
        ->name('classement.joueurs.data');

    Route::get('/classement/services/data', [MatchController::class, 'classementServicesData'])
        ->name('classement.services.data');

    Route::get('/classement/mon-service/data', [MatchController::class, 'classementMonServiceData'])
        ->name('classement.monservice.data');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])
        ->name('admin.login');

    Route::post('/login', [AdminLoginController::class, 'login'])
        ->name('admin.login.submit');

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/dashboard', [MatchController::class, 'index'])
            ->name('dashboard');

        Route::get('/classement', [MatchController::class, 'classementadmin'])
            ->name('classementadmin');

        Route::get('/matches/admin/data', [MatchController::class, 'adminMatchesData'])
            ->name('matches.admin.data');

        Route::post('/matches/create', [MatchController::class, 'create'])
            ->name('matches.create');

        Route::delete('/matches/{id}', [MatchController::class, 'delete'])
            ->name('matches.delete');

        Route::get('/matches/{id}/modify', [MatchController::class, 'modify'])
            ->name('matches.modify');

        Route::post('/matches/{id}/update', [MatchController::class, 'update'])
            ->name('matches.update');

        Route::get('/resultat', [ResultatController::class, 'index'])
            ->name('resultat.index');

        Route::get('/resultats/data', [ResultatController::class, 'resultatsData'])
            ->name('resultats.data');

        Route::post('/resultat/store', [ResultatController::class, 'store'])
            ->name('resultats.store');

        Route::delete('/resultats/{id}', [ResultatController::class, 'destroy'])
            ->name('resultats.destroy');

        Route::get('/users', [UserController::class, 'index'])
            ->name('users.index');

        Route::get('/users/data', [UserController::class, 'getData'])
            ->name('users.getData');

        Route::post('/users/import-paste', [UserController::class, 'importPaste'])
            ->name('users.importPaste');

        Route::put('/users/{id}', [UserController::class, 'update'])
            ->name('users.update');

        Route::delete('/users/{id}', [UserController::class, 'destroy'])
            ->name('users.destroy');

        Route::post('/users/reset-password/{id}', [UserController::class, 'resetPassword'])
            ->name('users.resetPassword');

        Route::get('/classement/data', [MatchController::class, 'classementData'])
            ->name('admin.classement.data');

        Route::post('/logout', [AdminLoginController::class, 'logout'])
            ->name('logoutadmin');
    });
});

/*
|--------------------------------------------------------------------------
| FALLBACK
|--------------------------------------------------------------------------
*/

Route::fallback(function () {
    return redirect('/');
});