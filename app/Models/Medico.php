<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    use HasFactory;
    protected $fillable =[
        'ci',
        'nombre',
        'a_paterno',
        'a_materno',
        'especialidad',
        'sexo',
        'telefono',
        'direccion',
        'estado',
        'user_id'
    ];
    
    public function user(){

            //relacion uno a uno
            return $this->hasOne('App\Models\User');

    }
}
