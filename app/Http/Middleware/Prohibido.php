<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Prohibido
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // if($request->query('edad') < 18) {
        //     abort(403, 'Aceso denegado, debes ser mayor de edad para acceder a este contenido.');
        // }
        abort(403, 'Aceso denegado, no tienes permiso para manipular este contenido.');

        //return $next($request);
        return $response;
    }
}
