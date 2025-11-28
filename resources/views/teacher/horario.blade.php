@extends('layouts.teacher')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold" style="color: #0d2149 !important;">Mi Horario Semestral</h4>
        <button onclick="window.print()" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-printer me-2"></i> Imprimir
        </button>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0 text-center align-middle" style="table-layout: fixed;">
                    <thead class="text-white" style="background-color: #0d2149;">
                        <tr>
                            <th style="width: 80px;">Hora</th>
                            <th>Lunes</th>
                            <th>Martes</th>
                            <th>Miércoles</th>
                            <th>Jueves</th>
                            <th>Viernes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($horasDisponibles as $hora)
                            <tr>
                                <td class="fw-bold bg-light text-secondary">
                                    {{ sprintf('%02d', $hora) }}:00
                                </td>
                                @for ($dia = 1; $dia <= 5; $dia++)
                                    @if (isset($calendario[$dia][$hora]))
                                        @if (is_array($calendario[$dia][$hora]))
                                            @php $clase = $calendario[$dia][$hora]; @endphp
                                            <td rowspan="{{ $clase['duracion'] }}" 
                                                class="p-2 border-white text-start shadow-sm" 
                                                style="background-color: {{ $clase['color'] }}; vertical-align: middle; border-radius: 4px;">
                                                
                                                <div class="badge bg-dark mb-1">{{ $clase['codigo'] }}</div>
                                                <div class="fw-bold text-dark small mb-1">{{ $clase['materia'] }}</div>
                                                <div class="small text-muted">
                                                    <i class="bi bi-people-fill"></i> Grupo {{ $clase['grupo_id'] }}
                                                </div>
                                                <div class="badge bg-white text-dark border mt-1">
                                                    <i class="bi bi-geo-alt-fill"></i> {{ $clase['aula'] }}
                                                </div>
                                            </td>
                                        @endif
                                    @else
                                        <td class="bg-white"></td>
                                    @endif
                                @endfor
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection