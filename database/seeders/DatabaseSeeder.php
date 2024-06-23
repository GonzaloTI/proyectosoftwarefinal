<?php

namespace Database\Seeders;

use App\Models\abogado;
use App\Models\almacen;
use App\Models\cliente;
use App\Models\factura;
use App\Models\Producto;
use Illuminate\Database\Seeder;

use App\Models\proveedor;
use App\Models\compra;
use App\Models\juece;
use App\Models\User;
use App\Models\rol;
use App\Models\suministro;
use App\Models\venta;
use App\Models\vista;
use App\Models\Subscription;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $user = new User;
        $user->name = 'admin';
        $user->email = 'admin@gmail.com';
        $user->password = '1234';
        $user->role = 'admin';
        $user->save();

        $user = new User;
        $user->name = 'medico';
        $user->email = 'medico@gmail.com';
        $user->password = '1234';
        $user->role = 'medico';
        $user->save();

        $user = new User;
        $user->name = 'cliente';
        $user->email = 'cliente@gmail.com';
        $user->password = '1234';
        $user->role = 'cliente';
        $user->save();

        // Agregar suscripcion al cliente
        $subscription = new Subscription;
        $subscription->user_id = 3;
        $subscription->paypal_plan_id = 'P-4JU64663JX8791442L5ZQZ7I';
        $subscription->paypal_agreement_id = 'I-0YJ9XJ1XJXJX';
        $subscription->status = 'active';
        $subscription->start_date = date('Y-m-d');
        $subscription->end_date = date('Y-m-d', strtotime('+1 month'));
        $subscription->save();

        $user = new User;
        $user->name = 'cliente dos';
        $user->email = 'cliente2@gmail.com';
        $user->password = '1234';
        $user->role = 'cliente';
        $user->save();


    }




}
