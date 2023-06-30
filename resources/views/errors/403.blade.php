@extends('layouts.master')

@section('contenido')
    <div class="m-10">
        <div class="content" style="text-align: center">
            <figure class="row mt-2 mb-2 col-10 offset-2">
                <img class="d-block w-75" 
                        alt="Logo de pelis" 
                        src="{{asset('images/errors/403YouShallNotPass.png')}}">
            </figure>
            <div class="title mt-3" style="font-size: 2rem">
                ERROR 403: Prohibido
            </div>
            <div class="title mb-5" style="font-size: 1rem">
                {{$exception->getMessage()}}
            </div>
        </div>
    </div>
@endsection

@section('enlaces')
    @parent
    <a href="{{route('pelis.index')}}" class="btn btn-primary m-2">Listado</a>
@endsection