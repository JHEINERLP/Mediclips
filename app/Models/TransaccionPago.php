<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaccionPago extends Model
{
    /**
     * La tabla asociada al modelo.
     */
    protected $table = 'transacciones_pagos';

    /**
     * Los atributos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'clinica_id',
        'monto',
        'estado_pago',
        'pagado_at',
    ];

    /**
     * Los atributos que deben ser casteados.
     */
    protected $casts = [
        'monto' => 'decimal:2',
        'pagado_at' => 'datetime',
    ];

    /**
     * Relación: la transacción pertenece a una clínica.
     */
    public function clinica(): BelongsTo
    {
        return $this->belongsTo(Clinica::class, 'clinica_id');
    }
}
