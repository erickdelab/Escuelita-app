@extends('layouts.app')

@section('template_title')
    Inscribir Alumno a Grupos
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card shadow-lg border-0">
                <!-- Header -->
                <div class="card-header text-white" style="background-color: #002D72;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h4 class="mb-0">🎓 {{ __('Inscribir Alumno a Grupos') }}</h4>
                        <a href="{{ route('alumnos.show', $alumno->n_control) }}" class="btn btn-light btn-sm fw-bold">
                            ← {{ __('Regresar al Detalle del Alumno') }}
                        </a>
                    </div>
                </div>

                <div class="card-body bg-white">
                    <!-- Información del Alumno -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <h5 class="alert-heading">Alumno: {{ $alumno->n_control }} - {{ $alumno->nombre }} {{ $alumno->ap_pat }} {{ $alumno->ap_mat }}</h5>
                                <p class="mb-0">Selecciona un grupo disponible para inscribir al alumno.</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Formulario para Inscribir a Nuevo Grupo -->
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header text-white" style="background-color: #002D72;">
                                    <h5 class="mb-0">Grupos Disponibles</h5>
                                </div>
                                <div class="card-body">
                                    @if($gruposDisponibles->count() > 0)
                                        <form method="POST" action="{{ route('alumno-grupo.store', $alumno->n_control) }}">
                                            @csrf
                                            <div class="form-group mb-3">
                                                <label for="id_grupo" class="form-label fw-bold">Selecciona un grupo:</label>
                                                <select name="id_grupo" class="form-select" id="id_grupo" required>
                                                    <option value="">-- Seleccione un Grupo --</option>
                                                    @foreach($gruposDisponibles as $grupo)
                                                        <option value="{{ $grupo->id_grupo }}">
                                                            Grupo {{ $grupo->id_grupo }} - 
                                                            @if($grupo->nombre_materia)
                                                                {{ $grupo->nombre_materia }} ({{ $grupo->cod_materia }})
                                                            @else
                                                                {{ $grupo->cod_materia ?? 'Materia no asignada' }}
                                                            @endif
                                                            - Semestre {{ $grupo->semestre }}
                                                            @if($grupo->profesore)
                                                                - Prof: {{ $grupo->profesore->nombre }} {{ $grupo->profesore->ap_paterno }}
                                                            @endif
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button type="submit" class="btn text-white w-100" style="background-color: #002D72; border-color: #002D72;">
                                                <i class="fa fa-user-plus"></i> Inscribir a Grupo Seleccionado
                                            </button>
                                        </form>
                                    @else
                                        <div class="alert alert-warning">
                                            <i class="fa fa-info-circle"></i> No hay grupos disponibles para inscribir.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Grupos Inscritos -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header text-white" style="background-color: #002D72;">
                                    <h5 class="mb-0">Grupos Inscritos ({{ $gruposInscritos->count() }})</h5>
                                </div>
                                <div class="card-body">
                                    @if($gruposInscritos->count() > 0)
                                        @foreach($gruposInscritos as $grupo)
                                            <div class="d-flex justify-content-between align-items-center mb-3 p-2 border rounded">
                                                <div>
                                                    <strong>Grupo {{ $grupo->id_grupo }}</strong> - 
                                                    @if($grupo->nombre_materia)
                                                        <span style="color: #002D72; font-weight: 600;">{{ $grupo->nombre_materia }}</span> ({{ $grupo->cod_materia }})
                                                    @else
                                                        <span class="text-warning">{{ $grupo->cod_materia ?? 'Materia no asignada' }}</span>
                                                    @endif
                                                    <br>
                                                    <small class="text-muted">
                                                        Semestre {{ $grupo->semestre }}
                                                        @if($grupo->profesore)
                                                            - {{ $grupo->profesore->nombre }} {{ $grupo->profesore->ap_paterno }}
                                                        @endif
                                                    </small>
                                                </div>
                                                <form method="POST" action="{{ route('alumno-grupo.destroy', [$alumno->n_control, $grupo->id_grupo]) }}" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                                            onclick="return confirm('¿Estás seguro de desinscribir al alumno de este grupo?')">
                                                        <i class="fa fa-user-times"></i> Desinscribir
                                                    </button>
                                                </form>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="alert alert-info">
                                            <i class="fa fa-info-circle"></i> El alumno no está inscrito en ningún grupo.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border: 1px solid #dee2e6;
        border-radius: 0.5rem;
    }
    
    .card-header {
        border-bottom: 1px solid rgba(0,0,0,0.125);
    }
    
    .form-select {
        border-radius: 0.375rem;
        border: 1px solid #dee2e6;
    }
    
    .form-select:focus {
        border-color: #002D72;
        box-shadow: 0 0 0 0.2rem rgba(0, 45, 114, 0.25);
    }
    
    .btn {
        border-radius: 0.375rem;
    }
    
    .alert-info {
        background-color: rgba(0, 45, 114, 0.1);
        border-color: rgba(0, 45, 114, 0.2);
        color: #002D72;
    }
    
    .border {
        border-color: #e9ecef !important;
    }
    
    .border:hover {
        border-color: #002D72 !important;
    }
</style>
@endsection