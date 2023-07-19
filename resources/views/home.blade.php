@extends('layouts.master')

@section('contenido')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @if (is_null(Auth::user()->email_verified_at))
            <span class="invalid-feedback" role="alert">
                <strong>Mensaje: usuario no verificado</strong>
            </span>
            @endif


            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label text-md-end">Nombre:</label>
                        <label class="col-md-4 col-form-label ">{{Auth::user()->name}}</label>
                    </div>
                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label text-md-end">Población:</label>
                        <label class="col-md-4 col-form-label ">{{Auth::user()->poblacion}}</label>
                    </div>
                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label text-md-end">Código Postal:</label>
                        <label class="col-md-4 col-form-label ">{{Auth::user()->cp}}</label>
                    </div>
                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label text-md-end">Fecha de nacimiento:</label>
                        <label class="col-md-4 col-form-label ">{{Auth::user()->fechanacimiento}}</label>
                    </div>
                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label text-md-end">Email:</label>
                        <label class="col-md-4 col-form-label ">{{Auth::user()->email}}</label>
                    </div>

                </div>
            </div>

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
                @foreach($pelis as $peli)
                    <tr>
                        <td>{{$peli->id}}</td>
                        
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
                        <td class="text-center p-0">
                            <a class="btn btn-success" href="{{route('pelis.show', $peli->id)}}">
                                <img heigh="20" width="20" src="{{asset('images/buttons/show.svg')}}" alt="Detalles" title="Detalles">
                            </a>
                            @can('update', $peli)
                                <a class="btn btn-warning" href="{{route('pelis.edit', $peli->id)}}">
                                    <img heigh="20" width="20" src="{{asset('images/buttons/update.svg')}}" alt="Modificar" title="Modificar">
                                </a>
                            @endcan
                            @can('delete', $peli)
                                <a class="btn btn-danger" href="{{route('pelis.delete', $peli->id)}}">
                                    <img heigh="20" width="20" src="{{asset('images/buttons/delete.svg')}}" alt="Borrar" title="Borrar">
                                </a>
                            @endcan                        
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="7">Mostrando {{sizeof($pelis)}} de {{$pelis->total()}}.</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection
