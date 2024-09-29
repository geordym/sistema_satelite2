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
        Schema::table('pagos_procesos', function (Blueprint $table) {
            $table->string('actividad')->nullable(); // Cambia 'string' y 'nullable' según lo que necesites
            $table->text('descripcion')->nullable(); // Cambia 'text' y 'nullable' según lo que necesites
            $table->date('fecha_procesado')->nullable(); // Cambia 'date' y 'nullable' según lo que necesites
            $table->integer('cantidad')->nullable(); // Cambia 'integer' y 'nullable' según lo necesites
            $table->decimal('valor_actividad', 10, 2)->nullable(); // Cambia 'decimal' y 'nullable' según lo necesites
            $table->decimal('total', 10, 2)->nullable(); // Cambia 'decimal' y 'nullable' según lo necesites
        });
    }

    public function down()
    {
        Schema::table('pagos_procesos', function (Blueprint $table) {
            $table->dropColumn('actividad');
            $table->dropColumn('descripcion');
            $table->dropColumn('fecha_procesado');
            $table->dropColumn('cantidad');
            $table->dropColumn('valor_actividad');
            $table->dropColumn('total');
        });
    }
};
