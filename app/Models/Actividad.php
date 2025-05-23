<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Actividad extends Model
{
    use HasFactory;

    protected $table = "actividades";


    protected $fillable = [
        'nombre',
        'valor_unitario'
    ];

    public function procesos(): HasMany
    {
        return $this->hasMany(Proceso::class, 'actividad_id');
    }

}
