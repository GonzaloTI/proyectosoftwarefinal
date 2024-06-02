<?php

namespace App\Http\Controllers;
use App\Models\Diagnostico;
use Illuminate\Http\Request;

class DiagnosticoController extends Controller
{
    public function index()
    {
        $diagnosticos = Diagnostico::all(); // Obtener todos los diagnósticos de la base de datos
        return view('diagnosticos.index', compact('diagnosticos')); // Mostrar la vista index con los diagnósticos
    }

    public function create()
    {
        return view('diagnosticos.create'); // Mostrar la vista para crear un nuevo diagnóstico
    }

    public function store(Request $request)
    {
        $request->validate([
            'ci' => 'required|integer',
            'nombre' => 'required|string|max:30',
            'a_paterno' => 'required|string|max:30',
            'a_materno' => 'required|string|max:30',
        ]);

        Diagnostico::create($request->all()); // Crear un nuevo diagnóstico en la base de datos
        return redirect()->route('diagnosticos.create')->with('success', 'Diagnóstico creado exitosamente.');
    }

    public function show($id)
    {
        $diagnostico = Diagnostico::find($id); // Obtener el diagnóstico con el ID proporcionado
        return view('diagnosticos.show', compact('diagnostico')); // Mostrar la vista show con el diagnóstico
    }

    public function edit($id)
    {
        $diagnostico = Diagnostico::find($id); // Obtener el diagnóstico con el ID proporcionado
        return view('diagnosticos.edit', compact('diagnostico')); // Mostrar la vista edit con el diagnóstico
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ci' => 'required|integer',
            'nombre' => 'required|string|max:30',
            'a_paterno' => 'required|string|max:30',
            'a_materno' => 'required|string|max:30',
        ]);

        Diagnostico::find($id)->update($request->all()); // Actualizar el diagnóstico con los datos proporcionados
        return redirect()->route('diagnosticos.index')->with('success', 'Diagnóstico actualizado exitosamente.');
    }

    public function destroy($id)
    {
        Diagnostico::destroy($id); // Eliminar el diagnóstico con el ID proporcionado
        return redirect()->route('diagnosticos.index')->with('success', 'Diagnóstico eliminado exitosamente.');
    }
}
