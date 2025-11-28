@extends('layouts.app')

@section('template_title', 'Asignar Hora')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-primary mb-0">
            🕒 Asignar Horario al Grupo #{{ $grupo->id_grupo }}
        </h3>
        <a href="{{ route('grupos.index') }}" class="btn btn-outline-secondary btn-sm">← Regresar</a>
    </div>

    {{-- Mensajes --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('grupos.hora.store', $grupo->id_grupo) }}">
        @csrf

        {{-- PATRÓN --}}
        <div class="mb-3">
            <label class="form-label fw-bold">Patrón</label>
            <select name="patron" class="form-select @error('patron') is-invalid @enderror" required>
                <option value="">-- Selecciona un patrón --</option>
                <option value="L-M" {{ old('patron') === 'L-M' ? 'selected' : '' }}>Lunes y Miércoles</option>
                <option value="M-J" {{ old('patron') === 'M-J' ? 'selected' : '' }}>Martes y Jueves</option>
            </select>
            @error('patron')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        {{-- HORA DE INICIO (GRID) --}}
        <div class="mb-3">
            <label class="form-label fw-bold">Selecciona la hora de inicio</label>

            <div class="horario-grid d-flex flex-wrap">
                @foreach($allowedStartTimes as $hora)
                    @php
                        $ocupado = in_array($hora, $horasOcupadasDelProfesor);
                        $clase = $ocupado ? 'btn-secondary disabled' : 'btn-outline-success';

                        // Mantener seleccionado si el usuario regresó por validación
                        if (old('hora_inicio') === $hora && ! $ocupado) {
                            $clase = 'btn-success';
                        }
                    @endphp
                    
                    <button type="button" 
                            class="btn {{ $clase }} m-1 block-selector" 
                            data-hora="{{ $hora }}"
                            @if(!$ocupado) onclick="selectBlock(this)" @endif>
                        {{ \Carbon\Carbon::parse($hora)->format('H:i') }}
                        @if($ocupado) <small>(Ocupado)</small> @endif
                    </button>
                @endforeach
            </div>

            {{-- Input oculto --}}
            <input type="hidden" name="hora_inicio" id="hora_inicio_input" value="{{ old('hora_inicio') }}">

            @error('hora_inicio')
                <span class="text-danger small">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary px-4">Guardar y continuar</button>

    </form>
</div>

{{-- SCRIPT --}}
<script>
function selectBlock(btn) {
    // Limpiar selección previa
    document.querySelectorAll('.block-selector').forEach(b => {
        if(!b.classList.contains('disabled')) {
            b.classList.remove('btn-success');
            b.classList.add('btn-outline-success');
        }
    });

    // Seleccionar el botón elegido
    btn.classList.remove('btn-outline-success');
    btn.classList.add('btn-success');

    // Guardar la hora seleccionada
    document.getElementById('hora_inicio_input').value = btn.getAttribute('data-hora');

    // Aquí puedes activar lógica extra si la tienes
    // fetchAulasDisponibles(); 
}
</script>

@endsection
