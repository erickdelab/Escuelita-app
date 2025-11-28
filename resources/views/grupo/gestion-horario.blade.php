@extends('layouts.app')

@section('template_title')
    Gestionar Horario - Grupo {{ $grupo->id_grupo }}
@endsection

@section('content')
<div class="container-fluid">
    {{-- ✅ AGREGAR ESTO: Bloque para mostrar errores de choque --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
            <h5 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i> Error al asignar horario</h5>
            <p class="mb-0">{{ session('error') }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    {{-- Fin del bloque de error --}}
    
    {{-- 1. DETALLES DEL GRUPO (Parte Superior) --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header text-white" style="background-color: #002D72;">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-clock me-2"></i>Gestión de Horario
                </h5>
                <a href="{{ route('grupos.show', $grupo->id_grupo) }}" class="btn btn-light btn-sm fw-bold">
                    <i class="fas fa-arrow-left me-1"></i> Regresar
                </a>
            </div>
        </div>
        <div class="card-body bg-light">
            <div class="row text-center text-md-start">
                <div class="col-md-3 border-end">
                    <small class="text-muted text-uppercase fw-bold">Materia</small>
                    <div class="text-primary fw-bold">{{ $grupo->materia->nombre }}</div>
                    <small>{{ $grupo->materia->cod_materia }}</small>
                </div>
                <div class="col-md-3 border-end">
                    <small class="text-muted text-uppercase fw-bold">Profesor</small>
                    <div class="text-dark fw-bold">
                        {{ $grupo->profesore->nombre }} {{ $grupo->profesore->ap_paterno }}
                    </div>
                    <small>ID: {{ $grupo->n_trabajador }}</small>
                </div>
                <div class="col-md-3 border-end">
                    <small class="text-muted text-uppercase fw-bold">Detalles</small>
                    <div>
                        <span class="badge bg-secondary">Semestre {{ $grupo->semestre }}</span>
                        <span class="badge bg-info text-dark">Créditos: {{ $grupo->materia->credito }}</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <small class="text-muted text-uppercase fw-bold">Periodo</small>
                    <div class="text-success fw-bold">
                        {{ $grupo->periodo->periodo_nombre ?? '' }} {{ $grupo->periodo->anio ?? '' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        
        {{-- 2. CUADRÍCULA DE HORARIO DEL PROFESOR (Visual) --}}
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0 fw-bold text-primary">
                        <i class="fas fa-calendar-week me-1"></i> Disponibilidad del Profesor
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-middle mb-0 table-sm" style="font-size: 0.85rem;">
                            <thead class="text-white" style="background-color: #002D72;">
                                <tr>
                                    <th style="width: 60px;">Hora</th>
                                    <th style="width: 18%;">Lunes</th>
                                    <th style="width: 18%;">Martes</th>
                                    <th style="width: 18%;">Miércoles</th>
                                    <th style="width: 18%;">Jueves</th>
                                    <th style="width: 18%;">Viernes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($horas as $hora)
                                    <tr>
                                        <td class="fw-bold bg-light">{{ sprintf('%02d', $hora) }}:00</td>
                                        
                                        @for($dia = 1; $dia <= 5; $dia++)
                                            @if(isset($mapaHorario[$dia][$hora]))
                                                @if(is_array($mapaHorario[$dia][$hora]))
                                                    {{-- CLASE ENCONTRADA --}}
                                                    @php $clase = $mapaHorario[$dia][$hora]; @endphp
                                                    
                                                    <td rowspan="{{ $clase['duracion'] }}" 
                                                        class="{{ $clase['es_este_grupo'] ? 'bg-success-subtle border-success' : 'bg-danger-subtle border-danger' }} position-relative p-1">
                                                        
                                                        <div class="d-flex flex-column h-100 justify-content-center">
                                                            {{-- Parte Superior: Código y Status --}}
                                                            <div class="mb-1">
                                                                <span class="badge bg-white text-dark border">{{ $clase['codigo'] }}</span>
                                                                @if($clase['es_este_grupo'])
                                                                    <span class="badge bg-success ms-1" title="Grupo Actual"><i class="fas fa-check"></i></span>
                                                                @else
                                                                    <span class="badge bg-danger ms-1" title="Ocupado"><i class="fas fa-ban"></i></span>
                                                                @endif
                                                            </div>

                                                            {{-- Nombre Materia --}}
                                                            <div class="fw-bold text-dark small lh-1 mb-1">
                                                                {{ $clase['materia'] }}
                                                            </div>

                                                            {{-- Detalles Grupo/Aula --}}
                                                            <div class="small text-muted" style="font-size: 0.75rem;">
                                                                <i class="fas fa-users"></i> Gpo: {{ $clase['grupo'] }}
                                                            </div>
                                                            <div class="badge bg-dark mt-1 align-self-center">
                                                                <i class="fas fa-door-open"></i> {{ $clase['aula'] }}
                                                            </div>
                                                        </div>
                                                    </td>
                                                @endif
                                                {{-- Si es 'ocupado' (string), no imprimimos td porque hay rowspan --}}
                                            @else
                                                {{-- ESPACIO LIBRE --}}
                                                <td class="bg-white text-muted small opacity-25 hover-cell">
                                                    Libre
                                                </td>
                                            @endif
                                        @endfor
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white small text-muted text-center">
                    <span class="me-3"><i class="fas fa-square text-danger opacity-50"></i> Ocupado (Otro Grupo)</span>
                    <span class="me-3"><i class="fas fa-square text-success opacity-50"></i> Grupo Actual</span>
                    <span><i class="fas fa-square text-white border"></i> Disponible</span>
                </div>
            </div>
        </div>

        {{-- 3. FORMULARIO DE SELECCIÓN --}}
        <div class="col-lg-4">
            <div class="card shadow-lg border-0 bg-white">
                <div class="card-header text-white fw-bold" style="background-color: #002D72;">
                    <i class="fas fa-edit me-2"></i>Asignar Bloque
                </div>
                <div class="card-body">
                    
                    <form action="{{ route('grupos.hora.store', $grupo->id_grupo) }}" method="POST">
                        @csrf
                        
                        {{-- Selección de Patrón --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">1. Seleccione Patrón de Días</label>
                            <div class="d-flex gap-2">
                                <input type="radio" class="btn-check patron-radio" name="patron" id="patronLM" value="L-M" 
                                    data-ocupados="{{ json_encode($ocupadoLM) }}"
                                    {{ $grupo->patron == 'L-M' ? 'checked' : '' }} required>
                                <label class="btn btn-outline-primary flex-fill" for="patronLM">
                                    Lunes - Miércoles
                                </label>

                                <input type="radio" class="btn-check patron-radio" name="patron" id="patronMJ" value="M-J" 
                                    data-ocupados="{{ json_encode($ocupadoMJ) }}"
                                    {{ $grupo->patron == 'M-J' ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary flex-fill" for="patronMJ">
                                    Martes - Jueves
                                </label>
                            </div>
                        </div>

                        {{-- Selección de Hora Inicio (Se bloquea dinámicamente) --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">2. Hora de Inicio</label>
                            <select name="hora_inicio" class="form-select form-select-lg border-primary" id="selectHora" required>
                                <option value="">-- Seleccione Hora --</option>
                                @foreach([7,9,11,13,15,17,19] as $h)
                                    @php 
                                        $timeStr = sprintf('%02d:00:00', $h); 
                                        $label = sprintf('%02d:00 - %02d:00', $h, $h+2);
                                    @endphp
                                    {{-- Renderizamos todas las opciones limpias, JS las bloqueará --}}
                                    <option value="{{ $timeStr }}" class="hora-option" 
                                        {{ $grupo->hora_inicio == $timeStr ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text text-danger d-none" id="avisoOcupado">
                                <i class="fas fa-ban me-1"></i> Algunas horas están ocupadas en estos días.
                            </div>
                        </div>

                        {{-- Selección de Aula --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">3. Aula Disponible</label>
                            <select name="aula_id" class="form-select" required>
                                <option value="">-- Seleccione Aula --</option>
                                @foreach($aulas as $aula)
                                    <option value="{{ $aula->id }}" 
                                        {{ $grupo->horarios->first() && $grupo->horarios->first()->aula_id == $aula->id ? 'selected' : '' }}>
                                        {{ $aula->nombre }} (Cap: {{ $aula->capacidad }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg fw-bold shadow-sm">
                                <i class="fas fa-save me-2"></i> Guardar Horario
                            </button>
                        </div>
                    </form>

                    @if($grupo->horarios->count() > 0)
                        <div class="text-center mt-3 border-top pt-3">
                            <form action="{{ route('grupos.horario.destroy', $grupo->id_grupo) }}" method="POST" onsubmit="return confirm('¿Eliminar horario?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-link text-danger text-decoration-none btn-sm">
                                    <i class="fas fa-trash me-1"></i> Borrar horario actual
                                </button>
                            </form>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div> {{-- Cierre de row principal --}}
</div>

{{-- SCRIPT PARA BLOQUEO DINÁMICO --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const radios = document.querySelectorAll('.patron-radio');
        const selectHora = document.getElementById('selectHora');
        const options = document.querySelectorAll('.hora-option');
        const aviso = document.getElementById('avisoOcupado');

        // Función para actualizar el select según el radio seleccionado
        function updateOptions() {
            let selectedRadio = document.querySelector('input[name="patron"]:checked');
            
            if (!selectedRadio) return;

            // Obtener array de horas ocupadas del atributo data
            let ocupados = JSON.parse(selectedRadio.getAttribute('data-ocupados'));
            let hayBloqueados = false;

            options.forEach(opt => {
                // Limpiar estado previo
                opt.disabled = false;
                opt.text = opt.text.replace(' (Ocupado)', '');

                // Verificar si esta hora está en la lista de ocupados
                if (ocupados.includes(opt.value)) {
                    opt.disabled = true;
                    opt.text += ' (Ocupado)';
                    hayBloqueados = true;
                    
                    // Si la opción seleccionada ahora está bloqueada, deseleccionarla
                    if (opt.selected) {
                        selectHora.value = "";
                    }
                }
            });

            // Mostrar/Ocultar aviso
            if (hayBloqueados) {
                aviso.classList.remove('d-none');
            } else {
                aviso.classList.add('d-none');
            }
        }

        // Escuchar cambios en los radio buttons
        radios.forEach(radio => {
            radio.addEventListener('change', updateOptions);
        });

        // Ejecutar al cargar por si ya hay uno seleccionado (edición)
        updateOptions();
    });
</script>

<style>
    .hover-cell:hover {
        background-color: #e9ecef !important;
        cursor: pointer;
    }
    /* Estilo visual para opciones deshabilitadas */
    option:disabled {
        background-color: #f8d7da;
        color: #721c24;
    }
    /* Ajustes para la celda de la tabla */
    .bg-success-subtle { background-color: #d1e7dd !important; }
    .bg-danger-subtle { background-color: #f8d7da !important; }
</style>
@endsection