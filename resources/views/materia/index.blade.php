@extends('layouts.app')

@section('template_title')
    Materias
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">

            <div class="card shadow-lg border-0">
                <!-- Header -->
                <div class="card-header text-white" style="background-color: #002D72;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h4 class="mb-0">📚 {{ __('Materias') }}</h4>

                        <a href="{{ route('materias.create') }}" class="btn btn-light btn-sm fw-bold">
                            + {{ __('Nueva Materia') }}
                        </a>
                    </div>
                </div>

                <!-- Mensaje de éxito -->
                @if ($message = Session::get('success'))
                    <div class="alert alert-success m-4 shadow-sm border-0 rounded">
                        <p class="mb-0">{{ $message }}</p>
                    </div>
                @endif

                <!-- Tabla -->
                <div class="card-body bg-white rounded-bottom">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="text-center text-white" style="background-color: #002D72;">
                                <tr>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Créditos</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($materias as $materia)
                                    <tr>
                                        <td class="text-center"><strong>{{ $materia->cod_materia }}</strong></td>
                                        <td>{{ $materia->nombre }}</td>
                                        <td class="text-center">{{ $materia->credito }}</td>
                                        <td class="text-center">
                                            <span class="badge {{ $materia->materia_estado == 'Activa' ? 'bg-success' : 'bg-danger' }}">
                                                {{ $materia->materia_estado }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a class="btn btn-sm btn-outline-primary" href="{{ route('materias.show', $materia->cod_materia) }}">
                                                    <i class="fa fa-fw fa-eye"></i> Ver
                                                </a>
                                                <a class="btn btn-sm btn-outline-success" href="{{ route('materias.edit', $materia->cod_materia) }}">
                                                    <i class="fa fa-fw fa-edit"></i> Editar
                                                </a>
                                                
                                                @if($materia->materia_estado == 'Activa')
                                                    <form action="{{ route('materias.destroy', $materia->cod_materia) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-warning"
                                                            onclick="event.preventDefault(); confirm('¿Seguro que deseas dar de baja esta materia?') ? this.closest('form').submit() : false;">
                                                            <i class="fa fa-fw fa-arrow-down"></i> Dar de Baja
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('materias.reactivar', $materia->cod_materia) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-info"
                                                            onclick="event.preventDefault(); confirm('¿Seguro que deseas reactivar esta materia?') ? this.closest('form').submit() : false;">
                                                            <i class="fa fa-fw fa-arrow-up"></i> Reactivar
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Paginación centrada -->
            <div class="d-flex justify-content-center mt-3">
               {!! $materias->withQueryString()->links('pagination::bootstrap-5') !!}
            </div>

        </div>
    </div>
</div>
@endsection