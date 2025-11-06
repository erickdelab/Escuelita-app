<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        {{-- CAMPO Código Materia --}}
        @if (!isset($materia->cod_materia))
            {{-- En creación: Campo editable --}}
            <div class="form-group mb-2 mb20">
                <label for="cod_materia" class="form-label">{{ __('Código Materia') }} <span class="text-danger">*</span></label>
                <input type="text" name="cod_materia" class="form-control @error('cod_materia') is-invalid @enderror" value="{{ old('cod_materia', $materia?->cod_materia) }}" id="cod_materia" placeholder="Ej: TICS101, MAT201" required>
                {!! $errors->first('cod_materia', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                <small class="form-text text-muted">Ingrese el código único de la materia</small>
            </div>
        @else
            {{-- En edición: Solo lectura --}}
            <div class="form-group mb-2 mb20">
                <label for="cod_materia" class="form-label">{{ __('Código Materia') }}</label>
                <input type="text" class="form-control bg-light" value="{{ $materia->cod_materia }}" readonly>
                <small class="form-text text-muted">El código de materia no se puede modificar</small>
            </div>
            <input type="hidden" name="cod_materia" value="{{ $materia->cod_materia }}">
        @endif

        {{-- CAMPO Nombre --}}
        <div class="form-group mb-2 mb20">
            <label for="nombre" class="form-label">{{ __('Nombre') }} <span class="text-danger">*</span></label>
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $materia?->nombre) }}" id="nombre" placeholder="Nombre de la materia" required>
            {!! $errors->first('nombre', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        {{-- CAMPO Créditos --}}
        <div class="form-group mb-2 mb20">
            <label for="credito" class="form-label">{{ __('Créditos') }} <span class="text-danger">*</span></label>
            <input type="number" name="credito" class="form-control @error('credito') is-invalid @enderror" value="{{ old('credito', $materia?->credito) }}" id="credito" placeholder="Ej: 4" min="1" max="10" required>
            {!! $errors->first('credito', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        {{-- CAMPO Cadena --}}
        <div class="form-group mb-2 mb20">
            <label for="cadena" class="form-label">{{ __('Cadena') }}</label>
            <input type="number" name="cadena" class="form-control @error('cadena') is-invalid @enderror" value="{{ old('cadena', $materia?->cadena) }}" id="cadena" placeholder="Número de cadena">
            {!! $errors->first('cadena', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        {{-- CAMPO Estado --}}
        <div class="form-group mb-2 mb20">
            <label for="materia_estado" class="form-label">{{ __('Estado') }} <span class="text-danger">*</span></label>
            <select name="materia_estado" class="form-control @error('materia_estado') is-invalid @enderror" id="materia_estado" required>
                <option value="">-- Seleccionar Estado --</option>
                <option value="Activa" {{ old('materia_estado', $materia?->materia_estado) == 'Activa' ? 'selected' : '' }}>Activa</option>
                <option value="Baja" {{ old('materia_estado', $materia?->materia_estado) == 'Baja' ? 'selected' : '' }}>Baja</option>
            </select>
            {!! $errors->first('materia_estado', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
    </div>
</div>