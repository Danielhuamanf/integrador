<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{
    protected $table = 'zonas';
    protected $primaryKey = 'id_zona';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion'
    ];

    // =========================
    // RELACIONES
    // =========================

    // Envíos donde es origen
    public function enviosOrigen()
    {
        return $this->hasMany(Envio::class, 'id_zona_origen');
    }

    // Envíos donde es destino
    public function enviosDestino()
    {
        return $this->hasMany(Envio::class, 'id_zona_destino');
    }

    // Tarifas donde es zona origen
    public function preciosOrigen()
    {
        return $this->hasMany(Precio::class, 'id_zona_origen');
    }

    // Tarifas donde es zona destino
    public function preciosDestino()
    {
        return $this->hasMany(Precio::class, 'id_zona_destino');
    }
}