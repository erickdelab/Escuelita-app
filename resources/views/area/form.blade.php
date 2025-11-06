<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        {{-- CAMPO 1: Código de Área - Solo se muestra como INFORMACIÓN en edición --}}
        @if (isset($area->cod_area))
            {{-- En edición, mostramos el código como texto informativo --}}
            <div class="form-group mb-2 mb20">
                <label class="form-label">{{ __('Código de Área') }}</label>
                <input type="text" 
                       class="form-control bg-light" 
                       value="{{ $area->cod_area }}" 
                       readonly>
                <small class="form-text text-muted">El código del área es generado automáticamente</small>
            </div>
            {{-- Campo oculto para mantener el código en el formulario --}}
            <input type="hidden" name="cod_area" value="{{ $area->cod_area }}">
        @else
            {{-- En creación: NO mostramos ningún campo para cod_area --}}
            {{-- El código se generará automáticamente en la base de datos --}}
            <div class="alert alert-info">
                <small>El código del área será generado automáticamente al guardar.</small>
            </div>
        @endif
        
        {{-- CAMPO 2: Nombre del Área --}}
        <div class="form-group mb-2 mb20">
            <label for="area" class="form-label">{{ __('Nombre del Área') }} <span class="text-danger">*</span></label>
            <input type="text" 
                   name="area" 
                   class="form-control @error('area') is-invalid @enderror" 
                   value="{{ old('area', $area?->area) }}" 
                   id="area" 
                   placeholder="Ingrese el nombre del área"
                   required>
            @error('area')
                <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
            @enderror
        </div>
        
        {{-- CAMPO 3: Jefe de Área (SELECT con todos los profesores disponibles) --}}
        <div class="form-group mb-2 mb20">
            <label for="jefe_area" class="form-label">{{ __('Jefe de Área') }}</label>
            <select name="jefe_area" id="jefe_area" class="form-control @error('jefe_area') is-invalid @enderror">
                <option value="">-- Sin asignar --</option>
                
                {{-- Usamos $profesores que viene del controlador --}}
                @foreach ($profesores as $n_trabajador => $fullName)
                    <option value="{{ $n_trabajador }}" 
                        {{ old('jefe_area', $area?->jefe_area) == $n_trabajador ? 'selected' : '' }}>
                        {{ $fullName }} ({{ $n_trabajador }})
                    </option>
                @endforeach
            </select>
            @error('jefe_area')
                <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
            @enderror
            <small class="form-text text-muted">
                Solo se muestran profesores que no son jefes de otras áreas
            </small>
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
    </div>
</div>