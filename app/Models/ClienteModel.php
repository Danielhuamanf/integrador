<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClienteModel extends Model
{
    protected $table = 'cliente';
    protected $primaryKey = 'id_cliente';

    public $timestamps = true;

    protected $fillable = [
        'id_usuario',
        'tipo_persona',
        'nombre_completo',
        'correo',
        'telefono',
        'direccion',
        'ubigeo',
        'estado',
        'ruc',
        'nombre_comercial',
        'representante_legal',
        'dni'
    ];

    // =========================
    // RELACIONES
    // =========================

    // Cliente pertenece a un usuario (login)
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    // Cliente tiene muchos envíos
    public function envios()
    {
        return $this->hasMany(Envio::class, 'id_cliente');
    }
}