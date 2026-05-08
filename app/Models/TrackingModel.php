<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    protected $table = 'tracking';
    protected $primaryKey = 'id_tracking';

    public $timestamps = true;

    protected $fillable = [
        'id_envio',
        'id_estado',
        'id_almacen',
        'descripcion',
        'fecha_evento'
    ];

    // =========================
    // RELACIONES
    // =========================

    // Pertenece a un envío
    public function envio()
    {
        return $this->belongsTo(Envio::class, 'id_envio');
    }

    // Estado del evento
    public function estado()
    {
        return $this->belongsTo(EstadoEnvio::class, 'id_estado');
    }

    // Almacén (opcional, si implementaste esta FK)
    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'id_almacen');
    }
}