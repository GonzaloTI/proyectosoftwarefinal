<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cliente;

class RegisterController extends Controller{

    public function create(){

        return view('auth.register');
    }

    public function store(){

        $this->validate(request(),['ci'=>'required',
        'nombre'=>'required',
        'a_paterno'=>'required',
        'a_materno'=>'required',
        'sexo'=>'required',
        'telefono'=>'required',
        'direccion'=>'required']);

        $Client = Cliente::create(request(['ci','nombre','a_paterno','a_materno','sexo','telefono','direccion']));
        $Client->estado='h';
      
        $this->validate(request(),['name'=>'required','email'=>'required|email','password'=>'required|confirmed',]);
       
        $user = User::create(request(['name','email','password']));
        $user->role='cliente';
      
        $Client->user_id=$user->id;
        $user->save();
        $Client->save();







     //   auth()->login($user);
        return redirect()->to('/login');
    }
    
}
