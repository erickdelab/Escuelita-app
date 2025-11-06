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
                            <!-- Búsqueda General (Siempre visible) -->
                            <div class="col-md-8">
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

                            <!-- Botón para mostrar/ocultar filtros avanzados -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-primary">&nbsp;</label>
                                <div class="d-grid gap-2">
                                    <button type="button" class="btn btn-outline-primary" id="toggleFiltersBtn">
                                        <i class="bi bi-funnel me-1"></i>Filtros Avanzados
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Filtros Avanzados (Ocultos por defecto) -->
                        <div id="advancedFilters" class="row g-3 mt-2" style="display: none;">
                            <!-- Filtro de Situación (Checkboxes) -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-primary">Situación Académica</label>
                                <div class="border rounded p-3 bg-white">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="situacion_filter[]" value="Vigente" 
                                               id="situacion_vigente" {{ in_array('Vigente', request('situacion_filter', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="situacion_vigente">
                                            Vigente
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="situacion_filter[]" value="Baja" 
                                               id="situacion_baja" {{ in_array('Baja', request('situacion_filter', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="situacion_baja">
                                            Baja
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="situacion_filter[]" value="Egresado" 
                                               id="situacion_egresado" {{ in_array('Egresado', request('situacion_filter', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="situacion_egresado">
                                            Egresado
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Filtro de Carrera (Checkboxes) -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-primary">Carrera(s)</label>
                                <div class="border rounded p-3 bg-white" style="max-height: 150px; overflow-y: auto;">
                                    @foreach($carreras as $id => $nombre)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="carrera_filter[]" value="{{ $id }}" 
                                               id="carrera_{{ $id }}" {{ in_array($id, request('carrera_filter', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="carrera_{{ $id }}">
                                            {{ $nombre }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Filtro de Semestre (Checkboxes) -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-primary">Semestre(s)</label>
                                <div class="border rounded p-3 bg-white" style="max-height: 200px; overflow-y: auto;">
                                    @for($i = 1; $i <= 12; $i++)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="semestre_filter[]" value="{{ $i }}" 
                                               id="semestre_{{ $i }}" {{ in_array($i, request('semestre_filter', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="semestre_{{ $i }}">
                                            Semestre {{ $i }}
                                        </label>
                                    </div>
                                    @endfor
                                </div>
                            </div>

                            <!-- Filtro de Género -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-primary">Género</label>
                                <select name="genero_filter" class="form-select">
                                    <option value="">Todos los géneros</option>
                                    <option value="M" {{ request('genero_filter') == 'M' ? 'selected' : '' }}>Masculino</option>
                                    <option value="F" {{ request('genero_filter') == 'F' ? 'selected' : '' }}>Femenino</option>
                                </select>
                            </div>

                            <!-- Filtro de Promedio -->
                            <div class="col-md-6">
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

                            <!-- Botones de Acción para filtros avanzados -->
                            <div class="col-12">
                                <div class="d-flex gap-2 justify-content-end">
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
                                                <span class="text-dark fw-bold">
                                                    {{ number_format($alumno->promedio_general, 1) }}
                                                </span>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        
                                        <td class="text-center fw-bold">{{ $alumno->n_control }}</td>
                                        
                                        <!-- Nombre Completo -->
                                        <td>
                                            <div class="fw-bold">{{ $alumno->nombre }} {{ $alumno->s_nombre ?? '' }}</div>
                                            <small class="text-muted">{{ $alumno->ap_pat }} {{ $alumno->ap_mat }}</small>
                                        </td>
                                        
                                        <!-- Género (sin color) -->
                                        <td class="text-center">
                                            {{ $alumno->genero == 'M' ? ' Masculino' : ' Femenino' }}
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
                                        
                                        <!-- Semestre (solo número) -->
                                        <td class="text-center">
                                            <span class="fw-bold">{{ $alumno->semestre }}</span>
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
    
    #advancedFilters {
        transition: all 0.3s ease;
    }
    
    .form-check-input:checked {
        background-color: #002D72;
        border-color: #002D72;
    }
</style>

<script>
    // Auto-submit para selects simples
    document.querySelectorAll('select:not([multiple])').forEach(select => {
        select.addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    });

    // Mostrar/ocultar filtros avanzados
    document.getElementById('toggleFiltersBtn').addEventListener('click', function() {
        const filters = document.getElementById('advancedFilters');
        const isVisible = filters.style.display === 'block';
        
        filters.style.display = isVisible ? 'none' : 'block';
        this.innerHTML = isVisible 
            ? '<i class="bi bi-funnel me-1"></i>Filtros Avanzados' 
            : '<i class="bi bi-funnel-fill me-1"></i>Ocultar Filtros';
        
        // Cambiar estilo del botón
        this.classList.toggle('btn-outline-primary');
        this.classList.toggle('btn-primary');
    });

    // Mostrar filtros automáticamente si hay algún filtro avanzado activo
    document.addEventListener('DOMContentLoaded', function() {
        const hasAdvancedFilters = {{ request()->anyFilled(['situacion_filter', 'carrera_filter', 'semestre_filter', 'genero_filter', 'promedio_filter']) ? 'true' : 'false' }};
        
        if (hasAdvancedFilters) {
            const filters = document.getElementById('advancedFilters');
            const toggleBtn = document.getElementById('toggleFiltersBtn');
            
            filters.style.display = 'block';
            toggleBtn.innerHTML = '<i class="bi bi-funnel-fill me-1"></i>Ocultar Filtros';
            toggleBtn.classList.remove('btn-outline-primary');
            toggleBtn.classList.add('btn-primary');
        }
    });
</script>
@endsection