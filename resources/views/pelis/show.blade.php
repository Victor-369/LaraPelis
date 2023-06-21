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
                <a class="nav-link" href="{{url('/')}}">Inicio</a>
            </li>
            <li class="nav-item mr-2">
                <a class="nav-link active" href="{{route('pelis.index')}}">Listado</a>
            </li>
            <li class="nav-item mr-2">
                <a class="nav-link" href="{{route('pelis.create')}}">Nueva película</a>
            </li>
        </ul>
    </nav>

    <h1 class="my-2">Gestor de películas LaraPelis</h1>
    <main>
        <h2>Detalles de la película {{"$peli->titulo"}}</h2>

        @if (Session::has('success'))
            <div class="alert alert-success">
                {{Session::get('success')}}
            </div>
        @endif

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
            <div class="btn-group" role="group" aria-label="Links">
                <a href="{{url('/')}}" class="btn btn-primary m-2">Inicio</a>
                <a href="{{route('pelis.index')}}" class="btn btn-primary m-2">Listado</a>
            </div>
    </main>

    <footer class="page-footer font-small p-4 bg-light">
        <p>Aplicación creada por <a href="https://github.com/Victor-369">Víctor García</a> como ejemplo. Desarrollada utilizando <b>Laravel</b> y <b>Bootstrap</b>.</p>
    </footer>
</body>
</html>