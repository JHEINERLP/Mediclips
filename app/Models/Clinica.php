<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clinica extends Model
{
    protected $table = 'clinicas';

    protected $fillable = [
        'nombre',
        'subdominio',
        'logo_ruta',
        'banner_ruta',
        'plan_suscripcion',
        'estado',
        'vigente_hasta',
    ];

    protected $casts = [
        'vigente_hasta' => 'datetime',
    ];

    public function usuarios()
    {
        return $this->hasMany(User::class, 'clinica_id');
    }

    public function medicos()
    {
        return $this->hasMany(Medico::class, 'clinica_id');
    }

    public function pacientes()
    {
        return $this->hasMany(Paciente::class, 'clinica_id');
    }

    public function citas()
    {
        return $this->hasMany(Cita::class, 'clinica_id');
    }

    public function medicamentos()
    {
        return $this->hasMany(Medicamento::class, 'clinica_id');
    }

    public function transaccionesPago()
    {
        return $this->hasMany(TransaccionPago::class, 'clinica_id');
    }
}
