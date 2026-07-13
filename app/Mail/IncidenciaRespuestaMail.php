<?php

namespace App\Mail;

use App\Models\IncidenciaComentarioModel;
use App\Models\IncidenciaModel;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class IncidenciaRespuestaMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public IncidenciaModel $incidencia,
        public IncidenciaComentarioModel $respuesta
    ) {
    }

    public function build()
    {
        return $this->subject('Respuesta a incidencia ' . $this->incidencia->codigo)
            ->view('emails.incidencia_respuesta');
    }
}
