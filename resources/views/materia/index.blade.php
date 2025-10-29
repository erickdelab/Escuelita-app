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
                                    <th>Nombre</th>
                                    <th>Crédito</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($materias as $materia)
                                    <tr>
                                        <td>{{ $materia->nombre }}</td>
                                        <td class="text-center">{{ $materia->credito }}</td>
                                        <td>{{ $materia->materia_estado }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('materias.destroy', $materia->cod_materia) }}" method="POST">
                                                <a class="btn btn-sm btn-outline-primary" href="{{ route('materias.show', $materia->cod_materia) }}">
                                                    <i class="fa fa-fw fa-eye"></i> Ver
                                                </a>
                                                <a class="btn btn-sm btn-outline-success" href="{{ route('materias.edit', $materia->cod_materia) }}">
                                                    <i class="fa fa-fw fa-edit"></i> Editar
                                                </a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="event.preventDefault(); confirm('¿Seguro que deseas eliminar esta materia?') ? this.closest('form').submit() : false;">
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
               {!! $materias->withQueryString()->links('pagination::bootstrap-5') !!}
            </div>

        </div>
    </div>
</div>
@endsection