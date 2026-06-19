<?php

namespace App\Controllers;

use App\Models\AuditoriaEntidadModel;
use App\Models\AuditoriaVersionModel;
use App\Models\AuditoriaCambioModel;

class AuditoriaController extends BaseController
{
    private $apiKey = 'tu-clave-secreta'; // Define tu clave de comunicación segura

    public function registrar()
    {
        try {
            // Verificar Token de Seguridad de Laravel
            $headerToken = $this->request->getHeaderLine('X-API-Key');
            if ($headerToken !== $this->apiKey) {
                return $this->response->setStatusCode(401)->setJSON([
                    'success' => false,
                    'message' => 'No autorizado'
                ]);
            }

            $json = $this->request->getJSON(true);
            if (!$json) {
                return $this->response->setStatusCode(400)->setJSON([
                    'success' => false,
                    'message' => 'JSON inválido'
                ]);
            }

            // Validar que los campos mínimos requeridos existan
            $camposRequeridos = ['sistema', 'tabla', 'id_registro', 'accion'];
            foreach ($camposRequeridos as $field) {
                if (!isset($json[$field])) {
                    return $this->response->setStatusCode(400)->setJSON([
                        'success' => false,
                        'message' => "Falta el campo requerido: {$field}"
                    ]);
                }
            }

            $sistema = $json['sistema'];
            $tabla = $json['tabla'];
            $idRegistro = $json['id_registro'];
            $accion = $json['accion'];

            $usuarioId = $json['usuario']['id'] ?? null;
            $usuarioNombre = $json['usuario']['nombre'] ?? null;

            $antes = $json['antes'] ?? [];
            $despues = $json['despues'] ?? [];

            $entidadModel = new AuditoriaEntidadModel();
            $versionModel = new AuditoriaVersionModel();
            $cambioModel = new AuditoriaCambioModel();

            // Iniciar Transacción en CodeIgniter
            $db = \Config\Database::connect();
            $db->transStart();

            // 1. Buscar o Crear Entidad
            $entidad = $entidadModel
                ->where('sistema', $sistema)
                ->where('tabla', $tabla)
                ->where('id_registro', $idRegistro)
                ->first();

            $entidadId = $entidad ? $entidad['id'] : $entidadModel->insert([
                'sistema'     => $sistema,
                'tabla'       => $tabla,
                'id_registro' => $idRegistro
            ]);

            // 2. Obtener número de versión
            $ultimaVersion = $versionModel
                ->where('entidad_id', $entidadId)
                ->orderBy('version', 'DESC')
                ->first();

            $version = $ultimaVersion ? ($ultimaVersion['version'] + 1) : 1;

            // 3. Crear versión
            $versionId = $versionModel->insert([
                'entidad_id'     => $entidadId,
                'version'        => $version,
                'accion'         => $accion,
                'usuario_id'     => $usuarioId,
                'usuario_nombre' => $usuarioNombre,
                'datos_json'     => json_encode($despues, JSON_UNESCAPED_UNICODE)
            ]);

            // 4. Guardar diferencias de forma estricta (no vacías/nulas equivalentes)
            $campos = array_unique(array_merge(array_keys($antes), array_keys($despues)));

            foreach ($campos as $campo) {
                $valorAnterior = $antes[$campo] ?? null;
                $valorNuevo = $despues[$campo] ?? null;

                // Comparación estricta para evitar falsos negativos (ej. null !== false)
                if ($valorAnterior !== $valorNuevo) {
                    $cambioModel->insert([
                        'version_id'     => $versionId,
                        'campo'          => $campo,
                        'valor_anterior' => is_array($valorAnterior) || is_object($valorAnterior) 
                            ? json_encode($valorAnterior, JSON_UNESCAPED_UNICODE) 
                            : $valorAnterior,
                        'valor_nuevo'    => is_array($valorNuevo) || is_object($valorNuevo) 
                            ? json_encode($valorNuevo, JSON_UNESCAPED_UNICODE) 
                            : $valorNuevo
                    ]);
                }
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \RuntimeException('Error al guardar datos de auditoría en la BD');
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Auditoría registrada',
                'entidad_id' => $entidadId,
                'version' => $version
            ]);

        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function rollback()
    {
        try {
            $versionId = $this->request->getPost('version_id');

            if (!$versionId) {
                return $this->response->setStatusCode(400)->setJSON([
                    'success' => false,
                    'message' => 'Debe indicar version_id'
                ]);
            }

            $versionModel = new AuditoriaVersionModel();
            $entidadModel = new AuditoriaEntidadModel();

            $version = $versionModel->find($versionId);
            if (!$version) {
                return $this->response->setStatusCode(404)->setJSON([
                    'success' => false,
                    'message' => 'Versión no encontrada'
                ]);
            }

            $entidad = $entidadModel->find($version['entidad_id']);
            if (!$entidad) {
                return $this->response->setStatusCode(404)->setJSON([
                    'success' => false,
                    'message' => 'Entidad no encontrada'
                ]);
            }

            $datosRestaurar = json_decode($version['datos_json'], true);

            // Payload para Laravel
            $payload = [
                'tabla'       => $entidad['tabla'],
                'id_registro' => $entidad['id_registro'],
                'datos'       => $datosRestaurar
            ];

            // Petición HTTP agregando el header X-API-Key de seguridad
            $client = \Config\Services::curlrequest();
            $respuesta = $client->post(
                'http://integrador.test/api/rollback',
                [
                    'headers' => [
                        'X-API-Key' => $this->apiKey,
                        'Accept'    => 'application/json'
                    ],
                    'json' => $payload
                ]
            );

            $resultado = json_decode($respuesta->getBody(), true);

            if (!isset($resultado['success']) || !$resultado['success']) {
                return $this->response->setStatusCode(500)->setJSON([
                    'success' => false,
                    'message' => 'Laravel rechazó el rollback: ' . ($resultado['message'] ?? 'Sin detalles')
                ]);
            }

            // Iniciar Transacción para registrar el evento de Rollback
            $db = \Config\Database::connect();
            $db->transStart();

            $ultimaVersion = $versionModel
                ->where('entidad_id', $entidad['id'])
                ->orderBy('version', 'DESC')
                ->first();

            $nuevaVersion = $ultimaVersion ? ($ultimaVersion['version'] + 1) : 1;

            $versionModel->insert([
                'entidad_id'     => $entidad['id'],
                'version'        => $nuevaVersion,
                'accion'         => 'ROLLBACK',
                'usuario_id'     => session()->get('id_usuario'),
                'usuario_nombre' => session()->get('nombre'),
                'datos_json'     => json_encode($datosRestaurar, JSON_UNESCAPED_UNICODE)
            ]);

            $db->transComplete();

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Rollback ejecutado correctamente'
            ]);

        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}