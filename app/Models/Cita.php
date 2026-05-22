<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cita extends Model
{
    protected $table = 'citas';

    protected $fillable = [
        'clinica_id',
        'paciente_id',
        'medico_id',
        'fecha_hora',
        'estado',
        'motivo',
    ];

    protected $casts = [
        'fecha_hora' => 'datetime',
    ];

    /**
     * Relación con la clínica.
     */
    public function clinica(): BelongsTo
    {
        return $this->belongsTo(Clinica::class, 'clinica_id');
    }

    /**
     * Relación con el paciente.
     */
    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    /**
     * Relación con el médico.
     */
    public function medico(): BelongsTo
    {
        return $this->belongsTo(Medico::class, 'medico_id');
    }

    /**
     * Relación con el reporte clínico.
     */
    public function reporteClinico(): HasOne
    {
        return $this->hasOne(ReporteClinico::class, 'cita_id');
    }
}
