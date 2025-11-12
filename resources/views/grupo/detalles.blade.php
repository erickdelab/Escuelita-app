@extends('layouts.app')

{{-- MODIFICADO: Usamos el título del grupo --}}
@section('template_title')
    Detalles del Grupo #{{ $grupo->id_grupo }}
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            
            @if ($message = Session::get('success'))
                <div class="alert alert-success shadow-sm border-0 rounded">
                    <p class="mb-0">{{ $message }}</p>
                </div>
            @elseif ($message = Session::get('error'))
                <div class="alert alert-danger shadow-sm border-0 rounded">
                    <p class="mb-0">{{ $message }}</p>
                </div>
            @endif

            <div class="card shadow-lg border-0">
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
                    <div class="row mb-4">
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

                        <div class="col-md-3 mb-3">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-header text-white fw-bold" style="background-color: #002D72;">
                                    <i class="fas fa-book me-2"></i>Materia
                                </div>
                                <div class="card-body">
                                    @if($grupo->materia)
                                        <div class="mb-3">
                                            <strong class="text-primary d-block">Código:</strong>
                                            <span class="fw-bold fs-6" style="color: #002D72;">{{ $grupo->materia->cod_materia }}</span>
                                        </div>
                                        <div class="mb-3">
                                            <strong class="text-primary d-block">Nombre:</strong>
                                            <span style="color: #002D72;">{{ $grupo->materia->nombre }}</span>
                                        </div>
                                        <div class="mb-3">
                                            <strong class="text-primary d-block">Créditos:</strong>
                                            <span style="color: #002D72;">{{ $grupo->materia->credito }}</span>
                                        </div>
                                        <div>
                                            <strong class="text-primary d-block">Estado:</strong>
                                            <span class="badge {{ $grupo->materia->materia_estado == 'Activa' ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $grupo->materia->materia_estado }}
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
                                                {{ $grupo->profesore->nombre }} {{ $grupo->profesore->s_nombre ?? '' }} {{ $grupo->profesore->ap_paterno }} {{ $grupo->profesore->ap_materno }}
                                            </span>
                                        </div>
                                        <div class="mb-2">
                                            <strong class="text-primary d-block">Correo:</strong>
                                            <span style="color: #002D72;">{{ $grupo->profesore->correo_institucional ?? 'N/A' }}</span>
                                        </div>
                                        <div>
                                            <strong class="text-primary d-block">Situación:</strong>
                                            <span class="badge {{ $grupo->profesore->situacion == 'Vigente' ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $grupo->profesore->situacion }}
                                            </span>
                                        </div>
                                    @else
                                        <div class="text-center text-muted">
                                            <i class="fas fa-exclamation-circle fa-2x mb-2"></i>
                                            <p class="mb-0">Profesor no asignado</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-header text-white fw-bold" style="background-color: #002D72;">
                                    <i class="fas fa-building me-2"></i>Área del Profesor
                                </div>
                                <div class="card-body">
                                    @if($grupo->profesore && $grupo->profesore->area)
                                        <div class="mb-3">
                                            <strong class="text-primary d-block">Nombre Área:</strong>
                                            <span style="color: #002D72;">{{ $grupo->profesore->area->area }}</span>
                                        </div>
                                        <div>
                                            <strong class="text-primary d-block">Jefe de Área:</strong>
                                            <span style="color: #002D72;">{{ $grupo->profesore->area->jefe->nombre ?? 'N/A' }}</span>
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

                    
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header text-white fw-bold" style="background-color: #002D72;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="fas fa-calendar-alt me-2"></i>
                                            Gestión de Horario
                                        </div>
                                        @if($grupo->horarios->count() > 0 || $grupo->patron)
                                            <form method="POST" action="{{ route('grupos.horario.destroy', $grupo->id_grupo) }}" class="d-inline" onsubmit="return confirm('¿Estás seguro de que deseas ELIMINAR el horario actual de este grupo?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash me-1"></i> Eliminar Horario
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 border-end">
                                            <h6 class="text-dark fw-bold">Horario Actual</h6>
                                            @if($grupo->horarios->isEmpty())
                                                <div class="alert alert-warning text-center mt-3">
                                                    <i class="fas fa-calendar-times fa-lg mb-2"></i>
                                                    <p class="mb-0">Sin horario asignado.</p>
                                                </div>
                                            @else
                                                @foreach($diasSemana as $diaNum => $diaNombre)
                                                    @if($horariosAgrupados->has($diaNum))
                                                        <strong class="text-primary">{{ $diaNombre }}</strong>
                                                        <ul class="list-group list-group-flush mb-2">
                                                            @foreach($horariosAgrupados[$diaNum] as $horario)
                                                                <li class="list-group-item d-flex justify-content-between align-items-center ps-0">
                                                                    <span>
                                                                        <i class="fas fa-clock me-2 text-muted"></i>
                                                                        {{ \Carbon\Carbon::parse($horario->hora_inicio)->format('h:i A') }} - 
                                                                        {{ \Carbon\Carbon::parse($horario->hora_fin)->format('h:i A') }}
                                                                    </span>
                                                                    <span class="badge bg-primary rounded-pill">
                                                                        <i class="fas fa-door-open me-1"></i>
                                                                        {{ $horario->aula->nombre ?? 'N/A' }}
                                                                    </span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>

                                        <div class="col-md-8">
                                            <h6 class="text-dark fw-bold">Modificar Horario</h6>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <form method="POST" action="{{ route('grupos.hora.store', $grupo->id_grupo) }}">
                                                        @csrf
                                                        <label class="form-label fw-bold">Paso 1: Patrón y Hora</label>
                                                        <div class="input-group mb-2">
                                                            <select name="patron" class="form-select" required>
                                                                <option value="">Patrón...</option>
                                                                <option value="L-M" {{ $grupo->patron == 'L-M' ? 'selected' : '' }}>Lunes y Miérc.</option>
                                                                <option value="M-J" {{ $grupo->patron == 'M-J' ? 'selected' : '' }}>Martes y Juev.</option>
                                                            </select>
                                                            <select name="hora_inicio" class="form-select" required>
                                                                <option value="">Hora...</option>
                                                                @foreach ($allowedStartTimes as $hora)
                                                                    <option value="{{ $hora }}" {{ $grupo->hora_inicio == $hora ? 'selected' : '' }}>
                                                                        {{ \Carbon\Carbon::parse($hora)->format('h:i A') }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <button type="submit" class="btn btn-warning btn-sm w-100">
                                                            <i class="fas fa-save me-1"></i> Guardar Patrón/Hora
                                                        </button>
                                                    </form>
                                                </div>
                                                <div class="col-lg-6">
                                                    <form method="POST" action="{{ route('grupos.aula.store', $grupo->id_grupo) }}">
                                                        @csrf
                                                        <label class="form-label fw-bold">Paso 2: Aula</label>
                                                        @if (!$grupo->patron || !$grupo->hora_inicio)
                                                            <div class="alert alert-info p-2 text-center">
                                                                <small>Complete el Paso 1 para ver aulas.</small>
                                                            </div>
                                                        @else
                                                            <select name="aula_id" class="form-select mb-2" required>
                                                                <option value="">-- Selecciona un aula --</option>
                                                                @foreach ($aulasDisponibles as $aula)
                                                                    <option value="{{ $aula->id }}">{{ $aula->nombre }} (Cap: {{ $aula->capacidad }})</option>
                                                                @endforeach
                                                                
                                                                @if(count($aulasOcupadas) > 0)
                                                                    <optgroup label="Ocupadas">
                                                                        @foreach ($aulasOcupadas as $aula)
                                                                            <option value="{{ $aula->id }}" disabled>{{ $aula->nombre }} (Ocupada)</option>
                                                                        @endforeach
                                                                    </optgroup>
                                                                @endif
                                                            </select>
                                                            <button type="submit" class="btn btn-success btn-sm w-100">
                                                                <i class="fas fa-check-circle me-1"></i> Asignar Aula
                                                            </button>
                                                        @endif
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                                <thead style="background-color: #f8f9fa;">
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
                                                    <tr class="border-bottom">
                                                        <td class="text-center fw-bold" style="color: #002D72;">
                                                            {{ $index + 1 }}
                                                        </td>
                                                        <td>
                                                            <strong style="color: #002D72;">{{ $alumno->n_control }}</strong>
                                                        </td>
                                                        <td>
                                                            <div class="fw-bold" style="color: #002D72;">
                                                                {{ $alumno->nombre }} {{ $alumno->s_nombre ?? '' }} {{ $alumno->ap_pat }} {{ $alumno->ap_mat }}
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-primary">
                                                                {{ $alumno->semestre }}
                                                            </span>
                                                        </td>
                                                        <td style="color: #002D72;">
                                                            {{ $alumno->carrera->nombre_carrera ?? 'N/A' }}
                                                        </td>
                                                        <td>
                                                            <span class="badge {{ $alumno->situacion == 'Vigente' ? 'bg-success' : 'bg-danger' }}">
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
    /* Estilos para los formularios de horario */
    .border-end {
        border-right: 1px solid #dee2e6 !important;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: .875rem;
    }
    .list-group-flush .list-group-item {
        background-color: transparent;
    }
</style>
@endsection