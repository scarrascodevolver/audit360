# SPEC — Subida de documentos + panel admin (audit360)

> Contrato a aprobar antes de programar. Los criterios de aceptación de abajo
> se convierten 1:1 en tests Pest (MySQL `audit360_test`).

## 1. Endpoint de subida

`POST /api/envios` — multipart/form-data, sin autenticación.

| Campo | Reglas |
|---|---|
| `comunidad` | opcional, string, máx 150 |
| `telefono` | **obligatorio**, string, 9–20 caracteres |
| `email` | **obligatorio**, email válido, máx 150 — se usa para responder al solicitante (hay que añadir el campo al formulario Vue) |
| `consentimiento` | **obligatorio**, debe ser aceptado (checkbox RGPD) |
| `turnstile_token` | **obligatorio**, validado server-side contra Cloudflare |
| `documentos[actas]`, `documentos[presupuesto]`, `documentos[contratos]`, `documentos[incidencias]` | opcionales, 1 archivo por slot |
| `documentos[otros][]` | opcional, múltiples archivos |

Reglas de archivos: al menos **1 archivo en total**; máx **15 en total**; cada uno
PDF/JPG/PNG (validado por contenido, no por extensión) y máx **20 MB**.

Respuestas: `201 {id}` · `422` errores de validación (JSON) · `429` rate-limit.
Rate-limit: **5 envíos/hora por IP** (no se persiste la IP).

## 2. Datos

- `envios`: id, comunidad (nullable), telefono, email,
  estado (`nuevo`|`revisado`, default `nuevo`), consentimiento_at, timestamps.
- `documentos`: id, envio_id (FK, cascade), slot, nombre_original,
  ruta, tamano_bytes, mime, timestamps. Relación Envio 1—N Documento.

## 3. Archivos (cifrado en reposo)

Se guardan en el disco `envios` de Laravel con nombre aleatorio,
**cifrados con `Crypt`** al escribir. Nunca se sirven directamente: la descarga
descifra al vuelo y solo existe dentro del panel admin.

El disco es la abstracción `Storage` de Laravel: en **dev y primeras pruebas
apunta a disco local** (`storage/app/envios/`); en producción se cambia por
`.env` al storage contratado en **Hetzner** (Object Storage S3-compatible o
disco del VPS) **sin tocar código**.

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

## 7. Contenido editable del sitio (CMS ligero)

El cliente debe poder cambiar los **textos del sitio** desde el panel, sin
programador. Enfoque: **lista curada de textos editables**, no un editor libre
de páginas (el diseño/maquetación sigue en código; lo editable es el contenido).

- Tabla `contenidos`: `clave` (única, ej. `hero.titulo`, `hero.circulo_24h`,
  `documentos.precio`, `cuota_segura.titulo`…), `valor` (texto), `grupo`
  (página/sección, para ordenar el panel).
- Seeder inicial con **todos los textos actuales** de las 4 páginas Vue
  (landing, recopilación/documentos, Cuota Segura) como valores por defecto.
- `GET /api/contenido` devuelve el mapa clave→valor (cacheado; la caché se
  invalida al guardar desde el panel).
- La SPA carga ese mapa al arrancar y lo usa en lugar de los textos hardcodeados.
- En Filament: sección **"Textos del sitio"** agrupada por página, campos de
  texto/textarea editables.

Nota aparte (diseño, no CMS): el círculo del hero "informe en solo 24 horas"
se ve pequeño → ajuste visual pendiente en código; su **texto** sí será editable.

## 8. Criterios de aceptación (tests)

1. Envío válido (teléfono + consentimiento + turnstile + 1 archivo) → 201, fila en `envios`, documentos en BD y en disco cifrados.
2. Sin teléfono → 422. Sin consentimiento → 422. Turnstile inválido → 422.
3. Sin ningún archivo → 422. Más de 15 archivos → 422.
4. Archivo de 21 MB → 422. Archivo `.exe` renombrado a `.pdf` → 422.
5. El archivo en disco NO es legible en claro (está cifrado); la descarga desde el panel devuelve el contenido original.
6. Al crear envío se encola el email al especialista (`Mail::fake`/`Queue::fake`).
7. 6º envío en una hora desde la misma IP → 429.
8. `envios:purgar` borra envíos de +30 días (BD y disco) y respeta los recientes.
9. `/admin` exige login; un admin ve el listado y puede cambiar el estado.
10. Sin email o con email inválido → 422.
11. `GET /api/contenido` devuelve los textos seedeados; al editar un texto en
    el panel, el endpoint devuelve el valor nuevo.

## Preguntas abiertas

- Email del especialista destinatario (puede decidirse en despliegue).
