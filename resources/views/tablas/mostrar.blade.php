@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">Tabla: {{ $nombre }}</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    @if($registros->isNotEmpty())
                        @foreach(array_keys((array) $registros[0]) as $columna)
                            <th>{{ $columna }}</th>
                        @endforeach
                    @else
                        <th>No hay registros</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($registros as $fila)
                    <tr>
                        @foreach((array) $fila as $valor)
                            <td>{{ $valor }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <a href="{{ route('tablas.index') }}" class="btn btn-secondary mt-3">Volver al listado de tablas</a>
</div>
@endsection
