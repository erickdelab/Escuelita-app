@extends('layouts.teacher')

@section('content')
<div class="container-fluid">
    
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-4" style="color: #0d2149 !important;">Identificación Docente</h5>
            
            <div class="row align-items-center">
                <div class="col-md-3 text-center mb-3 mb-md-0">
                    <i class="bi bi-person-workspace" style="font-size: 8rem; color: #0d2149;"></i>
                </div>

                <div class="col-md-9">
                    <h3 class="fw-bold mb-1 text-uppercase text-dark">
                        {{ $profesor->nombre }} {{ $profesor->ap_paterno }} {{ $profesor->ap_materno }}
                    </h3>
                    <p class="text-muted mb-4 fs-5">
                        <span class="badge bg-light text-dark border me-2">{{ $profesor->n_trabajador }}</span> 
                        {{ $profesor->correo_institucional }}
                    </p>

                    <hr>

                    <div class="row g-4 mt-2">
                        <div class="col-md-4">
                            <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.75rem;">Área Académica</small>
                            <span class="fw-bold text-primary">{{ $profesor->area->area ?? 'No asignada' }}</span>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.75rem;">Estatus</small>
                            <span class="badge {{ $profesor->situacion == 'Vigente' ? 'bg-success' : 'bg-secondary' }}">
                                {{ strtoupper($profesor->situacion) }}
                            </span>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.75rem;">Fecha Ingreso</small>
                            <span class="fw-bold text-dark">{{ $profesor->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100 bg-primary text-white" style="background: linear-gradient(45deg, #0d2149, #1a3c7a);">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold mb-0">{{ $totalGrupos }}</h2>
                        <div class="opacity-75">Grupos Asignados</div>
                    </div>
                    <i class="bi bi-collection-fill fs-1 opacity-50"></i>
                </div>
                <a href="{{ route('teacher.grupos') }}" class="card-footer bg-transparent border-0 text-white text-end text-decoration-none">
                    Ver detalles <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100 bg-success text-white" style="background: linear-gradient(45deg, #198754, #20c997);">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold mb-0">{{ $totalAlumnos }}</h2>
                        <div class="opacity-75">Alumnos Totales</div>
                    </div>
                    <i class="bi bi-people-fill fs-1 opacity-50"></i>
                </div>
                <div class="card-footer bg-transparent border-0 text-white text-end opacity-75 small">
                    En cursos actuales
                </div>
            </div>
        </div>
    </div>

</div>
@endsection