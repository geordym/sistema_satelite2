<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Proceso extends Model
{
    use HasFactory;
    protected $table = "procesos";


    public function entrada(): BelongsTo
    {
        return $this->belongsTo(Entrada::class, 'entrada_id');
    }

    public function operador(): BelongsTo
    {
        return $this->belongsTo(Operador::class, 'operador_id');
    }


    public function actividad(): BelongsTo
    {
        return $this->belongsTo(Actividad::class, 'actividad_id');
    }

    public function calcularValor()
    {
        // Verificar si el proceso tiene una actividad asociada
        if ($this->actividad) {
            // Multiplicar la cantidad por el valor unitario de la actividad
            return $this->cantidad * $this->actividad->valor_unitario;
        }

        // Si no tiene actividad asociada, retornar 0 o null
        return 0;
    }

    public function pagos(): BelongsToMany
    {
        return $this->belongsToMany(Pago::class, 'pagos_procesos', 'proceso_id', 'pago_id');
    }

}
