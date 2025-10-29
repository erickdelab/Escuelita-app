@extends('layouts.app')

@section('template_title')
    Áreas
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">

            <div class="card shadow-lg border-0">
                <!-- Header -->
                <div class="card-header text-white" style="background-color: #002D72;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h4 class="mb-0">🏢 {{ __('Áreas') }}</h4>

                        <a href="{{ route('areas.create') }}" class="btn btn-light btn-sm fw-bold">
                            + {{ __('Nueva Área') }}
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
                                    {{-- Columna "Cod Área" ELIMINADA DE LA VISTA --}}
                                    <th>Área</th>
                                    <th>Jefe de Área</th> {{-- Título más descriptivo --}}
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($areas as $area)
                                    <tr>
                                        <td class="text-center">{{ ++$i }}</td>
                                        {{-- El valor de $area->cod_area ya no se muestra --}}
                                        <td>{{ $area->area }}</td>
                                        
                                        {{-- CAMBIO CLAVE: Muestra el nombre completo del Jefe --}}
                                        <td class="text-center">
                                            @if ($area->jefe)
                                                {{ $area->jefe->nombre }} {{ $area->jefe->ap_paterno }} {{ $area->jefe->ap_materno }}
                                            @else
                                                <span class="text-muted">Sin asignar</span>
                                            @endif
                                        </td>
                                        
                                        <td class="text-center">
                                            <form action="{{ route('areas.destroy', $area->cod_area) }}" method="POST">
                                                <a class="btn btn-sm btn-outline-primary" href="{{ route('areas.show', $area->cod_area) }}">
                                                    <i class="fa fa-fw fa-eye"></i> Ver
                                                </a>
                                                <a class="btn btn-sm btn-outline-success" href="{{ route('areas.edit', $area->cod_area) }}">
                                                    <i class="fa fa-fw fa-edit"></i> Editar
                                                </a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="event.preventDefault(); confirm('¿Seguro que deseas eliminar esta área?') ? this.closest('form').submit() : false;">
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
                {!! $areas->withQueryString()->links() !!}
            </div>

        </div>
    </div>
</div>
@endsection
