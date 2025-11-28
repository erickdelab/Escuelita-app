<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Asistencia - {{ $grupo->materia->cod_materia }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
        }
        .header {
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h2, .header h3 {
            margin: 0;
            text-transform: uppercase;
            text-align: center;
        }
        .info-grid {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            font-size: 14px;
        }
        /* TABLA TIPO EXCEL */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #000; /* Bordes negros sólidos */
            padding: 4px 6px;
            vertical-align: middle;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
            font-size: 10px;
        }
        /* Cuadritos de asistencia */
        .check-box {
            width: 25px; /* Ancho fijo para los cuadritos */
            text-align: center;
        }
        .student-name {
            white-space: nowrap;
        }
        
        /* CONFIGURACIÓN DE IMPRESIÓN */
        @media print {
            @page {
                size: landscape; /* Hoja horizontal */
                margin: 1cm;
            }
            body {
                -webkit-print-color-adjust: exact;
            }
            .no-print {
                display: none;
            }
        }

        /* Botón flotante para imprimir */
        .btn-print {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #0d2149;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            cursor: pointer;
        }
        .btn-print:hover {
            background-color: #1a3c7a;
        }
    </style>
</head>
<body>

    <button onclick="window.print()" class="btn-print no-print">🖨️ Imprimir Lista</button>

    <div class="header">
        <h2>Instituto Tecnológico de Puebla</h2>
        <h3>Lista de Asistencia y Evaluación</h3>
        
        <div class="info-grid">
            <div>
                <strong>Docente:</strong> {{ $grupo->profesore->nombre }} {{ $grupo->profesore->ap_paterno }} {{ $grupo->profesore->ap_materno }}<br>
                <strong>Materia:</strong> {{ $grupo->materia->nombre }} ({{ $grupo->materia->cod_materia }})
            </div>
            <div style="text-align: right;">
                <strong>Grupo:</strong> {{ $grupo->id_grupo }}<br>
                <strong>Periodo:</strong> {{ $grupo->periodo->periodo_nombre ?? '' }} {{ $grupo->periodo->anio ?? '' }}
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px;">#</th>
                <th style="width: 80px;">No. Control</th>
                <th style="text-align: left;">Nombre del Alumno</th>
                
                @for($i = 1; $i <= 20; $i++)
                    <th class="check-box"></th>
                @endfor
            </tr>
        </thead>
        <tbody>
            @forelse($grupo->alumnos as $index => $alumno)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td style="text-align: center; font-weight: bold;">{{ $alumno->n_control }}</td>
                    <td class="student-name">
                        {{ $alumno->ap_pat }} {{ $alumno->ap_mat }} {{ $alumno->nombre }}
                    </td>

                    @for($i = 1; $i <= 20; $i++)
                        <td></td>
                    @endfor
                </tr>
            @empty
                <tr>
                    <td colspan="23" style="text-align: center; padding: 20px;">
                        No hay alumnos inscritos en este grupo.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px; font-size: 10px; text-align: center;">
        Generado el: {{ now()->format('d/m/Y H:i') }} | Portal Docente
    </div>

</body>
</html>