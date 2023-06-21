<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Aplicación de gestión de pelis LaraPelis">
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
                <a class="nav-link" href="{{route('pelis.create')}}">Nueva película</a>
            </li>
        </ul>
    </nav>

    <h1 class="my-2">Gestor de películas LaraPelis</h1>
    <main>
        <h2>Borrado de la película {{"$peli->titulo"}}</h2>

        <form class="my-2 border p-5" method="POST" action="{{route('pelis.destroy', $peli->id)}}">
            @csrf
            @method('DELETE')
            <label for="confirmdelete">Confirmar borrado de {{"$peli->titulo"}}:</label>
            <input type="submit" alt="Borrar" title="Borrar" class="btn btn-danger m-4" value="Borrar" id="confirmdelete">
        </form>

        <div class="btn-group" role="group" aria-label="Links">
            <a href="{{url('/')}}" class="btn btn-primary m-2">Inicio</a>
            <a href="{{route('pelis.index')}}" class="btn btn-primary m-2">Listado</a>
            <a href="{{route('pelis.show', $peli->id)}}" class="btn btn-primary m-2">Regresar al detalle de la película</a>
        </div>
    </main>

    <footer class="page-footer font-small p-4 bg-light">
        <p>Aplicación creada por <a href="https://github.com/Victor-369">Víctor García</a> como ejemplo. Desarrollada utilizando <b>Laravel</b> y <b>Bootstrap</b>.</p>
    </footer>
</body>
</html>