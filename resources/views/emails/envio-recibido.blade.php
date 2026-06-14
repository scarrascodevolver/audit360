<x-mail::message>
# Nuevo envío de documentación

Ha entrado un envío nuevo en Comunidad Audit 360°:

- **Comunidad:** {{ $envio->comunidad ?: '—' }}
- **Teléfono:** {{ $envio->telefono }}
- **Email:** {{ $envio->email }}
- **Documentos:** {{ $envio->documentos->count() }}
- **Recibido:** {{ $envio->created_at->format('d/m/Y H:i') }}

@if ($adjuntados)
Los archivos van **adjuntos a este correo**. También puedes revisarlos desde el panel de administración.
@else
Los archivos no se han adjuntado (el envío supera el tamaño permitido para correo). Puedes revisarlos y descargarlos desde el panel de administración.
@endif

Gracias,<br>
{{ config('app.name') }}
</x-mail::message>
