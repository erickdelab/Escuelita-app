<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-2 mb20">
                    <label for="numero" class="form-label">{{ __('Número de Aula') }}</label>
                    <select name="numero" class="form-select @error('numero') is-invalid @enderror" id="numero">
                        <option value="">Seleccione un número...</option>
                        @foreach($numeros as $num)
                            <option value="{{ $num }}" 
                                {{ (isset($selectedNumero) && $selectedNumero == $num) || old('numero') == $num ? 'selected' : '' }}>
                                {{ $num }}
                            </option>
                        @endforeach
                    </select>
                    @error('numero')
                        <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
                    @enderror
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group mb-2 mb20">
                    <label for="letra" class="form-label">{{ __('Letra (Edificio/Zona)') }}</label>
                    <select name="letra" class="form-select @error('letra') is-invalid @enderror" id="letra">
                        <option value="">Seleccione una letra...</option>
                        @foreach($letras as $let)
                            <option value="{{ $let }}" 
                                {{ (isset($selectedLetra) && $selectedLetra == $let) || old('letra') == $let ? 'selected' : '' }}>
                                {{ $let }}
                            </option>
                        @endforeach
                    </select>
                    @error('letra')
                        <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="form-group mb-2 mb20">
            <label for="capacidad" class="form-label">{{ __('Capacidad') }}</label>
            <input type="number" name="capacidad" class="form-control @error('capacidad') is-invalid @enderror" value="{{ old('capacidad', $aula?->capacidad) }}" id="capacidad" placeholder="Ej: 30" min="1">
            @error('capacidad')
                <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
            @enderror
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
    </div>
</div>