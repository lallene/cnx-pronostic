<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LogLastUserActivity
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $userId =$user->id;

            $user = User::find($userId);

            if ($user) {
                $user->last_activity = Carbon::now();
                $user->save();
            }

        }

        return $next($request);
    }
}
