<x-mail::message>
# Nuevo envío de documentación

Ha entrado un envío nuevo en Comunidad Audit 360°:

- **Comunidad:** {{ $envio->comunidad ?: '—' }}
- **Teléfono:** {{ $envio->telefono }}
- **Email:** {{ $envio->email }}
- **Documentos:** {{ $envio->documentos->count() }}
- **Recibido:** {{ $envio->created_at->format('d/m/Y H:i') }}

Puede revisarlo y descargar los archivos desde el panel de administración.

Gracias,<br>
{{ config('app.name') }}
</x-mail::message>
