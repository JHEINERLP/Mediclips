<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medicamento extends Model
{
    protected $table = 'medicamentos';

    protected $fillable = [
        'clinica_id',
        'nombre',
        'codigo_sku',
        'stock',
        'descripcion',
    ];

    protected $casts = [
        'stock' => 'integer',
    ];

    /**
     * Relación con la clínica.
     */
    public function clinica(): BelongsTo
    {
        return $this->belongsTo(Clinica::class, 'clinica_id');
    }

    /**
     * Relación con las entregas de este medicamento.
     */
    public function entregas(): HasMany
    {
        return $this->hasMany(EntregaMedicamento::class, 'medicamento_id');
    }
}
