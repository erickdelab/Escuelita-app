@extends('layouts.app') {{-- (O tu layout principal) --}}

@section('content')
<div classclass="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Asignar Nuevo Horario</div>
                <div class="card-body">

                    <form action="{{ route('horarios.store') }}" method="POST">
                        @csrf

                        {{-- ===== MOSTRAR ERRORES DE COLISIÓN ===== --}}
                        @if($errors->has('error_horario'))
                            <div class="alert alert-danger">
                                <strong>Error de Colisión:</strong>
                                {{ $errors->first('error_horario') }}
                            </div>
                        @endif

                        {{-- ===== MOSTRAR MENSAJE DE ÉXITO ===== --}}
                        @if(session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{-- ===== 1. GRUPO ===== --}}
                        <div class="mb-3">
                            <label for="grupo_id" class="form-label">Grupo:</label>
                            <select name="grupo_id" id="grupo_id" 
                                    class="form-select @error('grupo_id') is-invalid @enderror">
                                <option value="">-- Seleccione un grupo --</option>
                                @foreach($grupos as $id => $nombre)
                                    <option value="{{ $id }}" {{ old('grupo_id') == $id ? 'selected' : '' }}>
                                        {{ $nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('grupo_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- ===== 2. MATERIA ===== --}}
                        <div class="mb-3">
                            <label for="materia_id" class="form-label">Materia:</label>
                            <select name="materia_id" id="materia_id" 
                                    class="form-select @error('materia_id') is-invalid @enderror">
                                <option value="">-- Seleccione una materia --</option>
                                @foreach($materias as $id => $nombre)
                                    <option value="{{ $id }}" {{ old('materia_id') == $id ? 'selected' : '' }}>
                                        {{ $nombre }} ({{ $id }})
                                    </option>
                                @endforeach
                            </select>
                            @error('materia_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- ===== 3. PROFESOR ===== --}}
                        <div class="mb-3">
                            <label for="profesore_id" class="form-label">Profesor:</label>
                            <select name="profesore_id" id="profesore_id" 
                                    class="form-select @error('profesore_id') is-invalid @enderror">
                                <option value="">-- Seleccione un profesor --</option>
                                @foreach($profesores as $id => $nombre)
                                    <option value="{{ $id }}" {{ old('profesore_id') == $id ? 'selected' : '' }}>
                                        {{ $nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('profesore_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- ===== 4. AULA ===== --}}
                        <div class="mb-3">
                            <label for="aula_id" class="form-label">Aula:</label>
                            <select name="aula_id" id="aula_id" 
                                    class="form-select @error('aula_id') is-invalid @enderror">
                                <option value="">-- Seleccione un aula --</option>
                                @foreach($aulas as $id => $nombre)
                                    <option value="{{ $id }}" {{ old('aula_id') == $id ? 'selected' : '' }}>
                                        {{ $nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('aula_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

                        {{-- ===== 5. PATRÓN DE DÍAS ===== --}}
                        <div class="mb-3">
                            <label for="patron" class="form-label">Patrón de Días:</label>
                            <select name="patron" id="patron" 
                                    class="form-select @error('patron') is-invalid @enderror">
                                <option value="">-- Seleccione un patrón --</option>
                                <option value="L-M" {{ old('patron') == 'L-M' ? 'selected' : '' }}>
                                    Lunes y Miércoles (p/ 4 o 5 créditos)
                                </option>
                                <option value="M-J" {{ old('patron') == 'M-J' ? 'selected' : '' }}>
                                    Martes y Jueves (p/ 4 o 5 créditos)
                                </option>
                            </select>
                            @error('patron')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- ===== 6. HORA DE INICIO (BLOQUE) ===== --}}
                        <div class="mb-3">
                            <label for="hora_inicio" class="form-label">Hora de Inicio (Bloque):</label>
                            <select name="hora_inicio" id="hora_inicio" 
                                    class="form-select @error('hora_inicio') is-invalid @enderror">
                                <option value="">-- Seleccione un bloque --</option>
                                @foreach($allowedStartTimes as $time)
                                    <option value="{{ $time }}" {{ old('hora_inicio') == $time ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::parse($time)->format('h:i A') }}
                                    </option>
                                @endforeach
                            </select>
                            @error('hora_inicio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- ===== SUBMIT ===== --}}
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Asignar Horario</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection