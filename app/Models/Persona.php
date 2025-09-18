<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $table = 'personas';

    protected $fillable = [
        'identificacion',
        'telefono',
        'direccion',
        'email',
        'ocupacion',
        'fecha_ingreso',
        'estado'
    ];

    protected $casts = [
        'fecha_ingreso' => 'date',
    ];

    // Relaciones - Una persona puede estar relacionada con la estructura electoral
    public function infoElectoralCoordinador()
    {
        return $this->hasMany(InfoElectoral::class, 'fk_id_testigo')
                    ->where('mesa_vota', 'coordinador');
    }

    public function infoElectoralLider()
    {
        return $this->hasMany(InfoElectoral::class, 'fk_id_testigo')
                    ->where('mesa_vota', 'lider');
    }

    // Scope para personas activas
    public function scopeActivas($query)
    {
        return $query->where('estado', 'activo');
    }

    // Accessor para mostrar nombre completo (usando identificación como referencia)
    public function getNombreCompletoAttribute()
    {
        return $this->identificacion . ' - ' . ($this->email ?: 'Sin email');
    }
}