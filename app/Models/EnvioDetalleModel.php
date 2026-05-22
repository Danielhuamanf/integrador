<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnvioDetalleModel extends Model
{
    protected $table = 'envio_detalle';

    protected $primaryKey = 'id_detalle';

    protected $fillable = [

        'id_envio',
        'zona_origen',
        'zona_destino',
        'peso',
        'alto',
        'ancho',
        'largo',
        'tipo_envio',
        'categoria',
        'descripcion'

    ];

    // =========================
    // RELACIONES
    // =========================

    // Cliente
    
}