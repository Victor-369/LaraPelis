@extends('layout.master')
@section('contenido')
<div class="container">
    <h3 class="mt-4">Motos borradas</h3>
    <div class="text-start">{{$pelis->links()}}</div>
    <table class="table table-striped table-bordered">
        <tr>
            <th>ID</th>
            <th>Imagen</th>
            <th>Titulo</th>
            <th>Director</th>
            <th>Año</th>
            <th>ISAN</th>
            <th>Color</th>
            <th>Descatalogada</th>
        </tr>
        @forelse($pelis as $peli)
            <tr>
                <td><b>{{$peli->id}}</b></td>
                <td class="text-center" style="max-width: 80px">
                    <img class="rounded" style="max-width: 80%"
                        alt="Imagen de {{$peli->titulo}}" 
                        title="Imagen de {{$peli->titulo}}"
                        src="{{$peli->imagen ?
                            asset('storage/' . config('filesystems.pelisImageDir')) . '/' . $peli->imagen:
                            asset('storage/' . config('filesystems.pelisImageDir')) . '/default.png'
                    }}">
                </td>
                <td>{{$peli->titulo}}</td>
                <td>{{$peli->director}}</td>
                <td>{{$peli->anyo}}</td>
                <td>{{$peli->isan}}</td>
                <td style="background-color:{{$peli->color}}">{{$peli->color}}</td>
                <td>{{$peli->descatalogada? 'SI': 'NO'}}</td>
                <td class="text-center">
                    <a href="{{route('pelis.restore', $peli->id)}}">
                        <button class="btn btn-success">Restaurar</button>
                    </a>
                </td>
                <td class="text-center">
                    <a onclick='if(confirm("¿Estás seguro?"))
                                this.nextElementSibling.submit();'>
                        <button class="btn btn-danger">Eliminar</button>
                    </a>
                    <form method="POST" class="d-none" action="{{route('pelis.purge')}}">
                        @csrf
                        <input name="_method" type="hidden" value="DELETE">
                        <input name="peli_id" type="hidden" value="{{$peli->id}}">
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td coolspan="8" class="alert alert-danger">No hay películas borradas.</td>
            </tr>
        @endforelse
    </table>
</div>
@endsection
