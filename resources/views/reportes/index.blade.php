@extends('layouts.app')

@section('template_title')
    Reportes del Sistema
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card shadow-lg border-0">
                <!-- Header -->
                <div class="card-header text-white" style="background-color: #002D72;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h4 class="mb-0">📊 {{ __('Reportes del Sistema') }}</h4>
                        <div class="btn-group">
                            <button type="button" class="btn btn-light btn-sm fw-bold dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fas fa-download me-1"></i>Exportar
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-file-pdf me-2"></i>PDF</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-file-excel me-2"></i>Excel</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-file-csv me-2"></i>CSV</a></li>
                            </ul>
                        </div>
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

                <!-- Panel de Filtros Generales -->
                <div class="card-body bg-light">
                    <form method="GET" action="{{ route('reportes.index') }}" id="filterForm">
                        <div class="row g-3">
                            <!-- Periodo Académico -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-primary">Periodo Académico</label>
                                <select name="periodo" class="form-select" onchange="this.form.submit()">
                                    <option value="">Todos los periodos</option>
                                    @foreach($periodos as $periodo)
                                        <option value="{{ $periodo->id }}" {{ request('periodo') == $periodo->id ? 'selected' : '' }}>
                                            {{ $periodo->periodo_nombre }} {{ $periodo->anio }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Carrera -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-primary">Carrera</label>
                                <select name="carrera" class="form-select" onchange="this.form.submit()">
                                    <option value="">Todas las carreras</option>
                                    @foreach($carreras as $carrera)
                                        <option value="{{ $carrera->id_carrera }}" {{ request('carrera') == $carrera->id_carrera ? 'selected' : '' }}>
                                            {{ $carrera->nombre_carrera }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Semestre -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-primary">Semestre</label>
                                <select name="semestre" class="form-select" onchange="this.form.submit()">
                                    <option value="">Todos los semestres</option>
                                    @for($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ request('semestre') == $i ? 'selected' : '' }}>
                                            Semestre {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <!-- Contadores de Filtros Activos -->
                        @if(request()->anyFilled(['periodo', 'carrera', 'semestre']))
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="alert alert-info py-2">
                                    <small>
                                        <strong>Filtros activos:</strong>
                                        @if(request('periodo'))
                                            @php
                                                $periodoSeleccionado = $periodos->firstWhere('id', request('periodo'));
                                            @endphp
                                            <span class="badge bg-primary me-1">Periodo: {{ $periodoSeleccionado->periodo_nombre ?? '' }} {{ $periodoSeleccionado->anio ?? '' }}</span>
                                        @endif
                                        @if(request('carrera'))
                                            @php
                                                $carreraSeleccionada = $carreras->firstWhere('id_carrera', request('carrera'));
                                            @endphp
                                            <span class="badge bg-primary me-1">Carrera: {{ $carreraSeleccionada->nombre_carrera ?? '' }}</span>
                                        @endif
                                        @if(request('semestre'))
                                            <span class="badge bg-primary me-1">Semestre: {{ request('semestre') }}</span>
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </div>
                        @endif
                    </form>
                </div>

                <!-- Tarjetas de Resumen -->
                <div class="card-body">
                    <div class="row g-4">
                        <!-- Reporte de Alumnos -->
                        <div class="col-md-6 col-lg-3">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <i class="fas fa-user-graduate fa-3x text-primary"></i>
                                    </div>
                                    <h5 class="card-title text-primary">Reporte de Alumnos</h5>
                                    <p class="card-text text-muted small">
                                        Información detallada de estudiantes por carrera, situación académica y promedio.
                                    </p>
                                    <div class="mt-3">
                                        <span class="badge bg-primary fs-6">{{ $totalAlumnos }}</span>
                                        <small class="text-muted d-block">Total de alumnos</small>
                                    </div>
                                    <a href="{{ route('reportes.alumnos') }}" class="btn btn-outline-primary btn-sm mt-3">
                                        <i class="fas fa-chart-bar me-1"></i>Ver Reporte
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Reporte de Grupos -->
                        <div class="col-md-6 col-lg-3">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <i class="fas fa-users fa-3x text-success"></i>
                                    </div>
                                    <h5 class="card-title text-success">Reporte de Grupos</h5>
                                    <p class="card-text text-muted small">
                                        Distribución de grupos por materia, profesor y semestre.
                                    </p>
                                    <div class="mt-3">
                                        <span class="badge bg-success fs-6">{{ $totalGrupos }}</span>
                                        <small class="text-muted d-block">Grupos activos</small>
                                    </div>
                                    <a href="{{ route('reportes.grupos') }}" class="btn btn-outline-success btn-sm mt-3">
                                        <i class="fas fa-chart-pie me-1"></i>Ver Reporte
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Reporte de Profesores -->
                        <div class="col-md-6 col-lg-3">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <i class="fas fa-chalkboard-teacher fa-3x text-warning"></i>
                                    </div>
                                    <h5 class="card-title text-warning">Reporte de Profesores</h5>
                                    <p class="card-text text-muted small">
                                        Datos del personal docente por área y situación laboral.
                                    </p>
                                    <div class="mt-3">
                                        <span class="badge bg-warning fs-6">{{ $totalProfesores }}</span>
                                        <small class="text-muted d-block">Profesores activos</small>
                                    </div>
                                    <a href="{{ route('reportes.profesores') }}" class="btn btn-outline-warning btn-sm mt-3">
                                        <i class="fas fa-chart-line me-1"></i>Ver Reporte
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Estadísticas Generales -->
                        <div class="col-md-6 col-lg-3">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <i class="fas fa-chart-line fa-3x text-info"></i>
                                    </div>
                                    <h5 class="card-title text-info">Estadísticas Generales</h5>
                                    <p class="card-text text-muted small">
                                        Métricas y KPIs del sistema educativo completo.
                                    </p>
                                    <div class="mt-3">
                                        <span class="badge bg-info fs-6">{{ $totalCarreras }}</span>
                                        <small class="text-muted d-block">Carreras activas</small>
                                    </div>
                                    <a href="{{ route('reportes.estadisticas') }}" class="btn btn-outline-info btn-sm mt-3">
                                        <i class="fas fa-chart-area me-1"></i>Ver Reporte
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gráficos Rápidos -->
                <div class="card-body">
                    <div class="row g-4">
                        <!-- Distribución por Carrera -->
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 text-primary">
                                        <i class="fas fa-university me-2"></i>Distribución de Alumnos por Carrera
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <canvas id="carreraChart" height="250"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Situación Académica -->
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 text-success">
                                        <i class="fas fa-user-check me-2"></i>Situación Académica
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <canvas id="situacionChart" height="250"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Profesores por Área -->
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 text-warning">
                                        <i class="fas fa-sitemap me-2"></i>Profesores por Área
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <canvas id="areaChart" height="250"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Grupos por Semestre -->
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 text-info">
                                        <i class="fas fa-layer-group me-2"></i>Grupos por Semestre
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <canvas id="semestreChart" height="250"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabla de Resumen Rápido -->
                <div class="card-body">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light">
                            <h6 class="mb-0 text-dark">
                                <i class="fas fa-table me-2"></i>Resumen General del Sistema
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle">
                                    <thead class="text-center text-white" style="background-color: #002D72;">
                                        <tr>
                                            <th>Métrica</th>
                                            <th>Total</th>
                                            <th>Vigentes</th>
                                            <th>Inactivos</th>
                                            <th>Porcentaje</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="fw-bold">Alumnos</td>
                                            <td class="text-center">{{ $totalAlumnos }}</td>
                                            <td class="text-center">{{ $alumnosVigentes }}</td>
                                            <td class="text-center">{{ $totalAlumnos - $alumnosVigentes }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-success">
                                                    {{ number_format(($alumnosVigentes / $totalAlumnos) * 100, 1) }}%
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Profesores</td>
                                            <td class="text-center">{{ $totalProfesores }}</td>
                                            <td class="text-center">{{ $profesoresVigentes }}</td>
                                            <td class="text-center">{{ $totalProfesores - $profesoresVigentes }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-success">
                                                    {{ number_format(($profesoresVigentes / $totalProfesores) * 100, 1) }}%
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Grupos</td>
                                            <td class="text-center">{{ $totalGrupos }}</td>
                                            <td class="text-center">{{ $gruposActivos }}</td>
                                            <td class="text-center">{{ $totalGrupos - $gruposActivos }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-success">
                                                    {{ number_format(($gruposActivos / $totalGrupos) * 100, 1) }}%
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Carreras</td>
                                            <td class="text-center">{{ $totalCarreras }}</td>
                                            <td class="text-center">{{ $carrerasActivas }}</td>
                                            <td class="text-center">{{ $totalCarreras - $carrerasActivas }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-success">
                                                    {{ number_format(($carrerasActivas / $totalCarreras) * 100, 1) }}%
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Incluir Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Datos para los gráficos (debes reemplazar con datos reales de tu controlador)
        const carreraData = {
            labels: {!! json_encode($distribucionCarreras->pluck('nombre_carrera')) !!},
            datasets: [{
                data: {!! json_encode($distribucionCarreras->pluck('total')) !!},
                backgroundColor: [
                    '#3498db', '#2ecc71', '#e74c3c', '#f39c12', '#9b59b6',
                    '#1abc9c', '#34495e', '#d35400', '#c0392b', '#16a085'
                ]
            }]
        };

        const situacionData = {
            labels: ['Vigente', 'Baja', 'Egresado'],
            datasets: [{
                data: {!! json_encode([$alumnosVigentes, $alumnosBaja, $alumnosEgresados]) !!},
                backgroundColor: ['#28a745', '#dc3545', '#17a2b8']
            }]
        };

        const areaData = {
            labels: {!! json_encode($distribucionAreas->pluck('area')) !!},
            datasets: [{
                data: {!! json_encode($distribucionAreas->pluck('total')) !!},
                backgroundColor: ['#ffc107', '#20c997', '#fd7e14', '#6f42c1', '#e83e8c']
            }]
        };

        const semestreData = {
            labels: {!! json_encode($distribucionSemestres->pluck('semestre')) !!},
            datasets: [{
                label: 'Grupos por Semestre',
                data: {!! json_encode($distribucionSemestres->pluck('total')) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.8)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };

        // Configuración común para gráficos
        const chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        };

        // Inicializar gráficos
        new Chart(document.getElementById('carreraChart'), {
            type: 'doughnut',
            data: carreraData,
            options: chartOptions
        });

        new Chart(document.getElementById('situacionChart'), {
            type: 'pie',
            data: situacionData,
            options: chartOptions
        });

        new Chart(document.getElementById('areaChart'), {
            type: 'bar',
            data: {
                labels: areaData.labels,
                datasets: [{
                    label: 'Profesores',
                    data: areaData.datasets[0].data,
                    backgroundColor: areaData.datasets[0].backgroundColor
                }]
            },
            options: chartOptions
        });

        new Chart(document.getElementById('semestreChart'), {
            type: 'line',
            data: {
                labels: semestreData.labels,
                datasets: [{
                    label: 'Grupos',
                    data: semestreData.datasets[0].data,
                    backgroundColor: semestreData.datasets[0].backgroundColor,
                    borderColor: semestreData.datasets[0].borderColor,
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: chartOptions
        });
    });
</script>

<style>
    .card {
        transition: transform 0.2s ease-in-out;
    }
    
    .card:hover {
        transform: translateY(-5px);
    }
    
    .badge {
        font-size: 0.9em;
    }
    
    .table th {
        font-weight: 600;
    }
    
    .btn-group-sm > .btn {
        padding: 0.25rem 0.5rem;
    }
</style>
@endsection