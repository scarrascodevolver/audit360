<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSolicitudRequest;
use App\Mail\SolicitudRecibidaMail;
use App\Models\Ajuste;
use App\Models\Solicitud;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class SolicitudController extends Controller
{
    public function store(StoreSolicitudRequest $request): JsonResponse
    {
        $solicitud = Solicitud::create([
            'telefono' => $request->validated('telefono'),
            'email' => $request->validated('email'),
            'consentimiento_at' => now(),
        ]);

        // Los destinatarios de solicitudes se editan en el panel (Ajustes); si
        // no se ha configurado ninguno, caen a los avisos generales.
        $destinatarios = Ajuste::emailsSolicitudes();

        if ($destinatarios !== []) {
            Mail::to($destinatarios)->queue(new SolicitudRecibidaMail($solicitud));
        }

        return response()->json(['id' => $solicitud->id], 201);
    }
}
