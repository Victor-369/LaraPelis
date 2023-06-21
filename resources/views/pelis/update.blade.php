<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Aplicación de gestión de películas LaraPelis">
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
    <title>{{config('app.name')}} - PORTADA</title>
</head>
<body class="container p-3">
    <nav>
        <ul class="nav nav-pills my-3">
            <li class="nav-item mr-2">
                <a class="nav-link active" href="{{url('/')}}">Inicio</a>
            </li>
            <li class="nav-item mr-2">
                <a class="nav-link" href="{{route('pelis.index')}}">Listado</a>
            </li>
            <li class="nav-item mr-2">
                <a class="nav-link" href="{{route('pelis.create')}}">Nueva película</a>
            </li>
        </ul>
    </nav>

    <h1 class="my-2">Gestor de películas LaraPelis</h1>
    <main>
        <h2>Actualización de la película {{"$peli->titulo"}}</h2>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if(Session::has('success'))
            <div class="alert alert-success">
                {{Session::get('success')}}
            </div>
        @endif

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
        <div class="btn-group" role="group" aria-label="Links">
            <a href="{{url('/')}}" class="btn btn-primary m-2">Inicio</a>
            <a href="{{route('pelis.index')}}" class="btn btn-primary m-2">Listado</a>
        </div>
    </main>

    <footer class="page-footer font-small p-4 bg-light">
        <p>Aplicación creada por Víctor García como ejemplo. Desarrollada utilizando <b>Laravel</b> y <b>Bootstrap</b>.</p>
    </footer>
</body>
</html>