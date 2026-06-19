<?php

namespace App\Models;

use CodeIgniter\Model;

class ArchivoBloqueadoModel extends Model
{
    protected $table = 'archivos_bloqueados';

    protected $primaryKey = 'id_bloqueo';

    protected $returnType = 'array';

    protected $allowedFields = [
        'archivo',
        'id_usuario',
        'fecha_inicio',
        'activo'
    ];

    public $useTimestamps = false;

    public function obtenerBloqueoActivo($archivo)
    {
        return $this
            ->where('archivo', $archivo)
            ->where('activo', 1)
            ->first();
    }
}