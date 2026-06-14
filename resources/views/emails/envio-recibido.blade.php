<x-mail::message>
# 📄 Nuevo envío de documentación

Ha entrado documentación nueva en **{{ config('app.name') }}**:

- **Comunidad:** {{ $envio->comunidad ?: '—' }}
- **Teléfono:** {{ $envio->telefono }}
- **Email del remitente:** {{ $envio->email }}
- **Documentos:** {{ $envio->documentos->count() }}
- **Recibido:** {{ $envio->created_at->format('d/m/Y H:i') }}

<x-mail::button :url="$urlPanel" color="success">
Ver y descargar los documentos
</x-mail::button>

@if ($adjuntados)
Los archivos van **adjuntos** a este correo y también disponibles en el panel.
@else
El envío es demasiado grande para adjuntarlo al correo. Pulsa el botón de arriba para **revisarlo y descargar todo (ZIP)** desde el panel de administración.
@endif

Gracias,<br>
{{ config('app.name') }}
</x-mail::message>
