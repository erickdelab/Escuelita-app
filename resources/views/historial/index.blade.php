@extends('layouts.app')

@section('template_title')
    Historial
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">

            <div class="card shadow-lg border-0">
                <!-- Header -->
                <div class="card-header text-white" style="background-color: #002D72;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h4 class="mb-0">📚 {{ __('Historial') }}</h4>

                        <a href="{{ route('historials.create') }}" class="btn btn-light btn-sm fw-bold">
                            + {{ __('Nuevo Registro') }}
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
                                    <th>No</th>
                                    <th>Calificación</th>
                                    <th>N° Control</th>
                                    <th>Materia</th>
                                    <th>Profesor</th>
                                    <th>Periodo</th>
                                    <th>Oportunidad</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($historials as $historial)
                                    <tr>
                                        <td class="text-center">{{ ++$i }}</td>
                                        <td class="text-center">{{ $historial->calificacion }}</td>
                                        <td class="text-center">{{ $historial->FKn_control }}</td>
                                        <td class="text-center">{{ $historial->FK_materia }}</td>
                                        <td class="text-center">{{ $historial->FK_prof }}</td>
                                        <td class="text-center">{{ $historial->periodo }}</td>
                                        <td class="text-center">{{ $historial->oportunidad }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('historials.destroy', $historial->id) }}" method="POST">
                                                <a class="btn btn-sm btn-outline-primary" href="{{ route('historials.show', $historial->id) }}">
                                                    <i class="fa fa-fw fa-eye"></i> Ver
                                                </a>
                                                <a class="btn btn-sm btn-outline-success" href="{{ route('historials.edit', $historial->id) }}">
                                                    <i class="fa fa-fw fa-edit"></i> Editar
                                                </a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="event.preventDefault(); confirm('¿Seguro que deseas eliminar este registro?') ? this.closest('form').submit() : false;">
                                                    <i class="fa fa-fw fa-trash"></i> Eliminar
                                                </button>
                                            </form>
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
                {!! $historials->withQueryString()->links('pagination::bootstrap-5') !!}

            </div>

        </div>
    </div>
</div>
@endsection
