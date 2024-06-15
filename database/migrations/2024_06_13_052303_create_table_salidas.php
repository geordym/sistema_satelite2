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
        Schema::create('salidas', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion'); // Campo para la descripción
            $table->integer('cantidad'); // Campo para la cantidad
            $table->dateTime('fecha_salida'); // Campo para la fecha de entrada
            $table->unsignedBigInteger('entrada_id'); // Clave foránea para la relación
            $table->timestamps(); // Campos created_at y updated_at para la fecha de creación y actualización

            $table->foreign('entrada_id')->references('id')->on('entradas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salidas');
    }
};
