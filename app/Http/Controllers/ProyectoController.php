<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\Tarea;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProyectoController extends Controller
{
    public function index()
    {
        $query = request('query');

        if ($query) {
            $proyectos = Proyecto::search($query)->paginate(5);
        } else {
            $proyectos = Proyecto::orderBy('fecha_inicio', 'desc')->paginate(5);
        }
        // Se transforma la fecha del formaro 'd-m-Y' a 'd de m del Y'
        $proyectos->transform(function ($proyecto) {
            if ($proyecto->fecha_inicio) {
                $proyecto->fecha_inicio = Carbon::parse($proyecto->fecha_inicio)->translatedFormat('d \d\e F \d\e Y');
            }
            return $proyecto;
        });
    
        return view('proyectos.index', compact('proyectos', 'query'));
    }

    /**
     * endpoint de todos los proyectos con sus respectivas
     */
    public function proyectosTareas()
    {
        $proyectos = Proyecto::with('tareas')->paginate(5);

        return response()->json($proyectos);
    }

    public function store(Request $request)
    {
        $this->validateProyecto($request);

        $date = Carbon::now();
        $fechaHoy = $date->format('Y-m-d');

        if ($request->fecha_inicio < $fechaHoy) {
            notify()->error('El proyecto debe iniciar hoy o en el futuro.', 'Operación fallida');
            return redirect()->back()->withInput();
        }

        Proyecto::create([
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
            'fecha_inicio' => $request->input('fecha_inicio'),
        ]);
        notify()->success('El proyecto ha sido creado con éxito.', 'Operación exitosa');
        return redirect()->route('proyectos.index');
    }

    public function show(string $id)
    {
        $proyecto = Proyecto::findOrFail($id);

        $proyecto->fecha_inicio = Carbon::parse($proyecto->fecha_inicio)->translatedFormat('d \d\e F \d\e Y');

        $query = request('query');

        $proyecto->load('tareas');

        if ($query) {
            $tareas = Tarea::search($query)->where('proyecto_id', $id)->paginate(5);
        } else {
            $tareas = $proyecto->tareas()->orderByRaw("estado = 'pendiente' DESC")->paginate(5);
        }
        
        return view('proyectos.show', compact('proyecto', 'tareas','query'));
    }

    public function update(Request $request, $id)
    {
        $this->validateProyecto($request);

        $proyecto = Proyecto::findOrFail($id);

        $date = Carbon::now();
        $fechaHoy = $date->format('Y-m-d');

        if ($proyecto->fecha_inicio !== $request->fecha_inicio) {
            if ($request->fecha_inicio >= $fechaHoy) {
                $proyecto->update($request->all());
                return response()->json(['code' => 200, 'message' => 'Proyecto actualizado exitosamente.']);
            } else {
                return response()->json(['code' => 404, 'message' => 'El proyecto debe iniciar hoy o en el futuro.']);
            }
        }

        // Validar que si los campos son diferentes, pues no se actualiza el registro
        if ($proyecto->nombre === $request->nombre && $proyecto->descripcion === $request->descripcion && $proyecto->fecha_inicio === $request->fecha_inicio) {
            return response()->json(['code' => 404, 'message' => 'No se han realizado cambios en el proyecto.']);
        }

        $proyecto->update($request->all());

        return response()->json(['code' => 200, 'message' => 'Proyecto actualizado exitosamente.']);
    }

    public function edit($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        if (request()->ajax()) {
            return response()->json($proyecto);
        }
        return response()->json($proyecto);
    }

    public function destroy($id)
    {
        $proyecto = Proyecto::findOrFail($id);

        $proyecto->load('tareas');
        $tareasProceso = $proyecto->tareas()->where('estado', 'en progreso')->count();
        $tareasPendientes = $proyecto->tareas()->where('estado', 'pendiente')->count();
        $tareasCompletas = $proyecto->tareas()->where('estado', 'completada')->count();

        if ($tareasProceso > 0) {
            notify()->error('Tiene tareas en proceso, no se puede eliminar.', 'Operación fallida');
            return redirect()->back()->withInput();
        }

        if ($tareasPendientes > 0 && $tareasCompletas > 0) {
            notify()->error('Tiene tareas pendientes, no se puede eliminar.', 'Operación fallida');
            return redirect()->back()->withInput();
        }

        $proyecto->delete();

        notify()->success('El proyecto ha sido eliminado con éxito.', 'Operación exitosa');
        return redirect()->back()->withInput();
    }

    public function validateProyecto(Request $request)
    {
        $request->validate(
            [
                'nombre' => ['required', 'string', 'min:5', 'max:50', 'regex:/^(?!\s)(?!\d+$)[^0-9\s].*/'],
                'descripcion' => ['required', 'string', 'min:10', 'regex:/^(?!\s)(?!\d+$)[^0-9\s].*/'],
                'fecha_inicio' => 'required|date',
            ],
            [
                'nombre.required' => 'El nombre del proyecto es obligatorio.',
                'descripcion.required' => 'La descripción es obligatoria.',
                'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
            ],
        );
    }
}
