<template>
    <div class="min-h-screen bg-bg-light py-6 sm:py-10">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">

            <!-- ============ FORM + RESUMEN ============ -->
            <div class="grid gap-6 lg:grid-cols-3">

                <!-- ----- Columna formulario ----- -->
                <div class="space-y-6 lg:col-span-2">

                    <!-- Mensaje de éxito (mockup) -->
                    <div v-if="submitted" class="flex items-start gap-3 rounded-3xl bg-teal p-6 text-white shadow-sm">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-white/20">
                            <Icon name="check" class="h-6 w-6" />
                        </span>
                        <div>
                            <h3 class="font-heading text-lg font-black">¡Documentación recibida!</h3>
                            <p class="mt-1 text-sm text-white/85">
                                Hemos registrado {{ count }} {{ count === 1 ? 'archivo' : 'archivos' }}. Uno de
                                nuestros especialistas le contactará en el teléfono indicado. Recibirá su informe
                                en un plazo máximo de 24 horas.
                            </p>
                            <button class="mt-3 text-sm font-bold underline" @click="reset">Enviar más documentos</button>
                        </div>
                    </div>

                    <!-- Datos de contacto -->
                    <section class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-gray-100">
                        <div class="flex items-center gap-3 bg-navy px-6 py-4">
                            <Icon name="phone" class="h-6 w-6 text-teal-light" />
                            <h2 class="text-sm font-extrabold tracking-wide text-white">DATOS DE CONTACTO</h2>
                        </div>
                        <div class="grid gap-4 p-6 sm:grid-cols-2">
                            <label class="block sm:col-span-2">
                                <span class="text-xs font-bold text-navy/70">Nombre de la comunidad</span>
                                <input v-model="comunidad" type="text" placeholder="Ej. Comunidad C/ Mayor 12"
                                    class="mt-1.5 w-full rounded-xl border border-gray-200 bg-bg-light px-4 py-2.5 text-sm text-navy outline-none transition focus:border-teal focus:ring-2 focus:ring-teal/20" />
                            </label>
                            <label class="block">
                                <span class="text-xs font-bold text-navy/70">Teléfono de contacto *</span>
                                <input v-model="phone" type="tel" placeholder="600 000 000"
                                    class="mt-1.5 w-full rounded-xl border border-gray-200 bg-bg-light px-4 py-2.5 text-sm text-navy outline-none transition focus:border-teal focus:ring-2 focus:ring-teal/20" />
                            </label>
                            <label class="block">
                                <span class="text-xs font-bold text-navy/70">Email de contacto *</span>
                                <input v-model="email" type="email" placeholder="su@email.com"
                                    class="mt-1.5 w-full rounded-xl border border-gray-200 bg-bg-light px-4 py-2.5 text-sm text-navy outline-none transition focus:border-teal focus:ring-2 focus:ring-teal/20" />
                            </label>
                        </div>
                    </section>

                    <!-- Documentos solicitados -->
                    <section class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-gray-100">
                        <div class="flex items-center gap-3 bg-teal px-6 py-4">
                            <Icon name="folder" class="h-6 w-6 text-white" />
                            <h2 class="text-sm font-extrabold tracking-wide text-white">DOCUMENTOS SOLICITADOS</h2>
                        </div>

                        <ul class="divide-y divide-gray-100">
                            <li v-for="doc in requeridos" :key="doc.key" class="flex flex-col gap-3 p-5 sm:flex-row sm:items-center sm:justify-between">
                                <div class="flex items-start gap-3">
                                    <span
                                        class="mt-0.5 flex h-7 w-7 shrink-0 items-center justify-center rounded-full border-2 transition"
                                        :class="files[doc.key] ? 'border-teal bg-teal text-white' : 'border-gray-300 text-gray-300'"
                                    >
                                        <Icon name="check" class="h-4 w-4" />
                                    </span>
                                    <div>
                                        <p class="text-sm font-semibold text-navy">{{ doc.label }}</p>
                                        <p v-if="files[doc.key]" class="mt-0.5 flex items-center gap-1 text-xs font-medium text-teal">
                                            <Icon name="document" class="h-3.5 w-3.5" /> {{ files[doc.key].name }}
                                        </p>
                                        <p v-else class="mt-0.5 text-xs text-navy/40">Pendiente de adjuntar</p>
                                    </div>
                                </div>

                                <div class="flex shrink-0 items-center gap-2 sm:pl-3">
                                    <label
                                        class="cursor-pointer rounded-full px-4 py-2 text-xs font-bold transition"
                                        :class="files[doc.key] ? 'bg-bg-light text-navy/70 hover:bg-gray-100' : 'bg-teal text-white hover:bg-teal-dark'"
                                    >
                                        {{ files[doc.key] ? 'Cambiar' : 'Adjuntar' }}
                                        <input type="file" class="hidden" @change="onPick($event, doc.key)" />
                                    </label>
                                    <button v-if="files[doc.key]" class="text-xs font-bold text-navy/40 hover:text-red-500" @click="removeFile(doc.key)">
                                        Quitar
                                    </button>
                                </div>
                            </li>
                        </ul>
                    </section>

                    <!-- Otros documentos: dropzone -->
                    <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
                        <h2 class="text-sm font-extrabold tracking-wide text-navy">OTROS DOCUMENTOS (OPCIONAL)</h2>
                        <label
                            class="mt-4 flex cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed px-6 py-10 text-center transition"
                            :class="dragging ? 'border-teal bg-teal/5' : 'border-gray-300 hover:border-teal hover:bg-bg-light'"
                            @dragover.prevent="dragging = true"
                            @dragleave.prevent="dragging = false"
                            @drop.prevent="onDrop"
                        >
                            <span class="flex h-14 w-14 items-center justify-center rounded-full bg-teal/10 text-teal">
                                <Icon name="upload" class="h-7 w-7" />
                            </span>
                            <p class="mt-4 text-sm font-bold text-navy">Arrastre aquí sus archivos o haga clic para seleccionarlos</p>
                            <p class="mt-1 text-xs text-navy/50">PDF, JPG o PNG · hasta 20 MB por archivo</p>
                            <input type="file" multiple class="hidden" @change="onPickMany" />
                        </label>

                        <ul v-if="otros.length" class="mt-4 space-y-2">
                            <li v-for="(archivo, i) in otros" :key="i" class="flex items-center justify-between rounded-xl bg-bg-light px-4 py-2.5">
                                <span class="flex items-center gap-2 text-sm text-navy">
                                    <Icon name="document" class="h-4 w-4 text-teal" /> {{ archivo.name }}
                                </span>
                                <button class="text-xs font-bold text-navy/40 hover:text-red-500" @click="otros.splice(i, 1)">Quitar</button>
                            </li>
                        </ul>
                    </section>

                    <!-- Enviar -->
                    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
                        <label class="flex cursor-pointer items-start gap-3">
                            <input v-model="consentimiento" type="checkbox"
                                class="mt-0.5 h-5 w-5 shrink-0 rounded border-gray-300 text-teal accent-teal focus:ring-teal" />
                            <span class="text-xs leading-relaxed text-navy/70">
                                Acepto que mis datos y documentos se utilicen únicamente para elaborar el
                                informe de mi comunidad. Se eliminarán automáticamente a los 30 días y solo
                                nos pondremos en contacto por el teléfono o email indicados. *
                            </span>
                        </label>

                        <div v-if="turnstileSiteKey" ref="turnstileEl" class="mt-4 flex justify-center"></div>

                        <p v-if="error" class="mt-4 text-sm font-semibold text-red-500">{{ error }}</p>

                        <button
                            class="mt-4 flex w-full items-center justify-center gap-2 rounded-full bg-teal px-6 py-4 text-base font-bold text-white shadow-md transition hover:bg-teal-dark disabled:cursor-not-allowed disabled:opacity-60"
                            :disabled="enviando"
                            @click="submit"
                        >
                            <Icon name="upload" class="h-5 w-5" />
                            {{ enviando ? `Subiendo… ${progresoSubida}%` : 'Enviar documentación' }}
                        </button>
                        <p class="mt-3 flex items-center justify-center gap-1.5 text-center text-xs text-navy/50">
                            <Icon name="shield" class="h-3.5 w-3.5 text-teal" />
                            Sus datos se tratan con la máxima seguridad y confidencialidad.
                        </p>
                    </div>
                </div>

                <!-- ----- Columna resumen ----- -->
                <aside class="lg:col-span-1">
                    <div class="space-y-6 lg:sticky lg:top-24">
                        <!-- Tu informe -->
                        <div class="rounded-3xl bg-navy p-6 text-white shadow-sm">
                            <div class="flex items-center gap-2 text-teal-light">
                                <Icon name="stopwatch" class="h-6 w-6" />
                                <span class="text-xs font-bold tracking-widest">TU INFORME</span>
                            </div>
                            <p v-editable="'documentos.precio'" class="mt-3 font-heading text-5xl font-black">
                                {{ t('documentos.precio', '100€') }}
                            </p>
                            <p v-editable="'documentos.precio_sub'" class="text-sm text-white/60">{{ t('documentos.precio_sub', 'Precio cerrado · entrega en 24 h') }}</p>

                            <ul v-editable="'documentos.recibe'" class="mt-5 space-y-3 border-t border-white/10 pt-5">
                                <li v-for="r in recibe" :key="r" class="flex items-start gap-2.5 text-sm text-white/80">
                                    <Icon name="check" class="mt-0.5 h-4 w-4 shrink-0 text-teal-light" />
                                    {{ r }}
                                </li>
                            </ul>
                        </div>

                        <!-- Progreso -->
                        <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold tracking-widest text-navy/60">DOCUMENTOS ADJUNTOS</span>
                                <span class="font-heading text-sm font-black text-teal">{{ count }}/{{ requeridos.length }}</span>
                            </div>
                            <div class="mt-3 h-2 w-full overflow-hidden rounded-full bg-bg-light">
                                <div class="h-full rounded-full bg-teal transition-all" :style="{ width: progress + '%' }"></div>
                            </div>
                            <p class="mt-3 text-xs leading-relaxed text-navy/55">
                                No es obligatorio adjuntar todos los documentos para enviar. Le indicaremos si
                                falta algo durante la llamada.
                            </p>
                        </div>
                    </div>
                </aside>
            </div>

            <!-- ============ FOOTER ============ -->
            <footer class="rounded-3xl bg-navy px-6 py-8 sm:px-10">
                <div class="flex flex-col items-center justify-between gap-6 text-center md:flex-row md:text-left">
                    <div class="flex items-center gap-4">
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-white/10 text-teal-light">
                            <Icon name="shield" class="h-7 w-7" />
                        </span>
                        <div>
                            <p v-editable="'footer.titulo'" class="text-lg font-extrabold text-teal-light">{{ t('footer.titulo', 'Tu comunidad en buenas manos.') }}</p>
                            <p v-editable="'footer.subtitulo'" class="text-sm text-white/60">{{ t('footer.subtitulo', 'Porque prevenir hoy, es ahorrar mañana.') }}</p>
                        </div>
                    </div>
                    <router-link to="/" class="flex items-center gap-3 transition hover:opacity-80">
                        <Icon name="globe" class="h-7 w-7 shrink-0 text-teal-light" />
                        <span v-editable="'footer.dominio'" class="text-lg font-extrabold text-teal-light">{{ t('footer.dominio', 'auditatucomunidad.com') }}</span>
                    </router-link>
                </div>
            </footer>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import Icon from '../components/Icon.vue';
import { useContenido } from '../composables/contenido';

const requeridos = [
    { key: 'actas', label: 'Últimas actas de la comunidad' },
    { key: 'presupuesto', label: 'Presupuesto y liquidación anual' },
    { key: 'contratos', label: 'Contratos de mantenimiento y servicios' },
    { key: 'incidencias', label: 'Información sobre incidencias o actuaciones pendientes' },
    { key: 'otros', label: 'Otra documentación relevante para la evaluación' },
];

const { t, lista } = useContenido();

const recibe = computed(() => lista('documentos.recibe', [
    'Estado general de la comunidad',
    'Riesgos y oportunidades detectadas',
    'Recomendaciones de mejora priorizadas',
    'Optimizaciones económicas y operativas',
]));

// En la demo estática de GitHub Pages no hay backend: se simula el envío.
const modoDemo = import.meta.env.VITE_GH_PAGES === '1';
const turnstileSiteKey = import.meta.env.VITE_TURNSTILE_SITE_KEY || '';

const comunidad = ref('');
const phone = ref('');
const email = ref('');
const consentimiento = ref(false);
const files = ref({});
const otros = ref([]);
const dragging = ref(false);
const submitted = ref(false);
const enviando = ref(false);
const progresoSubida = ref(0);
const error = ref('');
const turnstileEl = ref(null);
const turnstileToken = ref('');

const count = computed(() => Object.keys(files.value).length);
const progress = computed(() => Math.round((count.value / requeridos.length) * 100));

onMounted(() => {
    if (!turnstileSiteKey) return;
    const render = () => window.turnstile.render(turnstileEl.value, {
        sitekey: turnstileSiteKey,
        callback: (token) => (turnstileToken.value = token),
        'expired-callback': () => (turnstileToken.value = ''),
    });
    if (window.turnstile) {
        render();
    } else {
        const script = document.createElement('script');
        script.src = 'https://challenges.cloudflare.com/turnstile/v0/api.js?render=explicit';
        script.async = true;
        script.onload = render;
        document.head.appendChild(script);
    }
});

function onPick(e, key) {
    const f = e.target.files[0];
    if (f) files.value = { ...files.value, [key]: f };
}
function removeFile(key) {
    const copy = { ...files.value };
    delete copy[key];
    files.value = copy;
}
function onPickMany(e) {
    otros.value.push(...Array.from(e.target.files));
}
function onDrop(e) {
    dragging.value = false;
    otros.value.push(...Array.from(e.dataTransfer.files));
}

function validar() {
    if (!phone.value.trim()) return 'Indique un teléfono de contacto para poder llamarle.';
    if (!email.value.trim()) return 'Indique un email de contacto para poder responderle.';
    if (count.value === 0 && otros.value.length === 0) return 'Adjunte al menos un documento.';
    if (!consentimiento.value) return 'Debe aceptar el tratamiento de sus datos para poder enviar.';
    if (turnstileSiteKey && !turnstileToken.value) return 'Complete la verificación anti-spam antes de enviar.';
    return '';
}

async function submit() {
    error.value = validar();
    if (error.value) return;

    if (modoDemo) {
        submitted.value = true;
        window.scrollTo({ top: 0, behavior: 'smooth' });
        return;
    }

    const datos = new FormData();
    datos.append('comunidad', comunidad.value);
    datos.append('telefono', phone.value);
    datos.append('email', email.value);
    datos.append('consentimiento', '1');
    if (turnstileToken.value) datos.append('turnstile_token', turnstileToken.value);
    for (const [slot, archivo] of Object.entries(files.value)) {
        // El apartado "Otra documentación" comparte la clave "otros" con la
        // zona de arrastre: ambos viajan en la misma lista documentos[otros][].
        if (slot === 'otros') {
            datos.append('documentos[otros][]', archivo);
        } else {
            datos.append(`documentos[${slot}]`, archivo);
        }
    }
    for (const archivo of otros.value) {
        datos.append('documentos[otros][]', archivo);
    }

    enviando.value = true;
    progresoSubida.value = 0;
    try {
        await window.axios.post('/api/envios', datos, {
            onUploadProgress: (e) => {
                if (e.total) progresoSubida.value = Math.round((e.loaded / e.total) * 100);
            },
        });
        submitted.value = true;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    } catch (e) {
        if (e.response?.status === 422) {
            error.value = Object.values(e.response.data.errors ?? {}).flat()[0]
                ?? 'Revise los datos del formulario.';
        } else if (e.response?.status === 429) {
            error.value = 'Ha alcanzado el límite de envíos por hora. Inténtelo más tarde.';
        } else {
            error.value = 'No se pudo enviar la documentación. Inténtelo de nuevo en unos minutos.';
        }
    } finally {
        enviando.value = false;
        if (turnstileSiteKey && window.turnstile) {
            window.turnstile.reset();
            turnstileToken.value = '';
        }
    }
}

function reset() {
    submitted.value = false;
    files.value = {};
    otros.value = [];
}
</script>
