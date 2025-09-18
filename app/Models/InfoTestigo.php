<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoTestigo extends Model
{
    use HasFactory;

    protected $table = 'infotestigo';

    protected $fillable = [
        'id_zona',
        'id_puesto',
        'direccion',
        'mesa_testigo',
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

    // Scopes para filtros
    public function scopePorZona($query, $zona)
    {
        return $query->where('id_zona', $zona);
    }

    public function scopePorPuesto($query, $puesto)
    {
        return $query->where('id_puesto', $puesto);
    }

    public function scopePorMesa($query, $mesa)
    {
        return $query->where('mesa_testigo', $mesa);
    }

    // Accessor para mostrar información completa
    public function getInfoCompletoAttribute()
    {
        return "Mesa {$this->mesa_testigo} - Zona {$this->id_zona} - Puesto {$this->id_puesto}";
    }
}