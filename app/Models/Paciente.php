<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Paciente extends Model
{
    protected $table = 'pacientes';

    protected $fillable = [
        'usuario_id',
        'clinica_id',
        'fecha_nacimiento',
        'genero',
        'grupo_sanguineo',
        'contacto_emergencia',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    /**
     * Relación con el usuario (perfil).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Relación con la clínica.
     */
    public function clinica(): BelongsTo
    {
        return $this->belongsTo(Clinica::class, 'clinica_id');
    }

    /**
     * Relación con las citas del paciente.
     */
    public function citas(): HasMany
    {
        return $this->hasMany(Cita::class, 'paciente_id');
    }
}
