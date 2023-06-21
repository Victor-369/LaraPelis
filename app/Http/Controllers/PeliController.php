<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peli;

class PeliController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pelis = Peli::orderBy('id', 'DESC')->paginate(config('pagination.pelis', 10));

        $total = Peli::count();

        return view('pelis.index', ['pelis' => $pelis,
                                    'total' => $total]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pelis.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
                            'titulo' => 'required|max:255',
                            'director' => 'required|max:255',
                            'anyo' => 'required|integer',                            
                            'descatalogada' => 'sometimes'
                        ]);
        
        $peli = Peli::create($request->all());

        return redirect()->route('pelis.show', $peli->id)
                    ->with('success', "Película $peli->titulo añadida satisfactoriamente.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $peli = Peli::findOrFail($id);

        return view('pelis.show', ['peli' => $peli]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $peli = Peli::findOrFail($id);

        return view('pelis.update', ['peli' => $peli]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|max:255',
            'director' => 'required|max:255',
            'anyo' => 'required|integer',            
            'descatalogada' => 'sometimes'
        ]);

        $peli = Peli::findOrFail($id);
        $peli->update($request->all() + ['descatalogada' => 0]);

        return back()->with('success', "Película $peli->titulo actualizada.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $peli = Peli::findOrFail($id);
        $peli->delete();

        return redirect('pelis')->with('success', "Película $peli->titulo eliminado.");
    }

    // Entrada manual de confirmación de borrado
    public function delete($id)
    {
        $peli = Peli::findOrFail($id);

        return view('pelis.delete', ['peli' => $peli]);
    }
}
