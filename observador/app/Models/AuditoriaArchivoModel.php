<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditoriaArchivoModel extends Model
{
    protected $table = 'auditoria_archivos';

    protected $primaryKey = 'id_auditoria';

    protected $returnType = 'array';

    protected $allowedFields = [
        'id_usuario',
        'archivo',
        'accion',
        'fecha'
    ];

    public $useTimestamps = false;
}