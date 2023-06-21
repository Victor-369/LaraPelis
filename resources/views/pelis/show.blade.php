@extends('layouts.master')

@section('titulo', "Detalles de $peli->titulo")

@section('contenido')
        <table class="table table-striped table-bordered">
            <tr>
                <td>ID</td>
                <td>{{$peli->id}}</td>
            </tr>
            <tr>
                <td>Título</td>
                <td>{{$peli->titulo}}</td>
            </tr>
            <tr>
                <td>Director</td>
                <td>{{$peli->director}}</td>
            </tr>
            <tr>
                <td>Año</td>
                <td>{{$peli->anyo}}</td>
            </tr>            
            <tr>
                <td>Descatalogada</td>
                <td>{{$peli->descatalogada? 'SI': 'NO'}}</td>
            </tr>
        </table>
        <div class="text-end my-3">
            <div class="btn-group mx-2">
                <a class="mx-2" href="{{route('pelis.edit', $peli->id)}}">
                    <img heigh="40" width="40" src="{{asset('images/buttons/update.png')}}" alt="Modificar" title="Modificar">
                </a>
                <a class="mx-2" href="{{route('pelis.delete', $peli->id)}}">
                    <img heigh="40" width="40" src="{{asset('images/buttons/delete.png')}}" alt="Borrar" title="Borrar">
                </a>
            </div>
        </div>
@endsection

@section('enlaces')
    @parent    
    <a href="{{route('pelis.index')}}" class="btn btn-primary m-2">Listado</a>    
@endsection
