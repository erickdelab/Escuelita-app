<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        {{-- CAMPO 1: Código de Área - Solo se muestra si estamos EDITANDO --}}
        {{-- Si $area->cod_area tiene valor, estamos editando --}}
        @if ($area->cod_area)
            <div class="form-group mb-2 mb20">
                <label for="cod_area" class="form-label">{{ __('Código de Área') }}</label>
                <input type="text" 
                       name="cod_area" 
                       class="form-control @error('cod_area') is-invalid @enderror" 
                       value="{{ old('cod_area', $area->cod_area) }}" 
                       id="cod_area" 
                       placeholder="Código de Área"
                       readonly> {{-- Solo lectura en edición --}}
                @error('cod_area')
                    <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
                @enderror
            </div>
        @endif
        
        {{-- CAMPO 2: Nombre del Área --}}
        <div class="form-group mb-2 mb20">
            <label for="area" class="form-label">{{ __('Nombre del Área') }}</label>
            <input type="text" 
                   name="area" 
                   class="form-control @error('area') is-invalid @enderror" 
                   value="{{ old('area', $area?->area) }}" 
                   id="area" 
                   placeholder="Nombre del Área">
            @error('area')
                <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
            @enderror
        </div>
        
        {{-- CAMPO 3: Jefe de Área (SELECT Dinámico con Exclusión) --}}
        <div class="form-group mb-2 mb20">
            <label for="jefe_area" class="form-label">{{ __('Jefe de Área') }}</label>
            <select name="jefe_area" id="jefe_area" class="form-control @error('jefe_area') is-invalid @enderror">
                <option value="">-- Sin asignar --</option>
                
                {{-- ASUMIMOS que el controlador pasa $todosProfesores y $jefesAsignados --}}
                @if (isset($todosProfesores))
                    @foreach ($todosProfesores as $profesor)
                        @php
                            $n_trabajador = $profesor->n_trabajador;
                            $fullName = trim($profesor->nombre . ' ' . $profesor->ap_paterno . ' ' . $profesor->ap_materno);
                            
                            // 1. Verificar si este profesor es el jefe actual del área que estamos editando
                            $isCurrentJefe = ($area->jefe_area == $n_trabajador);
                            
                            // 2. Verificar si está asignado en OTRA área
                            $isAssigned = in_array($n_trabajador, $jefesAsignados) && !$isCurrentJefe;
                        @endphp
                        
                        <option value="{{ $n_trabajador }}" 
                                {{ old('jefe_area', $area?->jefe_area) == $n_trabajador ? 'selected' : '' }}
                                {{ $isAssigned ? 'disabled' : '' }}>
                            
                            {{ $fullName }} 
                            
                            @if ($isAssigned)
                                (Ya es jefe de otra área)
                            @endif
                        </option>
                    @endforeach
                @endif
                
            </select>
            @error('jefe_area')
                <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
            @enderror
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
    </div>
</div>
