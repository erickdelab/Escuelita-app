@extends('layouts.app')

@section('template_title')
    {{ __('Editar Grupo') }}
@endsection

@section('content')
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">

            <div class="card shadow-lg border-0">
                
                <div class="card-header text-white" style="background-color: #002D72;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        
                        <span class="card-title h4 mb-0">{{ __('Editar Grupo') }}</span>
                        
                        <div class="float-right">
                            <a href="{{ route('grupos.index') }}" class="btn btn-light btn-sm fw-bold" data-placement="left">
                                {{ __('Regresar') }}
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card-body bg-white">
                    {{-- ⚙️ Formulario de edición --}}
                    <form method="POST" action="{{ route('grupos.update', $grupo->id_grupo) }}" role="form">
                        @csrf
                        @method('PATCH')

                        {{-- Mostrar errores generales --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Ups!</strong> Hay algunos problemas con tus datos.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Mostrar mensajes de éxito o error --}}
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        {{-- Campos del formulario --}}
                        {{-- 🔹 El campo id_grupo fue eliminado por ser autoincremental --}}
                        @include('grupo.form', [
                            'grupo' => $grupo,
                            'materias' => $materias,
                            'profesores' => $profesores,
                            'periodos' => $periodos
                        ])

                        {{-- Botón de guardar cambios (único) --}}
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary fw-bold">
                                <i class="bi bi-save"></i> {{ __('Guardar Cambios') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
