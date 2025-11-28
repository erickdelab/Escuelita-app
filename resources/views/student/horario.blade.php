@extends('layouts.student')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4 fw-bold text-primary" style="color: #1B396A !important;">Horario Semestral</h4>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0 text-center align-middle" style="table-layout: fixed;">
                    <thead class="text-white" style="background-color: #1B396A;">
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
                                                
                                                <div class="fw-bold text-dark small">{{ $clase['materia'] }}</div>
                                                <div class="small text-muted">{{ $clase['profesor'] }}</div>
                                                <div class="badge bg-dark mt-1">Aula: {{ $clase['aula'] }}</div>
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
    
    <div class="mt-3 text-end">
        <button onclick="window.print()" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-printer me-2"></i> Imprimir Horario
        </button>
    </div>
</div>
@endsection