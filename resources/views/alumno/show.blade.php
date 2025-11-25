@extends('layouts.app')

@section('template_title')
    Detalle del Alumno
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card shadow-lg border-0">
                <!-- Header -->
                <div class="card-header text-white" style="background-color: #002D72;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h4 class="mb-0">🎓 {{ __('Detalle del Alumno') }}</h4>
                        <div class="float-right">
                            {{-- ✅ NUEVO BOTÓN: VER KARDEX --}}
            <a href="{{ route('kardex.show', $alumno->n_control) }}" class="btn btn-warning btn-sm fw-bold text-dark me-2">
                <i class="fas fa-th me-1"></i> Ver Retícula / Kardex
            </a>
                            <a href="{{ route('alumnos.index') }}" class="btn btn-light btn-sm fw-bold">
                                ← {{ __('Regresar') }}
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body bg-white">
                    <!-- Información Personal -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header text-white" style="background-color: #002D72;">
                                    <h5 class="mb-0">Información Personal</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="40%">Número de Control:</th>
                                            <td><strong>{{ $alumno->n_control }}</strong></td>
                                        </tr>
                                        <tr>
                                            <th>Nombre Completo:</th>
                                            <td>{{ $alumno->nombre }} {{ $alumno->s_nombre ?? '' }} {{ $alumno->ap_pat }} {{ $alumno->ap_mat }}</td>
                                        </tr>
                                        <tr>
                                            <th>Fecha de Nacimiento:</th>
                                            <td>{{ $alumno->fech_nac }}</td>
                                        </tr>
                                        <tr>
                                            <th>Género:</th>
                                            <td>{{ $alumno->genero == 'M' ? 'Masculino' : ($alumno->genero == 'F' ? 'Femenino' : $alumno->genero) }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header text-white" style="background-color: #002D72;">
                                    <h5 class="mb-0">Información Académica</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="40%">Carrera:</th>
                                            <td>{{ $alumno->carrera->nombre_carrera ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Situación:</th>
                                            <td>
                                                <span class="badge 
                                                    @if($alumno->situacion == 'Vigente') bg-success
                                                    @elseif($alumno->situacion == 'Baja') bg-danger
                                                    @elseif($alumno->situacion == 'Egresado') bg-info
                                                    @else bg-secondary @endif">
                                                    {{ $alumno->situacion }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Semestre:</th>
                                            <td>
                                                @if($alumno->semestre)
                                                    <span class="badge bg-primary">Semestre {{ $alumno->semestre }}</span>
                                                @else
                                                    <span class="text-muted">No asignado</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <!-- ✅ NUEVA FILA: Promedio General -->
                                        <tr>
                                            <th>Promedio General:</th>
                                            <td>
                                                @if($alumno->promedio_general !== null)
                                                    <span class="badge 
                                                        @if($alumno->promedio_general >= 90) bg-success
                                                        @elseif($alumno->promedio_general >= 80) bg-info
                                                        @elseif($alumno->promedio_general >= 70) bg-warning
                                                        @else bg-danger @endif">
                                                        {{ number_format($alumno->promedio_general, 2) }}%
                                                    </span>
                                                @else
                                                    <span class="text-muted">No asignado</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Materias Tomadas -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header text-white" style="background-color: #002D72;">
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <h5 class="mb-0">Materias Inscritas ({{ $alumno->grupos->count() }})</h5>
                                        <a href="{{ route('alumnos.grupos.create', $alumno->n_control) }}" class="btn btn-light btn-sm">
                                            <i class="fa fa-plus"></i> Inscribir a Grupo
                                        </a>
                                    </div>
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