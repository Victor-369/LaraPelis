@extends('layouts.master')

@section('titulo', "Actualizar $peli->titulo")

@section('contenido')
        <form class="my-2 border p-5" method="POST" action="{{route('pelis.update', $peli->id)}}">
            @csrf
            @method('PUT')
            <div class="form-group row">
                <label for="inputTitulo" class="col-sm-2 col-form-label">Titulo</label>
                <input name="titulo" value="{{$peli->titulo}}" type="text" class="up form-control col-sm-10" id="inputTitulo" placeholder="Título" maxlengh="255" required value="{{old('titulo')}}">
            </div>
            <div class="form-group row">
                <label for="inputDirector" class="col-sm-2 col-form-label">Director</label>
                <input name="director" value="{{$peli->director}}" type="text" class="up form-control col-sm-10" id="inputDirector" placeholder="Director" maxlengh="255" required value="{{old('director')}}">
            </div>
            <div class="form-group row">
                <label for="inputanyo" class="col-sm-2 col-form-label">Año</label>
                <input name="anyo" value="{{$peli->anyo}}" type="number" class="up form-control col-sm-4" id="inputanyo" required value="{{old('anyo')}}">
            </div>            
            <div class="form-group row">
                <div class="form-check">
                    <input name="descatalogada" value="1" class="form-check-input" type="checkbox" {{$peli->descatalogada? "checked" : ""}}>
                    <label class="form-check-label">Descatalogada</label>
                </div>
            </div>
            <div class="form-group row">
                <button type="submit" class="btn btn-success m-2 mt-5">Guardar</button>
                <button type="reset" class="btn btn-secondary m-2">Reestablecer</button>
            </div>
        </form>
        <div class="text-end my-3">
            <div class="btn-group mx-2">
                <a class="mx-2" href="{{route('pelis.show', $peli->id)}}">
                    <img heigh="40" width="40" src="{{asset('image/buttons/show.png')}}" alt="Detalles" title="Detalles">
                </a>
                <a class="mx-2" href="{{route('pelis.delete', $peli->id)}}">
                    <img heigh="40" width="40" src="{{asset('image/buttons/delete.png')}}" alt="Borrar" title="Borrar">
                </a>
            </div>
        </div>
@endsection

@section('enlaces')
    @parent    
    <a href="{{route('pelis.index')}}" class="btn btn-primary m-2">Listado</a>    
@endsection