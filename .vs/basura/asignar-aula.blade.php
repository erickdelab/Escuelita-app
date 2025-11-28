@extends('layouts.app')

@section('template_title', 'Asignar Aula')

@section('content')
<div class="container">
    <h3 class="mb-4 text-primary">🏫 Asignar Aula al Grupo #{{ $grupo->id_grupo }}</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <p><strong>Horario:</strong> {{ $grupo->patron }} - {{ \Carbon\Carbon::parse($grupo->hora_inicio)->format('h:i A') }}</p>

    <form method="POST" action="{{ route('grupos.aula.store', $grupo->id_grupo) }}">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-bold">Aula disponible</label>
            <select name="aula_id" class="form-select" required>
                <option value="">-- Selecciona un aula --</option>
                @foreach ($aulasDisponibles as $aula)
                    <option value="{{ $aula->id }}">{{ $aula->nombre }} (Cap: {{ $aula->capacidad }})</option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary">Asignar Aula</button>
    </form>

    @if(count($aulasOcupadas))
        <div class="alert alert-warning mt-3">
            <strong>Aulas ocupadas:</strong>
            <ul>
                @foreach ($aulasOcupadas as $aula)
                    <li>{{ $aula->nombre }} (Cap: {{ $aula->capacidad }})</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
@endsection
