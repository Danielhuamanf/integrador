<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DamModel extends Model
{
    protected $table = 'dam';
    protected $primaryKey = 'id_dam';

    public $timestamps = true;

    protected $fillable = [
        'id_envio',
        'numero_dam',
        'canal_control',
        'fecha_numeracion',
        'aduana',
        'estado'
    ];

    // =========================
    // RELACIONES
    // =========================

    // 1 DAM pertenece a 1 envío (1:1)
    public function envio()
    {
        return $this->belongsTo(Envio::class, 'id_envio');
    }

    // 1 DAM tiene muchos costos (tributos)
    public function costos()
    {
        return $this->hasMany(DamCosto::class, 'id_dam');
    }
}