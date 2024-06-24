<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiagnosticoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagnostico', function (Blueprint $table) {
            $table->id();
            $table->integer('ci');
            $table->string('nombre', 30);
            $table->string('a_paterno', 30);
            $table->string('a_materno', 30);
            $table->unsignedBigInteger('user_id'); // Campo para almacenar el ID del usuario
            $table->timestamps();

            // Definir la clave foránea con la tabla users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diagnostico');
    }
}
