<?php

namespace App\Http\Controllers;

use App\Enums\EstadoTarea;
use Illuminate\Validation\Rule;
use App\Models\Tarea;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    public function store(Request $request)
    {
        $this->validateTarea($request);

        $tareaExistente = Tarea::where('nombre', $request->nombre)
            ->where('proyecto_id', $request->proyecto_id)
            ->whereNull('deleted_at')
            ->first();
        if ($tareaExistente) {
            notify()->error('Ya existe una tarea con ese nombre.', 'Operación fallida');
            return redirect()->back()->withInput();
        }

        if (!$request->id) {
            if (EstadoTarea::from($request->estado) !== EstadoTarea::PENDIENTE) {
                notify()->error('El estado de la tarea debe ser pendiente.', 'Operación fallida');
                return redirect()->back()->withInput();
            }
        }

        Tarea::create([
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
            'estado' => $request->input('estado'),
            'proyecto_id' => $request->input('proyecto_id'),
        ]);

        notify()->success('La tarea ha sido creado con éxito.', 'Operación exitosa');
        return redirect()->route('proyectos.show', $request->input('proyecto_id'))->with('success', 'Tarea creada correctamente.');
    }

    public function update(Request $request, string $id)
    {
        $this->validateTarea($request);

        $tarea = Tarea::find($id);

        if (!$tarea) {
            return response()->json(['code' => 404, 'message' => 'Tarea no encontrada.']);
        }

        //Validar que si la tarea está completada, no se puedan cambiar los otros campos y solo cambie el estado
        if ($tarea->estado === EstadoTarea::COMPLETADA) {
            if ($tarea->estado === EstadoTarea::from($request->estado)) {
                return response()->json(['code' => 404, 'message' => 'No se han realizado cambios en la tarea.']);
            }

            if ($tarea->nombre !== $request->nombre && $tarea->descripcion !== $request->descripcion) {
                return response()->json(['code' => 404, 'message' => 'El nombre y la descripción son diferentes.']);
            }

            if ($tarea->nombre !== $request->nombre) {
                return response()->json(['code' => 404, 'message' => 'El nombre de la tarea es diferente.']);
            }

            if ($tarea->descripcion !== $request->descripcion) {
                return response()->json(['code' => 404, 'message' => 'La descripción de la tarea es diferente.']);
            }

            $tarea->update($request->only(['estado']));
            return response()->json(['code' => 200, 'message' => 'Estado de la tarea actualizado.']);
        }

        if ($tarea->nombre === $request->nombre && $tarea->descripcion === $request->descripcion && $tarea->estado === EstadoTarea::from($request->estado)) {
            return response()->json(['code' => 404, 'message' => 'No se han realizado cambios en la tarea.']);
        }

        $tarea->update($request->all());

        return response()->json(['code' => 200, 'message' => 'Tarea actualizada exitosamente.']);
    }

    public function destroy($id)
    {
        $tarea = Tarea::findOrFail($id);

        $tarea->delete();

        notify()->success('La tarea ha sido eliminada con éxito.', 'Operación exitosa');
        return redirect()->back()->withInput();
    }

    public function edit($id)
    {
        $tarea = Tarea::findOrFail($id);
        if (request()->ajax()) {
            return response()->json($tarea);
        }
        return response()->json($tarea);
    }

    public function validateTarea(Request $request)
    {
        $request->validate(
            [
                'nombre' => ['required', 'string', 'min:5', 'max:50', 'regex:/^(?!\s)(?!\d+$)[^0-9\s].*/'],
                'descripcion' => ['required', 'string', 'min:10', 'regex:/^(?!\s)(?!\d+$)[^0-9\s].*/'],
                'estado' => ['required', Rule::in(array_column(EstadoTarea::cases(), 'value'))],
                'proyecto_id' => 'required|exists:proyecto,id',
            ],
            [
                'nombre.required' => 'El nombre del proyecto es obligatorio.',
                'descripcion.required' => 'La descripción es obligatoria',
                'estado.required' => 'El estado es obligatorio.',
            ],
        );
    }
}
