<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="calificacion" class="form-label">{{ __('Calificacion') }}</label>
            <input type="text" name="calificacion" class="form-control @error('calificacion') is-invalid @enderror" value="{{ old('calificacion', $historial?->calificacion) }}" id="calificacion" placeholder="Calificacion">
            {!! $errors->first('calificacion', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="f_kn_control" class="form-label">{{ __('Fkn Control') }}</label>
            <input type="text" name="FKn_control" class="form-control @error('FKn_control') is-invalid @enderror" value="{{ old('FKn_control', $historial?->FKn_control) }}" id="f_kn_control" placeholder="Fkn Control">
            {!! $errors->first('FKn_control', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="f_k_materia" class="form-label">{{ __('Fk Materia') }}</label>
            <input type="text" name="FK_materia" class="form-control @error('FK_materia') is-invalid @enderror" value="{{ old('FK_materia', $historial?->FK_materia) }}" id="f_k_materia" placeholder="Fk Materia">
            {!! $errors->first('FK_materia', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="f_k_prof" class="form-label">{{ __('Fk Prof') }}</label>
            <input type="text" name="FK_prof" class="form-control @error('FK_prof') is-invalid @enderror" value="{{ old('FK_prof', $historial?->FK_prof) }}" id="f_k_prof" placeholder="Fk Prof">
            {!! $errors->first('FK_prof', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="periodo" class="form-label">{{ __('Periodo') }}</label>
            <input type="text" name="periodo" class="form-control @error('periodo') is-invalid @enderror" value="{{ old('periodo', $historial?->periodo) }}" id="periodo" placeholder="Periodo">
            {!! $errors->first('periodo', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="oportunidad" class="form-label">{{ __('Oportunidad') }}</label>
            <input type="text" name="oportunidad" class="form-control @error('oportunidad') is-invalid @enderror" value="{{ old('oportunidad', $historial?->oportunidad) }}" id="oportunidad" placeholder="Oportunidad">
            {!! $errors->first('oportunidad', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>