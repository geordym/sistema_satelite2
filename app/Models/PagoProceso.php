<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PagoProceso extends Model
{
    use HasFactory;

    protected $table = "pagos_procesos";

    protected $fillable = [
        'pago_id',
        'proceso_id',
        'actividad',
        'descripcion',
        'fecha_procesado',
        'cantidad',
        'valor_actividad',
        'total'
    ];


    public function procesos(): BelongsToMany
    {
        return $this->belongsToMany(Proceso::class, 'pagos_procesos', 'pago_id', 'proceso_id');
    }


}
