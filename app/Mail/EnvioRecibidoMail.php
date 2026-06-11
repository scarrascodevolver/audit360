<?php

namespace App\Mail;

use App\Models\Envio;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnvioRecibidoMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Envio $envio)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nuevo envío de documentación — '.($this->envio->comunidad ?: $this->envio->telefono),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.envio-recibido',
        );
    }
}
