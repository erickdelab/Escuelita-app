@extends('layouts.app')

@section('template_title')
    {{ __('Editar Carrera') }}
@endsection

@section('content')
<section class="content container-fluid">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <span class="fs-5 fw-bold">Editar Carrera</span>
                <a href="{{ route('carreras.index') }}" class="btn btn-light btn-sm">Regresar</a>
            </div>

            <div class="card-body bg-white">
                <form method="POST" action="{{ route('carreras.update', $carrera->id_carrera) }}">
                    @csrf
                    @method('PATCH')

                    @include('carrera.form')

                    <div class="mt-3 text-end">
                        <button type="submit" class="btn btn-success">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
