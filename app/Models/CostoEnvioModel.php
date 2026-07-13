<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CostoEnvioModel extends Model
{
    protected $table = 'costos_envio';
    protected $primaryKey = 'id_costo';

    public $timestamps = true;

    protected $fillable = [
        'id_envio',
        'tipo_costo',
        'monto',
        'moneda',
        'descripcion'
    ];

    // =========================
    // RELACIONES
    // =========================

    // Pertenece a un envío
    public function envio()
    {
        return $this->belongsTo(Envio::class, 'id_envio');
    }
}