<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pagos';
    protected $primaryKey = 'id_pago';

    public $timestamps = true;

    protected $fillable = [
        'id_envio',
        'monto',
        'moneda',
        'metodo_pago',
        'estado',
        'fecha_pago'
    ];

    // =========================
    // RELACIONES
    // =========================

    // Pago pertenece a un envío
    public function envio()
    {
        return $this->belongsTo(Envio::class, 'id_envio');
    }

    // =========================
    // SCOPES
    // =========================

    public function scopePagados($query)
    {
        return $query->where('estado', 'pagado');
    }

    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }
}