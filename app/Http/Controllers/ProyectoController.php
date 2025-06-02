<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyecto;
use Illuminate\Support\Facades\Validator;

class ProyectoController extends Controller
{
    public function index()
    {
        return Proyecto::with('creador')->get();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errores' => $validator->errors()], 422);
        }

        $proyecto = Proyecto::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'created_by' => auth()->id(),
        ]);

        return response()->json([
            'mensaje' => 'Proyecto creado',
            'proyecto' => $proyecto
        ], 201);
    }

    public function show($id)
    {
        $proyecto = Proyecto::with('creador')->find($id);

        if (!$proyecto) {
            return response()->json(['mensaje' => 'Proyecto no encontrado'], 404);
        }

        return response()->json($proyecto);
    }

    public function update(Request $request, $id)
    {
        $proyecto = Proyecto::find($id);

        if (!$proyecto) {
            return response()->json(['mensaje' => 'Proyecto no encontrado'], 404);
        }

        $proyecto->update($request->only(['titulo', 'descripcion']));

        return response()->json([
            'mensaje' => 'Proyecto actualizado',
            'proyecto' => $proyecto
        ]);
    }

    public function destroy($id)
    {
        $proyecto = Proyecto::find($id);

        if (!$proyecto) {
            return response()->json(['mensaje' => 'Proyecto no encontrado'], 404);
        }

        $proyecto->delete();

        return response()->json(['mensaje' => 'Proyecto eliminado']);
    }
}
