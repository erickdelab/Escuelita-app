@extends('layouts.app')

@section('template_title')
    Panel de Control - Sistema Académico
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-xxl-10 col-xl-12">
            <!-- Header Informativo -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, #002D72 0%, #0056b3 100%);">
                        <div class="card-body text-white text-center py-4">
                            <h2 class="mb-2 fw-bold">
                                <i class="fas fa-graduation-cap me-3"></i>Sistema Académico
                            </h2>
                            <p class="mb-0 opacity-75 fs-5">
                                Instituto Tecnológico de Puebla
                            </p>
                            <small class="opacity-50">Plataforma integral de gestión educativa</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tarjetas de Módulos -->
            <div class="row g-4">
                <!-- Gestión Académica -->
                <div class="col-xl-4 col-md-6">
                    <div class="card h-100 shadow-lg border-0 hover-lift">
                        <div class="card-header text-white text-center py-3" style="background: linear-gradient(135deg, #002D72 0%, #0056b3 100%);">
                            <i class="fas fa-book-open fa-2x mb-2"></i>
                            <h5 class="card-title mb-0 fw-bold">Gestión Académica</h5>
                        </div>
                        <div class="card-body text-center p-4">
                            <p class="card-text text-muted mb-4">
                                Administra la información académica fundamental del instituto
                            </p>
                            <div class="d-grid gap-2">
                                <a href="{{ url('/materias') }}" class="btn btn-outline-primary btn-hover">
                                    <i class="fas fa-journal-text me-2"></i>Materias
                                </a>
                                <a href="{{ url('/carreras') }}" class="btn btn-outline-primary btn-hover">
                                    <i class="fas fa-mortarboard me-2"></i>Carreras
                                </a>
                                <a href="{{ url('/periodos') }}" class="btn btn-outline-primary btn-hover">
                                    <i class="fas fa-calendar-alt me-2"></i>Períodos
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gestión de Personal -->
                <div class="col-xl-4 col-md-6">
                    <div class="card h-100 shadow-lg border-0 hover-lift">
                        <div class="card-header text-white text-center py-3" style="background: linear-gradient(135deg, #002D72 0%, #0056b3 100%);">
                            <i class="fas fa-chalkboard-teacher fa-2x mb-2"></i>
                            <h5 class="card-title mb-0 fw-bold">Gestión de Personal</h5>
                        </div>
                        <div class="card-body text-center p-4">
                            <p class="card-text text-muted mb-4">
                                Gestiona la información del personal docente y áreas académicas
                            </p>
                            <div class="d-grid gap-2">
                                <a href="{{ url('/profesores') }}" class="btn btn-outline-primary btn-hover">
                                    <i class="fas fa-user-tie me-2"></i>Profesores
                                </a>
                                <a href="{{ url('/areas') }}" class="btn btn-outline-primary btn-hover">
                                    <i class="fas fa-building me-2"></i>Áreas
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gestión Estudiantil -->
                <div class="col-xl-4 col-md-6">
                    <div class="card h-100 shadow-lg border-0 hover-lift">
                        <div class="card-header text-white text-center py-3" style="background: linear-gradient(135deg, #002D72 0%, #0056b3 100%);">
                            <i class="fas fa-user-graduate fa-2x mb-2"></i>
                            <h5 class="card-title mb-0 fw-bold">Gestión Estudiantil</h5>
                        </div>
                        <div class="card-body text-center p-4">
                            <p class="card-text text-muted mb-4">
                                Administra estudiantes, grupos y asignaciones académicas
                            </p>
                            <div class="d-grid gap-2">
                                <a href="{{ url('/alumnos') }}" class="btn btn-outline-primary btn-hover">
                                    <i class="fas fa-users me-2"></i>Alumnos
                                </a>
                                <a href="{{ url('/grupos') }}" class="btn btn-outline-primary btn-hover">
                                    <i class="fas fa-layer-group me-2"></i>Grupos
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reportes y Análisis -->
                <div class="col-xl-6 col-md-6">
                    <div class="card h-100 shadow-lg border-0 hover-lift">
                        <div class="card-header text-white text-center py-3" style="background: linear-gradient(135deg, #002D72 0%, #0056b3 100%);">
                            <i class="fas fa-chart-bar fa-2x mb-2"></i>
                            <h5 class="card-title mb-0 fw-bold">Reportes y Análisis</h5>
                        </div>
                        <div class="card-body text-center p-4">
                            <p class="card-text text-muted mb-4">
                                Accede a reportes especializados y análisis académicos
                            </p>
                            <div class="d-grid gap-2">
                                <a href="{{ url('/reportes/alumnos-especial-tics') }}" class="btn btn-outline-primary btn-hover">
                                    <i class="fas fa-chart-line me-2"></i>Reporte Alumnos Especial
                                </a>
                                <a href="{{ url('/historials') }}" class="btn btn-outline-primary btn-hover">
                                    <i class="fas fa-history me-2"></i>Historial Académico
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Administración General -->
                <div class="col-xl-6 col-md-6">
                    <div class="card h-100 shadow-lg border-0 hover-lift">
                        <div class="card-header text-white text-center py-3" style="background: linear-gradient(135deg, #002D72 0%, #0056b3 100%);">
                            <i class="fas fa-cogs fa-2x mb-2"></i>
                            <h5 class="card-title mb-0 fw-bold">Administración General</h5>
                        </div>
                        <div class="card-body text-center p-4">
                            <p class="card-text text-muted mb-4">
                                Herramientas administrativas y de configuración del sistema
                            </p>
                            <div class="d-grid gap-2">
                                <a href="{{ url('/tablas') }}" class="btn btn-outline-primary btn-hover">
                                    <i class="fas fa-table me-2"></i>Tablas del Sistema
                                </a>
                                <button class="btn btn-outline-primary btn-hover" disabled>
                                    <i class="fas fa-cog me-2"></i>Configuración
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Informativo -->
            <div class="row mt-5">
                <div class="col-12">
                    <div class="card border-0 bg-light">
                        <div class="card-body text-center py-3">
                            <div class="row align-items-center">
                                <div class="col-md-4 text-md-start">
                                    <small class="text-muted">
                                        <i class="fas fa-database me-1"></i>
                                        Sistema Académico v1.0
                                    </small>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ now()->format('d/m/Y H:i') }}
                                    </small>
                                </div>
                                <div class="col-md-4 text-md-end">
                                    <small class="text-muted">
                                        <i class="fas fa-user me-1"></i>
                                        {{ Auth::user()->name }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-lift {
        transition: all 0.3s ease;
        border-radius: 12px;
    }
    
    .hover-lift:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15) !important;
    }
    
    .btn-hover {
        transition: all 0.3s ease;
        border-width: 2px;
        font-weight: 500;
        border-radius: 8px;
    }
    
    .btn-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    .card-header {
        border-radius: 12px 12px 0 0 !important;
    }
    
    .btn-outline-primary { 
        color: #002D72; 
        border-color: #002D72; 
    }
    
    .btn-outline-primary:hover { 
        background-color: #002D72; 
        color: white; 
    }
</style>

<!-- Font Awesome para iconos -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection