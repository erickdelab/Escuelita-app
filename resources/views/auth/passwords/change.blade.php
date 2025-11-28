@extends('layouts.student')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header text-white fw-bold" style="background-color: #1B396A;">
                    <i class="bi bi-shield-lock me-2"></i> Cambiar Contraseña
                </div>
                <div class="card-body p-4">
                    
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.change.update') }}">
                        @csrf

                        {{-- Contraseña Actual --}}
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Contraseña Actual</label>
                            <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" required>
                            @error('current_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <hr>

                        {{-- Nueva Contraseña --}}
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Nueva Contraseña</label>
                            <input id="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" required>
                            @error('new_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Confirmar Nueva --}}
                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                            <input id="new_password_confirmation" type="password" class="form-control" name="new_password_confirmation" required>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary" style="background-color: #1B396A; border: none;">
                                Actualizar Contraseña
                            </button>
                        </div>
                        
                        <div class="text-center mt-3">
                            <a href="{{ route('student.dashboard') }}" class="text-decoration-none text-muted small">Cancelar y volver</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection