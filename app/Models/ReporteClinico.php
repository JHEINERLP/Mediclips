<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ReporteClinico extends Model
{
    protected $table = 'reportes_clinicos';

    protected $fillable = [
        'cita_id',
        'diagnostico',
        'plan_tratamiento',
    ];

    /**
     * Relación con la cita.
     */
    public function cita(): BelongsTo
    {
        return $this->belongsTo(Cita::class, 'cita_id');
    }

    /**
     * Relación con la receta médica asociada.
     */
    public function receta(): HasOne
    {
        return $this->hasOne(Receta::class, 'reporte_clinico_id');
    }
}
