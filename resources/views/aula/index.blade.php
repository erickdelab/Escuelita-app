@extends('layouts.app')

@section('template_title')
    Aulas
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card shadow-lg border-0">
                <div class="card-header text-white" style="background-color: #002D72;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h4 class="mb-0">🏫 {{ __('Aulas') }}</h4>
                        <a href="{{ route('aulas.create') }}" class="btn btn-light btn-sm fw-bold">
                            + {{ __('Nueva Aula') }}
                        </a>
                    </div>
                </div>

                @if ($message = Session::get('success'))
                    <div class="alert alert-success m-4 shadow-sm border-0 rounded">
                        <p class="mb-0">{{ $message }}</p>
                    </div>
                @elseif ($message = Session::get('error'))
                    <div class="alert alert-danger m-4 shadow-sm border-0 rounded">
                        <p class="mb-0">{{ $message }}</p>
                    </div>
                @endif

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="text-center text-white" style="background-color: #002D72;">
                                <tr>
                                    <th>No</th>
                                    <th>Nombre</th>
                                    <th>Capacidad</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($aulas as $aula)
                                    <tr>
                                        <td class="text-center">{{ ++$i }}</td>
                                        <td>{{ $aula->nombre }}</td>
                                        <td class="text-center">{{ $aula->capacidad }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('aulas.destroy', $aula->id) }}" method="POST">
                                                <a class="btn btn-sm btn-outline-success" href="{{ route('aulas.edit', $aula->id) }}">
                                                    <i class="fa fa-fw fa-edit"></i> Editar
                                                </a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="event.preventDefault(); confirm('¿Seguro que deseas eliminar esta aula?') ? this.closest('form').submit() : false;">
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
            {!! $aulas->links() !!}
        </div>
    </div>
</div>
@endsection