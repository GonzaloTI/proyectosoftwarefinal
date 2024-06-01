<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cliente extends Model
{
    use HasFactory;


    //obligatorio para editar 

    protected $fillable =[
        'ci',
        'nombre',
        'a_paterno',
        'a_materno',
        'sexo',
        'telefono',
        'direccion',
        'estado',
        'user_id'
      
    ];


    public function venta(){
        //relacion uno a muchos 
        //un cliente tendra muchas ventas
        return $this->hasMany('App\Models\venta');
    }

}
