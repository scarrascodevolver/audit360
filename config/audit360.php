<?php

return [

    // Destinatario del email de aviso cuando entra un envío nuevo.
    'especialista_email' => env('AUDIT_SPECIALIST_EMAIL'),

    // RGPD: los envíos y sus archivos se borran pasados estos días.
    'retencion_dias' => (int) env('AUDIT_RETENCION_DIAS', 30),

    // Anti-spam: envíos permitidos por hora y por IP (5 en producción;
    // súbelo en .env local para poder probar sin toparte con el 429).
    'envios_por_hora' => (int) env('AUDIT_ENVIOS_POR_HORA', 5),

];
