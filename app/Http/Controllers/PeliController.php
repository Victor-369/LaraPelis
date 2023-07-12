<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Peli;
use App\Http\Requests\PeliRequest;


class PeliController extends Controller
{
    public function __construct() {
        // middleware a todo excepto:
        $this->middleware('auth')->except('index','show','search');
        $this->middleware('adulto')->except('index','show','search');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$pelis = Peli::orderBy('id', 'DESC')->paginate(config('pagination.pelis', 10));
        $pelis = Peli::orderBy('id', 'ASC')->paginate(config('pagination.pelis', 10));

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
    public function store(/*Request $request,*/ PeliRequest $pr, Peli $peli)
    {
        /*
        $request->validate([
                            'titulo' => 'required|max:255',
                            'director' => 'required|max:255',
                            'anyo' => 'required|integer',                            
                            //'descatalogada' => 'required_with:isan',
                            'descatalogada' => 'isan|nullable',
                            
                            // 'isan' => "required_if:descatalogada,1|
                            //             nullable|
                            //             regex:/^d{4}[B-Z]{3}$/i|
                            //             unique:pelis,isan,$peli->id",
                            
                            'isan' => "required_if:descatalogada,1|
                                        nullable|
                                        regex:/[B-Z]/|
                                        unique:pelis,isan,$peli->id",
                            'imagen' => 'sometimes|file|image|mimes:jpg,png,gif,webp|max:2048'
                        ]);
        */
        
        //$datos = $request->only(['titulo', 'director', 'anyo', 'descatalogada', 'isan', 'color']);
        $datos = $pr->only(['titulo', 'director', 'anyo', 'descatalogada', 'isan', 'color']);
        $datos += ['imagen' => NULL];

        // proceso de recuperación de la imagen
        if($pr->hasfile('imagen')) {
            // sube la imagen al directorio indicado en el fichero de configuración.
            $ruta = $pr->file('imagen')->store(config('filesystems.pelisImageDir'));

            // recoge el nombre del fichero para agregarlo a la BBDD.
            $datos['imagen'] = pathinfo($ruta, PATHINFO_BASENAME);
        }

        $peli = Peli::create($datos);

        return redirect()
                ->route('pelis.show', $peli->id)
                ->with('success', "Película $peli->titulo añadida satisfactoriamente.")                
                ->cookie('lastInsertID', $peli->id, 0); // Se agrega una cookie
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
            //'descatalogada' => 'required_with:isan',
            'descatalogada' => 'isan|nullable',
            /*
            'isan' => "required_if:descatalogada,1|
                        nullable|
                        regex:/^d{4}[B-Z]{3}$/i|
                        unique:pelis,isan,$peli->id",
            */
            'isan' => "required_if:descatalogada,1|
                        nullable|
                        regex:/[B-Z]/|
                        unique:pelis,isan,$peli->id",
            'imagen' => 'sometimes|file|image|mimes:jpg,png,gif,webp|max:2048'
        ]);

        // recoge los datos del formulario
        $datos = $request->only('titulo', 'director', 'anyo');

        // no se puede tomar directamente
        $datos['descatalogada'] = $request->has('descatalogada') ? 1 : 0;
        $datos['isan'] = $request->has('descatalogada') ? NULL : $request->input('isan');
        $datos['color'] = $request->input('color') ?? NULL;

        // comprueba si llega el checkbox y pone 1 o 0 dependiendo de si llega o no.
        //$datos += $request->has('descatalogada') ? ['descatalogada' => 1] : ['descatalogada' => 0];

        // si llega una nueva imagen
        if($request->hasFile('imagen')) {
            // marca la imagen antigua para ser borrada si la actualización va bien.
            if($peli->imagen) {
                $aBorrar = config('filesystems.pelisImageDir') . '/' . $peli->imagen;
            }

            // sube la imagen al directorio indicado en el fichero de configuración.
            $imagenNueva = $request->file('imagen')->store(config('filesystems.pelisImageDir'));

            // toma el nombre del fichero
            $datos['imagen'] = pathinfo($imagenNueva, PATHINFO_BASENAME);
        }

        // si solicitan eliminar la imagen
        if($request->filled('eliminarimagen') && $peli->imagen) {
            $datos['imagen'] = NULL;
            $aBorrar = config('filesystems.pelisImageDir') . '/' . $peli->imagen;
        }

        // el proceso de actualizacion
        if($peli->update($datos)) {
            if(isset($aBorrar)) {
                // borra foto antigua
                Storage::delete($aBorrar);
            }        
        } else { 
            // si algo falla
            if(isset($imagenNueva)) {
                // borra la foto nueva
                Storage::delete($imagenNueva);
            }
        }

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
        // si consigue eliminar la foto y tiene imagen
        if($peli->delete() && $peli->imagen) {
            Storage::delete(config('filesystems.pelisImageDir') . '/' . $peli->imagen);
        }

        return redirect('pelis')
                ->with('success', "Película $peli->titulo eliminado.");
    }

    // Entrada manual de confirmación de borrado
    public function delete(Peli $peli)
    {
        return view('pelis.delete', ['peli' => $peli]);
    }


    // método que busca una película
    public function search(Request $request) {
        $request->validate(['titulo' => 'max: 16', 'director' => 'max: 16']);

        // toma los valores que llegan para titulo y director
        $titulo = $request->input('titulo', '');
        $director = $request->input('director', '');

        // recupera los resultados, se agrega titulo y director al paginator
        // para que haga bien los enlaces y se mantenga el filtro al pasar de página 
        $pelis = Peli::where('titulo', 'like', "%$titulo%")
                    ->where('director', 'like', "%$director%")
                    ->paginate(config('paginator.pelis'))
                    ->appends (['titulo' => $titulo
                                ,'director' => $director]);

        // retorna la vista de lista con el filtro aplicado
        return view('pelis.index', ['pelis' => $pelis
                                    ,'titulo' => $titulo
                                    ,'director' => $director]);
    }
}
