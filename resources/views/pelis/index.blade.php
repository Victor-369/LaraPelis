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
        <h2>Listado de películas</h2>

        @if (Session::has('success'))
            <div class="alert alert-success">
                {{Session::get('success')}}
            </div>
        @endif
        
        <div class="row">
            <div class="col-6 text-start">{{$pelis->links()}}</div>
            <div class="col-6 text-end">
                <p>Nueva película <a href="{{route('pelis.create')}}" class="btn btn-success ml-2">+</a></p>
            </div>
        </div>

        <table class="table table-striped table-bordered">
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Director</th>
                <th>Año</th>
                <th>Descatalogada</th>
            </tr>
            @foreach($pelis as $peli)
                <tr>
                    <td>{{$peli->id}}</td>
                    <td>{{$peli->titulo}}</td>
                    <td>{{$peli->director}}</td>
                    <td>{{$peli->anyo}}</td>
                    <td>{{$peli->descatalogada}}</td>
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
                <td colspan="4">Mostrando {{sizeof($pelis)}} de {{$total}}.</td>
            </tr>
        </table>

        <div class="btn-group" role="group" label="Links">
            <a href="{{url('/')}}" class="btn btn-primary mr-2">Inicio</a>
        </div>
    </main>

    <footer class="page-footer font-small p-4 bg-light">
        <p>Aplicación creada por <a href="https://github.com/Victor-369">Víctor García</a> como ejemplo. Desarrollada utilizando <b>Laravel</b> y <b>Bootstrap</b>.</p>
    </footer>
</body>
</html>