@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">Tablas de la Base de Datos</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Tabla</th>
                    <th>Descripción</th>
                    <th>Filas</th>
                    <th>Tipo</th>
                    <th>Cotejamiento</th>
                    <th>Tamaño</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $tablas = [
                        ['name'=>'alumnos','rows'=>70,'type'=>'InnoDB','collation'=>'utf8mb4_general_ci','size'=>'32.0 KB'],
                        ['name'=>'areas','rows'=>5,'type'=>'InnoDB','collation'=>'utf8mb4_general_ci','size'=>'32.0 KB'],
                        ['name'=>'cache','rows'=>0,'type'=>'InnoDB','collation'=>'utf8mb4_unicode_ci','size'=>'16.0 KB'],
                        ['name'=>'cache_locks','rows'=>0,'type'=>'InnoDB','collation'=>'utf8mb4_unicode_ci','size'=>'16.0 KB'],
                        ['name'=>'carreras','rows'=>11,'type'=>'InnoDB','collation'=>'utf8mb4_general_ci','size'=>'48.0 KB'],
                        ['name'=>'failed_jobs','rows'=>0,'type'=>'InnoDB','collation'=>'utf8mb4_unicode_ci','size'=>'32.0 KB'],
                        ['name'=>'grupos','rows'=>10,'type'=>'InnoDB','collation'=>'utf8mb4_general_ci','size'=>'48.0 KB'],
                        ['name'=>'historials','rows'=>70,'type'=>'InnoDB','collation'=>'utf8mb4_general_ci','size'=>'64.0 KB'],
                        ['name'=>'jobs','rows'=>0,'type'=>'InnoDB','collation'=>'utf8mb4_unicode_ci','size'=>'32.0 KB'],
                        ['name'=>'job_batches','rows'=>0,'type'=>'InnoDB','collation'=>'utf8mb4_unicode_ci','size'=>'16.0 KB'],
                        ['name'=>'materias','rows'=>40,'type'=>'InnoDB','collation'=>'utf8mb4_general_ci','size'=>'16.0 KB'],
                        ['name'=>'migrations','rows'=>3,'type'=>'InnoDB','collation'=>'utf8mb4_unicode_ci','size'=>'16.0 KB'],
                        ['name'=>'password_reset_tokens','rows'=>0,'type'=>'InnoDB','collation'=>'utf8mb4_unicode_ci','size'=>'16.0 KB'],
                        ['name'=>'profesores','rows'=>10,'type'=>'InnoDB','collation'=>'utf8mb4_general_ci','size'=>'48.0 KB'],
                        ['name'=>'sessions','rows'=>1,'type'=>'InnoDB','collation'=>'utf8mb4_unicode_ci','size'=>'48.0 KB'],
                        ['name'=>'users','rows'=>1,'type'=>'InnoDB','collation'=>'utf8mb4_unicode_ci','size'=>'32.0 KB'],
                    ];
                @endphp

                @foreach($tablas as $tabla)
                <tr>
                    <td>
                        <a href="{{ route('tabla.mostrar', $tabla['name']) }}" class="btn btn-sm btn-primary">
                            {{ $tabla['name'] }}
                        </a>
                    </td>
                    <td>{{ $tabla['rows'] }} registros</td>
                    <td>{{ $tabla['rows'] }}</td>
                    <td>{{ $tabla['type'] }}</td>
                    <td>{{ $tabla['collation'] }}</td>
                    <td>{{ $tabla['size'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection