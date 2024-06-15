<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Entrada extends Model
{
    use HasFactory;

    protected $table = "entradas";


    public function procesos(): HasMany
    {
        return $this->hasMany(Proceso::class, 'entrada_id');
    }

}
