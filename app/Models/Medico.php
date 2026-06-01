<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    protected $table = 'medicos';

    protected $fillable = [
        'user_id',
        'clinica_id',
        'especialidad_id',
        'numero_licencia',
        'biografia',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function clinica()
    {
        return $this->belongsTo(Clinica::class, 'clinica_id');
    }

    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class, 'especialidad_id');
    }

    public function horarios()
    {
        return $this->hasMany(Horario::class, 'medico_id');
    }

    public function citas()
    {
        return $this->hasMany(Cita::class, 'medico_id');
    }
}
