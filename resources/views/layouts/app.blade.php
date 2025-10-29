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
            color: #660700ec !important; /* Azul rey */
            font-weight: bold;
        }
        .dropdown-item.text-primary:hover {
            color: #0055cc !important; /* Azul más claro al pasar cursor */
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
            box-shadow: 0 4px 10px rgba(255, 0, 0, 0.1);
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
            color: white !important; /* CORRECCIÓN: Texto blanco para los títulos de columna */
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

        /* Mejoras para iconos de ordenamiento */
        .table th a:hover {
            text-decoration: underline !important;
        }
        .table th i {
            font-size: 0.8em;
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
                    <ul class="navbar-nav me-auto"></ul>

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