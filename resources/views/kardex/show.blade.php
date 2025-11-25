@extends('layouts.app')

@section('template_title')
    Kardex - {{ $alumno->nombre }}
@endsection

@section('content')
<div class="container-fluid">
    
    {{-- Header --}}
    <div class="card mb-3 shadow-sm border-0">
        <div class="card-body" style="background-color: #f8f9fa;">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="mb-1 text-primary fw-bold">{{ $alumno->nombre }} {{ $alumno->ap_pat }} {{ $alumno->ap_mat }}</h4>
                    <p class="mb-0 text-muted">
                        <strong>No. Control:</strong> {{ $alumno->n_control }} | 
                        <strong>Plan:</strong> INGENIERÍA EN TICS
                    </p>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('alumnos.index') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-arrow-left"></i> Regresar
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Leyenda --}}
    <div class="d-flex gap-3 mb-4 justify-content-start small border-bottom pb-2 overflow-auto">
        <div class="d-flex align-items-center"><span class="badge bg-success me-1">&nbsp;</span> Aprobada</div>
        <div class="d-flex align-items-center"><span class="badge bg-warning text-dark me-1">&nbsp;</span> Repite</div>
        <div class="d-flex align-items-center"><span class="badge bg-danger me-1">&nbsp;</span> Especial</div>
        <div class="d-flex align-items-center"><span class="badge bg-light text-dark border me-1">&nbsp;</span> Disponible</div>
        <div class="d-flex align-items-center text-muted"><i class="fas fa-lock me-1"></i> Bloqueada</div>
    </div>

    {{-- RETÍCULA --}}
    <div class="kardex-scroll-container">
        <div class="d-flex gap-2">
            
            @for ($i = 1; $i <= $maxSemestres; $i++)
                <div class="semestre-col">
                    <div class="semestre-header">SEMESTRE {{ $i }}</div>

                    <div class="d-flex flex-column gap-2">
                        @if(isset($reticula[$i]))
                            @foreach($reticula[$i] as $materia)
                                
                                <div class="materia-card {{ $materia->clase_css }} position-relative">
                                    
                                    {{-- 🔒 LÓGICA VISUAL DEL CANDADO --}}
                                    @if($materia->bloqueada)
                                        <div class="bloqueo-overlay">
                                            <i class="fas fa-lock fa-2x text-secondary"></i>
                                        </div>
                                    @endif

                                    {{-- Contenido de la Tarjeta --}}
                                    <div class="materia-codigo">
                                        {{ $materia->cod_materia }}
                                    </div>
                                    
                                    <div class="materia-nombre" title="{{ $materia->nombre }}">
                                        {{ $materia->nombre }}
                                    </div>

                                    <div class="materia-footer">
                                        <span class="creditos">Cr: {{ $materia->credito }}</span>
                                        
                                        @if($materia->calificacion_mostrar !== null)
                                            <span class="calificacion fw-bold">
                                                {{ number_format($materia->calificacion_mostrar, 0) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                            @endforeach
                        @else
                            <div class="text-center text-muted small py-4 border rounded bg-light">-</div>
                        @endif
                    </div>
                </div>
            @endfor

        </div>
    </div>
</div>

<style>
    .kardex-scroll-container {
        overflow-x: auto;
        padding-bottom: 20px;
        white-space: nowrap;
    }
    .semestre-col {
        min-width: 140px; max-width: 140px;
        display: inline-block; vertical-align: top;
        white-space: normal;
    }
    .semestre-header {
        text-align: center; font-weight: bold; color: #666;
        font-size: 0.85rem; margin-bottom: 10px;
    }
    .materia-card {
        border: 1px solid rgba(0,0,0,0.1);
        border-radius: 4px; padding: 6px;
        height: 110px; 
        display: flex; flex-direction: column; justify-content: space-between;
        font-size: 0.75rem; transition: transform 0.2s;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    /* Efecto del Candado */
    .bloqueo-overlay {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(255,255,255, 0.6); /* Velo blanco semi-transparente */
        display: flex; align-items: center; justify-content: center;
        z-index: 5;
        border-radius: 4px;
    }
    .materia-card:hover { transform: scale(1.05); z-index: 10; }
    .materia-codigo { font-weight: bold; text-align: center; font-size: 0.7rem; opacity: 0.9; }
    .materia-nombre {
        text-align: center; font-weight: 600; line-height: 1.2;
        display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;
        overflow: hidden; margin: 4px 0;
    }
    .materia-footer {
        display: flex; justify-content: space-between; align-items: end;
        font-size: 0.7rem; border-top: 1px solid rgba(0,0,0,0.1); padding-top: 4px;
    }
    .kardex-scroll-container::-webkit-scrollbar { height: 10px; }
    .kardex-scroll-container::-webkit-scrollbar-thumb { background: #002D72; border-radius: 5px; }
</style>
@endsection