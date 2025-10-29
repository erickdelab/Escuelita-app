<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        {{-- CAMPO 1: ID CARRERA (Solo se muestra en edición) --}}
        @if ($carrera->id_carrera)
            <div class="form-group mb-2 mb20">
                <label for="id_carrera" class="form-label">{{ __('ID Carrera') }}</label>
                <input type="text" 
                       name="id_carrera" 
                       class="form-control @error('id_carrera') is-invalid @enderror" 
                       value="{{ old('id_carrera', $carrera->id_carrera) }}" 
                       id="id_carrera" 
                       placeholder="ID Carrera"
                       readonly> 
                @error('id_carrera')
                    <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
                @enderror
            </div>
        @endif

        {{-- CAMPO 2: Nombre de Carrera --}}
        <div class="form-group mb-2 mb20">
            <label for="nombre_carrera" class="form-label">{{ __('Nombre de Carrera') }}</label>
            <input type="text" name="nombre_carrera" class="form-control @error('nombre_carrera') is-invalid @enderror" value="{{ old('nombre_carrera', $carrera?->nombre_carrera) }}" id="nombre_carrera" placeholder="Nombre de Carrera">
            @error('nombre_carrera')
                <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
            @enderror
        </div>

        {{-- CAMPO 3: NÚMERO DE EDIFICIO (Revertido a un solo campo) --}}
        <div class="form-group mb-2 mb20">
            <label for="num_edif" class="form-label">{{ __('Número de Edificio') }}</label>
            <input type="text" 
                   name="num_edif" 
                   class="form-control @error('num_edif') is-invalid @enderror" 
                   value="{{ old('num_edif', $carrera?->num_edif) }}" 
                   id="num_edif" 
                   placeholder="Ej: 36, 209, etc.">
            @error('num_edif')
                <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
            @enderror
        </div>

        {{-- CAMPO 4: Capacidad --}}
        <div class="form-group mb-2 mb20">
            <label for="capacidad" class="form-label">{{ __('Capacidad') }}</label>
            <input type="text" name="capacidad" class="form-control @error('capacidad') is-invalid @enderror" value="{{ old('capacidad', $carrera?->capacidad) }}" id="capacidad" placeholder="Capacidad">
            @error('capacidad')
                <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
            @enderror
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
    </div>
</div>
