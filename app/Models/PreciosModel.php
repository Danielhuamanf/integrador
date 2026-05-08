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
        'id_zona_destino',
        'peso_base',
        'peso_tope',
        'alto_base',
        'alto_tope',
        'precio'
    ];

    // =========================
    // RELACIONES
    // =========================

    public function zonaOrigen()
    {
        return $this->belongsTo(Zona::class, 'id_zona_origen');
    }

    public function zonaDestino()
    {
        return $this->belongsTo(Zona::class, 'id_zona_destino');
    }

    // =========================
    // SCOPES (CLAVE)
    // =========================

    // Buscar tarifa aplicable
    public function scopeTarifa($query, $origen, $destino, $peso, $alto)
    {
        return $query
            ->where('id_zona_origen', $origen)
            ->where('id_zona_destino', $destino)
            ->where('peso_base', '<=', $peso)
            ->where('peso_tope', '>=', $peso)
            ->where('alto_base', '<=', $alto)
            ->where('alto_tope', '>=', $alto);
    }
}