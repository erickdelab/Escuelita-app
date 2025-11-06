<?php
// app/Http/Controllers/HorarioController.php
namespace App\Http\Controllers;

// 1. --- Importa los modelos y clases necesarios ---
use App\Models\Grupo;
use App\Models\Materia;
use App\Models\Profesore;
use App\Models\Aula;
use App\Http\Requests\StoreHorarioRequest;
use App\Services\ScheduleService;
use Illuminate\Http\Request; // Para leer el ID del grupo desde la URL
use Illuminate\Support\Facades\DB; // Para selectRaw

class HorarioController extends Controller
{
    public function __construct(protected ScheduleService $scheduleService)
    {
    }

    /**
     * Muestra el formulario para crear un nuevo horario.
     */
    public function create(Request $request)
    {
        // --- LÓGICA DE CARGA CORREGIDA ---

        // 1. Obtenemos el ID del grupo de la URL (ej. ?grupo_id=1)
        // Esto es para pre-seleccionar el grupo si vienes desde la pág. de detalles
        $selectedGrupoId = $request->query('grupo_id');

        // 2. Cargamos los Grupos (con sus relaciones para un nombre descriptivo)
        $grupos = Grupo::with(['materia', 'profesore'])->get()->mapWithKeys(function ($grupo) {
            $materiaNombre = $grupo->materia->nombre ?? 'Materia N/A';
            $profeNombre = $grupo->profesore ? ($grupo->profesore->nombre . ' ' . $grupo->profesore->ap_paterno) : 'Prof. N/A';
            
            // Construimos un nombre descriptivo
            $nombre = "Sem: {$grupo->semestre} - {$materiaNombre} (Prof: {$profeNombre})";
            
            // Usamos la llave primaria correcta: id_grupo
            return [$grupo->id_grupo => $nombre]; 
        });

        // 3. Cargamos Materias (usando la llave correcta 'cod_materia')
        $materias = Materia::where('materia_estado', 'Activa') // Buena práctica de tu GrupoController
                      ->pluck('nombre', 'cod_materia');

        // 4. Cargamos Profesores (usando 'n_trabajador' y CONCAT)
        $profesores = Profesore::where('situacion', 'Vigente') // Buena práctica de tu GrupoController
                       ->selectRaw("CONCAT(nombre, ' ', ap_paterno, ' ', ap_materno) as full_name, n_trabajador")
                       ->pluck('full_name', 'n_trabajador');
        
        // 5. Cargamos Aulas (esta usa 'id' estándar)
        $aulas = Aula::pluck('nombre', 'id');

        // 6. Definimos los bloques de inicio permitidos
        $allowedStartTimes = [
            '07:00', '09:00', '11:00', '13:00',
            '15:00', '17:00', '19:00'
        ];

        // 7. Enviamos todas las variables a la vista
        return view('horarios.create', compact(
            'grupos',
            'materias',
            'profesores',
            'aulas',
            'allowedStartTimes',
            'selectedGrupoId' // Para el dropdown
        ));
    }

    /**
     * Almacena un nuevo horario.
     */
    public function store(StoreHorarioRequest $request) 
    {
        $validated = $request->validated();

        try {
            // El ScheduleService ya está listo para recibir estos IDs
            $this->scheduleService->assignSchedule(
                $validated['grupo_id'],
                $validated['materia_id'], 
                $validated['profesore_id'],
                $validated['aula_id'],
                $validated['patron'],
                $validated['hora_inicio']
            );

        } catch (\Exception $e) {
            // Captura cualquier colisión (Grupo, Prof, Aula)
            return back()->withInput()->withErrors([
                'error_horario' => $e->getMessage()
            ]);
        }

        return redirect()->route('horarios.create') 
                         ->with('status', '¡Horario asignado con éxito!');
    }
}