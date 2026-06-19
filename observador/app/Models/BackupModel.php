<?php

namespace App\Models;

use CodeIgniter\Model;

class BackupModel extends Model
{
    protected $table = 'backups';

    protected $primaryKey = 'id_backup';

    protected $returnType = 'array';

    protected $allowedFields = [
        'nombre',
        'ruta',
        'fecha',
        'id_usuario'
    ];

    public $useTimestamps = false;
}