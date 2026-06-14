<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEnvioRequest;
use App\Mail\EnvioRecibidoMail;
use App\Models\Ajuste;
use App\Models\Envio;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EnvioController extends Controller
{
    public function store(StoreEnvioRequest $request): JsonResponse
    {
        $envio = DB::transaction(function () use ($request) {
            $envio = Envio::create([
                'comunidad' => $request->validated('comunidad'),
                'telefono' => $request->validated('telefono'),
                'email' => $request->validated('email'),
                'consentimiento_at' => now(),
            ]);

            foreach ($request->archivos() as [$slot, $archivo]) {
                $ruta = $envio->id.'/'.Str::uuid().'.bin';

                Storage::disk('envios')->put($ruta, Crypt::encrypt($archivo->get()));

                $envio->documentos()->create([
                    'slot' => $slot,
                    'nombre_original' => $archivo->getClientOriginalName(),
                    'ruta' => $ruta,
                    'tamano_bytes' => $archivo->getSize(),
                    'mime' => $archivo->getMimeType(),
                ]);
            }

            return $envio;
        });

        // Los destinatarios se editan desde el panel (Ajustes) y pueden ser
        // varios; si no hay ninguno, cae al valor del .env.
        $destinatarios = Ajuste::emailsNotificaciones();

        if ($destinatarios !== []) {
            Mail::to($destinatarios)->queue(new EnvioRecibidoMail($envio));
        }

        return response()->json(['id' => $envio->id], 201);
    }
}
