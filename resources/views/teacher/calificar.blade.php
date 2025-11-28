@extends('layouts.teacher')

@section('content')
<div class="container-fluid">
    
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold" style="color: #0d2149;">
                <i class="bi bi-pencil-square me-2"></i>Calificar Grupo
            </h4>
            <p class="text-muted mb-0">
                {{ $grupo->materia->nombre }} ({{ $grupo->materia->cod_materia }}) | 
                <span class="badge bg-light text-dark border">Grupo {{ $grupo->id_grupo }}</span>
            </p>
        </div>
        <a href="{{ route('teacher.grupos.show', $grupo->id_grupo) }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Regresar
        </a>
    </div>

    {{-- Alertas --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger border-0 shadow-sm mb-4">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3">
            <div class="d-flex justify-content-between align-items-center">
                <span class="fw-bold text-primary">Listado de Alumnos</span>
                <small class="text-danger fw-bold">
                    <i class="bi bi-info-circle me-1"></i>Nota: Si una unidad es < 70, el promedio será 0.
                </small>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #f8f9fa;">
                        <tr class="text-uppercase small text-muted">
                            <th class="ps-4" width="20%">Alumno</th>
                            <th class="text-center" width="10%">Oportunidad</th>
                            <th class="text-center" width="10%">U1</th>
                            <th class="text-center" width="10%">U2</th>
                            <th class="text-center" width="10%">U3</th>
                            <th class="text-center" width="10%">U4</th>
                            <th class="text-center" width="10%">Promedio</th>
                            <th class="text-center" width="15%">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inscripciones as $inscripcion)
                            @php
                                $cal = $inscripcion->calificacion;
                                $promedio = $cal->promedio ?? null;
                                $promedioListo = !is_null($promedio);
                                
                                // Valores para los inputs
                                $u1 = $cal->u1 ?? ''; 
                                $u2 = $cal->u2 ?? ''; 
                                $u3 = $cal->u3 ?? ''; 
                                $u4 = $cal->u4 ?? '';
                            @endphp

                            <tr>
                                {{-- Formulario Individual por Fila --}}
                                <form action="{{ route('grupos.calificar.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="alumno_grupo_id" value="{{ $inscripcion->id }}">

                                    <td class="ps-4">
                                        <div class="fw-bold text-dark">
                                            {{ $inscripcion->alumno->ap_pat }} {{ $inscripcion->alumno->ap_mat }}
                                        </div>
                                        <div class="small text-muted">{{ $inscripcion->alumno->nombre }}</div>
                                        <div class="small text-primary font-monospace">{{ $inscripcion->n_control }}</div>
                                    </td>
                                    
                                    <td class="text-center">
                                        <span class="badge rounded-pill 
                                            @if($inscripcion->oportunidad == 'Primera') bg-primary-subtle text-primary border border-primary-subtle
                                            @elseif($inscripcion->oportunidad == 'Repite') bg-warning-subtle text-warning-emphasis border border-warning-subtle
                                            @else bg-danger-subtle text-danger border border-danger-subtle @endif">
                                            {{ $inscripcion->oportunidad }}
                                        </span>
                                    </td>

                                    {{-- Inputs de Calificación --}}
                                    <td><input type="number" step="0.01" name="u1" value="{{ $u1 }}" class="form-control form-control-sm text-center input-calif {{ ($u1 !== '' && $u1 < 70) ? 'is-invalid text-danger fw-bold' : '' }}" placeholder="-"></td>
                                    <td><input type="number" step="0.01" name="u2" value="{{ $u2 }}" class="form-control form-control-sm text-center input-calif {{ ($u2 !== '' && $u2 < 70) ? 'is-invalid text-danger fw-bold' : '' }}" placeholder="-"></td>
                                    <td><input type="number" step="0.01" name="u3" value="{{ $u3 }}" class="form-control form-control-sm text-center input-calif {{ ($u3 !== '' && $u3 < 70) ? 'is-invalid text-danger fw-bold' : '' }}" placeholder="-"></td>
                                    <td><input type="number" step="0.01" name="u4" value="{{ $u4 }}" class="form-control form-control-sm text-center input-calif {{ ($u4 !== '' && $u4 < 70) ? 'is-invalid text-danger fw-bold' : '' }}" placeholder="-"></td>

                                    {{-- Promedio Calculado --}}
                                    <td class="text-center fw-bold fs-6">
                                        @if($promedioListo)
                                            @if($promedio < 70)
                                                <span class="text-danger">{{ number_format($promedio, 1) }}</span>
                                            @else
                                                <span class="text-success">{{ number_format($promedio, 1) }}</span>
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>

                                    {{-- Botones de Acción --}}
                                    <td class="text-center">
                                        {{-- Guardar --}}
                                        <button type="submit" class="btn btn-sm btn-primary" title="Guardar Calificaciones">
                                            <i class="bi bi-save"></i>
                                        </button>
                                </form> 
                                        
                                        {{-- Finalizar (Separado del form de guardar) --}}
                                        @if($promedioListo)
                                            <form action="{{ route('grupos.calificar.finalizar', $inscripcion->id) }}" method="POST" class="d-inline ms-1"
                                                onsubmit="return confirm('¿FINALIZAR CURSO?\n\nCalificación Final: {{ number_format($promedio, 1) }}\n\nEsta acción moverá la calificación a la Boleta y retirará al alumno de la lista activa.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-success text-white" title="Finalizar Curso">
                                                    <i class="bi bi-check-lg"></i>
                                                </button>
                                            </form>
                                        @else
                                            <button type="button" class="btn btn-sm btn-secondary ms-1" disabled>
                                                <i class="bi bi-lock-fill"></i>
                                            </button>
                                        @endif
                                    </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="bi bi-person-x display-4"></i>
                                    <p class="mt-2">No hay alumnos inscritos.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .input-calif { max-width: 65px; margin: 0 auto; }
    .input-calif:focus { border-color: #0d2149; box-shadow: 0 0 0 0.2rem rgba(13, 33, 73, 0.25); }
</style>

<script>
    // Validación rápida de rango en el cliente
    document.querySelectorAll('.input-calif').forEach(input => {
        input.addEventListener('input', function() {
            if (this.value > 100) this.value = 100;
            if (this.value < 0) this.value = 0;
        });
    });
</script>
@endsection