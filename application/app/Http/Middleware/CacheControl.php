<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CacheControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Définir les en-têtes de cache
        $response->headers->set('Cache-Control', 'max-age=86400, public'); // 86400 secondes = 1 jour
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Expires', gmdate('D, d M Y H:i:s \G\M\T', time() + 86400));

        return $response;
    }
}
