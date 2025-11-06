@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-lg border-0">
                <!-- Header Principal -->
                <div class="card-header text-white" style="background: linear-gradient(135deg, #002D72 0%, #0056b3 100%);">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-0 fw-bold">
                                <i class="fas fa-users me-2"></i>Detalles del Grupo #{{ $grupo->id_grupo }}
                            </h3>
                            <small class="opacity-75">Información completa del grupo, materia, profesor y alumnos inscritos</small>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-light text-dark fs-6 p-2">
                                <i class="fas fa-graduation-cap me-1"></i>
                                Semestre {{ $grupo->semestre }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card-body bg-light">
                    <!-- Información General en Tarjetas -->
                    <div class="row mb-4">
                        <!-- Información del Grupo -->
                        <div class="col-md-3 mb-3">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-header text-white fw-bold" style="background-color: #002D72;">
                                    <i class="fas fa-info-circle me-2"></i>Información del Grupo
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <strong class="text-primary d-block">ID Grupo:</strong>
                                        <span class="badge bg-primary fs-6">{{ $grupo->id_grupo }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <strong class="text-primary d-block">Semestre:</strong>
                                        <span class="fw-bold" style="color: #002D72;">{{ $grupo->semestre }}</span>
                                    </div>
                                    <!-- NUEVA INFORMACIÓN DEL PERIODO -->
                                    <div>
                                        <strong class="text-primary d-block">Periodo:</strong>
                                        @if($grupo->periodo)
                                            <span class="fw-bold" style="color: #002D72;">{{ $grupo->periodo->periodo_nombre }} {{ $grupo->periodo->anio }}</span>
                                            <br>
                                            <small class="text-muted">{{ $grupo->periodo->codigo_periodo }}</small>
                                            <br>
                                            <span class="badge {{ $grupo->periodo->activo ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $grupo->periodo->activo ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        @else
                                            <span class="text-danger fw-bold">Periodo no asignado</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información de la Materia -->
                        <div class="col-md-3 mb-3">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-header text-white fw-bold" style="background-color: #002D72;">
                                    <i class="fas fa-book me-2"></i>Materia
                                </div>
                                <div class="card-body">
                                    @if($grupo->cod_materia)
                                        <div class="mb-3">
                                            <strong class="text-primary d-block">Código:</strong>
                                            <span class="fw-bold fs-6" style="color: #002D72;">{{ $grupo->cod_materia }}</span>
                                        </div>
                                        <div class="mb-3">
                                            <strong class="text-primary d-block">Nombre:</strong>
                                            <span style="color: #002D72;">
                                                @php
                                                    // Buscar el nombre de la materia en la tabla materias
                                                    $materiaInfo = DB::table('materias')->where('cod_materia', $grupo->cod_materia)->first();
                                                @endphp
                                                {{ $materiaInfo->nombre ?? 'Nombre no encontrado' }}
                                            </span>
                                        </div>
                                        <div class="mb-3">
                                            <strong class="text-primary d-block">Créditos:</strong>
                                            <span style="color: #002D72;">{{ $materiaInfo->credito ?? 'N/A' }}</span>
                                        </div>
                                        <div>
                                            <strong class="text-primary d-block">Estado:</strong>
                                            <span class="badge 
                                                @if(($materiaInfo->materia_estado ?? '') == 'Activa') bg-success
                                                @else bg-secondary @endif">
                                                {{ $materiaInfo->materia_estado ?? 'N/A' }}
                                            </span>
                                        </div>
                                    @else
                                        <div class="text-center text-muted">
                                            <i class="fas fa-exclamation-circle fa-2x mb-2"></i>
                                            <p class="mb-0">Materia no asignada</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Información del Profesor -->
                        <div class="col-md-3 mb-3">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-header text-white fw-bold" style="background-color: #002D72;">
                                    <i class="fas fa-chalkboard-teacher me-2"></i>Profesor
                                </div>
                                <div class="card-body">
                                    @if($grupo->profesore)
                                        <div class="mb-2">
                                            <strong class="text-primary d-block">N° Trabajador:</strong>
                                            <span style="color: #002D72;">{{ $grupo->profesore->n_trabajador }}</span>
                                        </div>
                                        <div class="mb-2">
                                            <strong class="text-primary d-block">Nombre:</strong>
                                            <span style="color: #002D72;">
                                                {{ $grupo->profesore->nombre }} 
                                                {{ $grupo->profesore->s_nombre ?? '' }} 
                                                {{ $grupo->profesore->ap_paterno }} 
                                                {{ $grupo->profesore->ap_materno }}
                                            </span>
                                        </div>
                                        <div class="mb-2">
                                            <strong class="text-primary d-block">Correo:</strong>
                                            <span style="color: #002D72;">{{ $grupo->profesore->correo_institucional ?? 'N/A' }}</span>
                                        </div>
                                        <div>
                                            <strong class="text-primary d-block">Situación:</strong>
                                            <span class="badge 
                                                @if($grupo->profesore->situacion == 'Vigente') bg-success
                                                @elseif($grupo->profesore->situacion == 'En Asignación') bg-warning
                                                @else bg-secondary @endif">
                                                {{ $grupo->profesore->situacion }}
                                            </span>
                                        </div>
                                    @else
                                        <div class="text-center text-muted">
                                            <i class="fas fa-exclamation-circle fa-2x mb-2"></i>
                                            <p class="mb-0">Profesor no asignado</p>
                                            @if($grupo->n_trabajador)
                                                <small>ID: {{ $grupo->n_trabajador }}</small>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Información del Área -->
                        <div class="col-md-3 mb-3">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-header text-white fw-bold" style="background-color: #002D72;">
                                    <i class="fas fa-building me-2"></i>Área del Profesor
                                </div>
                                <div class="card-body">
                                    @if($grupo->profesore && $grupo->profesore->area)
                                        <div class="mb-3">
                                            <strong class="text-primary d-block">Código Área:</strong>
                                            <span style="color: #002D72;">{{ $grupo->profesore->area->cod_area }}</span>
                                        </div>
                                        <div class="mb-3">
                                            <strong class="text-primary d-block">Nombre Área:</strong>
                                            <span style="color: #002D72;">{{ $grupo->profesore->area->area }}</span>
                                        </div>
                                        <div>
                                            <strong class="text-primary d-block">Jefe de Área:</strong>
                                            <span style="color: #002D72;">{{ $grupo->profesore->area->jefe_area ?? 'N/A' }}</span>
                                        </div>
                                    @else
                                        <div class="text-center text-muted">
                                            <i class="fas fa-exclamation-circle fa-2x mb-2"></i>
                                            <p class="mb-0">No hay información del área</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Lista de Alumnos -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header text-white fw-bold" style="background-color: #002D72;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="fas fa-user-graduate me-2"></i>
                                            Alumnos Inscritos
                                        </div>
                                        <span class="badge bg-light text-dark fs-6">
                                            {{ $grupo->alumnos->count() }} alumno(s)
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if($grupo->alumnos->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle">
                                                <thead style="background-color: #002D72; color: white;">
                                                    <tr>
                                                        <th class="text-center" width="8%">#</th>
                                                        <th width="15%">N° Control</th>
                                                        <th width="30%">Nombre Completo</th>
                                                        <th width="15%">Semestre</th>
                                                        <th width="17%">Carrera</th>
                                                        <th width="15%">Situación</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($grupo->alumnos as $index => $alumno)
                                                    @php
                                                        // Obtener nombre de la carrera
                                                        $nombreCarrera = 'N/A';
                                                        if ($alumno->carrera) {
                                                            $nombreCarrera = $alumno->carrera->nombre_carrera;
                                                        } elseif ($alumno->FKid_carrera) {
                                                            // Si no está cargada la relación, mostrar el ID
                                                            $nombreCarrera = 'Carrera ID: ' . $alumno->FKid_carrera;
                                                        }
                                                    @endphp
                                                    <tr class="border-bottom">
                                                        <td class="text-center fw-bold" style="color: #002D72;">
                                                            {{ $index + 1 }}
                                                        </td>
                                                        <td>
                                                            <strong style="color: #002D72;">{{ $alumno->n_control }}</strong>
                                                        </td>
                                                        <td>
                                                            <div class="fw-bold" style="color: #002D72;">
                                                                {{ $alumno->nombre }} 
                                                                {{ $alumno->s_nombre ?? '' }} 
                                                                {{ $alumno->ap_pat }} 
                                                                {{ $alumno->ap_mat }}
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-primary">
                                                                {{ $alumno->semestre }}
                                                            </span>
                                                        </td>
                                                        <td style="color: #002D72;">
                                                            {{ $nombreCarrera }}
                                                        </td>
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
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center py-5">
                                            <i class="fas fa-user-slash fa-3x mb-3" style="color: #6c757d;"></i>
                                            <h5 style="color: #002D72;">No hay alumnos inscritos en este grupo</h5>
                                            <p class="text-muted">Los alumnos aparecerán aquí cuando se inscriban al grupo.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer con Botones -->
                <div class="card-footer bg-white border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('grupos.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i> Volver a la lista de grupos
                        </a>
                        <div>
                            <button onclick="window.print()" class="btn btn-outline-secondary">
                                <i class="fas fa-print me-2"></i> Imprimir
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 0.75rem;
        transition: transform 0.2s ease-in-out;
    }
    
    .card:hover {
        transform: translateY(-2px);
    }
    
    .card-header {
        border-radius: 0.75rem 0.75rem 0 0 !important;
        font-size: 1.1rem;
    }
    
    .table th {
        font-weight: 600;
        font-size: 0.9rem;
        border: none;
    }
    
    .table td {
        vertical-align: middle;
        border-color: #e9ecef;
    }
    
    .badge {
        font-size: 0.75rem;
        padding: 0.4em 0.6em;
    }
    
    .btn {
        border-radius: 0.5rem;
        font-weight: 500;
        padding: 0.5rem 1.5rem;
    }
    
    .text-primary {
        color: #002D72 !important;
    }
    
    .border-bottom {
        border-bottom: 1px solid #e9ecef !important;
    }
    
    .shadow-sm {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 45, 114, 0.1) !important;
    }
</style>
@endsection