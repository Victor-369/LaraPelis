<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Peli;
use App\Http\Requests\PeliRequest;
use App\Http\Requests\PeliUpdateRequest;
use App\Http\Requests\PeliDeleteRequest;
use App\Http\Requests\PeliDestroyRequest;
use App\Events\FirstPeliCreated;
//use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;


class PeliController extends Controller
{
    public function __construct() {
        // middleware a todo excepto:
        //$this->middleware('auth')->except('index','show','search');
        $this->middleware('verified')->except('index','show','search');
        $this->middleware('adulto')->except('index','show','search');
        // pide confirmación de borrado cuando la sesión haya finalizado
        $this->middleware('password.confirm')->only('destroy');
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

        // recupera el id del usuario y lo guarda con los datos de la película.
        $datos['user_id'] = $pr->user()->id;

        $peli = Peli::create($datos);

        // Si es la primera vez que el usuario crea una película.
        // Mejor hacerlo con un campo de la BBDD.
        if($pr->user()->pelis->count() == 1) {
            FirstPeliCreated::dispatch($peli, $pr->user());
        }

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
    public function update(PeliUpdateRequest $request, Peli $peli)
    {
        // recoge los datos del formulario
        $datos = $request->only('titulo', 'director', 'anyo');

        // no se puede tomar directamente
        $datos['descatalogada'] = $request->has('descatalogada') ? 1 : 0;
        $datos['isan'] = $request->has('descatalogada') ? NULL : $request->input('isan');
        $datos['color'] = $request->input('color') ?? NULL;

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
    public function destroy(PeliDestroyRequest $request, Peli $peli)
    {
        // soft delete (no se puede borrar la imagen aún)
        $peli->delete();

        // comprueba si hay que retornar a algún sitio concreto
        // en caso contrario irá a la lista de películas (ruta por defecto)
        $redirect = Session::has('returnTo') ?
                                redirect(Session::get('returnTo')) :    // por URL
                                redirect()->route('pelis.index');       // por nombre de ruta

        // se usará la URL por si hay parámetro adicionales a tener en cuenta
        // por ejemplo con la paginación va el número de página y si se usa el nombre
        // se irá al inicio de la lista y no a la página actual.

        Session::remove('returnTo');  // borra la variable de sesión si la hubiera

        //return redirect('pelis')
        return redirect()->route('pelis.index')
                ->with('success', "Película $peli->titulo eliminado.");
    }

    // Entrada manual de confirmación de borrado
    public function delete(PeliDeleteRequest $request, Peli $peli)
    {
        // recuerda la URL anterior para futuras redirecciones
        Session::put('returnTo', URL::previous());

        // Vista de confirmación de eliminación
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

    public function restore(Request $request, int $id) {
        // recupera la película borrada
        $peli = Peli::withTrashed()->findOrFail($id);

        // comprueba los permisos mediante la policy
        if($request->user()->cant('restore', $peli)) {
            throw new AuthorizationException('No tienes permiso');
        } else {
            // restaura la película
            $peli->restore();
        }

        return back()->with('success', "Película $peli->titulo restaurada correctamente.");
    }

    public function purge(Request $request) {
        // recupera la película borrada
        $peli = Peli::withTrashed()->findOrFail($request->input('peli_id'));

        // comprueba los permisos mediante la policy
        if($request->user()->cant('delete', $peli)) {
            throw new AuthorizationException('No tienes permiso');
        }

        // si borra la película y esta tiene foto...
        if($peli->forceDelete() && $peli->imagen) {
            // borra la foto
            Storage::delete(config('filesystems.pelisImageDir'). '/' . $peli->imagen);
        }

        return back()->with('success', "Película $peli->titulo eliminada definitivamente.");
    }
}
