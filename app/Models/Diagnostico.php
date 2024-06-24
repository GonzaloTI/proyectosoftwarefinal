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
        'id',
        'resultado_ia',
        'resultado',
        'estado',
        'confidence',
        'data',
        'user_id_cliente',
        'user_id_medico',
    ];

    // Aquí puedes definir relaciones con otros modelos si es necesario

    public function cliente()
    {
        return $this->belongsTo(User::class, 'user_id_cliente');
    }

    public function medico()
    {
        return $this->belongsTo(User::class, 'user_id_medico');
    }
    public function ecografias()
    {
        return $this->hasMany(Ecografia::class, 'id_diagnostico');
    }

}
