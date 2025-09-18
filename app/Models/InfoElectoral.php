<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoElectoral extends Model
{
    use HasFactory;

    protected $table = 'infoelectoral';

    protected $fillable = [
        'id_zona',
        'id_puesto',
        'direccion',
        'mesa_vota',
        'fk_id_testigo'
    ];

    protected $casts = [
        'fk_id_testigo' => 'integer',
    ];

    // Relaciones
    public function zona()
    {
        return $this->belongsTo(Puesto::class, 'id_zona', 'zona');
    }

    public function puesto()
    {
        return $this->belongsTo(Puesto::class, 'id_puesto', 'id');
    }

    public function testigo()
    {
        return $this->belongsTo(Testigo::class, 'fk_id_testigo', 'id');
    }

    // Scopes para filtrar por tipo de cargo
    public function scopeCoordinadores($query)
    {
        return $query->where('mesa_vota', 'coordinador');
    }

    public function scopeLideres($query)
    {
        return $query->where('mesa_vota', 'lider');
    }

    public function scopePorZona($query, $zona)
    {
        return $query->where('id_zona', $zona);
    }

    public function scopePorPuesto($query, $puesto)
    {
        return $query->where('id_puesto', $puesto);
    }

    // Accessor para mostrar información completa
    public function getInfoCompletoAttribute()
    {
        return ucfirst($this->mesa_vota) . " - Zona {$this->id_zona} - Puesto {$this->id_puesto}";
    }

    // Método para verificar si es coordinador
    public function esCoordinador()
    {
        return $this->mesa_vota === 'coordinador';
    }

    // Método para verificar si es líder
    public function esLider()
    {
        return $this->mesa_vota === 'lider';
    }
}