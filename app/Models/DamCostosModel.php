<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DamCostosModel extends Model
{
    protected $table = 'dam_costos';
    protected $primaryKey = 'id_costo';

    public $timestamps = true;

    protected $fillable = [
        'id_dam',
        'tipo_costo',
        'monto',
        'moneda',
        'descripcion'
    ];

    // =========================
    // RELACIONES
    // =========================

    // Pertenece a un DAM
    public function dam()
    {
        return $this->belongsTo(Dam::class, 'id_dam');
    }

    // Acceso directo al envío a través del DAM
    public function envio()
    {
        return $this->hasOneThrough(
            Envio::class,
            Dam::class,
            'id_dam',   // FK en dam_costos
            'id_envio', // FK en dam
            'id_dam',   // PK local (dam_costos)
            'id_envio'  // PK en dam
        );
    }
}