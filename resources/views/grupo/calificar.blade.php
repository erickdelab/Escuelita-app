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
                            <i class="fas fa-arrow-left me-1"></i> Regresar
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success m-3 shadow-sm border-0">
                        <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                    </div>
                @elseif(session('error'))
                    <div class="alert alert-danger m-3 shadow-sm border-0">
                        <i class="fas fa-exclamation-triangle me-1"></i> {{ session('error') }}
                    </div>
                @endif

                <div class="card-body bg-white">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="bg-light text-center text-primary">
                                <tr>
                                    <th width="10%">N° Control</th>
                                    <th width="20%" class="text-start">Nombre</th>
                                    <th width="10%">Oportunidad</th>
                                    <th width="8%">U1</th>
                                    <th width="8%">U2</th>
                                    <th width="8%">U3</th>
                                    <th width="8%">U4</th>
                                    <th width="8%">Promedio</th>
                                    <th width="20%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($inscripciones as $inscripcion)
                                    @php
                                        $cal = $inscripcion->calificacion;
                                        $promedio = $cal->promedio ?? null;
                                        
                                        // Obtenemos valores para pintar inputs
                                        $u1 = $cal->u1 ?? ''; 
                                        $u2 = $cal->u2 ?? ''; 
                                        $u3 = $cal->u3 ?? ''; 
                                        $u4 = $cal->u4 ?? '';
                                        
                                        $promedioListo = !is_null($promedio);
                                    @endphp

                                    <tr>
                                        <form action="{{ route('grupos.calificar.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="alumno_grupo_id" value="{{ $inscripcion->id }}">

                                            <td class="text-center fw-bold small">{{ $inscripcion->n_control }}</td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-bold">{{ $inscripcion->alumno->nombre }} {{ $inscripcion->alumno->ap_pat }}</span>
                                                    <span class="text-muted small">{{ $inscripcion->alumno->ap_mat }}</span>
                                                </div>
                                            </td>
                                            
                                            <td class="text-center">
                                                <span class="badge rounded-pill
                                                    @if($inscripcion->oportunidad == 'Primera') bg-primary
                                                    @elseif($inscripcion->oportunidad == 'Repite') bg-warning text-dark
                                                    @elseif($inscripcion->oportunidad == 'Especial') bg-danger
                                                    @else bg-secondary @endif">
                                                    {{ $inscripcion->oportunidad }}
                                                </span>
                                            </td>

                                            {{-- Inputs con alerta visual si es < 70 --}}
                                            <td><input type="number" step="0.01" name="u1" value="{{ $u1 }}" class="form-control form-control-sm text-center input-calif {{ ($u1 !== '' && $u1 < 70) ? 'text-danger fw-bold border-danger' : '' }}" placeholder="-"></td>
                                            <td><input type="number" step="0.01" name="u2" value="{{ $u2 }}" class="form-control form-control-sm text-center input-calif {{ ($u2 !== '' && $u2 < 70) ? 'text-danger fw-bold border-danger' : '' }}" placeholder="-"></td>
                                            <td><input type="number" step="0.01" name="u3" value="{{ $u3 }}" class="form-control form-control-sm text-center input-calif {{ ($u3 !== '' && $u3 < 70) ? 'text-danger fw-bold border-danger' : '' }}" placeholder="-"></td>
                                            <td><input type="number" step="0.01" name="u4" value="{{ $u4 }}" class="form-control form-control-sm text-center input-calif {{ ($u4 !== '' && $u4 < 70) ? 'text-danger fw-bold border-danger' : '' }}" placeholder="-"></td>

                                            {{-- Promedio --}}
                                            <td class="text-center fw-bold">
                                                @if($promedioListo)
                                                    @if($promedio == 0)
                                                        {{-- Si es 0, mostramos N.A. o 0 en rojo --}}
                                                        <span class="text-danger fs-6">0.0</span>
                                                    @elseif($promedio < 70)
                                                        <span class="text-danger">{{ number_format($promedio, 1) }}</span>
                                                    @else
                                                        <span class="text-success">{{ number_format($promedio, 1) }}</span>
                                                    @endif
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>

                                            {{-- Botones --}}
                                            <td class="text-center">
                                                {{-- Botón AZUL: Solo Guarda --}}
                                                <button type="submit" class="btn btn-sm btn-outline-primary me-1" title="Guardar Cambios">
                                                    <i class="fas fa-save"></i>
                                                </button>
                                        </form> 

                                        {{-- Botón VERDE: Finaliza (Solo activo si hay promedio) --}}
                                        @if($promedioListo)
                                            <form action="{{ route('grupos.calificar.finalizar', $inscripcion->id) }}" method="POST" class="d-inline"
                                                  onsubmit="return confirm('¿FINALIZAR CURSO?\n\nCalificación Final: {{ number_format($promedio, 1) }}\n\nSe moverá a la Boleta y el alumno saldrá del grupo.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-success text-white" title="Finalizar y enviar a Boleta">
                                                    <i class="fas fa-check-double"></i> Finalizar
                                                </button>
                                            </form>
                                        @else
                                            <button type="button" class="btn btn-sm btn-secondary" disabled title="Debes capturar las 4 unidades">
                                                <i class="fas fa-lock"></i>
                                            </button>
                                        @endif
                                            </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-5 text-muted">
                                            <i class="fas fa-users-slash fa-3x mb-3"></i>
                                            <h5>No hay alumnos inscritos en este grupo.</h5>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="card-footer bg-light text-danger fw-bold text-end small">
                    <i class="fas fa-exclamation-triangle me-1"></i> 
                    REGLA DE ACREDITACIÓN: Si una o más unidades son menores a 70, el promedio final será automáticamente 0.
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    .input-calif { border: 1px solid #ced4da; transition: border-color 0.2s; max-width: 70px; margin: 0 auto; }
    .input-calif:focus { border-color: #002D72; box-shadow: 0 0 0 0.2rem rgba(0, 45, 114, 0.25); }
    .table-hover tbody tr:hover { background-color: rgba(0, 45, 114, 0.05); }
</style>

<script>
    document.querySelectorAll('.input-calif').forEach(input => {
        input.addEventListener('input', function() {
            if (this.value > 100) this.value = 100;
            if (this.value < 0) this.value = 0;
        });
    });
</script>
@endsection