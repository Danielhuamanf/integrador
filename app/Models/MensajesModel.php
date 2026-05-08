<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MensajesModel extends Model
{
    protected $table = 'mensajes';
    protected $primaryKey = 'id_mensaje';

    public $timestamps = false; // si solo tienes created_at

    protected $fillable = [
        'id_usuario',
        'mensaje',
        'estado'
    ];

    // =========================
    // RELACIONES
    // =========================

    // Mensaje pertenece a un usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    // =========================
    // SCOPES
    // =========================

    public function scopeNoLeidos($query)
    {
        return $query->where('estado', 'no_leido');
    }

    public function scopeLeidos($query)
    {
        return $query->where('estado', 'leido');
    }
}