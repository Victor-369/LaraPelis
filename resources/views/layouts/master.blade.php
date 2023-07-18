<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Ejemplo CRUD con Laravel - LaraPelis">
    <title>{{config('app.name')}} - @yield('titulo')</title>

    <!-- CSS para Bootstrap -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
    <script type="text/javascript" src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
</head>
<body class="container p-3">
    <!-- PARTE SUPERIOR -->
    @section('navegacion')
    @php($pagina = Route::currentRouteName())
    <nav>
        <ul class="nav nav-pills my-3">
            <li class="nav-item mr-2">
                <a class="nav-link {{$pagina == 'portada' ? 'active' : ''}}" href="{{route('portada')}}">Inicio</a>
            </li>            
            <li class="nav-item mr-2">
                <a class="nav-link {{$pagina == 'pelis.index' ||
                                    $pagina == 'pelis.search' ? 'active' : ''}}" href="{{route('pelis.index')}}">Listado</a>
            </li>
            @auth
            <li class="nav-item">
                <a class="nav-link {{$pagina == 'pelis.create' ? 'active' : ''}}" href="{{route('pelis.create')}}">Nueva película</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{$pagina == 'home' ? 'active' : ''}}" href="{{route('home')}}">Mis películas</a>
            </li>
            @endauth
            <li class="nav-item">
                <a class="nav-link {{$pagina == 'contacto' ? 'active' : ''}}" href="{{route('contacto')}}">Contacto</a>
            </li>
            @auth
            <li class="nav-item bg-success">
                <a class="nav-link link-light" href="{{route('home')}}">{{Auth::user()->name}} {{Auth::user()->email}}</a>
            </li>
            @endauth
            
            <!-- Authentication Links -->
            @guest
                @if (Route::has('login'))
                    <li class="nav-item">
                        <a class="nav-link link-success" href="{{route('login') }}">{{ __('Entrar') }}</a>
                    </li>
                @endif

                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link link-success" href="{{route('register') }}">{{ __('Registrar') }}</a>
                    </li>
                @endif
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest

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
        @yield('ultimasPelis')

        <div class="btn-group" role="group" aria-label="Links">
            @section('enlaces')
                <a href="{{route('portada')}}" class="btn btn-primary m-2">Inicio</a>
            @show
        </div>
    </main>

    <!-- PARTE INFERIOR -->
    @section('pie')
    <footer class="page-footer font-small p-4 bg-light">
        <p>Aplicación creada por <a href="https://github.com/Victor-369">Víctor García</a> como ejemplo. Desarrollada utilizando <b>Laravel</b> y <b>Bootstrap</b>. Las imágenes son propiedad de sus respectivos dueños.</p>
    </footer>
    @show
</body>
</html>