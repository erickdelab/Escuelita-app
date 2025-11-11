@extends('layouts.app')

@section('template_title')
    Horario del Grupo #{{ $grupo->id_grupo }}
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            
            @if ($message = Session::get('success'))
                <div class="alert alert-success shadow-sm border-0 rounded">
                    <p class="mb-0">{{ $message }}</p>
                </div>
            @elseif ($message = Session::get('error'))
                <div class="alert alert-danger shadow-sm border-0 rounded">
                    <p class="mb-0">{{ $message }}</p>
                </div>
            @endif

            <div class="card shadow-lg border-0">
                <div class="card-header text-white" style="background-color: #002D72;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span class="card-title h4 mb-0">
                            <i class="bi bi-calendar-check"></i> 
                            Gestionar Horario del Grupo #{{ $grupo->id_grupo }}
                        </span>
                        <a href="{{ route('grupos.index') }}" class="btn btn-light btn-sm fw-bold">
                            ← Regresar a Grupos
                        </a>
                    </div>
                </div>
                
                <div class="card-body bg-light">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Materia:</strong>
                            <p class="fs-5">{{ $grupo->materia->nombre ?? 'N/A' }} 
                                <span class="text-muted">({{ $grupo->materia->creditos ?? 'N/A' }} créd.)</span>
                            </p>
                        </div>
                        <div class="col-md-4">
                            <strong>Profesor:</strong>
                            <p class="fs-5">{{ $grupo->profesore->nombre ?? 'N/A' }} {{ $grupo->profesore->ap_paterno ?? '' }}</p>
                        </div>
                        <div class="col-md-4">
                            <strong>Semestre/Periodo:</strong>
                            <p class="fs-5">Sem. {{ $grupo->semestre }} ({{ $grupo->periodo->codigo_periodo ?? 'N/A' }})</p>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="text-primary">Asignar Nuevo Horario</h5>
                            <p class="text-muted">
                                Asignar un horario nuevo reemplazará el existente.
                            </p>
                            
                            <form method="POST" action="{{ route('grupos.horario.store', $grupo->id_grupo) }}">
                                @csrf
                                
                                <div class="alert alert-info py-2">
                                    <small><i class="bi bi-info-circle-fill"></i> La materia tiene <strong>{{ $grupo->materia->creditos ?? 'N/A' }} créditos</strong>. El sistema asignará los bloques correspondientes (L-M + V o M-J + V) automáticamente si son 5 créditos.</small>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="patron" class="form-label fw-bold">Patrón de Horario</label>
                                    <select name="patron" id="patron" class="form-select @error('patron') is-invalid @enderror" required>
                                        <option value="">-- Seleccione un patrón --</option>
                                        <option value="L-M" {{ old('patron') == 'L-M' ? 'selected' : '' }}>Lunes y Miércoles</option>
                                        <option value="M-J" {{ old('patron') == 'M-J' ? 'selected' : '' }}>Martes y Jueves</option>
                                    </select>
                                    @error('patron')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="hora_inicio" class="form-label fw-bold">Hora de Inicio (Bloque)</label>
                                    <select name="hora_inicio" id="hora_inicio" class="form-select @error('hora_inicio') is-invalid @enderror" required>
                                        <option value="">-- Seleccione un bloque --</option>
                                        @foreach($allowedStartTimes as $time)
                                            <option value="{{ $time }}" {{ old('hora_inicio') == $time ? 'selected' : '' }}>
                                                {{ \Carbon\Carbon::parse($time)->format('h:i A') }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('hora_inicio')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="aula_id" class="form-label fw-bold">Aula</label>
                                    <select name="aula_id" class="form-select @error('aula_id') is-invalid @enderror" id="aula_id" required>
                                        <option value="">-- Seleccione patrón y hora para ver aulas --</option>
                                    </select>
                                    @error('aula_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bi bi-save"></i> Guardar Horario
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-6 border-start">
                            <h5 class="text-primary">Horario Actual Asignado</h5>
                            
                            @if($grupo->horarios->isEmpty())
                                <div class="alert alert-warning text-center">
                                    <i class="bi bi-calendar-x fs-1"></i>
                                    <p class="fs-5 mt-2">Este grupo no tiene ningún horario asignado.</p>
                                </div>
                            @else
                                @foreach($diasSemana as $diaNum => $diaNombre)
                                    @if($horariosAgrupados->has($diaNum))
                                        <strong>{{ $diaNombre }}</strong>
                                        <ul class="list-group mb-2">
                                            @foreach($horariosAgrupados[$diaNum] as $horario)
                                            <li class="list-group-item d-flex justify-content-between">
                                                <div>
                                                    <i class="bi bi-clock"></i> 
                                                    {{ \Carbon\Carbon::parse($horario->hora_inicio)->format('h:i A') }} - 
                                                    {{ \Carbon\Carbon::parse($horario->hora_fin)->format('h:i A') }}
                                                </div>
                                                <span class="badge bg-primary">
                                                    <i class="bi bi-door-open"></i> 
                                                    {{ $horario->aula->nombre ?? 'N/A' }}
                                                </span>
                                            </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                @endforeach
                                
                                <form method="POST" action="{{ route('grupos.horario.destroy', $grupo->id_grupo) }}" class="d-grid mt-3">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger"
                                        onclick="return confirm('¿Estás seguro de que deseas ELIMINAR el horario actual de este grupo?')">
                                        <i class="bi bi-trash"></i> Eliminar Horario Actual
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        // La materia es fija para este grupo, la obtenemos de Blade
        const materiaId = "{{ $grupo->cod_materia }}";
        
        const patronSelect = document.getElementById('patron');
        const horaSelect = document.getElementById('hora_inicio');
        const aulaSelect = document.getElementById('aula_id');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        async function fetchAulasDisponibles() {
            const patron = patronSelect.value;
            const horaInicio = horaSelect.value;

            // materiaId ya la tenemos, solo validamos patron y hora
            if (!patron || !horaInicio) {
                resetAulaSelect('Seleccione patrón y hora...');
                return;
            }

            resetAulaSelect('Buscando aulas disponibles...');

            try {
                const response = await fetch("{{ route('grupos.verificarAulas') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        materia_id: materiaId, // Usamos la variable fija
                        patron: patron,
                        hora_inicio: horaInicio
                    })
                });

                if (!response.ok) throw new Error('Error al verificar.');
                
                const data = await response.json();
                populateAulaSelect(data.disponibles, data.ocupadas);

            } catch (error) {
                console.error('Error en fetchAulasDisponibles:', error);
                resetAulaSelect('Error al cargar aulas', true);
            }
        }

        // ... (Las funciones resetAulaSelect y populateAulaSelect son idénticas a la respuesta anterior) ...
        
        function resetAulaSelect(message, isError = false) {
            aulaSelect.innerHTML = '';
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = message;
            if (isError) defaultOption.style.color = 'red';
            aulaSelect.appendChild(defaultOption);
        }

        function populateAulaSelect(disponibles, ocupadas) {
            aulaSelect.innerHTML = '';
            
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = '-- Seleccione un Aula --';
            aulaSelect.appendChild(defaultOption);

            // Disponibles
            disponibles.forEach(aula => {
                const option = document.createElement('option');
                option.value = aula.id;
                option.textContent = `${aula.nombre} (Cap: ${aula.capacidad})`;
                aulaSelect.appendChild(option);
            });

            // Ocupadas (Deshabilitadas)
            if (ocupadas.length > 0) {
                 const optGroup = document.createElement('optgroup');
                 optGroup.label = 'Aulas Ocupadas';
                 aulaSelect.appendChild(optGroup);

                ocupadas.forEach(aula => {
                    const option = document.createElement('option');
                    option.value = aula.id;
                    option.textContent = `${aula.nombre} (Cap: ${aula.capacidad})`;
                    option.disabled = true;
                    option.style.color = '#999';
                    optGroup.appendChild(option);
                });
            }
        }

        // Escuchamos solo patrón y hora
        patronSelect.addEventListener('change', fetchAulasDisponibles);
        horaSelect.addEventListener('change', fetchAulasDisponibles);
    });
</script>
@endpush