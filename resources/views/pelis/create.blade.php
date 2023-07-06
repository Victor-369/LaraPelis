@extends('layouts.master')

@section('titulo', 'Nueva película')

@section('contenido')
        <form class="my-2 border p-5" method="POST" action="{{route('pelis.store')}}" enctype="multipart/form-data">
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
            
            <div class="form-group row my-3">
                <div class="form-check col-sm-6">
                    <input name="descatalogada" type="checkbox" value="1" class="form-check-input" id="chkDescatalogada" {{empty(old('descatalogada'))? "" : "checked"}}>
                    <label for="chkDescatalogada" class="form-check-label">Descatalogada</label>
                </div>
                <div class="form-check col-sm-6">
                    <label for="inputIsan" class="col-sm-2 form-label">ISAN</label>
                    <input name="isan" type="text" class="up form-control"
                        id="inputIsan" value="{{old('isan')}}">                    
                </div>
            </div>
            <script>
                inputIsan.disabled = chkDescatalogada.checked;
                chkDescatalogada.onchange = function() {
                                                            inputIsan.disabled = chkDescatalogada.checked;
                                                        }
            </script>

            <div class="form-group row">
                <div class="form-check col-sm-6">
                    <input type="checkbox" class="form-check-input" id="chkColor">
                    <label class="form-check-label">Indica el color</label>
                </div>
                <div class="form-check col-sm-6">
                    <label for="inputColor" class="col-sm-2 form-label">Color</label>
                    <input name="color" type="color" class="up form-control form-control-color"
                        id="inputColor" value="{{old('color') ?? '#FFFFFF'}}">
                </div>
            </div>
            <script>
                inputColor.disabled = !chkColor.checked;
                chkColor.onchange = function() {
                                                    inputColor.disabled = !chkColor.checked;
                                                }
            </script>

            <div class="form-group row">
                <label for="inputImagen" class="col-sm-2 col-form-label">Imagen</label>
                <input name="imagen" type="file" class="form-contro-file col-sm-10" id="inputImagen">
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