<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreciosModel extends Model
{
    protected $table = 'precios';
    protected $primaryKey = 'id_precio';

    public $timestamps = false; // normalmente no necesitas timestamps aquí

    protected $fillable = [
        'id_zona_origen',
        'id_zona_dest', 
        'peso_base',
        'peso_tope',
        'alto_base',
        'alto_tope',
        'ancho_base',
        'ancho_tope',
        'largo_base',
        'largo_tope',
        'moneda',
        'tipo_envio',
        'monto',
        'created_at','updated_at'
    ];

    // =========================
    // RELACIONES
    // =========================

    public function zonaOrigen()
    {
        return $this->belongsTo(ZonasModel::class, 'id_zona_origen');
    }

    public function zonaDestino()
    {
        return $this->belongsTo(ZonasModel::class, 'id_zona_dest');
    }

    // =========================
    // SCOPES (CLAVE)
    // =========================

    // Buscar tarifa aplicable
    public function scopeTarifa(
        $query,
        $origen,
        $destino,
        $peso,
        $alto,
        $ancho,
        $largo,
        $tipoEnvio
    ) {
         return $query

        ->where('id_zona_origen', $origen)

        ->where('id_zona_dest', $destino)

        ->where('tipo_envio', $tipoEnvio)

        ->where('peso_base', '<=', $peso)
        ->where('peso_tope', '>=', $peso)

        ->where('alto_base', '<=', $alto)
        ->where('alto_tope', '>=', $alto)

        ->where('ancho_base', '<=', $ancho)
        ->where('ancho_tope', '>=', $ancho)

        ->where('largo_base', '<=', $largo)
        ->where('largo_tope', '>=', $largo);
    }
}