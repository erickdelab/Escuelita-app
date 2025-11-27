@extends('layouts.app')

@section('template_title')
    Inscribir Alumno a Grupos
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            
            {{-- 🔥 1. BLOQUE DE ALERTAS (Para mostrar el choque de horarios) --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> {!! session('error') !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            {{-- FIN BLOQUE DE ALERTAS --}}

            <div class="card shadow-lg border-0">
                <div class="card-header text-white" style="background-color: #002D72;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h4 class="mb-0">🎓 {{ __('Inscribir Alumno a Grupos') }}</h4>
                        <a href="{{ route('alumnos.show', $alumno->n_control) }}" class="btn btn-light btn-sm fw-bold">
                            ← {{ __('Regresar al Detalle') }}
                        </a>
                    </div>
                </div>

                <div class="card-body bg-white">
                    {{-- Encabezado Alumno --}}
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="alert alert-info border-0 shadow-sm" style="background-color: rgba(0, 45, 114, 0.1); color: #002D72;">
                                <h5 class="alert-heading fw-bold">
                                    <i class="fas fa-user-circle me-2"></i>
                                    Alumno: {{ $alumno->n_control }} - {{ $alumno->nombre }} {{ $alumno->ap_pat }} {{ $alumno->ap_mat }}
                                </h5>
                                <p class="mb-0">Selecciona un grupo de la lista. El sistema calculará automáticamente si es Primera, Repite o Especial.</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- COLUMNA IZQUIERDA: FORMULARIO --}}
                        <div class="col-md-6">
                            <div class="card mb-4 border shadow-sm">
                                <div class="card-header text-white fw-bold" style="background-color: #002D72;">
                                    <i class="fas fa-chalkboard-teacher me-2"></i> Selección de Grupo
                                </div>
                                <div class="card-body">
                                    @if($gruposDisponibles->count() > 0)
                                        <form method="POST" action="{{ route('alumnos.grupos.store', $alumno->n_control) }}" id="inscripcionForm">
                                            @csrf
                                            
                                            {{-- SELECT DE GRUPO --}}
                                            <div class="form-group mb-4">
                                                <label for="id_grupo" class="form-label fw-bold text-dark">Selecciona un grupo:</label>
                                                <select name="id_grupo" class="form-select form-select-lg" id="id_grupo" required>
                                                    <option value="" selected disabled>-- Seleccione un Grupo --</option>
                                                    @foreach($gruposDisponibles as $grupo)
                                                        @php
                                                            // Asegurar carga de relación
                                                            if (!$grupo->relationLoaded('materia') && $grupo->cod_materia) {
                                                                $grupo->load('materia');
                                                            }
                                                            $nombreMateria = $grupo->materia->nombre ?? 'Materia no encontrada';
                                                            $profesor = $grupo->profesore ? ($grupo->profesore->nombre . ' ' . $grupo->profesore->ap_paterno) : 'Sin Prof.';
                                                            $horario = $grupo->patron ? ($grupo->patron . ' ' . \Carbon\Carbon::parse($grupo->hora_inicio)->format('H:i')) : 'Sin Horario';
                                                        @endphp

                                                        <option value="{{ $grupo->id_grupo }}" 
                                                                data-oportunidad="{{ $grupo->oportunidad_calc }}"
                                                                data-materia="{{ $nombreMateria }}"
                                                                {{ $grupo->estado_materia == 'Bloqueada' ? 'disabled' : '' }}
                                                        >
                                                            @if($grupo->estado_materia == 'Bloqueada')
                                                                ⛔ ({{ $grupo->oportunidad_calc }}) 
                                                            @endif
                                                            {{ $nombreMateria }} - Gpo {{ $grupo->id_grupo }} ({{ $horario }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            {{-- VISUALIZACIÓN AUTOMÁTICA DE OPORTUNIDAD --}}
                                            <div class="card bg-light border-0 mb-4" id="infoOportunidadBox" style="display: none;">
                                                <div class="card-body text-center">
                                                    <h6 class="text-muted mb-2">El alumno cursará esta materia en:</h6>
                                                    <span id="badgeOportunidad" class="badge fs-5 px-4 py-2 bg-secondary">
                                                        Seleccione grupo...
                                                    </span>
                                                    <input type="hidden" name="oportunidad" id="inputOportunidad">
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold" id="btnInscribir" disabled>
                                                <i class="fa fa-check-circle me-2"></i> Confirmar Inscripción
                                            </button>
                                        </form>
                                    @else
                                        <div class="alert alert-warning text-center">
                                            <i class="fa fa-exclamation-triangle fa-2x mb-3"></i><br>
                                            No hay grupos disponibles para inscribir.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- COLUMNA DERECHA: CARGA ACTUAL (MODIFICADA CON HORARIOS) --}}
                        <div class="col-md-6">
                            <div class="card border shadow-sm">
                                <div class="card-header text-white fw-bold" style="background-color: #6c757d;">
                                    <i class="fas fa-list me-2"></i> Carga Académica Actual ({{ $alumno->grupos->count() }})
                                </div>
                                <div class="card-body bg-light">
                                    @if($alumno->grupos->count() > 0)
                                        <ul class="list-group list-group-flush">
                                            @foreach($alumno->grupos as $grupo)
                                                @php
                                                    $nombreMat = $grupo->materia->nombre ?? 'Materia';
                                                    // Mapeo de días para mostrar bonito
                                                    $diasSemana = [1=>'Lun', 2=>'Mar', 3=>'Mié', 4=>'Jue', 5=>'Vie', 6=>'Sáb'];
                                                @endphp
                                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent py-3">
                                                    <div class="w-100">
                                                        {{-- Título Materia --}}
                                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                                            <strong style="color: #002D72;">{{ $nombreMat }}</strong>
                                                            <small class="badge bg-secondary text-white">{{ $grupo->pivot->oportunidad }}</small>
                                                        </div>
                                                        
                                                        {{-- Subtítulo Grupo --}}
                                                        <div class="text-muted small mb-2">
                                                            Grupo {{ $grupo->id_grupo }} | Sem. {{ $grupo->semestre }}
                                                        </div>

                                                        {{-- 🔥 AQUÍ MOSTRAMOS EL HORARIO DETALLADO --}}
                                                        <div class="bg-white p-2 rounded border small">
                                                            @forelse($grupo->horarios as $h)
                                                                <div class="text-dark">
                                                                    <i class="far fa-clock text-primary me-1"></i>
                                                                    <strong>{{ $diasSemana[$h->dia_semana] ?? 'Dia '.$h->dia_semana }}</strong>: 
                                                                    {{ \Carbon\Carbon::parse($h->hora_inicio)->format('H:i') }} - 
                                                                    {{ \Carbon\Carbon::parse($h->hora_fin)->format('H:i') }}
                                                                    @if($h->aula)
                                                                        <span class="text-muted fst-italic ms-1">({{ $h->aula->nombre }})</span>
                                                                    @endif
                                                                </div>
                                                            @empty
                                                                <span class="text-danger fst-italic">Sin horario asignado</span>
                                                            @endforelse
                                                        </div>
                                                    </div>

                                                    {{-- Botón Eliminar --}}
                                                    <div class="ms-3 pt-1">
                                                        <form method="POST" action="{{ route('alumnos.grupos.destroy', [$alumno->n_control, $grupo->id_grupo]) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Desinscribir" onclick="return confirm('¿Seguro que deseas dar de baja esta materia?')">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <div class="text-center py-4 text-muted">
                                            <i class="fa fa-folder-open fa-2x mb-2"></i><br>
                                            Sin materias inscritas.
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

{{-- SCRIPT PARA AUTOMATIZACIÓN (Igual que antes) --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectGrupo = document.getElementById('id_grupo');
        const boxInfo = document.getElementById('infoOportunidadBox');
        const badge = document.getElementById('badgeOportunidad');
        const inputHidden = document.getElementById('inputOportunidad');
        const btnSubmit = document.getElementById('btnInscribir');

        selectGrupo.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const oportunidad = selectedOption.getAttribute('data-oportunidad');

            if (oportunidad) {
                boxInfo.style.display = 'block';
                btnSubmit.disabled = false;
                badge.textContent = oportunidad;
                badge.className = 'badge fs-5 px-4 py-2';

                if (oportunidad === 'Primera') badge.classList.add('bg-success');
                else if (oportunidad === 'Repite') badge.classList.add('bg-warning', 'text-dark');
                else if (oportunidad === 'Especial') badge.classList.add('bg-danger');
                else badge.classList.add('bg-secondary');

                inputHidden.value = oportunidad;
            } else {
                boxInfo.style.display = 'none';
                btnSubmit.disabled = true;
                inputHidden.value = '';
            }
        });
    });
</script>
@endsection