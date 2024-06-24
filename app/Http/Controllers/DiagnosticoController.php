<?php

namespace App\Http\Controllers;
use App\Models\Diagnostico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

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

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'ci' => 'required|integer',
    //         'nombre' => 'required|string|max:30',
    //         'a_paterno' => 'required|string|max:30',
    //         'a_materno' => 'required|string|max:30',
           
    //     ]);
           
    //     Diagnostico::create($request->all()); // Crear un nuevo diagnóstico en la base de datos
    //     return redirect()->route('diagnosticos.create')->with('success', 'Diagnóstico creado exitosamente.');
    // }
    public function store(Request $request)
{
    $request->validate([
        'ci' => 'required|integer',
        'nombre' => 'required|string|max:30',
        'a_paterno' => 'required|string|max:30',
        'a_materno' => 'required|string|max:30',
    ]);

    // Obtener el ID del usuario autenticado
    $userId = Auth::id();

    // Crear un nuevo diagnóstico en la base de datos con el ID del usuario
    Diagnostico::create([
        'ci' => $request->ci,
        'nombre' => $request->nombre,
        'a_paterno' => $request->a_paterno,
        'a_materno' => $request->a_materno,
        'user_id' => $userId, // Asignar el ID del usuario autenticado
    ]);

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



    public function solicitudAPI(Request $request)
        {
            // Validar la solicitud
            $request->validate([
                'ci' => 'required|numeric',
                'nombre' => 'required|string',
                'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validar que sea una imagen
            ]);
    
            // Guardar la imagen en el almacenamiento de Laravel (opcional, depende de tu caso de uso)
            if ($request->hasFile('imagen')) {
                $imagen = $request->file('imagen');
                // Aquí podrías guardar la imagen en el almacenamiento si es necesario
            }
    
            // Preparar los datos para enviar a la API externa
            $apiUrl = 'https://detect.roboflow.com/liver_ultrasound/10';
            $apiKey = 'ez0KYg4w4v0R1U0OkbWh';
    
            // Configurar los datos a enviar
            $formData = [
                'api_key' => $apiKey,
                'file' => $request->file('imagen'), // Asumiendo que 'imagen' es el nombre del campo file en el formulario
            ];
    
            // Realizar la solicitud a la API usando HTTP Client de Laravel
            try {
                $response = Http::post($apiUrl, $formData);
    
                // Manejar la respuesta de la API
                if ($response->successful()) {
                    // Procesar la respuesta según tus necesidades
                    $responseData = $response->json();
                    return redirect()->back()->with('success', 'Imagen enviada correctamente. Respuesta: ' . json_encode($responseData));
                } else {
                    // Manejar el caso de error de la API
                    return redirect()->back()->with('error', 'Error al enviar la imagen a la API.');
                }
            } catch (\Exception $e) {
                // Capturar y manejar errores de conexión u otros errores
                return redirect()->back()->with('error', 'Error al conectar con la API: ' . $e->getMessage());
            }
        }

    



}
