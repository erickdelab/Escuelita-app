@extends('layouts.student')

@section('content')
<div class="container-fluid">
    
    <!-- Selector de Carrera -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-2">
            <small class="text-muted d-block">Carrera actual</small>
            <div class="fw-bold text-dark text-uppercase">
                {{ $alumno->carrera->nombre_carrera ?? 'CARRERA NO ASIGNADA' }}
            </div>
        </div>
    </div>

    <!-- Tarjeta de Identificación Completa -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <h5 class="fw-bold text-primary mb-4" style="color: #1B396A !important;">Identificación del Estudiante</h5>
            
            <div class="row">
                <!-- Icono de Usuario Grande -->
                <div class="col-md-3 text-center mb-3 mb-md-0 d-flex align-items-center justify-content-center">
                    <i class="bi bi-person-circle" style="font-size: 10rem; color: #1B396A;"></i>
                </div>

                <!-- Datos del Alumno -->
                <div class="col-md-9">
                    <h3 class="fw-bold mb-1 text-uppercase text-dark">{{ $alumno->nombre }} {{ $alumno->ap_pat }} {{ $alumno->ap_mat }}</h3>
                    <p class="text-muted mb-4 fs-5">
                        <span class="badge bg-light text-dark border me-2">{{ $alumno->n_control }}</span> 
                        {{ Auth::user()->email }}
                    </p>

                    <hr>

                    <div class="row g-4 mt-2">
                        {{-- Fila 1 --}}
                        <div class="col-md-4">
                            <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.75rem;">Carrera</small>
                            <span class="fw-bold text-primary">{{ $alumno->carrera->nombre_carrera ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.75rem;">Especialidad</small>
                            <span class="fw-bold text-dark">PLAN DE ESTUDIOS 2025</span>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.75rem;">Semestre Actual</small>
                            <span class="fs-5 fw-bold text-dark">{{ $alumno->semestre ?? 1 }}</span>
                        </div>

                        {{-- Fila 2 --}}
                        <div class="col-md-4">
                            <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.75rem;">Promedio General</small>
                            <span class="fs-5 fw-bold text-success">{{ $alumno->promedio_general ?? '0.00' }}</span>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.75rem;">Fecha Nacimiento</small>
                            <span class="fw-bold text-dark">{{ $alumno->fech_nac ?? '--' }}</span>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.75rem;">Estatus</small>
                            <span class="badge {{ $alumno->situacion == 'Vigente' ? 'bg-success' : 'bg-danger' }} fs-6">
                                {{ strtoupper($alumno->situacion) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection