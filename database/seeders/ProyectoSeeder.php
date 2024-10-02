<?php

namespace Database\Seeders;

use App\Enums\EstadoTarea;
use App\Models\Proyecto;
use App\Models\Tarea;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProyectoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 25; $i++) {
            $proyectoData = [
                'nombre' => fake()->word(),
                'descripcion' => fake()->text(),
                'fecha_inicio' => fake()->date(),
            ];

            // Validar el proyecto antes de crearlo
            $proyectoValidator = Validator::make($proyectoData, [
                'nombre' => ['required', 'string', 'min:5', 'max:50', 'regex:/^(?!\s)(?!\d+$)[^0-9\s].*/'],
                'descripcion' => ['required', 'string', 'min:10', 'regex:/^(?!\s)(?!\d+$)[^0-9\s].*/'],
                'fecha_inicio' => 'required|date',
            ]);

            if ($proyectoValidator) {
                $proyecto = Proyecto::create($proyectoData);
            }

            // Ahora crear las tareas
            for ($j = 0; $j < 6; $j++) {
                $tareaData = [
                    'nombre' => fake()->word(),
                    'descripcion' => fake()->text(), // Asegúrate de que sea al menos 10 caracteres
                    'estado' => fake()->randomElement([EstadoTarea::PENDIENTE->value, 
                    EstadoTarea::EN_PROGRESO->value, 
                    EstadoTarea::COMPLETADA->value]),
                    'proyecto_id' => $proyecto->id,
                ];

                // Validar la tarea antes de crearla
                $tareaValidator = Validator::make($tareaData, [
                    'nombre' => ['required', 'string', 'min:5', 'max:50', 'regex:/^(?!\s)(?!\d+$)[^0-9\s].*/'],
                'descripcion' => ['required', 'string', 'min:10', 'regex:/^(?!\s)(?!\d+$)[^0-9\s].*/'],
                'estado' => ['required', Rule::in(array_column(EstadoTarea::cases(), 'value'))],
                'proyecto_id' => 'required|exists:proyecto,id',
                ]);

                if ($tareaValidator) {
                    Tarea::create($tareaData);
                }

                // Crear la tarea
            }
        }
    }
}
