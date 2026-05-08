<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnvioModel extends Model
{
    protected $table = 'envio';
    protected $primaryKey = 'id_envio';

    public $timestamps = true;

    protected $fillable = [
        'id_cliente',
        'id_zona_origen',
        'id_zona_destino',
        'id_almacen_origen',
        'id_almacen_destino',
        'peso',
        'volumen',
        'descripcion',
        'valor_declarado',
        'tipo_envio',
        'estado',
        'fecha_envio',
        'fecha_entrega',
        'total_estimado',
        'total_real',
        'total_pagado'
    ];

    // =========================
    // RELACIONES
    // =========================

    // Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    // Zonas
    public function zonaOrigen()
    {
        return $this->belongsTo(Zona::class, 'id_zona_origen');
    }

    public function zonaDestino()
    {
        return $this->belongsTo(Zona::class, 'id_zona_destino');
    }

    // Almacenes
    public function almacenOrigen()
    {
        return $this->belongsTo(Almacen::class, 'id_almacen_origen');
    }

    public function almacenDestino()
    {
        return $this->belongsTo(Almacen::class, 'id_almacen_destino');
    }

    // Tipo de envío
    public function tipo()
    {
        return $this->belongsTo(TipoEnvio::class, 'tipo_envio');
    }

    // Estado
    public function estadoEnvio()
    {
        return $this->belongsTo(EstadoEnvio::class, 'estado');
    }

    // Detalle de productos
    public function detalles()
    {
        return $this->hasMany(EnvioDetalle::class, 'id_envio');
    }

    // Documentos
    public function documentos()
    {
        return $this->hasMany(Documento::class, 'id_envio');
    }

    // Tracking
    public function tracking()
    {
        return $this->hasMany(Tracking::class, 'id_envio');
    }

    // Pagos
    public function pagos()
    {
        return $this->hasMany(Pago::class, 'id_envio');
    }

    // Costos logísticos
    public function costos()
    {
        return $this->hasMany(CostoEnvio::class, 'id_envio');
    }

    // DAM (1:1)
    public function dam()
    {
        return $this->hasOne(Dam::class, 'id_envio');
    }

    // =========================
    // MÉTODOS ÚTILES
    // =========================

    // Total costos logísticos
    public function totalCostos()
    {
        return $this->costos()->sum('monto');
    }

    // Total pagos
    public function totalPagado()
    {
        return $this->pagos()->sum('monto');
    }

    // Total costos DAM
    public function totalDam()
    {
        return $this->dam ? $this->dam->costos()->sum('monto') : 0;
    }
}