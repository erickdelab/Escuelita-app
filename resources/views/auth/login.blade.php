@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #002D72 0%, #0056b3 100%);
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        padding: 20px;
    }

    .login-container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0, 45, 114, 0.3);
        width: 100%;
        max-width: 420px;
        padding: 40px 35px;
        text-align: center;
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .login-container:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 45, 114, 0.4);
    }

    .logo-container {
        margin-bottom: 25px;
        padding: 15px;
        background: linear-gradient(135deg, #002D72 0%, #0056b3 100%);
        border-radius: 15px;
        display: inline-block;
        box-shadow: 0 5px 15px rgba(0, 45, 114, 0.3);
    }

    .logo-container img {
        width: 140px;
        height: auto;
        filter: brightness(0) invert(1);
    }

    .login-title {
        font-weight: 700;
        color: #002D72;
        margin-bottom: 30px;
        font-size: 26px;
        letter-spacing: -0.5px;
        position: relative;
    }

    .login-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: linear-gradient(135deg, #002D72 0%, #0056b3 100%);
        border-radius: 2px;
    }

    .form-group {
        margin-bottom: 25px;
        text-align: left;
    }

    .form-label {
        color: #002D72;
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 8px;
        display: block;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .input-group {
        position: relative;
    }

    .form-control {
        border-radius: 12px;
        padding: 14px 45px 14px 15px;
        font-size: 15px;
        border: 2px solid #e1e8f0;
        background: #f8fafc;
        transition: all 0.3s ease;
        height: 50px;
    }

    .form-control:focus {
        border-color: #002D72;
        background: white;
        box-shadow: 0 0 0 3px rgba(0, 45, 114, 0.1);
        transform: translateY(-2px);
    }

    .input-icon {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #002D72;
        font-size: 18px;
    }

    .btn-login {
        background: linear-gradient(135deg, #002D72 0%, #0056b3 100%);
        border: none;
        border-radius: 12px;
        padding: 15px;
        font-size: 16px;
        width: 100%;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
        margin-top: 10px;
        height: 50px;
        position: relative;
        overflow: hidden;
    }

    .btn-login::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }

    .btn-login:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 45, 114, 0.4);
    }

    .btn-login:hover::before {
        left: 100%;
    }

    .btn-login:active {
        transform: translateY(-1px);
    }

    .footer-links {
        margin-top: 25px;
        padding-top: 20px;
        border-top: 1px solid #e1e8f0;
    }

    .register-link {
        color: #666;
        font-size: 14px;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .register-link a {
        color: #002D72;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        position: relative;
    }

    .register-link a::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 0;
        height: 2px;
        background: #002D72;
        transition: width 0.3s ease;
    }

    .register-link a:hover {
        color: #0056b3;
    }

    .register-link a:hover::after {
        width: 100%;
    }

    .security-notice {
        background: linear-gradient(135deg, #f8fafc 0%, #e1e8f0 100%);
        border-radius: 10px;
        padding: 15px;
        margin-top: 20px;
        border-left: 4px solid #002D72;
    }

    .security-notice p {
        margin: 0;
        font-size: 12px;
        color: #666;
        text-align: center;
    }

    .security-notice i {
        color: #002D72;
        margin-right: 5px;
    }

    /* Animaciones */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .login-container {
        animation: fadeInUp 0.6s ease-out;
    }

    /* Responsive */
    @media (max-width: 480px) {
        .login-container {
            padding: 30px 20px;
            margin: 10px;
        }
        
        .login-title {
            font-size: 22px;
        }
    }
</style>

<div class="login-container">
    <div class="logo-container">
        <img src="{{ asset('images/tecnm-rosa.jpg') }}" alt="TecNM Logo">
    </div>

    <h4 class="login-title">Iniciar Sesión</h4>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label for="email" class="form-label">
                <i class="fas fa-envelope me-2"></i>Correo Institucional
            </label>
            <div class="input-group">
                <input id="email" type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       name="email" value="{{ old('email') }}" required autofocus
                       placeholder="usuario@itp.edu.mx">
                <div class="input-icon">
                    <i class="fas fa-user"></i>
                </div>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="password" class="form-label">
                <i class="fas fa-lock me-2"></i>Contraseña
            </label>
            <div class="input-group">
                <input id="password" type="password"
                       class="form-control @error('password') is-invalid @enderror"
                       name="password" required placeholder="••••••••">
                <div class="input-icon">
                    <i class="fas fa-key"></i>
                </div>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn-login">
            <i class="fas fa-sign-in-alt me-2"></i>Ingresar al Sistema
        </button>

        <div class="footer-links">
            <p class="register-link">
                ¿No tienes una cuenta? 
                <a href="{{ route('register') }}">Regístrate aquí</a>
            </p>
        </div>

        <div class="security-notice">
            <p>
                <i class="fas fa-shield-alt"></i>
                Tu información está protegida con encriptación SSL
            </p>
        </div>
    </form>
</div>

<!-- Font Awesome para iconos -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
    // Efecto de carga suave
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('.form-control');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            input.addEventListener('blur', function() {
                if (this.value === '') {
                    this.parentElement.classList.remove('focused');
                }
            });
        });
    });
</script>
@endsection