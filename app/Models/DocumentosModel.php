<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentosModel extends Model
{
    protected $table = 'documentos';
    protected $primaryKey = 'id_documento';

    public $timestamps = false; // solo tienes created_at

    protected $fillable = [
        'id_envio',
        'nombre_doc',
        'url_documento',
        'descripcion_doc',
        'created_at'
    ];

    // =========================
    // RELACIONES
    // =========================

    // Documento pertenece a un envío
    public function envio()
    {
        return $this->belongsTo(EnvioModel::class, 'id_envio');
    }
}