<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puesto extends Model
{
    use HasFactory;

    protected $table = 'puesto';

    protected $fillable = [
        'zona',
        'puesto',
        'nombre',
        'direccion',
        'total_mesas',
        'alias'
    ];

    protected $casts = [
        'total_mesas' => 'integer',
    ];

    // Relaciones
    public function testigos()
    {
        return $this->hasMany(Testigo::class, 'fk_id_puesto', 'id');
    }

    public function infoElectoral()
    {
        return $this->hasMany(InfoElectoral::class, 'id_puesto', 'id');
    }

    public function infoTestigo()
    {
        return $this->hasMany(InfoTestigo::class, 'id_puesto', 'id');
    }

    // Scope para filtrar por zona
    public function scopePorZona($query, $zona)
    {
        return $query->where('zona', $zona);
    }

    // Accessor para mostrar información completa del puesto
    public function getPuestoCompletoAttribute()
    {
        return "Zona {$this->zona} - Puesto {$this->puesto}: {$this->nombre}";
    }

    // Accessor para el código del puesto
    public function getCodigoPuestoAttribute()
    {
        return $this->zona . '-' . $this->puesto;
    }
}