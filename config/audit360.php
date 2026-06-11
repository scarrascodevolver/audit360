<?php

return [

    // Destinatario del email de aviso cuando entra un envío nuevo.
    'especialista_email' => env('AUDIT_SPECIALIST_EMAIL'),

    // RGPD: los envíos y sus archivos se borran pasados estos días.
    'retencion_dias' => (int) env('AUDIT_RETENCION_DIAS', 30),

];
