<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pago extends Model
{
    use HasFactory;

    protected $table = "pagos";


    public function operador(): BelongsTo
    {
        return $this->belongsTo(Operador::class, 'operador_id'); // Cambié HasOne por BelongsTo
    }


    public function pagoProcesos(): HasMany
    {
        return $this->hasMany(PagoProceso::class, 'pago_id');
    }

    public function procesos(): BelongsToMany
    {
        return $this->belongsToMany(Proceso::class, 'pagos_procesos', 'pago_id', 'proceso_id');
    }




}
