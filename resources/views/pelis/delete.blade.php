@extends('layouts.master')

@section('titulo', "Confirmación de borrado de $peli->titulo")

@section('contenido')
        <form class="my-2 border p-5" method="POST" action="{{URL::signedRoute('pelis.destroy', $peli->id)}}">
            @csrf
            @method('DELETE')
            <figure>
                <figcaption>Imagen actual:</figcaption>
                <img clas="rounded" style="max-width: 400px"
                    alt="Imagen de {{$peli->titulo}}"
                    title="Imagen de {{$peli->titulo}}"
                    src="{{$peli->imagen ?
                            asset('storage/' . config('filesystems.pelisImageDir')) . '/' . $peli->imagen:
                            asset('storage/' . config('filesystems.pelisImageDir')) . '/default.png'
                        }}">
            </figure>
            <label for="confirmdelete">Confirmar borrado de {{"$peli->titulo"}}:</label>
            <input type="submit" alt="Borrar" title="Borrar" class="btn btn-danger m-4" value="Borrar" id="confirmdelete">
        </form>
@endsection

@section('enlaces')
    @parent    
    <a href="{{route('pelis.index')}}" class="btn btn-primary m-2">Listado</a>
    <a href="{{route('pelis.show', $peli->id)}}" class="btn btn-primary m-2">Regresar al detalle de la película</a>
@endsection