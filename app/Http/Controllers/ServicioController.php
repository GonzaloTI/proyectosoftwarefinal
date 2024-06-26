<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    //
    public function index(){
        $medicos = Medico::all();
        return view('servicio', compact('medicos'));
    }

}
