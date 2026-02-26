<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VotoCandidato extends Model
{
    protected $table = 'votos_candidatos';

    protected $fillable = [
        'resultado_mesa_id',
        'candidato_id',
        'votos',
    ];

    protected $casts = [
        'votos' => 'integer',
    ];

    public function resultadoMesa()
    {
        return $this->belongsTo(ResultadoMesa::class);
    }

    public function candidato()
    {
        return $this->belongsTo(Candidato::class);
    }
}
