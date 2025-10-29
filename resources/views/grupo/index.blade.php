@extends('layouts.app')

@section('template_title')
    Grupos
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">

            <div class="card shadow-lg border-0">
                <!-- Header -->
                <div class="card-header text-white" style="background-color: #002D72;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h4 class="mb-0">👥 {{ __('Grupos') }}</h4>

                        <a href="{{ route('grupos.create') }}" class="btn btn-light btn-sm fw-bold">
                            + {{ __('Nuevo Grupo') }}
                        </a>
                    </div>
                </div>

                <!-- Mensaje de éxito/error -->
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
                                    <th>ID Grupo</th>
                                    <th>Materia</th>
                                    <th>Profesor</th>
                                    <th>Semestre</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($grupos as $grupo)
                                    <tr>
                                        <td class="text-center">{{ $grupo->id_grupo }}</td>
                                        
                                        {{-- COLUMNA MATERIA - MEJORADA --}}
                                        <td>
                                            @if ($grupo->materia)
                                                {{-- Si la relación funciona --}}
                                                <strong>{{ $grupo->materia->cod_materia }}</strong> - {{ $grupo->materia->nombre }}
                                            @elseif($grupo->cod_materia && $grupo->nombre_materia)
                                                {{-- Si tenemos código y podemos obtener el nombre --}}
                                                <strong>{{ $grupo->cod_materia }}</strong> - {{ $grupo->nombre_materia }}
                                            @elseif($grupo->cod_materia)
                                                {{-- Si solo tenemos el código --}}
                                                <span class="text-warning">
                                                    <strong>{{ $grupo->cod_materia }}</strong>
                                                </span>
                                                <br>
                                                <small class="text-muted">Código existe pero materia no encontrada</small>
                                            @else
                                                <span class="text-danger fw-bold">Materia no asignada</span>
                                            @endif
                                        </td>
                                        
                                        {{-- COLUMNA PROFESOR --}}
                                        <td>
                                            @if ($grupo->profesore)
                                                {{ $grupo->profesore->nombre }} {{ $grupo->profesore->ap_paterno }} {{ $grupo->profesore->ap_materno }}
                                                <br><small class="text-muted">{{ $grupo->profesore->n_trabajador }}</small>
                                            @else
                                                <span class="text-danger fw-bold">Profesor no asignado</span>
                                                <br><small class="text-muted">ID: {{ $grupo->n_trabajador }}</small>
                                            @endif
                                        </td>
                                        
                                        <td class="text-center">
                                            <span class="badge bg-primary fs-6">Semestre {{ $grupo->semestre }}</span>
                                        </td>
                                        
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                {{-- NUEVO BOTÓN VER DETALLES --}}
                                                <a class="btn btn-sm btn-info" href="{{ route('grupos.detalles', $grupo->id_grupo) }}" 
                                                   title="Ver detalles completos del grupo">
                                                    <i class="fas fa-list-alt"></i> Detalles
                                                </a>
                                                
                                               
                                                
                                                <a class="btn btn-sm btn-outline-success" href="{{ route('grupos.edit', $grupo->id_grupo) }}"
                                                   title="Editar grupo">
                                                    <i class="fa fa-fw fa-edit"></i> Editar
                                                </a>
                                                
                                                <form action="{{ route('grupos.destroy', $grupo->id_grupo) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        onclick="event.preventDefault(); confirm('¿Seguro que deseas eliminar este grupo?') ? this.closest('form').submit() : false;"
                                                        title="Eliminar grupo">
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
                </div>
            </div>

            <!-- Paginación centrada -->
            <div class="d-flex justify-content-center mt-3">
                {!! $grupos->withQueryString()->links('pagination::bootstrap-5') !!}
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
    
    /* Estilos para los botones de acciones */
    .btn-info {
        background-color: #17a2b8;
        border-color: #17a2b8;
        color: white;
    }
    
    .btn-info:hover {
        background-color: #138496;
        border-color: #117a8b;
        color: white;
    }
</style>
@endsection