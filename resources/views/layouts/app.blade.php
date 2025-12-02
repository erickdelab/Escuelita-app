<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('template_title') | {{ config('app.name', 'TecNM') }}</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .navbar {
            background-color: #002D72 !important;
        }
        .navbar-brand, .nav-link {
            color: white !important;
            font-weight: 600;
        }
        .navbar-brand img {
            height: 40px;
            margin-right: 8px;
        }
        
        .nav-link:hover {
            color: #d1e7dd !important;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #002D72;
            border-radius: 8px;
            border: none;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-primary:hover {
            background-color: #001f52;
            transform: scale(1.02);
        }

        .card { border: none; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .card-header { background-color: #002D72; color: white; font-weight: bold; border-radius: 12px 12px 0 0 !important; }

        table th { background-color: #002D72 !important; color: white !important; text-align: center; }
        table td { text-align: center; vertical-align: middle; }
        
        .dropdown-menu {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            border-radius: 0.5rem;
        }
        .dropdown-item {
            padding: 0.5rem 1.5rem;
            font-weight: 500;
        }
        .dropdown-item:hover {
            background-color: #e9ecef;
            color: #002D72;
        }
        .dropdown-header {
            color: #6c757d;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 700;
        }
    </style>
</head>
<body>
    <div id="app">

        <!-- NAVBAR -->
        <nav class="navbar navbar-expand-md navbar-dark shadow-sm">
            <div class="container">

                <!-- LOGO -->
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/home') }}">
                    <img src="{{ asset('https://www.tecnm.mx/images/tecnm_virtual/tecnm.png') }}" alt="Logo">
                    Instituto Tecnológico de Puebla
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- NAVBAR CONTENT -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <!-- LEFT SIDE -->
                    <ul class="navbar-nav me-auto">
                        @auth

                            {{-- SOLO ADMIN --}}
                            @role('admin')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                    <i class="bi bi-book-open me-1"></i>Académico
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-header">Gestión Académica</li>
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
                                    <li><a class="dropdown-item text-primary" href="{{ url('/aulas') }}">
                                        <i class="bi bi-building me-2"></i>Aulas
                                    </a></li>
                                    
                                    <li><hr class="dropdown-divider"></li>
                                    <li class="dropdown-header">Sistema</li>
                                    <li><a class="dropdown-item text-primary" href="{{ url('/tablas') }}">
                                        <i class="bi bi-database me-2"></i>Base de Datos
                                    </a></li>
                                </ul>
                            </li>
                            
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                    <i class="bi bi-people me-1"></i>Personal
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-header">Gestión de Personal</li>
                                    <li><a class="dropdown-item text-primary" href="{{ url('/profesores') }}">
                                        <i class="bi bi-person-badge me-2"></i>Profesores
                                    </a></li>
                                    <li><a class="dropdown-item text-primary" href="{{ url('/areas') }}">
                                        <i class="bi bi-building me-2"></i>Áreas
                                    </a></li>
                                    <li><a class="dropdown-item text-primary" href="{{ url('/alumnos') }}">
                                        <i class="bi bi-person-video3 me-2"></i>Alumnos (Admin)
                                    </a></li>
                                </ul>
                            </li>
                            @endrole

                            {{-- ADMIN + PROFESOR --}}
                            @hasanyrole('admin|profesor')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/grupos') }}">
                                        <i class="bi bi-people-fill me-1"></i>Mis Grupos
                                    </a>
                                </li>
                            @endhasanyrole

                            {{-- ESTUDIANTE --}}
                            @role('alumno')
                                {{-- ✅ AGREGADO: Solo mostrar si el usuario tiene n_control vinculado --}}
                                @if(Auth::user()->n_control_link) 
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('alumnos.calificaciones', Auth::user()->n_control_link) }}">
                                            <i class="bi bi-clipboard-data me-1"></i>Mis Calificaciones
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('alumnos.horario', Auth::user()->n_control_link) }}">
                                            <i class="bi bi-calendar-week me-1"></i>Mi Horario
                                        </a>
                                    </li>
                                @endif
                            @endrole

                        @endauth
                    </ul>

                    <!-- RIGHT SIDE -->
                    <ul class="navbar-nav ms-auto">

                        @guest
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                    <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li class="dropdown-header">Sesión</li>

                                    <li>
                                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="bi bi-box-arrow-right me-1"></i>Salir
                                        </a>
                                    </li>

                                    <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">
                                        @csrf
                                    </form>
                                </ul>
                            </li>
                        @endguest

                    </ul>
                </div>
            </div>
        </nav>

        <!-- MAIN -->
        <main class="py-4 container">
            @yield('content')
        </main>

    </div>
</body>
</html>
