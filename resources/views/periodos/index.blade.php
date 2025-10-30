@extends('layouts.app')

@section('template_title')
    Períodos Académicos
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card shadow-lg border-0">
                <!-- Header -->
                <div class="card-header text-white" style="background-color: #002D72;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h4 class="mb-0">📅 {{ __('Períodos Académicos') }}</h4>
                        <a href="{{ route('periodos.create') }}" class="btn btn-light btn-sm fw-bold">
                            + {{ __('Nuevo Período') }}
                        </a>
                    </div>
                </div>

                <!-- Mensajes -->
                @if ($message = Session::get('success'))
                    <div class="alert alert-success m-4 shadow-sm border-0 rounded">
                        <p class="mb-0">{{ $message }}</p>
                    </div>
                @elseif ($message = Session::get('error'))
                    <div class="alert alert-danger m-4 shadow-sm border-0 rounded">
                        <p class="mb-0">{{ $message }}</p>
                    </div>
                @endif

                <!-- Tabla -->
                <div class="card-body bg-white rounded-bottom">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="text-center text-white" style="background-color: #002D72;">
                                <tr>
                                    <th>Período</th>
                                    <th>Año</th>
                                    <th>Código</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($periodos as $periodo)
                                    <tr>
                                        <td>{{ $periodo->periodo_nombre }}</td>
                                        <td class="text-center">
                                            <span class="fw-bold">{{ $periodo->anio }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-secondary fs-6">{{ $periodo->codigo_periodo }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge {{ $periodo->activo ? 'bg-success' : 'bg-secondary' }} fs-6">
                                                {{ $periodo->activo ? '🟢 Activo' : '⚫ Inactivo' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a class="btn btn-sm btn-outline-primary" href="{{ route('periodos.show', $periodo->id) }}"
                                                   title="Ver detalles">
                                                    <i class="fa fa-fw fa-eye"></i> Ver
                                                </a>
                                                <a class="btn btn-sm btn-outline-success" href="{{ route('periodos.edit', $periodo->id) }}"
                                                   title="Editar período">
                                                    <i class="fa fa-fw fa-edit"></i> Editar
                                                </a>
                                                <form action="{{ route('periodos.destroy', $periodo->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        onclick="event.preventDefault(); confirm('¿Estás seguro de eliminar este período?') ? this.closest('form').submit() : false;"
                                                        title="Eliminar período">
                                                        <i class="fa fa-fw fa-trash"></i> Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Información de registros -->
                    <div class="mt-3 text-end">
                        <small class="text-muted">
                            <strong>Total de períodos:</strong> {{ $periodos->count() }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .table th {
        font-weight: 600;
        font-size: 0.9rem;
    }
    
    .badge {
        font-size: 0.8rem;
        padding: 0.4em 0.6em;
    }
    
    .btn-sm {
        margin: 2px;
        font-size: 0.8rem;
        padding: 0.25rem 0.5rem;
    }
    
    .btn-group {
        flex-wrap: wrap;
        gap: 2px;
    }
    
    .table td {
        vertical-align: middle;
    }
</style>
@endsection