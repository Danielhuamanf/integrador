<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncidenciaComentarioModel extends Model
{
    protected $table = 'incidencia_comentarios';
    protected $primaryKey = 'id_comentario';
    public $timestamps = true;

    protected $fillable = [
        'id_incidencia',
        'id_usuario',
        'comentario',
        'tipo',
        'enviado_por_correo',
        'correo_destino',
        'fecha_envio_correo',
    ];

    protected $casts = [
        'enviado_por_correo' => 'boolean',
        'fecha_envio_correo' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(UsuarioModel::class, 'id_usuario', 'id_usuario');
    }

    public function incidencia()
    {
        return $this->belongsTo(IncidenciaModel::class, 'id_incidencia', 'id_incidencia');
    }
}
