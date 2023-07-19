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
        $pelis = $request->user()->hasMany('\App\Models\Peli')->paginate(10);
        
        return view('home', ['pelis' => $pelis]);
    }
}
