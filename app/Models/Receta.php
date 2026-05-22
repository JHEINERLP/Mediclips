<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Receta extends Model
{
    protected $table = 'recetas';

    protected $fillable = [
        'reporte_clinico_id',
        'instrucciones_generales',
    ];

    /**
     * Relación con el reporte clínico.
     */
    public function reporteClinico(): BelongsTo
    {
        return $this->belongsTo(ReporteClinico::class, 'reporte_clinico_id');
    }

    /**
     * Relación con las entregas de medicamentos asociadas a esta receta.
     */
    public function entregas(): HasMany
    {
        return $this->hasMany(EntregaMedicamento::class, 'receta_id');
    }
}
