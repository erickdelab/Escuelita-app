@extends('layouts.app')

@section('template_title')
    Calificaciones - {{ $alumno->nombre }}
@endsection

@section('content')
<div class="container-fluid">
    
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="text-primary fw-bold mb-0">
                <i class="fas fa-clipboard-list me-2"></i> Reporte de Calificaciones
            </h3>
            <p class="text-muted mb-0">
                Estudiante: <strong>{{ $alumno->n_control }}</strong> - {{ $alumno->nombre }} {{ $alumno->ap_pat }} {{ $alumno->ap_mat }}
            </p>
        </div>
        <a href="{{ route('alumnos.show', $alumno->n_control) }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Regresar
        </a>
    </div>

    {{-- SECCIÓN 1: CARGA ACADÉMICA (ACORDEÓN DESPLEGABLE) --}}
    <h5 class="border-bottom pb-2 mb-3 text-dark"><i class="fas fa-book-reader me-2"></i> Carga Académica Actual</h5>

    @if($cargaActual->count() > 0)
        <div class="accordion shadow-sm" id="accordionCarga">
            @foreach($cargaActual as $index => $item)
                @php
                    $grupo = $item->grupo;
                    $materia = $grupo->materia;
                    $profe = $grupo->profesore;
                    $calif = $item->calificacion;
                    
                    // Lógica de horarios
                    $horarioMap = [1=>'-', 2=>'-', 3=>'-', 4=>'-', 5=>'-']; 
                    foreach($grupo->horarios as $h) {
                        $texto = \Carbon\Carbon::parse($h->hora_inicio)->format('H:i') . ' - ' . 
                                 \Carbon\Carbon::parse($h->hora_fin)->format('H:i') . ' ' . 
                                 ($h->aula->nombre ?? 'N/A');
                        if ($horarioMap[$h->dia_semana] !== '-') {
                            $horarioMap[$h->dia_semana] .= '<br>' . $texto;
                        } else {
                            $horarioMap[$h->dia_semana] = $texto;
                        }
                    }

                    // ID únicos para el acordeón
                    $headingId = "heading" . $index;
                    $collapseId = "collapse" . $index;
                @endphp

                <div class="accordion-item border-0 border-bottom">
                    <h2 class="accordion-header" id="{{ $headingId }}">
                        <button class="accordion-button {{ $index !== 0 ? 'collapsed' : '' }} fw-bold text-dark bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="{{ $collapseId }}">
                            {{-- Título de la materia en la barra --}}
                            <i class="fas fa-book me-2 text-primary"></i> 
                            {{ $materia->nombre ?? 'Materia Desconocida' }}
                            <span class="ms-auto badge bg-primary me-2">{{ $materia->cod_materia ?? '' }}</span>
                        </button>
                    </h2>
                    <div id="{{ $collapseId }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="{{ $headingId }}" data-bs-parent="#accordionCarga">
                        <div class="accordion-body bg-white">
                            
                            {{-- Datos Generales --}}
                            <div class="row mb-3">
                                <div class="col-md-5">
                                    <small class="text-muted d-block fw-bold">Docente:</small>
                                    <span>{{ $profe ? ($profe->nombre . ' ' . $profe->ap_paterno . ' ' . $profe->ap_materno) : 'Sin asignar' }}</span>
                                </div>
                                <div class="col-md-3">
                                    <small class="text-muted d-block fw-bold">Créditos:</small>
                                    <span>{{ $materia->credito ?? '0' }}</span>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted d-block fw-bold">Grupo / Semestre:</small>
                                    <span>Grupo {{ $grupo->id_grupo }} / Sem. {{ $grupo->semestre }}</span>
                                </div>
                            </div>

                            <hr class="text-muted opacity-25">

                            {{-- Horario --}}
                            <div class="mb-4">
                                <h6 class="text-secondary fw-bold mb-2 small text-uppercase">Horario</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered text-center align-middle mb-0" style="font-size: 0.85rem;">
                                        <thead class="table-light">
                                            <tr><th>Lunes</th><th>Martes</th><th>Miércoles</th><th>Jueves</th><th>Viernes</th></tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{!! $horarioMap[1] !!}</td>
                                                <td>{!! $horarioMap[2] !!}</td>
                                                <td>{!! $horarioMap[3] !!}</td>
                                                <td>{!! $horarioMap[4] !!}</td>
                                                <td>{!! $horarioMap[5] !!}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- Calificaciones --}}
                            <div>
                                <h6 class="text-secondary fw-bold mb-2 small text-uppercase">Calificaciones Parciales</h6>
                                <div class="table-responsive">
                                    <table class="table table-bordered text-center align-middle mb-0">
                                        <thead class="bg-light text-primary">
                                            <tr>
                                                <th style="width: 20%">U1</th>
                                                <th style="width: 20%">U2</th>
                                                <th style="width: 20%">U3</th>
                                                <th style="width: 20%">U4</th>
                                                <th style="width: 20%" class="table-dark text-white border-start">Promedio</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="{{ ($calif->u1 ?? 100) < 70 ? 'text-danger fw-bold' : '' }}">{{ $calif->u1 ?? '-' }}</td>
                                                <td class="{{ ($calif->u2 ?? 100) < 70 ? 'text-danger fw-bold' : '' }}">{{ $calif->u2 ?? '-' }}</td>
                                                <td class="{{ ($calif->u3 ?? 100) < 70 ? 'text-danger fw-bold' : '' }}">{{ $calif->u3 ?? '-' }}</td>
                                                <td class="{{ ($calif->u4 ?? 100) < 70 ? 'text-danger fw-bold' : '' }}">{{ $calif->u4 ?? '-' }}</td>
                                                <td class="fw-bold border-start bg-light">
                                                    @if(isset($calif->promedio))
                                                        <span class="badge rounded-pill px-3 py-2 {{ $calif->promedio >= 70 ? 'bg-success' : 'bg-danger' }}">
                                                            {{ number_format($calif->promedio, 1) }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-warning shadow-sm">
            <i class="fas fa-exclamation-triangle me-2"></i> El alumno no tiene carga académica registrada actualmente.
        </div>
    @endif

    {{-- SECCIÓN 2: HISTORIAL BOLETA (El código que ya tenías abajo se mantiene igual) --}}
    <div class="mt-5">
        {{-- ... Aquí va el bloque de la boleta estilo oficial que hicimos en el paso anterior ... --}}
        {{-- Solo asegúrate de NO borrar el formulario de selección de periodo que ya está ahí --}}
        
        <h5 class="border-bottom pb-2 mb-3 text-dark"><i class="fas fa-history me-2"></i> Consulta de Boletas Anteriores</h5>
        
        <div class="card shadow-sm border-0 mb-4 no-print">
            <div class="card-body bg-light">
                <form action="{{ route('alumnos.calificaciones', $alumno->n_control) }}" method="GET" class="row align-items-end">
                    <div class="col-md-4">
                        <label for="periodo_select" class="form-label fw-bold">Seleccionar Periodo:</label>
                        <select name="periodo_select" id="periodo_select" class="form-select" required>
                            <option value="">-- Seleccione --</option>
                            @foreach($periodosDisponibles as $periodo)
                                <option value="{{ $periodo }}" {{ $periodoSeleccionado == $periodo ? 'selected' : '' }}>
                                    {{ $periodo }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-eye me-1"></i> Consultar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if($mensajeHistorial)
            <div class="alert alert-info text-center py-4">
                <i class="fas fa-folder-open fa-2x mb-3 d-block text-info"></i>
                <h5 class="alert-heading">{{ $mensajeHistorial }}</h5>
            </div>
        @elseif($boletasHistorial->isNotEmpty())
             {{-- ... Aquí va todo el código de la Boleta con diseño oficial que te di en la respuesta anterior ... --}}
             <div class="boleta-container bg-white p-4 mx-auto" style="max-width: 950px; border: 1px solid #000; font-family: 'Arial', sans-serif;">
                {{-- Copia y pega aquí el bloque de la boleta de la respuesta anterior --}}
                {{-- (Te lo incluyo completo abajo para que solo copies y pegues todo el archivo) --}}
                
                <div class="text-center mb-2">
                    <h5 class="fw-bold mb-1 text-uppercase">Instituto Tecnológico de Puebla</h5>
                    <h6 class="fw-bold text-uppercase border-bottom border-dark border-2 pb-1 d-inline-block">Boleta de Calificaciones</h6>
                </div>
    
                <div class="row text-uppercase small fw-bold mb-3">
                    <div class="col-12 text-end mb-2">
                        Periodo: {{ $periodoSeleccionado }} <br>
                        Fecha: {{ now()->format('Y-m-d') }}
                    </div>
                    <div class="col-md-2">
                        {{ $alumno->n_control }}
                    </div>
                    <div class="col-md-10 border-bottom border-dark">
                        {{ $alumno->ap_pat }} {{ $alumno->ap_mat }} {{ $alumno->nombre }}
                    </div>
                    <div class="col-md-2 mt-1">
                        Carrera:
                    </div>
                    <div class="col-md-10 mt-1">
                        {{ $alumno->carrera->nombre_carrera ?? 'INGENIERÍA EN TICS' }}
                    </div>
                </div>
    
                <div class="table-responsive">
                    <table class="table table-bordered border-dark text-uppercase small align-middle">
                        <thead class="text-center fw-bold" style="border-bottom: 2px solid #000;">
                            <tr>
                                <th width="15%" class="border-dark">Clave</th>
                                <th width="55%" class="border-dark">Asignatura / Docente</th>
                                <th width="10%" class="border-dark">Cred</th>
                                <th width="10%" class="border-dark">Calif.</th>
                                <th width="10%" class="border-dark">Oportunidad</th>
                            </tr>
                        </thead>
                        <tbody class="border-dark">
                            @php
                                $sumaCalificaciones = 0;
                                $sumaCreditosCursados = 0;
                                $sumaCreditosAprobados = 0;
                                $totalMaterias = $boletasHistorial->count();
                            @endphp
    
                            @foreach($boletasHistorial as $boleta)
                                @php
                                    $calif = $boleta->calificacion;
                                    $creditos = $boleta->materia->credito ?? 0;
                                    $sumaCalificaciones += $calif;
                                    $sumaCreditosCursados += $creditos;
                                    if($calif >= 70) {
                                        $sumaCreditosAprobados += $creditos;
                                    }
    
                                    $opTexto = 'CO/1ª OP';
                                    if($boleta->oportunidad == 'Repite') $opTexto = 'CR/2ª OP';
                                    if($boleta->oportunidad == 'Especial') $opTexto = 'CE/ESP';
                                @endphp
                                <tr>
                                    <td class="text-center fw-bold border-dark">
                                        {{ $boleta->cod_materia }}
                                    </td>
                                    <td class="border-dark">
                                        <div class="fw-bold">{{ $boleta->materia->nombre ?? 'MATERIA NO ENCONTRADA' }}</div>
                                        <div class="text-muted" style="font-size: 0.85em;">
                                            {{ $boleta->profesor ? ($boleta->profesor->nombre . ' ' . $boleta->profesor->ap_paterno . ' ' . $boleta->profesor->ap_materno) : 'DOCENTE NO ASIGNADO' }}
                                        </div>
                                    </td>
                                    <td class="text-center border-dark">{{ $creditos }}</td>
                                    <td class="text-center fw-bold border-dark">{{ number_format($calif, 0) }}</td>
                                    <td class="text-center border-dark">{{ $opTexto }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
    
                <div class="row mt-4 small">
                    <div class="col-md-7">
                        <p class="mb-1"><strong>CO:</strong> Curso Ordinario <strong>CR:</strong> Curso de Repetición <strong>CE:</strong> Curso Especial</p>
                        <p class="mb-1"><strong>1ª OP:</strong> Primera Oportunidad / <strong>2ª OP:</strong> Segunda Oportunidad</p>
                        <p class="mb-0">Escala de Calificación Aprobatoria de 0 a 100, mínima aprobatoria 70</p>
                        <p class="mb-0">N.A.: No Acreditada</p>
                    </div>
                    <div class="col-md-5">
                        <table class="table table-borderless table-sm text-end fw-bold">
                            <tr>
                                <td>PROMEDIO:</td>
                                <td>{{ $totalMaterias > 0 ? number_format($sumaCalificaciones / $totalMaterias, 2) : '0.00' }}</td>
                            </tr>
                            <tr>
                                <td>CRÉDITOS CURSADOS:</td>
                                <td>{{ $sumaCreditosCursados }}</td>
                            </tr>
                            <tr>
                                <td>CRÉDITOS APROBADOS:</td>
                                <td>{{ $sumaCreditosAprobados }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
    
                <div class="mt-4 text-start small text-muted">
                    Este documento no tiene validez oficial
                </div>
    
            </div>
            
            <div class="text-center mt-3 mb-5">
                <button onclick="window.print()" class="btn btn-dark">
                    <i class="fas fa-print me-1"></i> Imprimir Boleta
                </button>
            </div>

        @endif
    </div>

</div>

<style>
    @media print {
        body * { visibility: hidden; }
        .boleta-container, .boleta-container * { visibility: visible; }
        .boleta-container { position: absolute; left: 0; top: 0; width: 100%; border: none !important; }
        .no-print, .btn, header, footer, nav { display: none !important; }
    }
    
    /* Ajustes para el acordeón */
    .accordion-button:not(.collapsed) {
        color: #002D72;
        background-color: #e7f1ff;
        box-shadow: inset 0 -1px 0 rgba(0,0,0,.125);
    }
</style>
@endsection