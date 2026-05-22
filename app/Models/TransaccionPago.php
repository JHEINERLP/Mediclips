<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaccionPago extends Model
{
    protected $table = 'transacciones_pagos';

    protected $fillable = [
        'clinica_id',
        'monto',
        'estado_pago',
        'pagado_at',
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'pagado_at' => 'datetime',
    ];

    /**
     * Relación con la clínica.
     */
    public function clinica(): BelongsTo
    {
        return $this->belongsTo(Clinica::class, 'clinica_id');
    }
}
