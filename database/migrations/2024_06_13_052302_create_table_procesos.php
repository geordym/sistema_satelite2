<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procesos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('entrada_id'); // Clave foránea para la relación
            $table->unsignedBigInteger('actividad_id'); // Campo para la cantidad
            $table->unsignedBigInteger('operador_id'); // Campo para la cantidad
            $table->unsignedBigInteger('cantidad'); // Campo para la cantidad
            $table->string('descripcion')->nullable(); // Campo para la descripción
            $table->dateTime('fecha_procesado'); // Campo para la fecha de entrada

            $table->timestamps();

            $table->foreign('actividad_id')->references('id')->on('actividades');
            $table->foreign('entrada_id')->references('id')->on('entradas');
            $table->foreign('operador_id')->references('id')->on('operadores');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('procesos');
    }
};
