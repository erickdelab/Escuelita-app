@extends('layouts.app')

@section('template_title')
    Reporte: Alumnos TICS en Especial
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">

            <div class="card shadow-lg border-0">
                <div class="card-header text-white" style="background-color: #002D72;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h4 class="mb-0">📊 Reporte: Alumnos de TICS en Oportunidad Especial</h4>
                        {{-- Puedes añadir un botón para volver a una página principal de reportes si la tienes --}}
                        {{-- <a href="{{ route('reportes.index') }}" class="btn btn-light btn-sm fw-bold">Volver</a> --}}
                    </div>
                </div>

                <div class="card-body bg-white rounded-bottom">
                    
                    @if ($alumnosEspecial->isEmpty())
                        <div class="alert alert-warning">
                            No se encontraron alumnos de TICS en oportunidad especial.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="text-center text-white" style="background-color: #002D72;">
                                    <tr>
                                        <th>Nombre Alumno</th>
                                        <th>Semestre</th>
                                        <th>Carrera</th>
                                        <th>Materias en Especial</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($alumnosEspecial as $alumno)
                                        <tr>
                                            <td>{{ $alumno->nombre }}</td>
                                            <td class="text-center">{{ $alumno->semestre }}</td>
                                            <td class="text-center">{{ $alumno->carrera }}</td>
                                            <td class="text-center">{{ $alumno->materias_en_especial }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
