@extends('layouts.app')

@section('template_title')
    Carreras
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">

            <div class="card shadow-lg border-0">
                <!-- Header -->
                <div class="card-header text-white" style="background-color: #002D72;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">🎓 {{ __('Carreras') }}</h4>
                        <a href="{{ route('carreras.create') }}" class="btn btn-light btn-sm fw-bold">
                            + {{ __('Nueva Carrera') }}
                        </a>
                    </div>
                </div>

                <!-- Alertas -->
                @if (session('success'))
                    <div class="alert alert-success m-4 shadow-sm border-0 rounded">
                        <p class="mb-0">{{ session('success') }}</p>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger m-4 shadow-sm border-0 rounded">
                        <p class="mb-0">{{ session('error') }}</p>
                    </div>
                @endif

                <!-- Tabla -->
                <div class="card-body bg-white rounded-bottom">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle text-center">
                            <thead class="text-white" style="background-color: #002D72;">
                                <tr>
                                    <th>No</th>
                                    <th>Id Carrera</th>
                                    <th>Nombre Carrera</th>
                                    <th>Num Edif</th>
                                    <th>Capacidad</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($carreras as $carrera)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $carrera->id_carrera }}</td>
                                        <td>{{ $carrera->nombre_carrera }}</td>
                                        <td>{{ $carrera->num_edif }}</td>
                                        <td>{{ $carrera->capacidad }}</td>
                                        <td>
                                            <form action="{{ route('carreras.destroy', $carrera->id_carrera) }}" method="POST">
                                                <a class="btn btn-sm btn-outline-primary" href="{{ route('carreras.show', $carrera->id_carrera) }}">
                                                    <i class="fa fa-fw fa-eye"></i> Ver
                                                </a>
                                                <a class="btn btn-sm btn-outline-success" href="{{ route('carreras.edit', $carrera->id_carrera) }}">
                                                    <i class="fa fa-fw fa-edit"></i> Editar
                                                </a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="event.preventDefault(); if(confirm('¿Seguro que deseas eliminar esta carrera?')) this.closest('form').submit();">
                                                    <i class="fa fa-fw fa-trash"></i> Eliminar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-muted py-4">No hay carreras registradas.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Paginación -->
                <div class="d-flex justify-content-center mt-3 mb-3">
                    @if ($carreras instanceof \Illuminate\Pagination\AbstractPaginator)
                        {!! $carreras->appends(request()->except('page'))->links('pagination::bootstrap-5') !!}
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
