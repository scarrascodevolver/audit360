# Comunidad Audit 360°

Servicio de revisión técnica, legal y económica de comunidades de propietarios.
**Analizamos. Detectamos. Mejoramos.** — Informe en 24 horas por 100 €.

## Stack

- **Laravel 12** (backend / API)
- **Vue 3 + Vue Router** (SPA pública)
- **Tailwind CSS 3** + **Vite**
- **MySQL/MariaDB** (datos) · **Filament** (panel admin, próximamente)

## Estructura del frontend

```
resources/js/
├── app.js                 # bootstrap Vue + router (/, /recopilacion, /subir-documentos)
├── App.vue                # shell + navbar
├── components/            # Navbar, Icon, Magnifier
└── pages/
    ├── LandingPage.vue        # Landing
    ├── RecopilacionPage.vue   # Proceso (2º paso)
    └── DocumentosPage.vue     # Subida de documentación (3er paso)
```

Rutas servidas por una SPA (`Route::view('/{any?}', 'app')`); el enrutado real lo gestiona Vue Router.

## Estado

- [x] Landing + páginas (mockup visual)
- [x] Formulario de subida (UI interactiva, sin backend aún)
- [ ] Backend de subida (API + almacenamiento cifrado + BD) — *en spec*
- [ ] Notificación por email + panel Filament
- [ ] RGPD: consentimiento + borrado automático (30 días)

## Desarrollo

```bash
composer install
npm install
cp .env.example .env && php artisan key:generate
npm run build        # o: npm run dev
php artisan serve
```

App en http://localhost:8000
