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
    public function show(Peli $peli)
    {
        return view('pelis.show', ['peli' => $peli]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Peli $peli)
    {
        return view('pelis.update', ['peli' => $peli]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Peli $peli)
    {
        $request->validate([
            'titulo' => 'required|max:255',
            'director' => 'required|max:255',
            'anyo' => 'required|integer',            
            'descatalogada' => 'sometimes'
        ]);

        $peli->update($request->all() + ['descatalogada' => 0]);

        return back()->with('success', "Película $peli->titulo actualizada.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Peli $peli)
    {
        $peli->delete();

        return redirect('pelis')->with('success', "Película $peli->titulo eliminado.");
    }

    // Entrada manual de confirmación de borrado
    public function delete(Peli $peli)
    {
        return view('pelis.delete', ['peli' => $peli]);
    }


    // método que busca una película
    public function search (Request $request) {
        $request->validate(['titulo' => 'max: 255', 'director' => 'max: 255']);

        // toma los valores que llegan para titulo y director
        $titulo = $request->input('titulo','');
        $director = $request->input('director','');

        // recupera los resultados, se agrega titulo y director al paginator
        // para que haga bien los enlaces y se mantenga el filtro al pasar de página 
        $bikes = Bike::where('titulo', 'like', "%$titulo%")
                    ->where('director', 'like', "%$director%")
                    ->paginate (config('paginator.pelis'))
                    ->appends (['titulo' => $titulo, 'director' => $director]);

        // retorna la vista de lista con el filtro aplicado
        return view('pelis.index', ['pelis'=>$pelis, 'titulo' => $titulo, 'director '=>$director]);
    }
}
