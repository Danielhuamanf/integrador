<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UsuarioModel extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';

    public $timestamps = true;

    protected $fillable = [
        'username',
        'correo',
        'password',
        'estado',
        'rol',
        'updated_at',
        'created_at'
    ];

    protected $hidden = [
        'password'
    ];

    // =========================
    // RELACIONES
    // =========================

    // Usuario puede ser un cliente
    public function cliente()
    {
        return $this->hasOne(Cliente::class, 'id_usuario');
    }

    // Usuario puede tener mensajes
    public function mensajes()
    {
        return $this->hasMany(Mensaje::class, 'id_usuario');
    }
}