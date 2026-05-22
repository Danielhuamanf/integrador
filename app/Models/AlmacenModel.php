<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlmacenModel extends Model
{
    protected $table = 'almacen';
    protected $primaryKey = 'id_almacen';

    public $timestamps = true;

    protected $fillable = [
        'nombre_almacen',
        'direccion',
        'nombre_responsable',
        'numero_responsable',
        'tipo',
        'estado',
        'capacidad_m3',
        'id_zona'
    ];

    // =========================
    // RELACIONES
    // =========================

    // Envíos donde es almacén de origen
    public function zona()
    {
        return $this->belongsTo(
            ZonasModel::class,
            'id_zona',
            'id_zona'
        );
    }
    public function enviosOrigen()
    {
        return $this->hasMany(Envio::class, 'id_almacen_origen');
    }

    // Envíos donde es almacén destino
    public function enviosDestino()
    {
        return $this->hasMany(Envio::class, 'id_almacen_destino');
    }

    // Tracking asociado (si implementaste almacén en tracking)
    public function tracking()
    {
        return $this->hasMany(Tracking::class, 'id_almacen');
    }
}