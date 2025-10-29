<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="n_control" class="form-label">{{ __('Número de Control') }}</label>
            <input type="text" name="n_control" class="form-control @error('n_control') is-invalid @enderror" value="{{ old('n_control', $alumno?->n_control) }}" id="n_control" placeholder="Número de Control">
            @error('n_control')
                <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
            @enderror
        </div>
        
        <div class="form-group mb-2 mb20">
            <label for="nombre" class="form-label">{{ __('Primer Nombre') }}</label>
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $alumno?->nombre) }}" id="nombre" placeholder="Primer Nombre">
            @error('nombre')
                <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
            @enderror
        </div>
        
        <div class="form-group mb-2 mb20">
            <label for="s_nombre" class="form-label">{{ __('Segundo Nombre (Opcional)') }}</label>
            <input type="text" name="s_nombre" class="form-control @error('s_nombre') is-invalid @enderror" value="{{ old('s_nombre', $alumno?->s_nombre) }}" id="s_nombre" placeholder="Segundo Nombre">
            @error('s_nombre')
                <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
            @enderror
        </div>
        
        <div class="form-group mb-2 mb20">
            <label for="ap_pat" class="form-label">{{ __('Apellido Paterno') }}</label>
            <input type="text" name="ap_pat" class="form-control @error('ap_pat') is-invalid @enderror" value="{{ old('ap_pat', $alumno?->ap_pat) }}" id="ap_pat" placeholder="Apellido Paterno">
            @error('ap_pat')
                <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
            @enderror
        </div>
        
        <div class="form-group mb-2 mb20">
            <label for="ap_mat" class="form-label">{{ __('Apellido Materno') }}</label>
            <input type="text" name="ap_mat" class="form-control @error('ap_mat') is-invalid @enderror" value="{{ old('ap_mat', $alumno?->ap_mat) }}" id="ap_mat" placeholder="Apellido Materno">
            @error('ap_mat')
                <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
            @enderror
        </div>
        
        <div class="form-group mb-2 mb20">
            <label for="fech_nac" class="form-label">{{ __('Fecha de Nacimiento') }}</label>
            <input type="date" 
                   name="fech_nac" 
                   class="form-control @error('fech_nac') is-invalid @enderror" 
                   value="{{ old('fech_nac', $alumno?->fech_nac) }}" 
                   id="fech_nac" 
                   placeholder="YYYY-MM-DD">
            @error('fech_nac')
                <div class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
            @enderror
        </div>

        <div class="form-group mb-2 mb20">
            <label for="genero" class="form-label">{{ __('Género') }}</label>
            <select name="genero" id="genero" class="form-control @error('genero') is-invalid @enderror">
                <option value="">Seleccione...</option>
                @php
                    $generos = ['M' => 'Masculino', 'F' => 'Femenino'];
                @endphp
                @foreach ($generos as $value => $label)
                    <option value="{{ $value }}" {{ old('genero', $alumno?->genero) == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            @error('genero')
                <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
            @enderror
        </div>
        
        <div class="form-group mb-2 mb20">
            <label for="FKid_carrera" class="form-label">{{ __('Carrera') }}</label>
            <select name="FKid_carrera" id="FKid_carrera" class="form-control @error('FKid_carrera') is-invalid @enderror">
                <option value="">Seleccione una carrera...</option>
                @foreach ($carreras as $id => $nombre)
                    <option value="{{ $id }}" {{ old('FKid_carrera', $alumno?->FKid_carrera) == $id ? 'selected' : '' }}>
                        {{ $nombre }}
                    </option>
                @endforeach
            </select>
            @error('FKid_carrera')
                <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
            @enderror
        </div>
        
        <div class="form-group mb-2 mb20">
            <label for="situacion" class="form-label">{{ __('Situación') }}</label>
            <select name="situacion" id="situacion" class="form-control @error('situacion') is-invalid @enderror">
                <option value="">Seleccione la situación...</option>
                @php
                    $situaciones = ['Vigente' => 'Vigente', 'Baja' => 'Baja', 'Egresado' => 'Egresado'];
                @endphp
                @foreach ($situaciones as $value => $label)
                    <option value="{{ $value }}" {{ old('situacion', $alumno?->situacion) == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            @error('situacion')
                <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
            @enderror
        </div>
        
        <div class="form-group mb-2 mb20">
            <label for="semestre" class="form-label">{{ __('Semestre') }}</label>
            <input type="number" name="semestre" class="form-control @error('semestre') is-invalid @enderror" value="{{ old('semestre', $alumno?->semestre) }}" id="semestre" placeholder="Semestre">
            @error('semestre')
                <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
            @enderror
        </div>

        <!-- ✅ NUEVO CAMPO: Promedio General -->
        <div class="form-group mb-2 mb20">
            <label for="promedio_general" class="form-label">{{ __('Promedio General (%)') }}</label>
            <input type="number" 
                   name="promedio_general" 
                   class="form-control @error('promedio_general') is-invalid @enderror" 
                   value="{{ old('promedio_general', $alumno?->promedio_general) }}" 
                   id="promedio_general" 
                   placeholder="0.00 - 100.00"
                   step="0.01"
                   min="0"
                   max="100">
            @error('promedio_general')
                <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
            @enderror
            <small class="form-text text-muted">
                Ingrese el promedio general como porcentaje (0.00 a 100.00)
            </small>
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
    </div>
</div>