<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CambioPasswordModel extends Model
{
    protected $table = 'cambio_password';

    protected $primaryKey = 'id_solicitud_cambio_password';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'password',
        'estado'
    ];

    public function usuario()
    {
        return $this->belongsTo(
            UsuarioModel::class,
            'id_usuario',
            'id_usuario'
        );
    }

}