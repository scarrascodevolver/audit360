<?php

namespace App\Mail;

use App\Models\Ajuste;
use App\Models\Documento;
use App\Models\Envio;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class EnvioRecibidoMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    // Brevo corta los mensajes en 20 MB y los adjuntos engordan ~33% al
    // codificarse, así que solo adjuntamos cuando el total es bien pequeño.
    // Por encima de esto se avisa con el botón de descarga al panel.
    public const LIMITE_ADJUNTOS_BYTES = 12 * 1024 * 1024;

    public function __construct(public Envio $envio) {}

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
            with: [
                'adjuntados' => $this->debeAdjuntar(),
                'urlPanel' => rtrim(config('app.url'), '/').'/admin/envios/'.$this->envio->id,
            ],
        );
    }

    /** @return array<int, Attachment> */
    public function attachments(): array
    {
        if (! $this->debeAdjuntar()) {
            return [];
        }

        return $this->envio->documentos
            ->map(fn (Documento $doc): Attachment => Attachment::fromData(
                fn (): string => Crypt::decrypt(Storage::disk('envios')->get($doc->ruta)),
                $doc->nombre_original,
            )->withMime($doc->mime))
            ->all();
    }

    /**
     * Se adjuntan los archivos solo si el ajuste lo permite y el peso total
     * cabe en un correo. Si no, va el aviso con enlace al panel.
     */
    public function debeAdjuntar(): bool
    {
        if (! Ajuste::bool(Ajuste::ADJUNTAR_ARCHIVOS, true)) {
            return false;
        }

        $total = (int) $this->envio->documentos->sum('tamano_bytes');

        return $total > 0 && $total <= self::LIMITE_ADJUNTOS_BYTES;
    }
}
