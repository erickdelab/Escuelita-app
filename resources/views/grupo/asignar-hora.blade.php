@extends('layouts.app')

@section('template_title', 'Asignar Hora')

@section('content')
<div class="container">
    <h3 class="mb-4 text-primary">🕒 Asignar Horario al Grupo #{{ $grupo->id_grupo }}</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('grupos.hora.store', $grupo->id_grupo) }}">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-bold">Patrón</label>
            <select name="patron" class="form-select" required>
                <option value="">-- Selecciona un patrón --</option>
                <option value="L-M">Lunes y Miércoles</option>
                <option value="M-J">Martes y Jueves</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Hora de inicio</label>
            <select name="hora_inicio" class="form-select" required>
                <option value="">-- Selecciona una hora --</option>
                @foreach ($allowedStartTimes as $hora)
                    <option value="{{ $hora }}">{{ \Carbon\Carbon::parse($hora)->format('h:i A') }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Guardar y continuar</button>
    </form>
</div>
@endsection
