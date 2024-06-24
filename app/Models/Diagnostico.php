<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnostico extends Model
{
    use HasFactory;

    protected $table = 'diagnostico';

    protected $fillable = [
        'ci',
        'nombre',
        'a_paterno',
        'a_materno',
        'user_id', // Asegúrate de incluir 'user_id' en $fillable
    ];

    // Definir la relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Definir la relación con el modelo Recomendacion
    public function recomendaciones()
    {
        return $this->hasMany(Recomendacion::class, 'diagnostico_id');
    }
}
