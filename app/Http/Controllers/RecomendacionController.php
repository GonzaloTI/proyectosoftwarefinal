<?php

namespace App\Http\Controllers;

use App\Models\Diagnostico;
use App\Models\Recomendacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecomendacionController extends Controller
{
    // // Mostrar todas las recomendaciones
    // public function index()
    // {
    //     $recomendaciones = Recomendacion::all();
    //     return view('recomendacion.index', compact('recomendaciones'));
    // }
    public function index()
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Obtener todos los diagnósticos del usuario autenticado
        $diagnosticos = $user->diagnosticos()->with('recomendaciones')->get();

        // Obtener todas las recomendaciones relacionadas con estos diagnósticos
        $recomendaciones = collect();

        foreach ($diagnosticos as $diagnostico) {
            $recomendaciones = $recomendaciones->merge($diagnostico->recomendaciones);
        }

        return view('recomendacion.index', compact('recomendaciones'));
    }
    

    // Mostrar el formulario para crear una nueva recomendacion
    public function create()
{
    $diagnosticos = Diagnostico::all(); // Obtener todos los diagnósticos disponibles
    return view('recomendacion.create', compact('diagnosticos'));
}

public function store(Request $request)
{
    $request->validate([
        'diagnostico_id' => 'required|exists:diagnostico,id',
        'recomendacion' => 'required|string',
    ]);

    // Obtener al usuario autenticado (médico en este caso)
    $user = Auth::user();

    // Verificar si ya existe una recomendación para el mismo diagnóstico y médico
    $existingRecomendacion = Recomendacion::where('diagnostico_id', $request->diagnostico_id)
                                          ->where('nombre_medico', $user->name)
                                          ->exists();

    if ($existingRecomendacion) {
        return redirect()->back()->with('error', 'Ya has enviado una recomendación para este diagnóstico.');
    }

    // Si no existe, crear una nueva instancia de Recomendacion y asignar los valores
    $recomendacion = new Recomendacion();
    $recomendacion->diagnostico_id = $request->diagnostico_id;
    $recomendacion->recomendacion = $request->recomendacion;
    $recomendacion->nombre_medico = $user->name; // Guardar el nombre del médico autenticado

    // Guardar la recomendación
    $recomendacion->save();

    return redirect()->route('medico.index')->with('success', 'Recomendación creada correctamente');
}

    // Mostrar una recomendacion específica
    public function show($id)
    {
        $recomendacion = Recomendacion::findOrFail($id);
        return view('recomendacion.show', compact('recomendacion'));
    }

    // Mostrar el formulario para editar una recomendacion
    public function edit($id)
    {
        $recomendacion = Recomendacion::findOrFail($id);
        return view('recomendacion.edit', compact('recomendacion'));
    }

    // Actualizar una recomendacion existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'diagnostico_id' => 'exists:diagnostico,id',
            'recomendacion' => 'string',
        ]);

        $recomendacion = Recomendacion::findOrFail($id);
        $recomendacion->update($request->all());
        return redirect()->route('recomendacion.index')->with('success', 'Recomendación actualizada correctamente');
    }

    // Eliminar una recomendacion
    public function destroy($id)
    {
        $recomendacion = Recomendacion::findOrFail($id);
        $recomendacion->delete();
        return redirect()->route('recomendacion.index')->with('success', 'Recomendación eliminada correctamente');
    }
}
