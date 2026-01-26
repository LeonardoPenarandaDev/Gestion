<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultadoMesa extends Model
{
    protected $table = 'resultados_mesas';

    protected $fillable = [
        'mesa_id',
        'testigo_id',
        'imagen_acta',
        'observacion',
        'total_votos',
        'estado',
    ];

    protected $casts = [
        'total_votos' => 'integer',
    ];

    public function mesa()
    {
        return $this->belongsTo(Mesa::class);
    }

    public function testigo()
    {
        return $this->belongsTo(Testigo::class);
    }
}
