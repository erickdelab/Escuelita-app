<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Título Corregido: Usa la sección 'template_title' y como fallback el nombre de la app -->
    <title>@yield('template_title') | {{ config('app.name', 'TecNM') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Scripts (Vite) -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        /* Body */
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }

        /* Navbar */
        .navbar {
            background-color: #002D72 !important; /* Azul rey */
        }
        .navbar-brand, .nav-link {
            color: white !important;
            font-weight: 600;
        }
        .navbar-brand img {
            height: 40px;
            margin-right: 8px;
        }
        .navbar-brand:hover, .nav-link:hover {
            color: #a8c8ff !important;
        }

        /* Dropdown */
        .dropdown-item.text-primary {
            color: #002D72 !important;
            font-weight: 500;
        }
        .dropdown-item.text-primary:hover {
            color: #001f52 !important;
            background-color: #e6f0ff !important;
        }

        /* Botones */
        .btn-primary {
            background-color: #002D72;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-primary:hover {
            background-color: #001f52;
            transform: scale(1.02);
        }

        /* Cards */
        .card {
            border: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
        }
        .card-header {
            background-color: #002D72;
            color: white;
            font-weight: bold;
            border-radius: 12px 12px 0 0;
        }

        /* Tables */
        table th {
            background-color: #002D72 !important;
            color: white !important;
            text-align: center;
        }
        table td {
            text-align: center;
            vertical-align: middle;
        }

        /* Links */
        a {
            color: #002D72;
        }
        a:hover {
            color: #0055cc;
            text-decoration: none;
        }

        /* Navbar items con iconos */
        .nav-item .nav-link {
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }
        
        .nav-item .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        /* Dropdown menus */
        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .dropdown-header {
            color: #002D72;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .dropdown-divider {
            margin: 0.3rem 0;
        }
    </style>
</head>
<body>
    <div id="app">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-md navbar-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/home') }}">
                    <img src="{{ asset('https://www.tecnm.mx/images/tecnm_virtual/tecnm.png') }}" alt="Logo">
                    Instituto Tecnológico De Puebla
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Menú de Navegación -->
                    <ul class="navbar-nav me-auto">
                        @auth
                        <!-- Gestión Académica -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-book-open me-1"></i>Académico
                            </a>
                            <ul class="dropdown-menu">
                                <li><span class="dropdown-header">Gestión Académica</span></li>
                                <li><a class="dropdown-item text-primary" href="{{ url('/materias') }}">
                                    <i class="bi bi-journal-text me-2"></i>Materias
                                </a></li>
                                <li><a class="dropdown-item text-primary" href="{{ url('/carreras') }}">
                                    <i class="bi bi-mortarboard me-2"></i>Carreras
                                </a></li>
                                <li><a class="dropdown-item text-primary" href="{{ url('/periodos') }}">
                                    <i class="bi bi-calendar-event me-2"></i>Períodos
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-primary" href="{{ url('/grupos') }}">
                                    <i class="bi bi-collection me-2"></i>Grupos
                                </a></li>
                            </ul>
                        </li>

                        <!-- Gestión de Personal -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-people me-1"></i>Personal
                            </a>
                            <ul class="dropdown-menu">
                                <li><span class="dropdown-header">Gestión de Personal</span></li>
                                <li><a class="dropdown-item text-primary" href="{{ url('/profesores') }}">
                                    <i class="bi bi-person-badge me-2"></i>Profesores
                                </a></li>
                                <li><a class="dropdown-item text-primary" href="{{ url('/areas') }}">
                                    <i class="bi bi-building me-2"></i>Áreas
                                </a></li>
                            </ul>
                        </li>

                        <!-- Gestión Estudiantil -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-standing me-1"></i>Estudiantes
                            </a>
                            <ul class="dropdown-menu">
                                <li><span class="dropdown-header">Gestión Estudiantil</span></li>
                                <li><a class="dropdown-item text-primary" href="{{ url('/alumnos') }}">
                                    <i class="bi bi-people me-2"></i>Alumnos
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-primary" href="{{ url('/historials') }}">
                                    <i class="bi bi-clock-history me-2"></i>Historial Académico
                                </a></li>
                            </ul>
                        </li>

                        <!-- Reportes -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-graph-up me-1"></i>Reportes
                            </a>
                            <ul class="dropdown-menu">
                                <li><span class="dropdown-header">Reportes y Análisis</span></li>
                                <li><a class="dropdown-item text-primary" href="{{ url('/reportes') }}">
                                    <i class="bi bi-bar-chart me-2"></i>Reportes Generales
                                </a></li>
                            </ul>
                        </li>

                        <!-- Administración -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-gear me-1"></i>Sistema
                            </a>
                            <ul class="dropdown-menu">
                                <li><span class="dropdown-header">Administración</span></li>
                                <li><a class="dropdown-item text-primary" href="{{ url('/tablas') }}">
                                    <i class="bi bi-table me-2"></i>Tablas del Sistema
                                </a></li>
                            </ul>
                        </li>
                        @endauth
                    </ul>

                    <!-- Menú de Usuario -->
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Ingresar</a></li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Registrarse</a></li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <span class="dropdown-header">Sesión de Usuario</span>
                                    <a class="dropdown-item text-primary" 
                                         href="{{ route('logout') }}"
                                         onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                         <i class="bi bi-box-arrow-right me-1"></i> Cerrar sesión
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="py-4 container">
            @yield('content')
        </main>
    </div>
</body>
</html>