<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MensajesModel extends Model
{
    protected $table = 'mensajes';

    protected $primaryKey = 'id_mensaje';

    public $timestamps = false; 
    // porque tú solo tienes created_at, no updated_at

    protected $fillable = [
        'id_emisor',
        'id_receptor',
        'mensaje',
        'estado',
        'created_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'estado' => 'integer'
    ];
    public static function conversaciones($userId)
    {
        return self::select('mensajes.*')
            ->whereRaw("id_mensaje IN (
                SELECT MAX(id_mensaje)
                FROM mensajes
                WHERE id_emisor = $userId OR id_receptor = $userId
                GROUP BY 
                    CASE 
                        WHEN id_emisor = $userId THEN id_receptor
                        ELSE id_emisor
                    END
            )")
            ->orderBy('id_mensaje', 'desc')
            ->get();
    }
}