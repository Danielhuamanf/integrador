<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudModel extends Model
{
    protected $table='solicitudes';

    protected $primaryKey='id_solicitud';

    public $timestamps=true;

    protected $fillable=[

        'id_cliente',
        'id_envio',
        'tipo',
        'motivo',
        'estado',
        'respuesta',
        'aprobado_por',
        'fecha_aprobacion',
        'fecha_cierre'
    ];
}