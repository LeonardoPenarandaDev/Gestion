<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    use HasFactory;

    protected $table = 'mesas';

    protected $fillable = [
        'testigo_id',
        'puesto_id',
        'numero_mesa',
    ];

    protected $casts = [
        'numero_mesa' => 'integer',
    ];

    /**
     * Relación con Testigo
     * Una mesa pertenece a un testigo
     */
    public function testigo()
    {
        return $this->belongsTo(Testigo::class, 'testigo_id', 'id');
    }

    /**
     * Relación con Puesto
     * Una mesa pertenece a un puesto
     */
    public function puesto()
    {
        return $this->belongsTo(Puesto::class, 'puesto_id', 'id');
    }

    /**
     * Relación con ResultadoMesa (un resultado por elección)
     */
    public function resultados()
    {
        return $this->hasMany(ResultadoMesa::class, 'mesa_id', 'id');
    }

    /**
     * Resultado para una elección específica (compatibilidad legacy si se necesita)
     */
    public function resultado()
    {
        return $this->hasOne(ResultadoMesa::class, 'mesa_id', 'id');
    }

    /**
     * Scope para filtrar por testigo
     */
    public function scopePorTestigo($query, $testigoId)
    {
        return $query->where('testigo_id', $testigoId);
    }

    /**
     * Scope para filtrar por puesto
     */
    public function scopePorPuesto($query, $puestoId)
    {
        return $query->where('puesto_id', $puestoId);
    }
}

