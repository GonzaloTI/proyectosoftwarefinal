<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medico;
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
        $this->validate(request(),['ci'=>'required',
                                                   'nombre'=>'required',
                                                   'a_paterno'=>'required',
                                                   'a_materno'=>'required',
                                                   'especialidad'=>'required',
                                                   'sexo'=>'required',
                                                   'telefono'=>'required',
                                                   'direccion'=>'required',
                                                    'user_id']);


        $user = Medico::create(request(['ci','nombre','a_paterno','a_materno','especialidad','sexo','telefono','direccion','user_id']));
        $user->estado='h';
       
        
        $user->save();

        return redirect()->route('admin.listarMedico');     
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
