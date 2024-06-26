<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medico;
use App\Models\User;
class MedicoController extends Controller
{
  
    /*////// Crear al Medico /////*/

    /*Manda al view clienteRegister */
    public function ListarP(){
        $user = Medico::all();
        return view('medico.MedicoRegister', compact('user'));
    }


    /*Manda al view crearCliente */
    public function createMedico(){
        return view('medico.crearMedico');
    }



    /*Guarda los datos del cliente */
    public function storedMedico(Request $request){
     
     try{
        $this->validate(request(),['ci'=>'required',
                                                   'nombre'=>'required',
                                                   'a_paterno'=>'required',
                                                   'a_materno'=>'required',
                                                   'especialidad'=>'required',
                                                   'sexo'=>'required',
                                                   'telefono'=>'required',
                                                   'direccion'=>'required',
                                                    'user_id']);


        $usermedico = Medico::create(request(['ci','nombre','a_paterno','a_materno','especialidad','sexo','telefono','direccion']));
        $usermedico->estado='h';
       
        
      
        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => request('password'),
        ]);
        $user->role = 'medico';
        $user->save();
        $usermedico->user_id=$user->id;
        $usermedico->save();

        return redirect()->route('admin.listarMedico');   
    } catch (\Exception $e) {
        return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
    }
        
    }

    /*////// Elimina a un cliente //// */

    public function destroyMedico(Request $request,$id){
        $user = Medico::find($id);
        $user->delete();

        return redirect()->route('admin.listarMedico');
    }

    /*///// Edita un cliente////// */

    public function editMedico($id){
        $user = Medico::find($id);
        return view('medico.editarMedico',compact('user'));
    }

    /* cambia los datos al editar presionando el button */
    public function updateMedico(Request $request, $id){
        $user = Medico::find($id);
        $user->ci = $request->ci;
        $user->nombre = $request->nombre;
        $user->a_paterno = $request->a_paterno;
        $user->a_materno = $request->a_materno;
        $user->sexo = $request->sexo;
        $user->telefono = $request->telefono;
        $user->direccion = $request->direccion;
        $user->estado = $request->estado;
        $user->user_id = $request->user_id;

        $user->save();
        return redirect()->route('admin.listarMedico');

    }


}
