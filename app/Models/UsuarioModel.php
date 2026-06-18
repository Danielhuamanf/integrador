<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\BackupToSqlite;
use App\Traits\Auditable;
class UsuarioModel extends Authenticatable
{
    use Notifiable;
    use BackupToSqlite;
     use Auditable;
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
    public function getAuthIdentifierName()
    {
    return 'id_usuario';
    }
}