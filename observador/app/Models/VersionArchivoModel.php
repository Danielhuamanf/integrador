<?php

namespace App\Models;

use CodeIgniter\Model;

class VersionArchivoModel extends Model
{
    protected $table = 'versiones_archivos';

    protected $primaryKey = 'id_version';

    protected $returnType = 'array';

    protected $allowedFields = [
        'archivo',
        'contenido',
        'id_usuario',
        'comentario',
        'fecha'
    ];

    public $useTimestamps = false;
}