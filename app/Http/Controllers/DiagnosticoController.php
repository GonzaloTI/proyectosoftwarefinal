<?php

namespace App\Http\Controllers;
use App\Models\Diagnostico;
use App\Models\Ecografia;
use App\Models\Medico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
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


    public function createsolicitud()
    {
        return view('diagnosticos.solicitudAPI'); // Mostrar la vista para crear un nuevo diagnóstico
    }

    public function solicitudAPI(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validar que sea una imagen
        ]);
        $request->validate([
            'medico' => 'required|exists:medicos,id',
        ]);

        // Obtener el ID del médico seleccionado
        $medicoId = $request->input('medico');

        // Buscar al médico en la base de datos
        $medico = Medico::find($medicoId);

        // Verificar la imagen
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
           // dd('Imagen recibida', $imagen); // Punto de depuración
           $file = $request->file('imagen');
           $filename = time() . '_' . $imagen->getClientOriginalName();
           $filePath = $file->storeAs('public/documents', $filename);
            
           $filePath = Storage::url($filePath);

        } else {
            return redirect()->back()->with('error', 'Error al enviar la imagen a la API.');
            dd('No se recibió ninguna imagen'); // Punto de depuración
        }
    
        // Preparar los datos para enviar a la API externa
        $apiUrl = 'https://detect.roboflow.com/liver_ultrasound/10';
        $apiKey = 'ez0KYg4w4v0R1U0OkbWh';
    
        $base64Image = base64_encode(file_get_contents($imagen->path()));
    
        try {
          
        // Realizar la solicitud a la API usando HTTP Client de Laravel (Guzzle)
        $response = Http::withHeaders([
           'Content-Type' => 'application/x-www-form-urlencoded',
        ])->post($apiUrl . '?api_key=' . $apiKey , [ $base64Image] // Enviar la imagen codificada en base64 como 'file'
            );
      
         //   dd(' respuesta de la API', $response);
            // Manejar la respuesta de la API
            if ($response->successful()) {

                $responseData = $response->json();
             //   dd('Respuesta exitosa', $responseData); // Punto de depuración
                $jsonencore = json_encode($responseData);
                $dataApi = json_decode($jsonencore);

                $userId =  auth()->user()->id;

                $medicouser = $medico->user;

               $diagnosticonew = Diagnostico::create([
             
                'resultado_ia' => 'se ha detectado ..',
                'resultado'=> 'en espera',
                'estado'=> 'revision',
                'confidence'=> '80%',
                'data'=> $jsonencore ,
                'user_id_cliente' =>  $userId ,
                'user_id_medico'=> $medicouser->id,
                ]);

               $ecogrfianew =  Ecografia::create([
                    'path' => $filePath,
                    'id_diagnostico'=> $diagnosticonew->id,    
            ]);
             //  dd('Respuesta exitosa', $jsonencore);
                return view('servicioresultado', compact('dataApi','ecogrfianew','jsonencore'));
             //   return redirect()->back()->with('success', 'Imagen enviada correctamente. Respuesta: ' . json_encode($responseData));
            } else {
              //  dd('Error en la respuesta de la API', $response); // Punto de depuración
                return redirect()->back()->with('error', 'Error al enviar la imagen a la API.');
            }
        } catch (\Exception $e) {
          //  dd('Error de excepción', $e); // Punto de depuración
            return redirect()->back()->with('error', 'Error al conectar con la API: ' . $e->getMessage());
        }
    }
    

    



}
