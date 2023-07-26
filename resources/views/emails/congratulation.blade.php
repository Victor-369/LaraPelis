<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        @php
            include 'css/bootstrap.min.css';
        @endphp
    </style>
</head>
<body class="container p-3">
    <header class="container row bg-light p-4 my-4">
        <figure class="img-fluid col-2">
            <img src="{{asset('images/logos/logo.jpg')}}" alt="logo">
        </figure>
        <h1 class="col-10">{{config('app.name')}}</h1>
    </header>
    <main>
        <h1>¡Felicidades</h1>
        <h2>¡Has publicado tu primera peli en laraPelis</h2>
        <p>Tu nueva peli {{$peli->titulo}} ya aparece en los resultados.</p>
        <p>Sigue así, estás colaborando para que laraPelis se convierta en la primera red de usuarios de películas.</p>
    </main>
    <footer class="page-footer font-small p-4 my-4 bg-light">
        <p>Aplicación creada por <a href="https://github.com/Victor-369">Víctor García</a> como ejemplo. Desarrollada utilizando <b>Laravel</b> y <b>Bootstrap</b>.</p>
    </footer>
</body>
</html>