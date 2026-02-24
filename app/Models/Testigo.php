<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Testigo extends Model
{
    use HasFactory;

    protected $table = 'testigo';

    protected $fillable = [
        'user_id',
        'fk_id_zona',
        'fk_id_puesto',
        'documento',
        'nombre',
        'alias'
    ];

    protected $casts = [
        // Removed 'mesas' cast to prevent conflict with mesas relationship
    ];

    /**
     * Relación con User
     * Un testigo puede estar vinculado a un usuario del sistema
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

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
     * Relación con Mesas
     * Un testigo puede tener múltiples mesas
     */
    public function mesas()
    {
        return $this->hasMany(Mesa::class, 'testigo_id', 'id');
    }

    /**
     * Relación con Resultados de Mesas
     * Un testigo puede reportar resultados para múltiples mesas
     */
    public function resultadosMesas()
    {
        return $this->hasMany(ResultadoMesa::class, 'testigo_id', 'id');
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

    /**
     * Accessor para obtener array de números de mesa asignados
     *
     * IMPORTANTE: Este accessor requiere que la relación 'mesas' esté cargada
     * mediante eager loading para evitar N+1 queries.
     *
     * Uso correcto:
     *   $testigo = Testigo::with('mesas')->find($id);
     *   $numerosMesas = $testigo->mesas_asignadas;
     *
     * @return array Array de números de mesa
     */
    public function getMesasAsignadasAttribute()
    {
        // Verificar si la relación está cargada para prevenir N+1 queries
        if (!$this->relationLoaded('mesas')) {
            // Si no está cargada, cargarla ahora (con advertencia en log)
            if (config('app.debug')) {
                Log::warning('Relación "mesas" no precargada en accessor getMesasAsignadasAttribute', [
                    'testigo_id' => $this->id,
                    'trace' => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3)
                ]);
            }
            $this->load('mesas');
        }

        return $this->mesas->pluck('numero_mesa')->toArray();
    }

}