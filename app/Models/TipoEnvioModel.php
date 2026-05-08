<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoEnvio extends Model
{
    protected $table = 'tipo_envio';
    protected $primaryKey = 'id_tipo';

    public $timestamps = false;

    protected $fillable = [
        'nombre'
    ];

    // =========================
    // RELACIONES
    // =========================

    // Un tipo de envío puede tener muchos envíos
    public function envios()
    {
        return $this->hasMany(Envio::class, 'tipo_envio');
    }
}