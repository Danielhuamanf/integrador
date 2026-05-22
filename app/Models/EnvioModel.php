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
        'alto',
        'ancho',
        'largo'
    ];

    // =========================
    // RELACIONES
    // =========================

    // Cliente
    public function detalle()
    {
        return $this->hasOne(
            EnvioDetalleModel::class,
            'id_envio',
            'id_envio'
        );
    }

   public function cliente()
    {
        return $this->belongsTo(
            ClienteModel::class,
            'id_cliente',
            'id_cliente'
        );
    }
    public function estado_envio()
    {
        return $this->belongsTo(
            EstadosEnvioModel::class,
            'estado',
            'id_estado'
        );
    }

    public function tipo()
    {
        return $this->belongsTo(
            TipoEnvioModel::class,
            'nombre',
            'id_tipo'
        );
    }
    // Zonas
    public function zonaOrigen()
    {
        return $this->belongsTo(ZonaModel::class, 'id_zona_origen');
    }

    public function zonaDestino()
    {
        return $this->belongsTo(ZonaModel::class, 'id_zona_destino');
    }

    // Almacenes
    public function almacenOrigen()
    {
        return $this->belongsTo(AlmacenModel::class, 'id_almacen_origen');
    }

    public function almacenDestino()
    {
        return $this->belongsTo(AlmacenModel::class, 'id_almacen_destino');
    }

      public function detalles()
    {
        return $this->hasMany(EnvioDetalleModel::class, 'id_envio');
    }
   
    // Documentos
    public function documentos()
    {
        return $this->hasMany(DocumentosModel::class, 'id_envio');
    }

    // Tracking
    public function tracking()
    {
        return $this->hasMany(TrackingModel::class, 'id_envio');
    }

    // Pagos
    public function pagos()
    {
        return $this->hasMany(PagosModel::class, 'id_envio');
    }

    // Costos logísticos
    public function costos()
    {
        return $this->hasMany(CostoEnvioModel::class, 'id_envio');
    }

    // DAM (1:1)
    public function dam()
    {
        return $this->hasOne(DamModel::class, 'id_envio');
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