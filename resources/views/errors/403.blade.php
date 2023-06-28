@extends('layouts.master')
@section('titulo', 'Error 403')
@section('contenido')
    <div class="m-10">
        <div class="content" style="text-align: center">
            <div class="title mt-5" style="font-size: 2rem">
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