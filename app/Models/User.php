<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);

    }
    public function venta()
    {
        //relacion uno a muchos con venta ,la llave 
        // de user se va a venta
        return $this->hasMany('App\Models\venta');
    }

    public function subscribed()
    {
        return $this->subscriptions()
            ->where('status', 'active') // Asume que 'active' es el estado de una suscripción activa
            ->where('end_date', '>', now()) // Asume que 'end_date' es la fecha de finalización de la suscripción
            ->exists();
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function diagnosticosCliente()
    {
        return $this->hasMany(Diagnostico::class, 'user_id_cliente');
    }

    public function diagnosticosMedico()
    {
        return $this->hasMany(Diagnostico::class, 'user_id_medico');
    }

    public function medicos()
    {
        return $this->hasMany(Medico::class);
    }
}
