<div class="row padding-1 p-1">
    <div class="col-md-12">

        {{-- CAMPO MATERIA (SELECT) --}}
        <div class="form-group mb-2 mb20">
            <label for="cod_materia" class="form-label">{{ __('Materia') }}</label>
            <select name="cod_materia" class="form-select @error('cod_materia') is-invalid @enderror" id="cod_materia">
                <option value="">-- Seleccionar Materia --</option>
                @foreach($materias as $cod_materia => $nombre)
                    <option value="{{ $cod_materia }}" 
                        {{ old('cod_materia', $grupo?->cod_materia) == $cod_materia ? 'selected' : '' }}>
                        {{ $nombre }} ({{ $cod_materia }})
                    </option>
                @endforeach
            </select>
            @error('cod_materia')
                <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
            @enderror
        </div>

        {{-- CAMPO PROFESOR (SELECT) --}}
        <div class="form-group mb-2 mb20">
            <label for="n_trabajador" class="form-label">{{ __('Profesor') }}</label>
            <select name="n_trabajador" class="form-select @error('n_trabajador') is-invalid @enderror" id="n_trabajador">
                <option value="">-- Seleccionar Profesor --</option>
                @foreach($profesores as $n_trabajador => $full_name)
                    <option value="{{ $n_trabajador }}" 
                        {{ old('n_trabajador', $grupo?->n_trabajador) == $n_trabajador ? 'selected' : '' }}>
                        {{ $full_name }} ({{ $n_trabajador }})
                    </option>
                @endforeach
            </select>
            @error('n_trabajador')
                <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
            @enderror
        </div>

        {{-- CAMPO SEMESTRE (SELECT) --}}
        <div class="form-group mb-2 mb20">
            <label for="semestre" class="form-label">{{ __('Semestre') }}</label>
            <select name="semestre" class="form-select @error('semestre') is-invalid @enderror" id="semestre">
                <option value="">-- Seleccionar Semestre --</option>
                @for($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" 
                        {{ old('semestre', $grupo?->semestre) == $i ? 'selected' : '' }}>
                        {{ $i }}
                    </option>
                @endfor
            </select>
            @error('semestre')
                <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
            @enderror
        </div>

        {{-- CAMPO PERIODO (SELECT) --}}
        <div class="form-group mb-2 mb20">
            <label for="periodo_id" class="form-label">{{ __('Periodo') }}</label>
            <select name="periodo_id" class="form-select @error('periodo_id') is-invalid @enderror" id="periodo_id">
                <option value="">-- Seleccionar Periodo --</option>
                @foreach($periodos as $id => $periodo_full)
                    <option value="{{ $id }}" 
                        {{ old('periodo_id', $grupo?->periodo_id) == $id ? 'selected' : '' }}>
                        {{ $periodo_full }}
                    </option>
                @endforeach
            </select>
            @error('periodo_id')
                <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
            @enderror
        </div>

    </div>

    {{-- BOTÓN PRINCIPAL --}}
    
</div>
