<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Models\Peli;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        //$pelis = $request->user()->hasMany('\App\Models\Peli')->paginate(10);

        // recupera las películas no borradas del usuario
        $pelis = $request->user()->pelis()->paginate(config('pagination.pelis', 10));

        // recupera las pelíiculas borradas del usuario.
        $deletedPelis = $request->user()->pelis()->onlyTrashed()->get();
        
        return view('home', ['pelis' => $pelis,
                            'deletedPelis' => $deletedPelis]);
    }
}
