<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Adulto
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
        
        // Calcula cuantos años tiene
        $fechaUsuario = date_create($request->user()->fechanacimiento);
        $hoy = date_create(date('Y-m-d'));
        $diff = date_diff($fechaUsuario, $hoy);

        if($diff->y < 18) {
            abort(403, 'Acceso denegado, debes ser mayor de edad para acceder a este contenido.');
        }

        return $response;
    }
}
