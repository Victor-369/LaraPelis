<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Ejemplo CRUD con Laravel - LaraPelis">
    <title>{{config('app.name')}} - @yield('titulo')</title>

    <!-- CSS para Bootstrap -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
</head>
<body class="container p-3">
    <!-- PARTE SUPERIOR -->
    @section('navegacion')
    @php($pagina = Route::currentRouteName())
    <nav>
        <ul class="nav nav-pills my-3">
            <li class="nav-item mr-2">
                <a class="nav-link {{$pagina == null ? 'active' : ''}}" href="{{route('portada')}}">Inicio</a>
            </li>
            <li class="nav-item mr-2">
                <a class="nav-link {{$pagina == 'pelis.index' ? 'active' : ''}}" href="{{route('pelis.index')}}">Listado</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{$pagina == 'pelis.create' ? 'active' : ''}}" href="{{route('pelis.create')}}">Nueva película</a>
            </li>
        </ul>
    </nav>
    @show

    <!-- PARTE CENTRAL -->
    <h1 class="my-2">CRUD con Laravel</h1>
    <main>
        <h2>@yield('titulo')</h2>

        @if(Session::has('success'))
            <x-alert type="success" message="{{Session::get('success')}}"/>
        @endif

        @if($errors->any())
            <x-alert type="danger" message="Se han producido errores:">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </x-alert>
        @endif

        @yield('contenido')

        <div class="btn-group" role="group" aria-label="Links">
            @section('enlaces')
                <a href="{{route('portada')}}" class="btn btn-primary m-2">Inicio</a>
            @show
        </div>
    </main>

    <!-- PARTE INFERIOR -->
    @section('pie')
    <footer class="page-footer font-small p-4 bg-light">
        <p>Aplicación creada por <a href="https://github.com/Victor-369">Víctor García</a> como ejemplo. Desarrollada utilizando <b>Laravel</b> y <b>Bootstrap</b>.</p>
    </footer>
    @show
</body>
</html>