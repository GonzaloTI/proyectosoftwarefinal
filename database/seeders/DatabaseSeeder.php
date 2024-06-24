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

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(){
        // \App\Models\User::factory(10)->create();
        $user = new User;
        $user->name = 'admin';
        $user->email =  'admin@gmail.com';
        $user->password = '1234';
        $user->role = 'admin';
        $user->save();

        $user = new User;
        $user->name = 'medico';
        $user->email =  'medico@gmail.com';
        $user->password = '1234';
        $user->role = 'medico';
        $user->save();

        $user = new User;
        $user->name = 'Pedro';
        $user->email =  'pedro@gmail.com';
        $user->password = '1234';
        $user->role = 'medico';
        $user->save();

        $user = new User;
        $user->name = 'cliente';
        $user->email =  'cliente@gmail.com';
        $user->password = '1234';
        $user->role = 'cliente';
        $user->save();

        $user = new User;
        $user->name = 'yamil';
        $user->email =  'yamil@gmail.com';
        $user->password = '1234';
        $user->role = 'cliente';
        $user->save();
        

    }




}
