<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cliente;

class RegisterController extends Controller{

    public function create(){

        return view('auth.register');
    }

    public function store()
    {
        try {
            $this->validate(request(), [
                'ci' => 'required',
                'nombre' => 'required',
                'a_paterno' => 'required',
                'a_materno' => 'required',
                'sexo' => 'required',
                'telefono' => 'required',
                'direccion' => 'required',
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required|confirmed',
            ]);
    
            $Client = Cliente::create(request(['ci', 'nombre', 'a_paterno', 'a_materno', 'sexo', 'telefono', 'direccion']));
            $Client->estado = 'h';
    
            $user = User::create([
                'name' => request('name'),
                'email' => request('email'),
                'password' => request('password'),
            ]);
            $user->role = 'cliente';
            $Client->user_id = $user->id;
            $user->save();
            $Client->save();
    
            return redirect()->to('/login');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }
    
    
}
