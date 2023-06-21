@extends('layouts.master')

@section('titulo', 'Portada de LaraPelis')

@section('contenido')
        <figure class="row mt-2 mb-2 col-10 offset-1">
            <img class="d-block w-80" 
                alt="Logo de pelis"
                src="{{asset('images/pelis/logoPelis.jpg')}}">
        </figure>
@endsection

@section('enlaces')
@endsection