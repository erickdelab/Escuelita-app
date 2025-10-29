@extends('layouts.app')

@section('template_title')
    Profesores
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">

            <div class="card shadow-lg border-0">
                <div class="card-header text-white" style="background-color: #002D72;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h4 class="mb-0">👩‍🏫 {{ __('Profesores') }}</h4>

                        <a href="{{ route('profesores.create') }}" class="btn btn-light btn-sm fw-bold">
                            + {{ __('Nuevo Profesor') }}
                        </a>
                    </div>
                </div>

                @if ($message = Session::get('success'))
                    <div class="alert alert-success m-4 shadow-sm border-0 rounded">
                        <p class="mb-0">{{ $message }}</p>
                    </div>
                @elseif ($message = Session::get('error'))
                    <div class="alert alert-danger m-4 shadow-sm border-0 rounded">
                        <p class="mb-0">{{ $message }}</p>
                    </div>
                @endif
                
                {{-- CUADRO DE BÚSQUEDA/FILTRO --}}
                <div class="card-body">
                    <form method="GET" action="{{ route('profesores.index') }}" class="mb-4">
                        <div class="input-group">
                            <input type="text" 
                                   name="search" 
                                   class="form-control" 
                                   placeholder="Buscar por N° Trabajador, Nombre, Apellido, Área o Situación..."
                                   value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">Buscar</button>
                            @if(request('search'))
                                <a href="{{ route('profesores.index') }}" class="btn btn-secondary">Limpiar</a>
                            @endif
                        </div>
                    </form>

                    <!-- Tabla -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="text-center text-white" style="background-color: #002D72;">
                                <tr>
                                    <th>N° Trabajador</th>
                                    <th>Nombre</th>
                                    <th>S Nombre</th>
                                    <th>Ap Paterno</th>
                                    <th>Ap Materno</th>
                                    <th>Correo Institucional</th>
                                    <th>Área</th>
                                    <th>Situación</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($profesores as $profesore)
                                    <tr>
                                        <td class="text-center">{{ $profesore->n_trabajador }}</td>
                                        <td>{{ $profesore->nombre }}</td>
                                        <td>{{ $profesore->s_nombre }}</td>
                                        <td>{{ $profesore->ap_paterno }}</td> 
                                        <td>{{ $profesore->ap_materno }}</td> 
                                        <td>{{ $profesore->correo_institucional }}</td> 
                                        
                                        {{-- Muestra el nombre del área --}}
                                        <td class="text-center">{{ $profesore->area->area ?? 'N/A' }}</td> 
                                        
                                        <td class="text-center">{{ $profesore->situacion }}</td> 
                                        
                                        <td class="text-center">
                                            <form action="{{ route('profesores.destroy', $profesore->n_trabajador) }}" method="POST">
                                                <a class="btn btn-sm btn-outline-primary" href="{{ route('profesores.show', $profesore->n_trabajador) }}">
                                                    <i class="fa fa-fw fa-eye"></i> Ver
                                                </a>
                                                <a class="btn btn-sm btn-outline-success" href="{{ route('profesores.edit', $profesore->n_trabajador) }}">
                                                    <i class="fa fa-fw fa-edit"></i> Editar
                                                </a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="event.preventDefault(); confirm('¿Seguro que deseas dar de baja a este profesor? Su estatus cambiará a Inactivo/Baja.') ? this.closest('form').submit() : false;">
                                                    <i class="fa fa-fw fa-trash"></i> Dar Baja
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">No se encontraron profesores que coincidan con la búsqueda.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center mt-3">
                {{-- appends mantiene el parámetro 'search' al navegar entre páginas --}}
                {!! $profesores->appends(['search' => request('search')])->links('pagination::bootstrap-5') !!}
            </div>

        </div>
    </div>
</div>
@endsection
