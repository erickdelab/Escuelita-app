@extends('layouts.app')

@section('content')
<div class="card text-center mx-auto" style="max-width: 700px;">
    <div class="card-header">
        Bienvenido al Sistema del TecNM
    </div>
    <div class="card-body">
        <h5 class="card-title text-primary">Panel de Control</h5>
        <p class="card-text">Selecciona una de las siguientes secciones para administrar la información.</p>

        <a href="{{ url('/areas') }}" class="btn btn-primary m-2">Áreas</a>
        <a href="{{ url('/carreras') }}" class="btn btn-primary m-2">Carreras</a>
        <a href="{{ url('/alumnos') }}" class="btn btn-primary m-2">Alumnos</a>
        <a href="{{ url('/profesores') }}" class="btn btn-primary m-2">Profesores</a>
        <a href="{{ url('/materias') }}" class="btn btn-primary m-2">Materias</a>
        <a href="{{ url('/grupos') }}" class="btn btn-primary m-2">Grupos</a>

    </div>
</div>
@endsection
