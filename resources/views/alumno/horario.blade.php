@extends('layouts.app')

@section('template_title')
    Horario Semestral - {{ $alumno->nombre }}
@endsection

@section('content')
<div class="container-fluid">
    
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="text-primary fw-bold mb-0">
                <i class="fas fa-calendar-alt me-2"></i> Horario Semestral
            </h3>
            <p class="text-muted mb-0">
                Estudiante: <strong>{{ $alumno->n_control }}</strong> - {{ $alumno->nombre }} {{ $alumno->ap_pat }} {{ $alumno->ap_mat }}
            </p>
        </div>
        <a href="{{ route('alumnos.show', $alumno->n_control) }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Regresar
        </a>
    </div>

    <div class="card shadow-lg border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0 text-center align-middle" style="table-layout: fixed;">
                    <thead class="text-white" style="background-color: #002D72;">
                        <tr>
                            <th style="width: 80px;">Hora</th>
                            <th>Lunes</th>
                            <th>Martes</th>
                            <th>Miércoles</th>
                            <th>Jueves</th>
                            <th>Viernes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($horasDisponibles as $hora)
                            <tr>
                                {{-- Columna de Hora --}}
                                <td class="fw-bold bg-light text-secondary">
                                    {{ sprintf('%02d', $hora) }}:00
                                </td>

                                {{-- Columnas de Días (1 a 5) --}}
                                @for ($dia = 1; $dia <= 5; $dia++)
                                    @if (isset($calendario[$dia][$hora]))
                                        
                                        @if (is_array($calendario[$dia][$hora]))
                                            {{-- Es el INICIO de una clase: Pintamos el bloque --}}
                                            @php $clase = $calendario[$dia][$hora]; @endphp
                                            <td rowspan="{{ $clase['duracion'] }}" 
                                                class="p-2 border-white class-block" 
                                                style="background-color: {{ $clase['color'] }}; vertical-align: middle;">
                                                
                                                <div class="d-flex flex-column justify-content-center h-100">
                                                    <span class="badge bg-white text-dark border mb-1 align-self-center">
                                                        {{ $clase['codigo'] }}
                                                    </span>
                                                    <strong class="text-dark small lh-sm mb-1">
                                                        {{ $clase['materia'] }}
                                                    </strong>
                                                    <div class="small text-muted mb-1" style="font-size: 0.75rem;">
                                                        <i class="fas fa-chalkboard-teacher"></i> {{ $clase['profesor'] }}
                                                    </div>
                                                    <div class="badge bg-dark text-white align-self-center">
                                                        <i class="fas fa-map-marker-alt me-1"></i> Aula: {{ $clase['aula'] }}
                                                    </div>
                                                </div>

                                            </td>
                                        @else
                                            {{-- Esta hora está ocupada por un rowspan anterior: NO pintamos td --}}
                                        @endif

                                    @else
                                        {{-- Hora libre --}}
                                        <td class="bg-white"></td>
                                    @endif
                                @endfor
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="mt-3 text-end no-print">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="fas fa-print me-2"></i> Imprimir Horario
        </button>
    </div>

</div>

<style>
    /* Efecto hover suave para las clases */
    .class-block {
        transition: transform 0.2s, box-shadow 0.2s;
        cursor: default;
    }
    .class-block:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        z-index: 10;
        position: relative;
    }
    
    /* Estilos de impresión */
    @media print {
        .no-print, nav, header, footer { display: none !important; }
        .card { border: none !important; shadow: none !important; }
        /* Forzar impresión de colores de fondo */
        .class-block { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    }
</style>
@endsection