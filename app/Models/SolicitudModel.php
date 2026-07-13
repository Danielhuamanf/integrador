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
        'fecha_cierre',

        'numero_tracking',
        'descripcion_tracking',

        'descripcion_estado_envio',

        'numero_dam',
        'anio_dam',
        'descripcion_dam',

        'tipo_documento',
        'descripcion_documento'
    ];
    public function cliente()
    {
        return $this->belongsTo(ClienteModel::class, 'id_cliente', 'id_cliente');
    }

    public function envio()
    {
        return $this->belongsTo(EnvioModel::class, 'id_envio', 'id_envio');
    }

}