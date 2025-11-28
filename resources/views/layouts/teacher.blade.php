<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Portal Docente | {{ config('app.name', 'TecNM') }}</title>

    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', system-ui, sans-serif;
            overflow-x: hidden;
        }

        /* NAVBAR SUPERIOR */
        .top-navbar {
            background-color: #0d2149; /* Azul más oscuro para diferenciar de Alumno */
            color: white;
            height: 60px;
            display: flex;
            align-items: center;
            padding: 0 20px;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1030;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        /* SIDEBAR */
        .sidebar {
            position: fixed;
            top: 60px;
            left: 0;
            height: 100vh;
            width: 260px;
            background-color: #ffffff;
            border-right: 1px solid #e0e0e0;
            padding-top: 15px;
            z-index: 1020;
            overflow-y: auto;
        }

        .sidebar .nav-link {
            color: #555;
            font-weight: 500;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            transition: all 0.2s;
            border-left: 4px solid transparent;
        }

        .sidebar .nav-link:hover {
            background-color: #f8f9fa;
            color: #0d2149;
        }

        .sidebar .nav-link.active {
            background-color: #eef2f7;
            color: #0d2149;
            border-left-color: #0d2149;
            font-weight: 600;
        }

        .sidebar .nav-link i {
            margin-right: 12px;
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        /* CONTENIDO PRINCIPAL */
        .main-content {
            margin-left: 260px;
            margin-top: 60px;
            padding: 30px;
            min-height: calc(100vh - 60px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); transition: transform 0.3s ease; }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }
    </style>
</head>
<body>

    <nav class="top-navbar justify-content-between">
        <div class="d-flex align-items-center">
            <button class="btn text-white d-md-none me-2" onclick="document.querySelector('.sidebar').classList.toggle('show')">
                <i class="bi bi-list fs-4"></i>
            </button>
            <div class="d-flex align-items-center">
                <img src="{{ asset('https://www.tecnm.mx/images/tecnm_virtual/tecnm.png') }}" height="35" class="me-2 bg-white rounded p-1">
                <div class="d-none d-sm-block lh-1">
                    <div class="small opacity-75">TECNOLÓGICO NACIONAL DE MÉXICO</div>
                    <div class="fw-bold">Portal Docente</div>
                </div>
            </div>
        </div>
        
        <div class="d-flex align-items-center gap-3">
            <span class="d-none d-md-block text-white small text-uppercase">
                {{ auth()->user()->profesorData->area->area ?? 'Docente' }}
            </span>

            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                    <div class="bg-white text-dark rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                        <i class="bi bi-person-fill"></i>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li><h6 class="dropdown-header">Sesión</h6></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('password.change.form') }}">
                            <i class="bi bi-key me-2"></i>Cambiar Contraseña
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="sidebar">
        <nav class="nav flex-column">
            <div class="px-3 py-2 text-muted small text-uppercase fw-bold">Menú Docente</div>
            
            <a href="{{ route('teacher.dashboard') }}" class="nav-link {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Inicio
            </a>
            
            <a href="{{ route('teacher.horario') }}" class="nav-link {{ request()->routeIs('teacher.horario') ? 'active' : '' }}">
                <i class="bi bi-calendar-week"></i> Mi Horario
            </a>
            
            <a href="{{ route('teacher.grupos') }}" class="nav-link {{ request()->routeIs('teacher.grupos') || request()->routeIs('teacher.grupos.show') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i> Mis Grupos
            </a>
        </nav>
    </div>

    <div class="main-content">
        @yield('content')
    </div>

</body>
</html>