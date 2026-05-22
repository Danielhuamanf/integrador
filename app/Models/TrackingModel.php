<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrackingModel extends Model
{
    protected $table = 'tracking';
    protected $primaryKey = 'id_tracking';

    public $timestamps = true;

    protected $fillable = [
        'id_envio',
        'id_estado',
        'ubicacion',
        'fecha',
        'comentario',
        'created_at',
        'updated_at'
    ];

    // =========================
    // RELACIONES
    // =========================

    // Pertenece a un envío
    public function envio()
    {
        return $this->belongsTo(EnvioModel::class, 'id_envio');
    }

    // Estado del evento
    public function estado()
    {
        return $this->belongsTo(EstadosEnvioModel::class, 'id_estado');
    }

    // Almacén (opcional, si implementaste esta FK)
    public function almacen()
    {
        return $this->belongsTo(AlmacenModel::class, 'id_almacen');
    }
}