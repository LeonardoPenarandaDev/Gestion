<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coordinador extends Model
{
    protected $table = 'coordinadores';

    protected $fillable = [
        'user_id',
        'fk_id_zona',
        'fk_id_puesto',
        'documento',
        'nombre',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function puesto()
    {
        return $this->belongsTo(Puesto::class, 'fk_id_puesto');
    }

    public function mesas()
    {
        return $this->hasMany(Mesa::class, 'puesto_id', 'fk_id_puesto');
    }
}
