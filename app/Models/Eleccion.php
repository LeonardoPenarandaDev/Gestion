<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eleccion extends Model
{
    protected $table = 'elecciones';

    protected $fillable = [
        'nombre',
        'fecha',
        'tipo_cargo',
        'descripcion',
        'color',
        'activa',
    ];

    protected $casts = [
        'fecha'  => 'date',
        'activa' => 'boolean',
    ];

    public function candidatos()
    {
        return $this->hasMany(Candidato::class)->orderBy('orden');
    }

    public function candidatosActivos()
    {
        return $this->hasMany(Candidato::class)->where('activo', true)->orderBy('orden');
    }

    public function scopeActivas($query)
    {
        return $query->where('activa', true);
    }
}
