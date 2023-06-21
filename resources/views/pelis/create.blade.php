<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Aplicación de gestión de pelis Larapelis">
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
    <title>{{config('app.name')}} - PORTADA</title>
</head>
<body class="container p-3">
    <nav>
        <ul class="nav nav-pills my-3">
            <li class="nav-item mr-2">
                <a class="nav-link" href="{{url('/')}}">Inicio</a>
            </li>
            <li class="nav-item mr-2">
                <a class="nav-link" href="{{route('pelis.index')}}">Listado</a>
            </li>
            <li class="nav-item mr-2">
                <a class="nav-link active" href="{{route('pelis.create')}}">Nueva peli</a>
            </li>
        </ul>
    </nav>

    <h1 class="my-2">Gestor de pelis Larapelis</h1>
    <main>
        <h2>Nuevo peli</h2>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
        @endif

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

    </main>

    <footer class="page-footer font-small p-4 bg-light">
        <p>Aplicación creada por <a href="https://github.com/Victor-369">Víctor García</a> como ejemplo. Desarrollada utilizando <b>Laravel</b> y <b>Bootstrap</b>.</p>
    </footer>
</body>
</html>