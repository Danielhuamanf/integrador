<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\BackupToSqlite;
class UsuarioModel extends Authenticatable
{
    use Notifiable;
    use BackupToSqlite;
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
    protected static function booted()
    {
        static::created(function ($usuario) {

            \DB::connection('sqlite_backup')
                ->table('usuarios')
                ->insert([
                    'id' => $usuario->id,
                    'nombre' => $usuario->nombre,
                    'correo' => $usuario->correo,
                    'password' => $usuario->password,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

        });
    }
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