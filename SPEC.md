# SPEC — Subida de documentos + panel admin (audit360)

> Contrato a aprobar antes de programar. Los criterios de aceptación de abajo
> se convierten 1:1 en tests Pest (MySQL `audit360_test`).

## 1. Endpoint de subida

`POST /api/envios` — multipart/form-data, sin autenticación.

| Campo | Reglas |
|---|---|
| `comunidad` | opcional, string, máx 150 |
| `telefono` | **obligatorio**, string, 9–20 caracteres |
| `consentimiento` | **obligatorio**, debe ser aceptado (checkbox RGPD) |
| `turnstile_token` | **obligatorio**, validado server-side contra Cloudflare |
| `documentos[actas]`, `documentos[presupuesto]`, `documentos[contratos]`, `documentos[incidencias]` | opcionales, 1 archivo por slot |
| `documentos[otros][]` | opcional, múltiples archivos |

Reglas de archivos: al menos **1 archivo en total**; máx **15 en total**; cada uno
PDF/JPG/PNG (validado por contenido, no por extensión) y máx **20 MB**.

Respuestas: `201 {id}` · `422` errores de validación (JSON) · `429` rate-limit.
Rate-limit: **5 envíos/hora por IP** (no se persiste la IP).

## 2. Datos

- `envios`: id, comunidad (nullable), telefono, email (nullable, ver §6),
  estado (`nuevo`|`revisado`, default `nuevo`), consentimiento_at, timestamps.
- `documentos`: id, envio_id (FK, cascade), slot, nombre_original,
  ruta, tamano_bytes, mime, timestamps. Relación Envio 1—N Documento.

## 3. Archivos (cifrado en reposo)

Se guardan en `storage/app/envios/{envio_id}/` con nombre aleatorio,
**cifrados con `Crypt`** al escribir. Nunca se sirven directamente: la descarga
descifra al vuelo y solo existe dentro del panel admin.

## 4. Notificación

Al crear un envío se encola un email al especialista (`AUDIT_SPECIALIST_EMAIL`
en `.env`; destinatario real pendiente — no bloqueante). En dev: `MAIL_MAILER=log`.

## 5. Panel Filament (`/admin`)

Login (usuarios creados por seeder/comando, sin registro público). Recurso
Envíos: listado (fecha, comunidad, teléfono, nº documentos, estado), detalle
con sus documentos, **descarga con descifrado al vuelo**, y marcar
`nuevo → revisado`.

## 6. RGPD

- Checkbox de consentimiento obligatorio en el formulario (texto breve: datos
  usados solo para elaborar el informe, retención 30 días, contacto).
- **Borrado automático a los 30 días**: comando `envios:purgar` en el
  scheduler diario — elimina filas y archivos.

## 7. Criterios de aceptación (tests)

1. Envío válido (teléfono + consentimiento + turnstile + 1 archivo) → 201, fila en `envios`, documentos en BD y en disco cifrados.
2. Sin teléfono → 422. Sin consentimiento → 422. Turnstile inválido → 422.
3. Sin ningún archivo → 422. Más de 15 archivos → 422.
4. Archivo de 21 MB → 422. Archivo `.exe` renombrado a `.pdf` → 422.
5. El archivo en disco NO es legible en claro (está cifrado); la descarga desde el panel devuelve el contenido original.
6. Al crear envío se encola el email al especialista (`Mail::fake`/`Queue::fake`).
7. 6º envío en una hora desde la misma IP → 429.
8. `envios:purgar` borra envíos de +30 días (BD y disco) y respeta los recientes.
9. `/admin` exige login; un admin ve el listado y puede cambiar el estado.

## Preguntas abiertas

- **¿Email del solicitante?** El formulario actual solo pide comunidad y
  teléfono. ¿Añadimos campo email (opcional) o se queda solo teléfono?
- Email del especialista destinatario (puede decidirse en despliegue).
