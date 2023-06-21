@extends('layouts.master')

@section('titulo', 'Nueva película')

@section('contenido')
        <form class="my-2 border p-5" method="POST" action="{{route('pelis.store')}}">
            @csrf
            <div class="form-group row">
                <label for="inputTitulo" class="col-sm-2 col-form-label">Titulo</label>
                <input name="titulo" type="text" class="up form-control col-sm-10" id="inputTitulo" placeholder="titulo" maxlengh="255" required value="{{old('titulo')}}">
            </div>
            <div class="form-group row">
                <label for="inputDirector" class="col-sm-2 col-form-label">Director</label>
                <input name="director" type="text" class="up form-control col-sm-10" id="inputDirector" placeholder="director" maxlengh="255" required value="{{old('director')}}">
            </div>
            <div class="form-group row">
                <label for="inputanyo" class="col-sm-2 col-form-label">Año</label>
                <input name="anyo" type="number" class="up form-control col-sm-4" id="inputanyo" required value="{{old('anyo')}}">
            </div>            
            <div class="form-group row">
                <div class="form-check">
                    <input name="descatalogada" value="1" class="form-check-input" type="checkbox" {{empty(old('descatalogada'))? "" : "checked"}}>
                    <label class="form-check-label">Descatalogada</label>
                </div>
            </div>
            <div class="form-group row">
                <button type="submit" class="btn btn-success m-2 mt-5">Guardar</button>
                <button type="reset" class="btn btn-secondary m-2">Borrar</button>
            </div>
        </form>
@endsection

@section('enlaces')
    @parent
    <a href="{{route('pelis.index')}}" class="btn btn-primary m-2">Listado</a>
@endsection