@extends('layouts.app')

@section('content')
<style>
    body {
        background: #002D72; /* Azul rey */
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: 'Segoe UI', sans-serif;
    }

    .login-container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.2);
        width: 380px;
        padding: 35px 30px;
        text-align: center;
    }

    .login-container img {
        width: 120px;
        margin-bottom: 15px;
    }

    .login-container h4 {
        font-weight: bold;
        color: #002D72;
        margin-bottom: 25px;
        font-size: 22px;
    }

    .form-label {
        color: #002D72;
        font-weight: 600;
        text-align: left;
        display: block;
        margin-bottom: 5px;
    }

    .form-control {
        border-radius: 10px;
        padding: 10px 15px;
        font-size: 15px;
        border: 2px solid #002D72;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #001f52;
        box-shadow: 0 0 5px rgba(0, 45, 114, 0.4);
    }

    .btn-primary {
        background-color: #002D72;
        border: none;
        border-radius: 10px;
        padding: 10px;
        font-size: 16px;
        width: 100%;
        font-weight: bold;
        color: white;
        transition: 0.3s;
        margin-top: 10px;
    }

    .btn-primary:hover {
        background-color: #001f52;
        transform: scale(1.02);
    }

    .footer-text {
        margin-top: 15px;
        color: #555;
        font-size: 13px;
    }
</style>

<div class="login-container">
    {{-- Si descargaste el logo en public/images --}}
    <img src="{{ asset('images/tecnm-rosa.jpg') }}" alt="">
    {{-- O usar directamente la URL externa --}}
    {{-- <img src="https://www.tecnm.mx/assets/files/main/img/pleca_tecnm_rosa.jpg?img=33" alt="Logo TecNM Rosa"> --}}

    <h4>Iniciar Sesión</h4>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3 text-start">
            <label for="email" class="form-label">Correo Institucional</label>
            <input id="email" type="email"
                   class="form-control @error('email') is-invalid @enderror"
                   name="email" value="{{ old('email') }}" required autofocus
                   placeholder="Tu correo institucional">

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3 text-start">
            <label for="password" class="form-label">Contraseña</label>
            <input id="password" type="password"
                   class="form-control @error('password') is-invalid @enderror"
                   name="password" required placeholder="••••••••">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Ingresar</button>

        <p class="footer-text">
            ¿No tienes una cuenta?
            <a href="{{ route('register') }}">Regístrate aquí</a>
        </p>
    </form>
</div>
@endsection
g