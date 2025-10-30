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
                
                <!-- PANEL DE FILTROS AVANZADOS -->
                <div class="card-body bg-light">
                    <form method="GET" action="{{ route('alumnos.index') }}" id="filterForm">
                        <div class="row g-3">
                            <!-- Búsqueda General -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-primary">Búsqueda General</label>
                                <div class="input-group">
                                    <input type="text" 
                                           name="search" 
                                           class="form-control" 
                                           placeholder="N° Control, Nombre, Apellidos..."
                                           value="{{ request('search') }}">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Filtro de Situación (Múltiple) -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-primary">Situación Académica</label>
                                <select name="situacion_filter[]" class="form-select" multiple size="3">
                                    <option value="Vigente" {{ in_array('Vigente', request('situacion_filter', [])) ? 'selected' : '' }}>Vigente</option>
                                    <option value="Baja" {{ in_array('Baja', request('situacion_filter', [])) ? 'selected' : '' }}>Baja</option>
                                    <option value="Egresado" {{ in_array('Egresado', request('situacion_filter', [])) ? 'selected' : '' }}>Egresado</option>
                                </select>
                                <small class="form-text text-muted">Mantén Ctrl para seleccionar múltiples</small>
                            </div>

                            <!-- Filtro de Carrera (Múltiple) -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-primary">Carrera(s)</label>
                                <select name="carrera_filter[]" class="form-select" multiple size="3">
                                    @foreach($carreras as $id => $nombre)
                                        <option value="{{ $id }}" {{ in_array($id, request('carrera_filter', [])) ? 'selected' : '' }}>
                                            {{ $nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Mantén Ctrl para seleccionar múltiples</small>
                            </div>

                            <!-- Filtro de Semestre (Múltiple) -->
                            <div class="col-md-3">
                                <label class="form-label fw-bold text-primary">Semestre(s)</label>
                                <select name="semestre_filter[]" class="form-select" multiple size="4">
                                    @for($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ in_array($i, request('semestre_filter', [])) ? 'selected' : '' }}>
                                            Semestre {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                                <small class="form-text text-muted">Selecciona uno o más semestres</small>
                            </div>

                            <!-- Filtro de Género -->
                            <div class="col-md-3">
                                <label class="form-label fw-bold text-primary">Género</label>
                                <select name="genero_filter" class="form-select">
                                    <option value="">Todos los géneros</option>
                                    <option value="M" {{ request('genero_filter') == 'M' ? 'selected' : '' }}>Masculino</option>
                                    <option value="F" {{ request('genero_filter') == 'F' ? 'selected' : '' }}>Femenino</option>
                                </select>
                            </div>

                            <!-- Filtro de Promedio -->
                            <div class="col-md-3">
                                <label class="form-label fw-bold text-primary">Rango de Promedio</label>
                                <select name="promedio_filter" class="form-select">
                                    <option value="">Todos los promedios</option>
                                    <option value="90-100" {{ request('promedio_filter') == '90-100' ? 'selected' : '' }}>Excelente (90-100%)</option>
                                    <option value="80-89" {{ request('promedio_filter') == '80-89' ? 'selected' : '' }}>Muy Bueno (80-89%)</option>
                                    <option value="70-79" {{ request('promedio_filter') == '70-79' ? 'selected' : '' }}>Bueno (70-79%)</option>
                                    <option value="0-69" {{ request('promedio_filter') == '0-69' ? 'selected' : '' }}>Necesita mejorar (0-69%)</option>
                                    <option value="sin_promedio" {{ request('promedio_filter') == 'sin_promedio' ? 'selected' : '' }}>Sin promedio</option>
                                </select>
                            </div>

                            <!-- Botones de Acción -->
                            <div class="col-md-3">
                                <label class="form-label fw-bold text-primary">&nbsp;</label>
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-funnel-fill me-1"></i>Aplicar Filtros
                                    </button>
                                    <a href="{{ route('alumnos.index') }}" class="btn btn-outline-secondary">
                                        <i class="bi bi-arrow-clockwise me-1"></i>Limpiar Filtros
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Contadores de Filtros Activos -->
                        @if(request()->anyFilled(['search', 'situacion_filter', 'carrera_filter', 'semestre_filter', 'genero_filter', 'promedio_filter']))
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="alert alert-info py-2">
                                    <small>
                                        <strong>Filtros activos:</strong>
                                        @if(request('search'))
                                            <span class="badge bg-primary me-1">Búsqueda: "{{ request('search') }}"</span>
                                        @endif
                                        @if(request('situacion_filter'))
                                            <span class="badge bg-primary me-1">Situación: {{ implode(', ', request('situacion_filter')) }}</span>
                                        @endif
                                        @if(request('carrera_filter'))
                                            <span class="badge bg-primary me-1">Carreras: {{ count(request('carrera_filter')) }} seleccionadas</span>
                                        @endif
                                        @if(request('semestre_filter'))
                                            <span class="badge bg-primary me-1">Semestres: {{ implode(', ', request('semestre_filter')) }}</span>
                                        @endif
                                        @if(request('genero_filter'))
                                            <span class="badge bg-primary me-1">Género: {{ request('genero_filter') == 'M' ? 'Masculino' : 'Femenino' }}</span>
                                        @endif
                                        @if(request('promedio_filter'))
                                            <span class="badge bg-primary me-1">Promedio: {{ request('promedio_filter') }}</span>
                                        @endif
                                        <span class="badge bg-success me-1">Resultados: {{ $alumnos->total() }}</span>
                                    </small>
                                </div>
                            </div>
                        </div>
                        @endif
                    </form>
                </div>

                <!-- Tabla con ordenamiento -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="text-center text-white" style="background-color: #002D72;">
                                <tr>
                                    <th width="100">
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'promedio_general', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" 
                                           class="text-white text-decoration-none">
                                            Promedio
                                        </a>
                                    </th>
                                    <th width="120">
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'n_control', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" 
                                           class="text-white text-decoration-none">
                                            N° Control
                                        </a>
                                    </th>
                                    <th>Nombre Completo</th>
                                    <th width="100">
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'genero', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" 
                                           class="text-white text-decoration-none">
                                            Género
                                        </a>
                                    </th>
                                    <th width="150">Carrera</th>
                                    <th width="120">
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'situacion', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" 
                                           class="text-white text-decoration-none">
                                            Situación
                                        </a>
                                    </th>
                                    <th width="100">
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'semestre', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" 
                                           class="text-white text-decoration-none">
                                            Semestre
                                        </a>
                                    </th>
                                    <th width="200">Acciones</th>
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
                                                    {{ number_format($alumno->promedio_general, 1) }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">N/A</span>
                                            @endif
                                        </td>
                                        
                                        <td class="text-center fw-bold">{{ $alumno->n_control }}</td>
                                        
                                        <!-- Nombre Completo -->
                                        <td>
                                            <div class="fw-bold">{{ $alumno->nombre }} {{ $alumno->s_nombre ?? '' }}</div>
                                            <small class="text-muted">{{ $alumno->ap_pat }} {{ $alumno->ap_mat }}</small>
                                        </td>
                                        
                                        <td class="text-center">
                                            <span class="badge {{ $alumno->genero == 'M' ? 'bg-primary' : 'bg-pink' }}">
                                                {{ $alumno->genero == 'M' ? '♂ Masculino' : '♀ Femenino' }}
                                            </span>
                                        </td>
                                        
                                        <!-- Carrera -->
                                        <td class="text-center">
                                            <span class="fw-bold">{{ $alumno->carrera->nombre_carrera ?? 'N/A' }}</span>
                                        </td>
                                        
                                        <!-- Situación -->
                                        <td class="text-center">
                                            <span class="badge 
                                                @if($alumno->situacion == 'Vigente') bg-success
                                                @elseif($alumno->situacion == 'Baja') bg-danger
                                                @elseif($alumno->situacion == 'Egresado') bg-info
                                                @else bg-secondary @endif">
                                                {{ $alumno->situacion }}
                                            </span>
                                        </td>
                                        
                                        <!-- Semestre -->
                                        <td class="text-center">
                                            <span class="badge bg-dark fs-6">S{{ $alumno->semestre }}</span>
                                        </td>
                                        
                                        <!-- Acciones -->
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a class="btn btn-outline-primary" href="{{ route('alumnos.show', $alumno->n_control) }}"
                                                   title="Ver detalles">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a class="btn btn-outline-success" href="{{ route('alumnos.edit', $alumno->n_control) }}"
                                                   title="Editar alumno">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a class="btn btn-outline-info" href="{{ route('alumnos.grupos.create', $alumno->n_control) }}"
                                                   title="Inscribir a grupos">
                                                    <i class="bi bi-plus-circle"></i>
                                                </a>
                                                <form action="{{ route('alumnos.destroy', $alumno->n_control) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger"
                                                        onclick="event.preventDefault(); confirm('¿Seguro que deseas dar de baja a este alumno?') ? this.closest('form').submit() : false;"
                                                        title="Dar de baja">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <i class="bi bi-search display-4 text-muted"></i>
                                            <h5 class="text-muted mt-3">No se encontraron alumnos</h5>
                                            <p class="text-muted">Intenta ajustar los filtros de búsqueda</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Paginación con parámetros de búsqueda -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Mostrando {{ $alumnos->firstItem() ?? 0 }} - {{ $alumnos->lastItem() ?? 0 }} de {{ $alumnos->total() }} registros
                </div>
                <div>
                    {!! $alumnos->appends(request()->except('page'))->links('pagination::bootstrap-5') !!}
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .bg-pink {
        background-color: #e83e8c !important;
    }
    
    .form-select[multiple] {
        height: auto;
        min-height: 80px;
    }
    
    .table th a:hover {
        text-decoration: underline !important;
    }
    
    .btn-group-sm > .btn {
        padding: 0.25rem 0.5rem;
    }
</style>

<script>
    // Auto-submit para selects simples
    document.querySelectorAll('select:not([multiple])').forEach(select => {
        select.addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    });
</script>
@endsection