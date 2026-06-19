<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditoriaCambioModel extends Model
{
    protected $table = 'auditoria_cambios';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'version_id',
        'campo',
        'valor_anterior',
        'valor_nuevo'
    ];
}