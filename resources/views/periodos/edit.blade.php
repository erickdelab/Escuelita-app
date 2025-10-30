@extends('layouts.app')

@section('template_title')
    Editar Período
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card shadow-lg border-0">
                <div class="card-header text-white" style="background-color: #002D72;">
                    <h4 class="mb-0">✏️ {{ __('Editar Período') }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('periodos.update', $periodo->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="periodo_nombre" class="form-label">Nombre del Período</label>
                            <select class="form-select @error('periodo_nombre') is-invalid @enderror" 
                                    id="periodo_nombre" name="periodo_nombre" required>
                                <option value="Enero-Junio" {{ $periodo->periodo_nombre == 'Enero-Junio' ? 'selected' : '' }}>Enero - Junio</option>
                                <option value="Agosto-Diciembre" {{ $periodo->periodo_nombre == 'Agosto-Diciembre' ? 'selected' : '' }}>Agosto - Diciembre</option>
                            </select>
                            @error('periodo_nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="anio" class="form-label">Año</label>
                            <input type="number" class="form-control @error('anio') is-invalid @enderror" 
                                   id="anio" name="anio" value="{{ old('anio', $periodo->anio) }}" 
                                   min="2020" max="2030" required>
                            @error('anio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="activo" name="activo" value="1"
                                   {{ $periodo->activo ? 'checked' : '' }}>
                            <label class="form-check-label" for="activo">Período activo</label>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('periodos.index') }}" class="btn btn-secondary me-md-2">
                                <i class="fa fa-arrow-left me-1"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save me-1"></i> Actualizar Período
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection