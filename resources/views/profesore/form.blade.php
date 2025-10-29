<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        {{-- N TRABAJADOR: Solo se muestra si estamos EDITANDO, ya que el ID se genera automáticamente al CREAR --}}
        @if ($profesore?->n_trabajador)
            <div class="form-group mb-2 mb20">
                <label for="n_trabajador" class="form-label">{{ __('N Trabajador') }}</label>
                <input type="text" 
                       name="n_trabajador" 
                       class="form-control @error('n_trabajador') is-invalid @enderror" 
                       value="{{ old('n_trabajador', $profesore->n_trabajador) }}" 
                       id="n_trabajador" 
                       placeholder="N Trabajador" 
                       readonly> 
                @error('n_trabajador')
                    <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
                @enderror
            </div>
        @endif
        
        {{-- NOMBRES Y APELLIDOS --}}
        <div class="form-group mb-2 mb20">
            <label for="nombre" class="form-label">{{ __('Nombre') }}</label>
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $profesore?->nombre) }}" id="nombre" placeholder="Nombre">
            @error('nombre')
                <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
            @enderror
        </div>
        <div class="form-group mb-2 mb20">
            <label for="s_nombre" class="form-label">{{ __('S Nombre') }}</label>
            <input type="text" name="s_nombre" class="form-control @error('s_nombre') is-invalid @enderror" value="{{ old('s_nombre', $profesore?->s_nombre) }}" id="s_nombre" placeholder="S Nombre">
            @error('s_nombre')
                <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
            @enderror
        </div>
        
        <div class="form-group mb-2 mb20">
            <label for="ap_paterno" class="form-label">{{ __('Ap Paterno') }}</label>
            <input type="text" name="ap_paterno" class="form-control @error('ap_paterno') is-invalid @enderror" value="{{ old('ap_paterno', $profesore?->ap_paterno) }}" id="ap_paterno" placeholder="Ap Paterno">
            @error('ap_paterno')
                <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
            @enderror
        </div>
        <div class="form-group mb-2 mb20">
            <label for="ap_materno" class="form-label">{{ __('Ap Materno') }}</label>
            <input type="text" name="ap_materno" class="form-control @error('ap_materno') is-invalid @enderror" value="{{ old('ap_materno', $profesore?->ap_materno) }}" id="ap_materno" placeholder="Ap Materno">
            @error('ap_materno')
                <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
            @enderror
        </div>
        <div class="form-group mb-2 mb20">
            <label for="correo_institucional" class="form-label">{{ __('Correo Institucional') }}</label>
            <input type="text" name="correo_institucional" class="form-control @error('correo_institucional') is-invalid @enderror" value="{{ old('correo_institucional', $profesore?->correo_institucional) }}" id="correo_institucional" placeholder="Correo Institucional">
            @error('correo_institucional')
                <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
            @enderror
        </div>
        
        {{-- 1. SELECT DE SITUACIÓN (NUEVO CAMPO) --}}
        <div class="form-group mb-2 mb20">
            <label for="situacion" class="form-label">{{ __('Situación') }}</label>
            <select name="situacion" id="situacion" class="form-control @error('situacion') is-invalid @enderror">
                <option value="">Seleccione el estatus...</option>
                @php
                    // Valores del ENUM/VARCHAR de la base de datos
                    $situaciones = [
                        'Vigente' => 'Vigente', 
                        'En Asignación' => 'En Asignación', 
                        'Inactivo/Baja' => 'Inactivo/Baja'
                    ];
                @endphp
                @foreach ($situaciones as $value => $label)
                    <option value="{{ $value }}" {{ old('situacion', $profesore?->situacion) == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            @error('situacion')
                <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
            @enderror
        </div>

        {{-- 2. SELECT DE ÁREA --}}
        <div class="form-group mb-2 mb20">
            <label for="FKcod_area" class="form-label">{{ __('Área') }}</label>
            <select name="FKcod_area" id="FKcod_area" class="form-control @error('FKcod_area') is-invalid @enderror">
                <option value="">Seleccione un área...</option>
                {{-- La variable $areas debe venir del controlador --}}
                @if (isset($areas))
                    @foreach ($areas as $id => $nombre)
                        <option value="{{ $id }}" {{ old('FKcod_area', $profesore?->FKcod_area) == $id ? 'selected' : '' }}>
                            {{ $nombre }}
                        </option>
                    @endforeach
                @endif
            </select>
            @error('FKcod_area')
                <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
            @enderror
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
    </div>
</div>
