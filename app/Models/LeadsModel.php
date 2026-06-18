<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BackupToSqlite;
class LeadsModel extends Model
{
     use BackupToSqlite;
    protected $table = 'leads';
    protected $primaryKey = 'id_lead';

    public $timestamps = false; // solo tienes created_at

    protected $fillable = [
        'nombre',
        'correo',
        'telefono',
        'estado',
        'mensaje',
        'created_at'
    ];

    // =========================
    // SCOPES (útiles)
    // =========================

    // Leads por estado
    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }
}