<x-mail::message>
# 📞 Nueva solicitud de contacto

Un cliente ha pedido que le contactéis en **{{ config('app.name') }}**:

@if ($solicitud->telefono)
- **Teléfono:** {{ $solicitud->telefono }}
@endif
@if ($solicitud->email)
- **Email:** {{ $solicitud->email }}
@endif
- **Recibida:** {{ $solicitud->created_at->format('d/m/Y H:i') }}

**Siguiente paso:** llamar al cliente y, durante la conversación, indicarle que suba su documentación desde la web.

<x-mail::button :url="$urlPanel" color="success">
Ver la solicitud en el panel
</x-mail::button>

Gracias,<br>
{{ config('app.name') }}
</x-mail::message>
