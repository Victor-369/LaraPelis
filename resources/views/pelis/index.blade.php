@extends('layouts.master')

@section('titulo', "Listado de películas")

@section('contenido')
        {{$pelis->links();}}

        <form method="GET" class="col-6 row" action="{{route('pelis.search')}}">
            <input name="titulo" type="text" class="col form-control mr-2 mb-2" 
                    placeholder="Título" maxlength="16" value="{{$titulo ?? ''}}">

            <input name="director" type="text" class="col form-control mr-2 mb-2" 
                    placeholder="Director" maxlength="16" value="{{$director ?? ''}}">
            
            <button type="submit" class="col btn btn-primary mr-2 mb-2">Buscar</button>

            <a href="{{route('pelis.index')}}">
                <button type="button" class="col btn btn-primary mb-2">Quitar filtro</button>
            </a>
        </form>

        <table class="table table-striped table-bordered">
            <tr>
                <th>ID</th>
                <th>Imagen</th>
                <th>Titulo</th>
                <th>Director</th>
                <th>Año</th>
                <th>Descatalogada</th>
            </tr>
            @foreach($pelis as $peli)
                <tr>
                    <td>{{$peli->id}}</td>
                    
                    <td class="text-center" style="max-width: 80px">
                        <img class="rounded" style="max-width: 80%" 
                            alt="Imagen de {{$peli->titulo}}" 
                            title="Imagen de {{$peli->titulo}}"
                            src="{{$peli->imagen ?
                                        asset('storage/' . config('filesystems.pelisImageDir')) . '/' . $peli->imagen:
                                        asset('storage/' . config('filesystems.pelisImageDir')) . '/default.png'
                                }}">                            
                    </td>

                    <td>{{$peli->titulo}}</td>
                    <td>{{$peli->director}}</td>
                    <td>{{$peli->anyo}}</td>
                    <td>{{$peli->descatalogada? 'SI': 'NO'}}</td>
                    <td class="text-center p-0">
                        <a class="btn btn-success" href="{{route('pelis.show', $peli->id)}}">
                            <img heigh="20" width="20" src="{{asset('images/buttons/show.svg')}}" alt="Detalles" title="Detalles">
                        </a>
                        <a class="btn btn-warning" href="{{route('pelis.edit', $peli->id)}}">
                            <img heigh="20" width="20" src="{{asset('images/buttons/update.svg')}}" alt="Modificar" title="Modificar">
                        </a>
                        <a class="btn btn-danger" href="{{route('pelis.delete', $peli->id)}}">
                            <img heigh="20" width="20" src="{{asset('images/buttons/delete.svg')}}" alt="Borrar" title="Borrar">
                        </a>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="7">Mostrando {{sizeof($pelis)}} de {{$pelis->total()}}.</td>
            </tr>
        </table>
@endsection

@section('enlaces')
    @parent
@endsection
