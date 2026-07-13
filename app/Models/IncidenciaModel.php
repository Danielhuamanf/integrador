<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncidenciaModel extends Model
{
    protected $table = 'incidencias';
    protected $primaryKey = 'id_incidencia';
    public $timestamps = true;

    protected $fillable = [
        'codigo',
        'titulo',
        'descripcion',
        'prioridad',
        'estado',
        'modulo_afectado',
        'categoria',
        'impacto',
        'urgencia',
        'remitente',
        'correo_remitente',
        'asunto_correo',
        'fecha_recepcion',
        'origen',
        'correo_message_id',
        'id_usuario_creador',
        'id_usuario_asignado',
        'id_usuario_cierre',
        'fecha_cierre',
    ];

    protected $casts = [
        'fecha_recepcion' => 'datetime',
        'fecha_cierre' => 'datetime',
    ];

    public function creador()
    {
        return $this->belongsTo(UsuarioModel::class, 'id_usuario_creador', 'id_usuario');
    }

    public function asignado()
    {
        return $this->belongsTo(UsuarioModel::class, 'id_usuario_asignado', 'id_usuario');
    }

    public function cerradoPor()
    {
        return $this->belongsTo(UsuarioModel::class, 'id_usuario_cierre', 'id_usuario');
    }

    public function comentarios()
    {
        return $this->hasMany(IncidenciaComentarioModel::class, 'id_incidencia', 'id_incidencia');
    }

    public static function generarCodigo(): string
    {
        $fecha = now()->format('Ymd');
        $totalDelDia = self::whereDate('created_at', now()->toDateString())->count() + 1;

        return 'INC-' . $fecha . '-' . str_pad((string) $totalDelDia, 2, '0', STR_PAD_LEFT);
    }

    public static function calcularPrioridad(?string $impacto, ?string $urgencia): string
    {
        $valores = ['bajo' => 1, 'medio' => 2, 'alto' => 3, 'critico' => 4];
        $puntaje = ($valores[$impacto] ?? 2) + ($valores[$urgencia] ?? 2);

        if ($puntaje >= 7) {
            return 'critica';
        }

        if ($puntaje >= 5) {
            return 'alta';
        }

        if ($puntaje >= 3) {
            return 'media';
        }

        return 'baja';
    }
}
