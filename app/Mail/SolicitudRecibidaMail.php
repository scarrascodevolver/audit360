<?php

namespace App\Mail;

use App\Models\Solicitud;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SolicitudRecibidaMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Solicitud $solicitud) {}

    public function envelope(): Envelope
    {
        // Prefijo [SOLICITUD] para distinguir de un vistazo del aviso de
        // documentos; el teléfono (o email) va en el asunto para poder llamar.
        return new Envelope(
            subject: '[SOLICITUD] Nuevo contacto — '.($this->solicitud->telefono ?: $this->solicitud->email),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.solicitud-recibida',
            with: [
                'urlPanel' => rtrim(config('app.url'), '/').'/admin/solicitudes/'.$this->solicitud->id,
            ],
        );
    }
}
