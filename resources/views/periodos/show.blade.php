@extends('layouts.app')

@section('template_title')
    Detalles del Período
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card shadow-lg border-0">
                <div class="card-header text-white" style="background-color: #002D72;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h4 class="mb-0">📋 {{ __('Detalles del Período') }}</h4>
                        <a href="{{ route('periodos.index') }}" class="btn btn-light btn-sm">
                            ← Volver
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold">ID:</div>
                        <div class="col-sm-8">{{ $periodo->id }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold">Nombre:</div>
                        <div class="col-sm-8">{{ $periodo->periodo_nombre }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold">Año:</div>
                        <div class="col-sm-8">{{ $periodo->anio }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold">Código:</div>
                        <div class="col-sm-8">
                            <span class="badge bg-secondary">{{ $periodo->codigo_periodo }}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold">Estado:</div>
                        <div class="col-sm-8">
                            <span class="badge {{ $periodo->activo ? 'bg-success' : 'bg-secondary' }}">
                                {{ $periodo->activo ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold">Creado:</div>
                        <div class="col-sm-8">{{ $periodo->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 fw-bold">Actualizado:</div>
                        <div class="col-sm-8">{{ $periodo->updated_at->format('d/m/Y H:i') }}</div>
                    </div>

                    <div class="mt-4 d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('periodos.edit', $periodo->id) }}" class="btn btn-primary">
                            <i class="fa fa-edit me-1"></i> Editar Período
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection