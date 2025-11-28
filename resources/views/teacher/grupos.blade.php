@extends('layouts.teacher')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4 fw-bold" style="color: #0d2149 !important;">Mis Grupos Asignados</h4>

    <div class="row g-4">
        @forelse($grupos as $grupo)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm border-0 hover-lift">
                    <div class="card-header bg-white border-bottom-0 pt-3">
                        <div class="d-flex justify-content-between">
                            <span class="badge bg-primary">Grupo {{ $grupo->id_grupo }}</span>
                            <span class="text-muted small">Semestre {{ $grupo->semestre }}</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-bold text-dark mb-1">{{ $grupo->materia->nombre }}</h5>
                        <small class="text-muted d-block mb-3">{{ $grupo->materia->cod_materia }}</small>
                        
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-people text-primary me-2"></i>
                            <span>{{ $grupo->alumnos_count }} Alumnos inscritos</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-calendar3 text-primary me-2"></i>
                            <span>{{ $grupo->periodo->periodo_nombre ?? 'Periodo' }} {{ $grupo->periodo->anio ?? '' }}</span>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-top-0 pb-3">
                        <div class="d-grid gap-2">
                            <a href="{{ route('teacher.grupos.show', $grupo->id_grupo) }}" class="btn btn-outline-primary">
                                <i class="bi bi-eye me-1"></i> Ver Detalles y Alumnos
                            </a>
                            <a href="{{ route('teacher.grupos.calificar', $grupo->id_grupo) }}" class="btn btn-success text-white">
    <i class="bi bi-pencil-square me-1"></i> Calificar
</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center py-5">
                    <i class="bi bi-folder2-open display-4"></i>
                    <p class="mt-3 mb-0">No tienes grupos asignados en este momento.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>

<style>
    .hover-lift { transition: transform 0.2s; }
    .hover-lift:hover { transform: translateY(-5px); }
</style>
@endsection