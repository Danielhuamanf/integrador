<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadosEnvioModel extends Model
{
    protected $table = 'estados_envio';
    protected $primaryKey = 'id_estado';

    public $timestamps = false; // tu tabla no tiene timestamps

    protected $fillable = [
        'nombre'
    ];

    // =========================
    // RELACIONES
    // =========================

    // Un estado puede estar en muchos envíos
    public function envios()
    {
        return $this->hasMany(Envio::class, 'estado');
    }

    // Un estado puede estar en muchos eventos de tracking
    public function tracking()
    {
        return $this->hasMany(Tracking::class, 'id_estado');
    }
}