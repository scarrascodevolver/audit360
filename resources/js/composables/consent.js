import { ref } from 'vue';

// Consentimiento de cookies (RGPD) + Google Consent Mode v2.
//
// Por defecto TODO está denegado: el valor por defecto se fija en el <head>
// (app.blade.php) ANTES de que cargue cualquier etiqueta de Google, para que
// Analytics/Ads no escriban cookies hasta que el usuario decida en el banner.
// Aquí solo guardamos la decisión y se la comunicamos a Google con un "update".

const CLAVE = 'audit_consent_v1';

// ¿Ha decidido ya el usuario? Si es false, se muestra el banner.
export const decisionTomada = ref(false);
// Categorías que controla el usuario (analítica = GA4, publicidad = Google Ads).
export const consentimiento = ref({ analitica: false, publicidad: false });

function gtag() {
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(arguments);
}

// Traduce nuestras categorías al formato de Consent Mode v2 de Google.
function comunicarAGoogle({ analitica, publicidad }) {
    gtag('consent', 'update', {
        analytics_storage: analitica ? 'granted' : 'denied',
        ad_storage: publicidad ? 'granted' : 'denied',
        ad_user_data: publicidad ? 'granted' : 'denied',
        ad_personalization: publicidad ? 'granted' : 'denied',
    });
}

// Lee la decisión guardada (si existe) y la reaplica en Google al cargar la web.
export function cargarConsentimiento() {
    try {
        const guardado = JSON.parse(localStorage.getItem(CLAVE));
        if (guardado && typeof guardado.analitica === 'boolean') {
            consentimiento.value = { analitica: guardado.analitica, publicidad: guardado.publicidad };
            decisionTomada.value = true;
            comunicarAGoogle(consentimiento.value);
        }
    } catch {
        // Sin localStorage o dato corrupto: se muestra el banner (todo denegado).
    }
}

function guardar(valor) {
    consentimiento.value = valor;
    decisionTomada.value = true;
    try {
        localStorage.setItem(CLAVE, JSON.stringify(valor));
    } catch {
        // Sin localStorage la decisión solo dura la sesión; no es bloqueante.
    }
    comunicarAGoogle(valor);
}

export function aceptarTodo() {
    guardar({ analitica: true, publicidad: true });
}

export function rechazarTodo() {
    guardar({ analitica: false, publicidad: false });
}

// Permite reabrir el banner para cambiar/retirar el consentimiento (RGPD:
// retirarlo debe ser tan fácil como darlo). Se usa desde la política de cookies.
export function reabrirBanner() {
    decisionTomada.value = false;
}
