@extends('layouts.app')

@section('template_title')
    Detalle del Profesor
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card shadow-lg border-0">
                <!-- Header -->
                <div class="card-header text-white" style="background-color: #002D72;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h4 class="mb-0">👨‍🏫 {{ __('Detalle del Profesor') }}</h4>
                        
                        {{-- BOTONES DE ACCIÓN --}}
                        <div class="float-right">
                            {{-- ✅ NUEVO BOTÓN: HORARIO --}}
                            <a href="{{ route('profesores.horario', $profesore->n_trabajador) }}" class="btn btn-primary btn-sm fw-bold me-2" style="background-color: #6f42c1; border-color: #6f42c1;">
                                <i class="fas fa-calendar-alt me-1"></i> Ver Horario
                            </a>

                            <a href="{{ route('profesores.index') }}" class="btn btn-light btn-sm fw-bold">
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
                                            <th width="40%">N° Trabajador:</th>
                                            <td><strong>{{ $profesore->n_trabajador }}</strong></td>
                                        </tr>
                                        <tr>
                                            <th>Nombre Completo:</th>
                                            <td>{{ $profesore->nombre }} {{ $profesore->s_nombre ?? '' }} {{ $profesore->ap_paterno }} {{ $profesore->ap_materno }}</td>
                                        </tr>
                                        <tr>
                                            <th>Correo Institucional:</th>
                                            <td>{{ $profesore->correo_institucional }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header text-white" style="background-color: #002D72;">
                                    <h5 class="mb-0">Información Profesional</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="40%">Área:</th>
                                            <td>{{ $profesore->area->area ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Situación:</th>
                                            <td>
                                                <span class="badge 
                                                    @if($profesore->situacion == 'Vigente') bg-success
                                                    @elseif($profesore->situacion == 'Inactivo/Baja') bg-danger
                                                    @elseif($profesore->situacion == 'En Asignación') bg-warning text-dark
                                                    @else bg-secondary @endif">
                                                    {{ $profesore->situacion }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Grupos Asignados -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header text-white" style="background-color: #002D72;">
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <h5 class="mb-0">Grupos Asignados ({{ $profesore->grupos->count() ?? 0 }})</h5>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if($profesore->grupos && $profesore->grupos->count() > 0)
                                        @foreach($profesore->grupos as $grupo)
                                            @php
                                                if (!$grupo->relationLoaded('materia') && $grupo->cod_materia) {
                                                    $grupo->load('materia');
                                                }
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
                                                        <br>
                                                        <span class="badge bg-primary">
                                                            {{ $grupo->alumnos_count ?? $grupo->alumnos->count() }} alumnos
                                                        </span>
                                                    </small>
                                                </div>
                                                <a href="{{ route('grupos.show', $grupo->id_grupo) }}" class="btn btn-outline-primary btn-sm">
                                                    Ver Grupo
                                                </a>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="alert alert-info">
                                            <i class="bi bi-info-circle"></i> El profesor no tiene grupos asignados.
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