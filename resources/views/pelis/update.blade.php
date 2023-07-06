@extends('layouts.master')

@section('titulo', "Actualizar $peli->titulo")

@section('contenido')
        <form class="my-2 border p-5" method="POST" action="{{route('pelis.update', $peli->id)}}" enctype="multipart/form-data">
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




            <div class="form-group row my-3">
                <div class="col-sm-9">
                    <label for="inputImagen" class="col-sm-2 col-form-label">
                        {{$peli->imagen ? 'Sustituir' : 'Añadir'}} imagen
                    </label>
                    <input name="imagen" type="file" class="form-control-file" id="inputImagen">
                    @if($peli->imagen)
                    <div class="form-check my-3">
                        <input name="eliminarimagen" type="checkbox"
                                class="form-check-input" id="inputEliminar">
                        <label for="inputEliminar" class="form-check-label">Eliminar imagen</label>
                    </div>
                    <script>
                        inputEliminar.onchange = function() { inputImagen.disabled = this.checked; }
                    </script>
                    @endif
                </div>
                <div class="col-sm-3">
                    <label>Imagen actual:</label>
                    <img class="rounded img-thumbnail my-3" 
                        alt="Imagen de {{$peli->titulo}}"
                        title="Imagen de {{$peli->titulo}}"
                        src="{{$peli->imagen ?
                            asset('storage/' . config('filesystems.pelisImageDir')) . '/' . $peli->imagen:
                            asset('storage/' . config('filesystems.pelisImageDir')) . '/default.png'
                            }}">
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