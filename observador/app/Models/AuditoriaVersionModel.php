<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditoriaVersionModel extends Model
{
    protected $table = 'auditoria_versiones';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'entidad_id',
        'version',
        'accion',
        'usuario_id',
        'usuario_nombre',
        'datos_json'
    ];
}