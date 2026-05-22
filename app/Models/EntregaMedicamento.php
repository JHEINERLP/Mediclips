<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EntregaMedicamento extends Model
{
    protected $table = 'entregas_medicamentos';

    protected $fillable = [
        'receta_id',
        'medicamento_id',
        'farmaceutico_id',
        'cantidad_entregada',
        'entregado_at',
    ];

    protected $casts = [
        'cantidad_entregada' => 'integer',
        'entregado_at' => 'datetime',
    ];

    /**
     * Relación con la receta.
     */
    public function receta(): BelongsTo
    {
        return $this->belongsTo(Receta::class, 'receta_id');
    }

    /**
     * Relación con el medicamento despachado.
     */
    public function medicamento(): BelongsTo
    {
        return $this->belongsTo(Medicamento::class, 'medicamento_id');
    }

    /**
     * Relación con el usuario farmacéutico que realizó el despacho.
     */
    public function farmaceutico(): BelongsTo
    {
        return $this->belongsTo(User::class, 'farmaceutico_id');
    }
}
