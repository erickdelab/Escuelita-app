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
                                        <form method="POST" action="{{ route('alumnos.grupos.store', $alumno->n_control) }}">
                                            @csrf
                                            <div class="form-group mb-3">
                                                <label for="id_grupo" class="form-label fw-bold">Selecciona un grupo:</label>
                                                <select name="id_grupo" class="form-select" id="id_grupo" required>
                                                    <option value="">-- Seleccione un Grupo --</option>
                                                    @foreach($gruposDisponibles as $grupo)
                                                        @php
                                                            // ✅ Asegurar que la materia esté cargada
                                                            if (!$grupo->relationLoaded('materia') && $grupo->cod_materia) {
                                                                $grupo->load('materia');
                                                            }
                                                            
                                                            // ✅ Obtener el nombre de la materia
                                                            $nombreMateria = $grupo->materia->nombre ?? $grupo->nombre_materia ?? 'Materia no encontrada';
                                                        @endphp
                                                        <option value="{{ $grupo->id_grupo }}">
                                                            Grupo {{ $grupo->id_grupo }} - 
                                                            {{ $nombreMateria }} ({{ $grupo->cod_materia ?? 'Sin código' }})
                                                            - Semestre {{ $grupo->semestre }}
                                                            @if($grupo->profesore)
                                                                - Prof: {{ $grupo->profesore->nombre }} {{ $grupo->profesore->ap_paterno }}
                                                            @endif
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            {{-- ✅ Campo para seleccionar oportunidad --}}
                                            <div class="form-group mb-3">
                                                <label for="oportunidad" class="form-label fw-bold">Oportunidad:</label>
                                                <select name="oportunidad" class="form-select" id="oportunidad" required>
                                                    <option value="Primera">Primera Oportunidad</option>
                                                    <option value="Repite">Repite Materia</option>
                                                    <option value="Especial">Oportunidad Especial</option>
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
                                    <h5 class="mb-0">Grupos Inscritos ({{ $alumno->grupos->count() }})</h5>
                                </div>
                                <div class="card-body">
                                    @if($alumno->grupos->count() > 0)
                                        @foreach($alumno->grupos as $grupo)
                                            @php
                                                // ✅ Asegurar que la materia esté cargada
                                                if (!$grupo->relationLoaded('materia') && $grupo->cod_materia) {
                                                    $grupo->load('materia');
                                                }
                                                
                                                // ✅ Obtener el nombre de la materia
                                                $nombreMateria = $grupo->materia->nombre ?? $grupo->nombre_materia ?? 'Materia no encontrada';
                                            @endphp
                                            <div class="d-flex justify-content-between align-items-center mb-3 p-2 border rounded">
                                                <div>
                                                    <strong>Grupo {{ $grupo->id_grupo }}</strong> - 
                                                    <span class="fw-bold" style="color: #002D72;">{{ $nombreMateria }}</span>
                                                    <small class="text-muted">({{ $grupo->cod_materia ?? 'Sin código' }})</small>
                                                    <br>
                                                    <small class="text-muted">
                                                        Semestre {{ $grupo->semestre }}
                                                        @if($grupo->profesore)
                                                            - {{ $grupo->profesore->nombre }} {{ $grupo->profesore->ap_paterno }}
                                                        @endif
                                                        {{-- ✅ Mostrar oportunidad --}}
                                                        <br>
                                                        <span class="badge 
                                                            @if($grupo->pivot->oportunidad == 'Primera') bg-success
                                                            @elseif($grupo->pivot->oportunidad == 'Repite') bg-warning
                                                            @elseif($grupo->pivot->oportunidad == 'Especial') bg-info
                                                            @else bg-secondary @endif">
                                                            {{ $grupo->pivot->oportunidad }}
                                                        </span>
                                                    </small>
                                                </div>
                                                <form method="POST" action="{{ route('alumnos.grupos.destroy', [$alumno->n_control, $grupo->id_grupo]) }}" class="d-inline">
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
    
    .fw-bold {
        font-weight: 600;
    }
    
    .badge {
        font-size: 0.7rem;
        padding: 0.3em 0.5em;
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