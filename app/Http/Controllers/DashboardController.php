<?php

namespace App\Http\Controllers;

use App\Enums\EstadoTarea;
use App\Models\Proyecto;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Visualizar proyectos con estado pendiente.
     * Se espera mostrar el id, nombre, descripción, fecha de inicio y estado de proyecto.
     */
    public function index()
    {
        $proyectos = Proyecto::select('id', 'nombre', 'descripcion', 'fecha_inicio')->get();
        
        $proyectos->map(function ($proyecto) {
            $proyecto->fecha_inicio = Carbon::parse($proyecto->fecha_inicio)->translatedFormat('d \d\e F \d\e Y');
            $proyecto->estado = $proyecto->tareas()->where('estado', EstadoTarea::PENDIENTE)->exists() 
                ? 'Pendiente' 
                : 'Completado';
        });

        $proyectosPendientes = $proyectos->filter(function ($proyecto) {
            return $proyecto->estado === 'Pendiente';
        })->take(5);

        $proyectosPendientes = $proyectosPendientes->values();
        
        return view('dashboard', compact('proyectosPendientes'));
    }
}
