@extends('layouts.teacher')

@section('content')
<div class="container-fluid">
    
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold" style="color: #0d2149;">
                Detalles del Grupo #{{ $grupo->id_grupo }}
            </h4>
            <p class="text-muted mb-0">
                {{ $grupo->materia->nombre }} ({{ $grupo->materia->cod_materia }})
            </p>
        </div>
        <div>
            <a href="{{ route('teacher.grupos.calificar', $grupo->id_grupo) }}" class="btn btn-success text-white me-2">
    <i class="bi bi-pencil-square me-1"></i> Calificar
</a>
            <a href="{{ route('teacher.grupos') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Regresar
            </a>
        </div>
    </div>

    {{-- Información General --}}
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white fw-bold border-bottom">
                    <i class="bi bi-clock me-2 text-primary"></i>Horario Asignado
                </div>
                <div class="card-body">
                    @if($grupo->horarios->isEmpty())
                        <p class="text-muted">Sin horario asignado.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-sm table-borderless">
                                <tbody>
                                    @foreach($diasSemana as $diaNum => $diaNombre)
                                        @if($horariosAgrupados->has($diaNum))
                                            @foreach($horariosAgrupados[$diaNum] as $horario)
                                                <tr>
                                                    <td class="fw-bold text-primary" width="120">{{ $diaNombre }}</td>
                                                    <td>
                                                        {{ \Carbon\Carbon::parse($horario->hora_inicio)->format('h:i A') }} -
                                                        {{ \Carbon\Carbon::parse($horario->hora_fin)->format('h:i A') }}
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-light text-dark border">
                                                            <i class="bi bi-door-open"></i> {{ $horario->aula->nombre ?? 'N/A' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white fw-bold border-bottom">
                    <i class="bi bi-info-circle me-2 text-primary"></i>Resumen
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <small class="text-muted d-block">Semestre</small>
                        <strong>{{ $grupo->semestre }}</strong>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted d-block">Créditos</small>
                        <strong>{{ $grupo->materia->credito }}</strong>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted d-block">Alumnos Inscritos</small>
                        <span class="badge bg-primary">{{ $grupo->alumnos->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Lista de Alumnos --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white fw-bold border-bottom">
            <i class="bi bi-people me-2 text-primary"></i>Listado de Alumnos
        </div>
        <div class="card-body p-0">
            @if($grupo->alumnos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-center ps-4" width="5%">#</th>
                                <th width="15%">N° Control</th>
                                <th>Nombre Completo</th>
                                <th>Carrera</th>
                                <th width="10%">Oportunidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($grupo->alumnos as $index => $alumno)
                                <tr>
                                    <td class="text-center ps-4 text-muted">{{ $index + 1 }}</td>
                                    <td class="fw-bold">{{ $alumno->n_control }}</td>
                                    <td>
                                        {{ $alumno->ap_pat }} {{ $alumno->ap_mat }} {{ $alumno->nombre }}
                                    </td>
                                    <td class="small text-muted">
                                        {{ $alumno->carrera->nombre_carrera ?? 'N/A' }}
                                    </td>
                                    <td>
                                        <span class="badge 
                                            @if($alumno->pivot->oportunidad == 'Primera') bg-success
                                            @elseif($alumno->pivot->oportunidad == 'Repite') bg-warning text-dark
                                            @else bg-danger @endif">
                                            {{ $alumno->pivot->oportunidad }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-person-x display-4"></i>
                    <p class="mt-2">No hay alumnos inscritos en este grupo.</p>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection