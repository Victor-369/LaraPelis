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
        </div>
    </div>
</div>
@endsection
