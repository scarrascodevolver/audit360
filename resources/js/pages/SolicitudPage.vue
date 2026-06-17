<template>
    <div class="min-h-screen bg-bg-light py-10 sm:py-16">
        <div class="mx-auto max-w-xl px-4 sm:px-6">

            <!-- Mensaje de éxito -->
            <div v-if="submitted" class="rounded-3xl bg-teal p-8 text-white shadow-sm">
                <span class="flex h-12 w-12 items-center justify-center rounded-full bg-white/20">
                    <Icon name="check" class="h-7 w-7" />
                </span>
                <h1 class="mt-5 font-heading text-2xl font-black">¡Solicitud recibida!</h1>
                <p class="mt-2 text-sm leading-relaxed text-white/85">
                    Un técnico se pondrá en contacto contigo a la mayor brevedad. Durante la
                    llamada te indicará cómo subir tu documentación.
                </p>
                <router-link to="/" class="mt-6 inline-flex items-center gap-2 rounded-full bg-white px-5 py-2.5 text-sm font-bold text-teal transition hover:bg-white/90">
                    Volver al inicio
                </router-link>
            </div>

            <template v-else>
                <!-- Encabezado -->
                <div class="text-center">
                    <p v-reveal class="text-xs font-bold tracking-[0.22em] text-navy/60">
                        {{ t('solicitud.kicker', 'PRIMER PASO') }}
                    </p>
                    <h1 v-reveal="60" v-editable="'solicitud.titulo'" class="mt-3 font-heading text-3xl font-black text-navy sm:text-4xl">
                        {{ t('solicitud.titulo', 'CONTRÁTALO AHORA') }}
                    </h1>
                    <p v-reveal="120" v-editable="'solicitud.intro'" class="mx-auto mt-4 max-w-md text-sm leading-relaxed text-navy/70">
                        {{ t('solicitud.intro', 'Déjanos tu teléfono o tu email y un técnico se pondrá en contacto contigo a la mayor brevedad. Sin compromiso.') }}
                    </p>
                </div>

                <!-- Formulario -->
                <section v-reveal="180" class="mt-8 overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-gray-100">
                    <div class="flex items-center gap-3 bg-navy px-6 py-4">
                        <Icon name="phone" class="h-6 w-6 text-teal-light" />
                        <h2 class="text-sm font-extrabold tracking-wide text-white">DATOS DE CONTACTO</h2>
                    </div>
                    <div class="space-y-4 p-6">
                        <label class="block">
                            <span class="text-xs font-bold text-navy/70">Teléfono de contacto</span>
                            <input v-model="phone" type="tel" placeholder="600 000 000"
                                class="mt-1.5 w-full rounded-xl border border-gray-200 bg-bg-light px-4 py-2.5 text-sm text-navy outline-none transition focus:border-teal focus:ring-2 focus:ring-teal/20" />
                        </label>
                        <label class="block">
                            <span class="text-xs font-bold text-navy/70">Email de contacto</span>
                            <input v-model="email" type="email" placeholder="su@email.com"
                                class="mt-1.5 w-full rounded-xl border border-gray-200 bg-bg-light px-4 py-2.5 text-sm text-navy outline-none transition focus:border-teal focus:ring-2 focus:ring-teal/20" />
                        </label>
                        <p class="text-xs text-navy/50">Indica al menos uno de los dos para que podamos contactarte.</p>

                        <label class="flex cursor-pointer items-start gap-3 border-t border-gray-100 pt-4">
                            <input v-model="consentimiento" type="checkbox"
                                class="mt-0.5 h-5 w-5 shrink-0 rounded border-gray-300 text-teal accent-teal focus:ring-teal" />
                            <span class="text-xs leading-relaxed text-navy/70">
                                Acepto que mis datos se utilicen únicamente para ponerse en contacto conmigo
                                en relación con la revisión de mi comunidad. Se eliminarán automáticamente a
                                los 30 días. *
                            </span>
                        </label>

                        <div v-if="turnstileSiteKey" ref="turnstileEl" class="flex justify-center"></div>

                        <p v-if="error" class="text-sm font-semibold text-red-500">{{ error }}</p>

                        <button
                            class="flex w-full items-center justify-center gap-2 rounded-full bg-teal px-6 py-4 text-base font-bold text-white shadow-md transition hover:bg-teal-dark disabled:cursor-not-allowed disabled:opacity-60"
                            :disabled="enviando"
                            @click="submit"
                        >
                            {{ enviando ? 'Enviando…' : 'Contrátalo ahora' }}
                            <Icon name="arrow" class="h-5 w-5" />
                        </button>
                        <p class="flex items-center justify-center gap-1.5 text-center text-xs text-navy/50">
                            <Icon name="shield" class="h-3.5 w-3.5 text-teal" />
                            Sus datos se tratan con la máxima seguridad y confidencialidad.
                        </p>
                    </div>
                </section>
            </template>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import Icon from '../components/Icon.vue';
import { useContenido } from '../composables/contenido';
import { guardarContacto } from '../composables/contacto';

const { t } = useContenido();

// En la demo estática de GitHub Pages no hay backend: se simula el envío.
const modoDemo = import.meta.env.VITE_GH_PAGES === '1';
const turnstileSiteKey = import.meta.env.VITE_TURNSTILE_SITE_KEY || '';

const phone = ref('');
const email = ref('');
const consentimiento = ref(false);
const submitted = ref(false);
const enviando = ref(false);
const error = ref('');
const turnstileEl = ref(null);
const turnstileToken = ref('');

function renderTurnstile() {
    if (!turnstileSiteKey || !window.turnstile || !turnstileEl.value) return;
    window.turnstile.render(turnstileEl.value, {
        sitekey: turnstileSiteKey,
        callback: (token) => (turnstileToken.value = token),
        'expired-callback': () => (turnstileToken.value = ''),
    });
}

onMounted(() => {
    if (!turnstileSiteKey) return;
    if (window.turnstile) {
        renderTurnstile();
    } else {
        const script = document.createElement('script');
        script.src = 'https://challenges.cloudflare.com/turnstile/v0/api.js?render=explicit';
        script.async = true;
        script.onload = renderTurnstile;
        document.head.appendChild(script);
    }
});

function validar() {
    if (!phone.value.trim() && !email.value.trim()) return 'Indique un teléfono o un email para que podamos contactarle.';
    if (!consentimiento.value) return 'Debe aceptar el tratamiento de sus datos para poder enviar.';
    if (turnstileSiteKey && !turnstileToken.value) return 'Complete la verificación anti-spam antes de enviar.';
    return '';
}

async function submit() {
    error.value = validar();
    if (error.value) return;

    // Recordamos el contacto para autorrellenar luego la subida de documentos.
    guardarContacto({ telefono: phone.value, email: email.value });

    if (modoDemo) {
        submitted.value = true;
        window.scrollTo({ top: 0, behavior: 'smooth' });
        return;
    }

    const datos = new FormData();
    datos.append('telefono', phone.value);
    datos.append('email', email.value);
    datos.append('consentimiento', '1');
    if (turnstileToken.value) datos.append('turnstile_token', turnstileToken.value);

    enviando.value = true;
    try {
        await window.axios.post('/api/solicitudes', datos);
        submitted.value = true;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    } catch (e) {
        if (e.response?.status === 422) {
            error.value = Object.values(e.response.data.errors ?? {}).flat()[0]
                ?? 'Revise los datos del formulario.';
        } else if (e.response?.status === 429) {
            error.value = 'Ha alcanzado el límite de solicitudes por hora. Inténtelo más tarde.';
        } else {
            error.value = 'No se pudo enviar la solicitud. Inténtelo de nuevo en unos minutos.';
        }
    } finally {
        enviando.value = false;
        if (turnstileSiteKey && window.turnstile) {
            window.turnstile.reset();
            turnstileToken.value = '';
        }
    }
}
</script>
