<template>
    <div class="min-h-screen bg-bg-light py-10">
        <div class="mx-auto max-w-3xl space-y-6 px-4 sm:px-6">
            <section v-reveal class="rounded-3xl bg-white p-8 shadow-sm ring-1 ring-gray-100 sm:p-10">
                <h1 v-reveal class="font-heading text-2xl font-black text-navy sm:text-3xl">{{ titulo }}</h1>

                <!-- Aviso legal -->
                <div v-if="seccion === 'aviso'" class="prose-legal">
                    <h2 v-reveal="90">Titular del sitio</h2>
                    <p>
                        Este sitio web es titularidad de
                        <strong v-editable="'legal.titular'">{{ t('legal.titular', '[Razón social pendiente]') }}</strong>,
                        con NIF/CIF <span v-editable="'legal.cif'">{{ t('legal.cif', '[CIF pendiente]') }}</span>
                        y domicilio en <span v-editable="'legal.direccion'">{{ t('legal.direccion', '[Dirección pendiente]') }}</span>.
                        Contacto: <span v-editable="'legal.email'">{{ t('legal.email', 'info@auditatucomunidad.com') }}</span>.
                    </p>
                    <h2 v-reveal="180">Condiciones de uso</h2>
                    <p>
                        El acceso a este sitio implica la aceptación de estas condiciones. Los contenidos
                        (textos, imágenes y marca) son propiedad del titular y no pueden reproducirse sin
                        autorización. El titular no se hace responsable del mal uso de los contenidos ni de
                        los daños derivados del uso de la información aquí publicada.
                    </p>
                </div>

                <!-- Privacidad -->
                <div v-else-if="seccion === 'privacidad'" class="prose-legal">
                    <h2 v-reveal="90">Responsable del tratamiento</h2>
                    <p>
                        <strong v-editable="'legal.titular'">{{ t('legal.titular', '[Razón social pendiente]') }}</strong> —
                        <span v-editable="'legal.email'">{{ t('legal.email', 'info@auditatucomunidad.com') }}</span>.
                    </p>
                    <h2 v-reveal="180">Qué datos tratamos y para qué</h2>
                    <p>
                        A través del formulario de envío de documentación recogemos: nombre de la comunidad,
                        teléfono y email de contacto, y los documentos que usted adjunta. Los usamos
                        <strong>exclusivamente para elaborar el informe de revisión de su comunidad</strong>
                        y ponernos en contacto con usted. La base legal es su consentimiento, que presta al
                        marcar la casilla del formulario.
                    </p>
                    <h2 v-reveal="270">Conservación</h2>
                    <p>
                        Los envíos y sus archivos se <strong>eliminan automáticamente a los 30 días</strong>.
                        Los archivos se almacenan cifrados.
                    </p>
                    <h2 v-reveal="360">Destinatarios</h2>
                    <p>
                        No cedemos sus datos a terceros. Solo accede a ellos el equipo que elabora el informe.
                    </p>
                    <h2 v-reveal="450">Sus derechos</h2>
                    <p>
                        Puede ejercer sus derechos de acceso, rectificación, supresión, oposición, limitación
                        y portabilidad escribiendo a
                        <span v-editable="'legal.email'">{{ t('legal.email', 'info@auditatucomunidad.com') }}</span>.
                        También puede reclamar ante la Agencia Española de Protección de Datos (aepd.es).
                    </p>
                </div>

                <!-- Cookies -->
                <div v-else class="prose-legal">
                    <h2 v-reveal="90">Qué cookies usamos</h2>
                    <p>
                        Este sitio utiliza únicamente <strong>cookies técnicas</strong> imprescindibles para su
                        funcionamiento (sesión y seguridad). No requieren consentimiento según la normativa
                        vigente y no se usan con fines publicitarios ni de seguimiento.
                    </p>
                    <p>
                        Si en el futuro incorporamos cookies de análisis o publicidad, se lo pediremos antes
                        mediante un aviso de consentimiento y actualizaremos esta política.
                    </p>
                    <p>
                        Puede cambiar o retirar su consentimiento en cualquier momento:
                    </p>
                    <button
                        type="button"
                        class="mt-1 inline-flex items-center gap-2 rounded-lg border border-teal px-4 py-2 text-sm font-bold text-teal transition hover:bg-teal hover:text-white"
                        @click="reabrirBanner"
                    >
                        Cambiar mis preferencias de cookies
                    </button>
                </div>

                <router-link v-reveal="180" to="/" class="mt-8 inline-flex items-center gap-2 text-sm font-bold text-teal transition hover:text-teal-dark">
                    ← Volver al inicio
                </router-link>
            </section>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { useRoute } from 'vue-router';
import { useContenido } from '../composables/contenido';
import { reabrirBanner } from '../composables/consent';

const { t } = useContenido();
const route = useRoute();

const seccion = computed(() => {
    if (route.path.includes('aviso-legal')) return 'aviso';
    if (route.path.includes('privacidad')) return 'privacidad';
    return 'cookies';
});

const titulo = computed(() => ({
    aviso: 'Aviso legal',
    privacidad: 'Política de privacidad',
    cookies: 'Política de cookies',
}[seccion.value]));
</script>

<style scoped>
.prose-legal h2 {
    margin-top: 1.75rem;
    font-size: 1rem;
    font-weight: 800;
    color: rgb(16 42 67);
}
.prose-legal p {
    margin-top: 0.75rem;
    font-size: 0.9rem;
    line-height: 1.7;
    color: rgb(16 42 67 / 0.7);
}
</style>
