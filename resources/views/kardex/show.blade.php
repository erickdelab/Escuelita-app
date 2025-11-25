@extends('layouts.app')

@section('template_title')
    Kardex - {{ $alumno->nombre }}
@endsection

@section('content')
<div class="container-fluid">
    
    {{-- Encabezado con datos del alumno --}}
    <div class="card mb-3 shadow-sm border-0">
        <div class="card-body d-flex justify-content-between align-items-center" style="background-color: #f8f9fa;">
            <div>
                <h4 class="mb-1 text-primary fw-bold">{{ $alumno->nombre }} {{ $alumno->ap_pat }} {{ $alumno->ap_mat }}</h4>
                <p class="mb-0 text-muted">
                    <strong>No. Control:</strong> {{ $alumno->n_control }} | 
                    <strong>Carrera:</strong> INGENIERÍA EN TICS
                </p>
            </div>
            <a href="{{ route('alumnos.index') }}" class="btn btn-outline-primary btn-sm">
                <i class="fas fa-arrow-left"></i> Regresar
            </a>
        </div>
    </div>

    {{-- Leyenda de Colores --}}
    <div class="d-flex gap-3 mb-4 justify-content-start small border-bottom pb-2 overflow-auto align-items-center">
        <div class="d-flex align-items-center"><span class="badge bg-success me-1">&nbsp;</span> Aprobada</div>
        <div class="d-flex align-items-center"><span class="badge bg-cursando border border-success me-1">&nbsp;</span> Cursando Actual</div>
        <div class="d-flex align-items-center"><span class="badge bg-warning text-dark me-1">&nbsp;</span> Repite</div>
        <div class="d-flex align-items-center"><span class="badge bg-danger me-1">&nbsp;</span> Especial</div>
        <div class="d-flex align-items-center"><span class="badge bg-light text-dark border me-1">&nbsp;</span> Pendiente</div>
        
        {{-- Leyenda visual para Bloqueada (Fondo rayado) --}}
        <div class="d-flex align-items-center text-muted ms-2" style="background: repeating-linear-gradient(45deg, #ddd, #ddd 5px, #eee 5px, #eee 10px); padding: 2px 8px; border: 1px solid #ccc; border-radius: 4px;">Bloqueada</div>
        
        <div class="d-flex align-items-center text-primary ms-2 fw-bold" style="border: 2px solid #0d6efd; padding: 2px 5px; border-radius: 4px;"> Cadena</div>
    </div>

    {{-- GRID HORIZONTAL (RETÍCULA) --}}
    <div class="kardex-scroll-container">
        <div class="d-flex gap-2">
            @for ($i = 1; $i <= $maxSemestres; $i++)
                <div class="semestre-col">
                    <div class="semestre-header">SEMESTRE {{ $i }}</div>
                    <div class="d-flex flex-column gap-2">
                        
                        @if(isset($reticula[$i]))
                            @foreach($reticula[$i] as $materia)
                                
                                {{-- TARJETA DE MATERIA --}}
                                <div class="materia-card {{ $materia->clase_css }} position-relative" 
                                     data-cadena="{{ $materia->cadena }}">
                                    
                                    {{-- CABECERA: Código y Botón Cadena --}}
                                    <div class="d-flex justify-content-between align-items-start w-100">
                                        <span class="materia-codigo">{{ $materia->cod_materia }}</span>
                                        
                                        {{-- BOTÓN CADENA (Visible incluso si está bloqueada) --}}
                                        @if($materia->cadena && $materia->cadena > 0)
                                            <button type="button" class="btn-cadena" onclick="toggleCadena({{ $materia->cadena }})" title="Ver cadena de materias">
                                                <i class="fas fa-link"></i>
                                            </button>
                                        @endif
                                    </div>
                                    
                                    {{-- NOMBRE DE LA MATERIA --}}
                                    <div class="materia-nombre" title="{{ $materia->nombre }}">
                                        {{ $materia->nombre }}
                                    </div>

                                    {{-- PIE: Créditos y Calificación --}}
                                    <div class="materia-footer">
                                        <span class="creditos">Cr: {{ $materia->credito }}</span>
                                        <span class="fw-bold">
                                            {{ $materia->calificacion_mostrar !== null ? number_format($materia->calificacion_mostrar, 0) : '-' }}
                                        </span>
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

{{-- JAVASCRIPT PARA RESALTAR CADENAS --}}
<script>
    let cadenaActual = null;

    function toggleCadena(idCadena) {
        // 1. Limpiar cualquier resaltado previo
        document.querySelectorAll('.materia-card').forEach(card => {
            card.classList.remove('resaltado-azul');
        });

        // 2. Si se hizo clic en la misma cadena, solo desactivamos (toggle)
        if (cadenaActual === idCadena) {
            cadenaActual = null;
            return;
        }

        // 3. Activar la nueva cadena
        cadenaActual = idCadena;
        const tarjetas = document.querySelectorAll(`.materia-card[data-cadena="${idCadena}"]`);
        
        if (tarjetas.length > 0) {
            tarjetas.forEach(card => {
                card.classList.add('resaltado-azul');
            });
        }
    }
</script>

{{-- ESTILOS CSS --}}
<style>
    /* Contenedor con scroll horizontal */
    .kardex-scroll-container { overflow-x: auto; padding-bottom: 20px; white-space: nowrap; }
    
    /* Columna de Semestre */
    .semestre-col { min-width: 145px; max-width: 145px; display: inline-block; vertical-align: top; white-space: normal; }
    
    /* Encabezado de Semestre */
    .semestre-header { text-align: center; font-weight: bold; color: #666; font-size: 0.85rem; margin-bottom: 10px; text-transform: uppercase; }

    /* Tarjeta Base */
    .materia-card {
        border: 1px solid rgba(0,0,0,0.1); 
        border-radius: 6px; 
        padding: 6px;
        height: 120px; 
        display: flex; 
        flex-direction: column; 
        justify-content: space-between;
        font-size: 0.75rem; 
        transition: all 0.2s; 
        box-sizing: border-box;
        background-color: white; /* Fondo blanco por defecto */
    }

    /* --- ESTILO: CURSANDO ACTUALMENTE (Verde Claro) --- */
    .bg-cursando { 
        background-color: #d1e7dd !important; 
        color: #0f5132 !important; 
    }
    
    /* --- ESTILO: BLOQUEADA (Gris Rayado sin candado) --- */
    .bg-locked {
        /* Fondo con patrón de rayas diagonales */
        background: repeating-linear-gradient(
            45deg,
            #f4f4f4,
            #f4f4f4 10px,
            #e9e9e9 10px,
            #e9e9e9 20px
        ) !important;
        color: #adb5bd !important; 
        border: 1px solid #dee2e6 !important;
        /* NOTA: No usamos pointer-events: none para permitir clic en el botón de cadena */
    }

    /* --- ESTILO: CADENA SELECCIONADA (Borde Azul) --- */
    .resaltado-azul { 
        box-shadow: 0 0 0 3px #0d6efd !important; /* Borde exterior azul */
        transform: scale(1.05); 
        z-index: 50; /* Traer al frente */
        background-color: #fff; /* Asegurar legibilidad si estaba bloqueada */
    }

    /* Botón de Cadena */
    .btn-cadena {
        background: rgba(0,0,0,0.05); 
        border: none; 
        border-radius: 50%;
        width: 24px; 
        height: 24px; 
        display: flex; 
        align-items: center; 
        justify-content: center;
        cursor: pointer; 
        color: #666;
        z-index: 10; /* Asegurar que esté por encima */
    }
    .btn-cadena:hover { 
        background-color: #0d6efd; 
        color: white; 
    }

    /* Textos internos */
    .materia-codigo { font-weight: bold; font-size: 0.7rem; opacity: 0.9; }
    .materia-nombre { 
        text-align: center; font-weight: 600; line-height: 1.1; margin: 4px 0;
        display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;
    }
    .materia-footer {
        display: flex; justify-content: space-between; align-items: end;
        border-top: 1px solid rgba(0,0,0,0.05); padding-top: 4px;
    }
    
    /* Scrollbar personalizada */
    .kardex-scroll-container::-webkit-scrollbar { height: 10px; }
    .kardex-scroll-container::-webkit-scrollbar-thumb { background: #002D72; border-radius: 5px; }
</style>
@endsection