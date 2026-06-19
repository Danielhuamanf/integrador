<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditoriaEntidadModel extends Model
{
    protected $table = 'auditoria_entidades';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'sistema',
        'tabla',
        'id_registro'
    ];
}