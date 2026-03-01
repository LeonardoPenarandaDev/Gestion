<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidato extends Model
{
    protected $table = 'candidatos';

    protected $fillable = [
        'eleccion_id',
        'nombre',
        'tipo',
        'cargo',
        'orden',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function eleccion()
    {
        return $this->belongsTo(Eleccion::class);
    }

    public function votosCandidatos()
    {
        return $this->hasMany(VotoCandidato::class);
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true)->orderBy('orden');
    }

    public function scopeCompetencia($query)
    {
        return $query->where('tipo', 'competencia');
    }

    public function scopePropio($query)
    {
        return $query->where('tipo', 'propio');
    }
}
