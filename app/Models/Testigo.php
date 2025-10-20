<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testigo extends Model
{
    use HasFactory;

    protected $table = 'testigo';

    protected $fillable = [
        'fk_id_zona',
        'fk_id_puesto',
        'documento',
        'nombre',
        'mesas',
        'alias'
    ];

    protected $casts = [
        'mesas' => 'integer',
    ];

    /**
     * Relación con Puesto
     * fk_id_puesto almacena el ID del puesto (numérico)
     */
    public function puesto()
    {
        return $this->belongsTo(Puesto::class, 'fk_id_puesto', 'id');
    }

    /**
     * Relaciones opcionales
     */
    public function infoElectoral()
    {
        return $this->hasMany(InfoElectoral::class, 'fk_id_testigo', 'id');
    }

    public function infoTestigo()
    {
        return $this->hasMany(InfoTestigo::class, 'fk_id_testigo', 'id');
    }

    /**
     * Scopes para filtrar
     */
    public function scopePorZona($query, $zona)
    {
        return $query->where('fk_id_zona', $zona);
    }

    public function scopePorPuesto($query, $puesto)
    {
        return $query->where('fk_id_puesto', $puesto);
    }

    /**
     * Accessor para mostrar información completa
     */
    public function getTestigoCompletoAttribute()
    {
        return "{$this->nombre} - Zona {$this->fk_id_zona} - Puesto {$this->fk_id_puesto}" . 
               ($this->alias ? " ({$this->alias})" : "");
    }
}