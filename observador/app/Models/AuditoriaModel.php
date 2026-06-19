<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditoriaModel extends Model
{
    protected $table            = 'auditorias';
    protected $primaryKey       = 'id';

    protected $returnType       = 'array';

    protected $useAutoIncrement = true;

    protected $protectFields    = true;

    protected $allowedFields = [
        'tabla',
        'accion',
        'id_registro',
        'usuario',
        'contenido',
        'fecha'
    ];

    protected bool $allowEmptyInserts = false;

    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = true;

    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Obtiene historial por registro
     */
    public function getHistorial($tabla, $idRegistro)
    {
        return $this->where('tabla', $tabla)
                    ->where('id_registro', $idRegistro)
                    ->orderBy('id', 'DESC')
                    ->findAll();
    }

    /**
     * Última versión registrada
     */
    public function getUltimoCambio($tabla, $idRegistro)
    {
        return $this->where('tabla', $tabla)
                    ->where('id_registro', $idRegistro)
                    ->orderBy('id', 'DESC')
                    ->first();
    }

    /**
     * Todos los cambios recientes
     */
    public function getRecientes($limite = 50)
    {
        return $this->orderBy('id', 'DESC')
                    ->findAll($limite);
    }
}