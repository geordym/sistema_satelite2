<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Operador extends Model
{
    use HasFactory;

    protected $table = "operadores";


    protected $fillable = [
        'nombre'
    ];


    public function procesos(): HasMany
    {
        return $this->hasMany(Proceso::class, 'operador_id');
    }



    public function pagos(): HasMany
    {
        return $this->hasMany(Pago::class, 'operador_id');
    }

}
