<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnostico extends Model
{
    use HasFactory;
    protected $table = 'diagnostico'; // Especificar el nombre de la tabla si es diferente al convencional
    // Definir el nombre de la clave primaria
    
    protected $fillable = [
        'ci',
        'nombre',
        'a_paterno',
        'a_materno',
    ];

    // Aquí puedes definir relaciones con otros modelos si es necesario
}
