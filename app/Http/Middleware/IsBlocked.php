<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsBlocked
{
    /*
    CONFIGURABLE: nombre de rutas web permitidas para los usuarios bloqueados.
    Se podría sacar hacia el fichero de configuración (p.e: /config/users.php).
    Se permitirán las operaciones de contacto, logout y user.blocked (evita loop)
    */
    protected $allowed = ['contacto', 'contacto.email', 'user.blocked', 'logout'];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();           // usuario identificado
        $ruta = Route::currentRouteName();  // toma el nombre de la ruta

        // si hay usuario, está bloqueado e intenta acceder a una ruta no permitida,
        // se le lleva a la ruta de bloqueo.
        if($user && $user->hasRole('bloqueado') && !in_array($ruta, $this->allowed)) {
            return redirect()->route('user.blocked');
        }

        return $next($request);
    }
}
