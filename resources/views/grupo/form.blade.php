<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="id_grupo" class="form-label">{{ __('Id Grupo') }}</label>
            <input type="text" name="id_grupo" class="form-control @error('id_grupo') is-invalid @enderror" value="{{ old('id_grupo', $grupo?->id_grupo) }}" id="id_grupo" placeholder="Id Grupo">
            {!! $errors->first('id_grupo', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

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
            {!! $errors->first('cod_materia', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

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
            {!! $errors->first('n_trabajador', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

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
            {!! $errors->first('semestre', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Actualizar Grupo') }}</button>
    </div>
</div>