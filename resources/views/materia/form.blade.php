<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="cod_materia" class="form-label">{{ __('Cod Materia') }}</label>
            <input type="text" name="cod_materia" class="form-control @error('cod_materia') is-invalid @enderror" value="{{ old('cod_materia', $materia?->cod_materia) }}" id="cod_materia" placeholder="Cod Materia">
            {!! $errors->first('cod_materia', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="nombre" class="form-label">{{ __('Nombre') }}</label>
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $materia?->nombre) }}" id="nombre" placeholder="Nombre">
            {!! $errors->first('nombre', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="credito" class="form-label">{{ __('Credito') }}</label>
            <input type="text" name="credito" class="form-control @error('credito') is-invalid @enderror" value="{{ old('credito', $materia?->credito) }}" id="credito" placeholder="Credito">
            {!! $errors->first('credito', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="cadena" class="form-label">{{ __('Cadena') }}</label>
            <input type="text" name="cadena" class="form-control @error('cadena') is-invalid @enderror" value="{{ old('cadena', $materia?->cadena) }}" id="cadena" placeholder="Cadena">
            {!! $errors->first('cadena', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="materia_estado" class="form-label">{{ __('Materia Estado') }}</label>
            <input type="text" name="materia_estado" class="form-control @error('materia_estado') is-invalid @enderror" value="{{ old('materia_estado', $materia?->materia_estado) }}" id="materia_estado" placeholder="Materia Estado">
            {!! $errors->first('materia_estado', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>