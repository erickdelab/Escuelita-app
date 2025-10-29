@extends('layouts.app')

@section('template_title')
    Alumnos
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">

            <div class="card shadow-lg border-0">
                <!-- Header -->
                <div class="card-header text-white" style="background-color: #002D72;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h4 class="mb-0">🎓 {{ __('Alumnos') }}</h4>

                        <a href="{{ route('alumnos.create') }}" class="btn btn-light btn-sm fw-bold">
                            + {{ __('Nuevo Alumno') }}
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
                
                <!-- CUADRO DE BÚSQUEDA/FILTRO INTEGRADO -->
                <div class="card-body">
                    <form method="GET" action="{{ route('alumnos.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" 
                                           name="search" 
                                           class="form-control" 
                                           placeholder="Buscar por N° Control, Nombre, Carrera o Situación..."
                                           value="{{ request('search') }}">
                                    <button class="btn btn-primary" type="submit">Buscar</button>
                                    @if(request('search'))
                                        <a href="{{ route('alumnos.index') }}" class="btn btn-secondary">Limpiar</a>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select name="situacion_filter" class="form-control" onchange="this.form.submit()">
                                    <option value="">Todas las situaciones</option>
                                    <option value="Vigente" {{ request('situacion_filter') == 'Vigente' ? 'selected' : '' }}>Vigente</option>
                                    <option value="Baja" {{ request('situacion_filter') == 'Baja' ? 'selected' : '' }}>Baja</option>
                                    <option value="Egresado" {{ request('situacion_filter') == 'Egresado' ? 'selected' : '' }}>Egresado</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="carrera_filter" class="form-control" onchange="this.form.submit()">
                                    <option value="">Todas las carreras</option>
                                    @foreach($carreras as $id => $nombre)
                                        <option value="{{ $id }}" {{ request('carrera_filter') == $id ? 'selected' : '' }}>
                                            {{ $nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>

                    <!-- Tabla con ordenamiento -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="text-center text-white" style="background-color: #002D72;">
                                <tr>
                                    <th>
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'promedio_general', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" 
                                           class="text-white text-decoration-none d-flex justify-content-between align-items-center">
                                            <span>Promedio General</span>
                                            @if(request('sort') == 'promedio_general')
                                                <i class="bi bi-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                                            @else
                                                <i class="bi bi-filter-left ms-1 opacity-50"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'n_control', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" 
                                           class="text-white text-decoration-none d-flex justify-content-between align-items-center">
                                            <span>N° Control</span>
                                            @if(request('sort') == 'n_control')
                                                <i class="bi bi-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                                            @else
                                                <i class="bi bi-filter-left ms-1 opacity-50"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'nombre', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" 
                                           class="text-white text-decoration-none d-flex justify-content-between align-items-center">
                                            <span>Nombre</span>
                                            @if(request('sort') == 'nombre')
                                                <i class="bi bi-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                                            @else
                                                <i class="bi bi-filter-left ms-1 opacity-50"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 's_nombre', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" 
                                           class="text-white text-decoration-none d-flex justify-content-between align-items-center">
                                            <span>S Nombre</span>
                                            @if(request('sort') == 's_nombre')
                                                <i class="bi bi-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                                            @else
                                                <i class="bi bi-filter-left ms-1 opacity-50"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'ap_pat', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" 
                                           class="text-white text-decoration-none d-flex justify-content-between align-items-center">
                                            <span>Ap Pat</span>
                                            @if(request('sort') == 'ap_pat')
                                                <i class="bi bi-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                                            @else
                                                <i class="bi bi-filter-left ms-1 opacity-50"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'ap_mat', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" 
                                           class="text-white text-decoration-none d-flex justify-content-between align-items-center">
                                            <span>Ap Mat</span>
                                            @if(request('sort') == 'ap_mat')
                                                <i class="bi bi-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                                            @else
                                                <i class="bi bi-filter-left ms-1 opacity-50"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'fech_nac', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" 
                                           class="text-white text-decoration-none d-flex justify-content-between align-items-center">
                                            <span>Fech Nac</span>
                                            @if(request('sort') == 'fech_nac')
                                                <i class="bi bi-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                                            @else
                                                <i class="bi bi-filter-left ms-1 opacity-50"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'genero', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" 
                                           class="text-white text-decoration-none d-flex justify-content-between align-items-center">
                                            <span>Género</span>
                                            @if(request('sort') == 'genero')
                                                <i class="bi bi-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                                            @else
                                                <i class="bi bi-filter-left ms-1 opacity-50"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'carrera', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" 
                                           class="text-white text-decoration-none d-flex justify-content-between align-items-center">
                                            <span>Carrera</span>
                                            @if(request('sort') == 'carrera')
                                                <i class="bi bi-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                                            @else
                                                <i class="bi bi-filter-left ms-1 opacity-50"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'situacion', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" 
                                           class="text-white text-decoration-none d-flex justify-content-between align-items-center">
                                            <span>Situación</span>
                                            @if(request('sort') == 'situacion')
                                                <i class="bi bi-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                                            @else
                                                <i class="bi bi-filter-left ms-1 opacity-50"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'semestre', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" 
                                           class="text-white text-decoration-none d-flex justify-content-between align-items-center">
                                            <span>Semestre</span>
                                            @if(request('sort') == 'semestre')
                                                <i class="bi bi-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                                            @else
                                                <i class="bi bi-filter-left ms-1 opacity-50"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($alumnos as $alumno)
                                    <tr>
                                        <!-- Promedio General -->
                                        <td class="text-center">
                                            @if($alumno->promedio_general !== null)
                                                <span class="badge 
                                                    @if($alumno->promedio_general >= 90) bg-success
                                                    @elseif($alumno->promedio_general >= 80) bg-info
                                                    @elseif($alumno->promedio_general >= 70) bg-warning
                                                    @else bg-danger @endif">
                                                    {{ number_format($alumno->promedio_general, 2) }}%
                                                </span>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        
                                        <td class="text-center">{{ $alumno->n_control }}</td>
                                        <td>{{ $alumno->nombre }}</td>
                                        <td>{{ $alumno->s_nombre }}</td>
                                        <td>{{ $alumno->ap_pat }}</td>
                                        <td>{{ $alumno->ap_mat }}</td>
                                        <td class="text-center">{{ $alumno->fech_nac }}</td>
                                        <td class="text-center">{{ $alumno->genero }}</td>
                                        
                                        <!-- Carrera -->
                                        <td class="text-center">
                                            {{ $alumno->carrera->nombre_carrera ?? 'N/A' }}
                                        </td>
                                        
                                        <td class="text-center">
                                            <span class="badge 
                                                @if($alumno->situacion == 'Vigente') bg-success
                                                @elseif($alumno->situacion == 'Baja') bg-danger
                                                @elseif($alumno->situacion == 'Egresado') bg-info
                                                @else bg-secondary @endif">
                                                {{ $alumno->situacion }}
                                            </span>
                                        </td>
                                        <td class="text-center">{{ $alumno->semestre }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('alumnos.destroy', $alumno->n_control) }}" method="POST">
                                                <a class="btn btn-sm btn-outline-primary" href="{{ route('alumnos.show', $alumno->n_control) }}">
                                                    Ver
                                                </a>
                                                <a class="btn btn-sm btn-outline-success" href="{{ route('alumnos.edit', $alumno->n_control) }}">
                                                    Editar
                                                </a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="event.preventDefault(); confirm('¿Seguro que deseas dar de baja a este alumno? (Su registro no se eliminará)') ? this.closest('form').submit() : false;">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12" class="text-center py-4">No se encontraron alumnos que coincidan con la búsqueda.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Paginación con parámetros de búsqueda -->
            <div class="d-flex justify-content-center mt-3">
                {!! $alumnos->appends([
                    'search' => request('search'),
                    'situacion_filter' => request('situacion_filter'),
                    'carrera_filter' => request('carrera_filter'),
                    'sort' => request('sort'),
                    'direction' => request('direction')
                ])->links('pagination::bootstrap-5') !!}
            </div>

        </div>
    </div>
</div>

<style>
    .table th a:hover {
        text-decoration: underline !important;
    }
    .table th i {
        font-size: 0.8em;
    }
</style>
@endsection