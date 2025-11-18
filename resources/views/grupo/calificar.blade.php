@extends('layouts.app')

@section('template_title')
    Calificar Grupo #{{ $grupo->id_grupo }}
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card shadow-lg border-0">
                
                {{-- HEADER --}}
                <div class="card-header text-white" style="background: linear-gradient(135deg, #002D72 0%, #0056b3 100%);">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-0 fw-bold">
                                <i class="fas fa-clipboard-list me-2"></i>Calificar Grupo
                            </h3>
                            <small class="opacity-75">
                                {{ $grupo->materia->nombre }} ({{ $grupo->materia->cod_materia }}) | Semestre {{ $grupo->semestre }}
                            </small>
                        </div>
                        <a href="{{ route('grupos.show', $grupo->id_grupo) }}" class="btn btn-light btn-sm fw-bold text-primary">
                            <i class="fas fa-arrow-left me-1"></i> Regresar al Grupo
                        </a>
                    </div>
                </div>

                {{-- ALERTA DE ÉXITO/ERROR --}}
                @if(session('success'))
                    <div class="alert alert-success m-3 shadow-sm border-0">
                        <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                    </div>
                @endif

                {{-- TABLA DE ALUMNOS --}}
                <div class="card-body bg-white">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="bg-light text-center text-primary">
                                <tr>
                                    <th width="10%">N° Control</th>
                                    <th width="25%" class="text-start">Nombre del Alumno</th>
                                    <th width="10%">Oportunidad</th>
                                    <th width="10%">U1</th>
                                    <th width="10%">U2</th>
                                    <th width="10%">U3</th>
                                    <th width="10%">U4</th>
                                    <th width="10%">Promedio</th>
                                    <th width="5%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($inscripciones as $inscripcion)
                                    <tr>
                                        {{-- FORMULARIO DE CALIFICACIÓN --}}
                                        <form action="{{ route('grupos.calificar.store') }}" method="POST">
                                            @csrf
                                            {{-- ID de la relación alumno_grupo --}}
                                            <input type="hidden" name="alumno_grupo_id" value="{{ $inscripcion->id }}">

                                            {{-- DATOS INFORMATIVOS --}}
                                            <td class="text-center fw-bold">{{ $inscripcion->n_control }}</td>
                                            <td>
                                                {{ $inscripcion->alumno->nombre }} 
                                                {{ $inscripcion->alumno->ap_pat }} 
                                                {{ $inscripcion->alumno->ap_mat }}
                                            </td>
                                            
                                            {{-- ESTATUS / OPORTUNIDAD --}}
                                            <td class="text-center">
                                                <span class="badge rounded-pill
                                                    @if($inscripcion->oportunidad == 'Aprobada') bg-success
                                                    @elseif($inscripcion->oportunidad == 'Primera') bg-primary
                                                    @elseif($inscripcion->oportunidad == 'Repite') bg-warning text-dark
                                                    @elseif($inscripcion->oportunidad == 'Especial') bg-danger
                                                    @endif">
                                                    {{ $inscripcion->oportunidad }}
                                                </span>
                                            </td>

                                            {{-- INPUTS U1 - U4 --}}
                                            {{-- Se usa el operador null safe o ?? para evitar error si no existe calificación --}}
                                            <td>
                                                <input type="number" step="0.01" min="0" max="100" name="u1" 
                                                       class="form-control form-control-sm text-center input-calif" 
                                                       value="{{ $inscripcion->calificacion->u1 ?? '' }}" placeholder="-">
                                            </td>
                                            <td>
                                                <input type="number" step="0.01" min="0" max="100" name="u2" 
                                                       class="form-control form-control-sm text-center input-calif" 
                                                       value="{{ $inscripcion->calificacion->u2 ?? '' }}" placeholder="-">
                                            </td>
                                            <td>
                                                <input type="number" step="0.01" min="0" max="100" name="u3" 
                                                       class="form-control form-control-sm text-center input-calif" 
                                                       value="{{ $inscripcion->calificacion->u3 ?? '' }}" placeholder="-">
                                            </td>
                                            <td>
                                                <input type="number" step="0.01" min="0" max="100" name="u4" 
                                                       class="form-control form-control-sm text-center input-calif" 
                                                       value="{{ $inscripcion->calificacion->u4 ?? '' }}" placeholder="-">
                                            </td>

                                            {{-- PROMEDIO (Calculado en Backend, visualizado aquí) --}}
                                            <td class="text-center fw-bold">
                                                @if(isset($inscripcion->calificacion->promedio))
                                                    <span class="{{ $inscripcion->calificacion->promedio >= 70 ? 'text-success' : 'text-danger' }}">
                                                        {{ number_format($inscripcion->calificacion->promedio, 1) }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>

                                            {{-- BOTÓN GUARDAR --}}
                                            <td class="text-center">
                                                <button type="submit" class="btn btn-sm btn-outline-primary" title="Guardar Calificaciones">
                                                    <i class="fas fa-save"></i>
                                                </button>
                                        </form>
                                                {{-- BOTÓN DESINSCRIBIR (Formulario separado) --}}
                                                <form action="{{ route('grupos.calificar.desinscribir', $inscripcion->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de desinscribir a este alumno? Se perderán sus calificaciones parciales.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger ms-1" title="Desinscribir Alumno">
                                                        <i class="fas fa-user-times"></i>
                                                    </button>
                                                </form>
                                            </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-5 text-muted">
                                            <i class="fas fa-users-slash fa-3x mb-3"></i>
                                            <h5>No hay alumnos inscritos en este grupo.</h5>
                                            <a href="{{ route('alumnos.index') }}" class="btn btn-link">Ir a inscribir alumnos</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="card-footer bg-light text-muted text-end small">
                    Nota: El promedio se calcula automáticamente cuando las 4 unidades tienen valor. <br>
                    Calificación mínima aprobatoria: 70.
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    /* Estilos para inputs de calificación */
    .input-calif {
        border: 1px solid #ced4da;
        transition: border-color 0.2s;
    }
    .input-calif:focus {
        border-color: #002D72;
        box-shadow: 0 0 0 0.2rem rgba(0, 45, 114, 0.25);
    }
    /* Tabla Hover más suave */
    .table-hover tbody tr:hover {
        background-color: rgba(0, 45, 114, 0.05);
    }
</style>

{{-- Script opcional para validación rápida en cliente (solo enteros o decimales validos) --}}
<script>
    document.querySelectorAll('.input-calif').forEach(input => {
        input.addEventListener('input', function() {
            if (this.value > 100) this.value = 100;
            if (this.value < 0) this.value = 0;
        });
    });
</script>
@endsection