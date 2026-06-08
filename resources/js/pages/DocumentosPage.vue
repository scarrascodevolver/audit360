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
                            <label class="block">
                                <span class="text-xs font-bold text-navy/70">Nombre de la comunidad</span>
                                <input v-model="comunidad" type="text" placeholder="Ej. Comunidad C/ Mayor 12"
                                    class="mt-1.5 w-full rounded-xl border border-gray-200 bg-bg-light px-4 py-2.5 text-sm text-navy outline-none transition focus:border-teal focus:ring-2 focus:ring-teal/20" />
                            </label>
                            <label class="block">
                                <span class="text-xs font-bold text-navy/70">Teléfono de contacto *</span>
                                <input v-model="phone" type="tel" placeholder="600 000 000"
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
                                            <Icon name="document" class="h-3.5 w-3.5" /> {{ files[doc.key] }}
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
                            <li v-for="(name, i) in otros" :key="i" class="flex items-center justify-between rounded-xl bg-bg-light px-4 py-2.5">
                                <span class="flex items-center gap-2 text-sm text-navy">
                                    <Icon name="document" class="h-4 w-4 text-teal" /> {{ name }}
                                </span>
                                <button class="text-xs font-bold text-navy/40 hover:text-red-500" @click="otros.splice(i, 1)">Quitar</button>
                            </li>
                        </ul>
                    </section>

                    <!-- Enviar -->
                    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
                        <p v-if="error" class="mb-3 text-sm font-semibold text-red-500">{{ error }}</p>
                        <button
                            class="flex w-full items-center justify-center gap-2 rounded-full bg-teal px-6 py-4 text-base font-bold text-white shadow-md transition hover:bg-teal-dark"
                            @click="submit"
                        >
                            <Icon name="upload" class="h-5 w-5" />
                            Enviar documentación
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
                            <p class="mt-3 font-heading text-5xl font-black">
                                100€
                            </p>
                            <p class="text-sm text-white/60">Precio cerrado · entrega en 24 h</p>

                            <ul class="mt-5 space-y-3 border-t border-white/10 pt-5">
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
                            <p class="text-lg font-extrabold text-teal-light">Tu comunidad en buenas manos.</p>
                            <p class="text-sm text-white/60">Porque prevenir hoy, es ahorrar mañana.</p>
                        </div>
                    </div>
                    <router-link to="/" class="flex items-center gap-3 transition hover:opacity-80">
                        <Icon name="globe" class="h-7 w-7 shrink-0 text-teal-light" />
                        <span class="text-lg font-extrabold text-teal-light">comunidadaudit360.com</span>
                    </router-link>
                </div>
            </footer>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import Icon from '../components/Icon.vue';

const requeridos = [
    { key: 'actas', label: 'Últimas actas de la comunidad' },
    { key: 'presupuesto', label: 'Presupuesto y liquidación anual' },
    { key: 'contratos', label: 'Contratos de mantenimiento y servicios' },
    { key: 'incidencias', label: 'Información sobre incidencias o actuaciones pendientes' },
    { key: 'otros', label: 'Otra documentación relevante para la evaluación' },
];

const recibe = [
    'Estado general de la comunidad',
    'Riesgos y oportunidades detectadas',
    'Recomendaciones de mejora priorizadas',
    'Optimizaciones económicas y operativas',
];

const comunidad = ref('');
const phone = ref('');
const files = ref({});
const otros = ref([]);
const dragging = ref(false);
const submitted = ref(false);
const error = ref('');

const count = computed(() => Object.keys(files.value).length);
const progress = computed(() => Math.round((count.value / requeridos.length) * 100));

function onPick(e, key) {
    const f = e.target.files[0];
    if (f) files.value = { ...files.value, [key]: f.name };
}
function removeFile(key) {
    const copy = { ...files.value };
    delete copy[key];
    files.value = copy;
}
function onPickMany(e) {
    otros.value.push(...Array.from(e.target.files).map((f) => f.name));
}
function onDrop(e) {
    dragging.value = false;
    otros.value.push(...Array.from(e.dataTransfer.files).map((f) => f.name));
}
function submit() {
    if (!phone.value.trim()) {
        error.value = 'Indique un teléfono de contacto para poder llamarle.';
        return;
    }
    error.value = '';
    submitted.value = true;
    window.scrollTo({ top: 0, behavior: 'smooth' });
}
function reset() {
    submitted.value = false;
    files.value = {};
    otros.value = [];
}
</script>
