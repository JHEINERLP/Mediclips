<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaccionPago extends Model
{
    use HasFactory;

    protected $table = 'transacciones_pagos';

    protected $fillable = [
        'clinica_id',
        'monto',
        'estado_pago',
        'pagado_at'
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'pagado_at' => 'datetime',
    ];

    public function clinica()
    {
        return $this->belongsTo(Clinica::class);
    }
}