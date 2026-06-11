<template>
    <div class="min-h-screen bg-bg-light py-6 sm:py-10">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">

            <!-- ============ HERO ============ -->
            <section class="rounded-3xl bg-white px-6 py-12 text-center shadow-sm ring-1 ring-gray-100 sm:px-10">
                <span v-editable="'recopilacion.kicker'" class="inline-block rounded-full bg-teal/10 px-4 py-1.5 text-xs font-bold tracking-widest text-teal-dark">
                    {{ t('recopilacion.kicker', 'SEGUNDO PASO') }}
                </span>
                <h1 v-editable="'recopilacion.titulo'" class="mt-4 font-heading text-2xl font-black text-navy sm:text-4xl">
                    {{ t('recopilacion.titulo', 'RECOPILACIÓN DE INFORMACIÓN') }}
                </h1>
                <p v-editable="'recopilacion.subtitulo'" class="mt-3 text-lg font-bold text-teal sm:text-xl">
                    {{ t('recopilacion.subtitulo', 'Reciba un diagnóstico preciso y adaptado a su comunidad') }}
                </p>
                <p v-editable="'recopilacion.intro'" class="mx-auto mt-4 max-w-2xl leading-relaxed text-navy/65">
                    {{ t('recopilacion.intro', 'Para elaborar una evaluación rigurosa y ofrecer recomendaciones de valor, necesitamos conocer algunos aspectos básicos de su comunidad.') }}
                </p>

                <!-- Badge combinado navy + teal -->
                <div class="mt-7 flex justify-center">
                    <div class="flex overflow-hidden rounded-2xl shadow-sm ring-1 ring-gray-100">
                        <div class="flex items-center gap-2 bg-navy px-5 py-3 text-white">
                            <Icon name="stopwatch" class="h-6 w-6 text-teal-light" />
                            <div class="text-left leading-none">
                                <p class="text-[9px] font-bold tracking-widest">INFORME EN SOLO</p>
                                <p class="font-heading text-xl font-black text-teal-light">24 <span class="text-[10px] tracking-widest text-white">HORAS</span></p>
                            </div>
                        </div>
                        <div class="flex flex-col justify-center bg-teal px-5 py-3 text-center text-white">
                            <p class="text-[9px] font-bold tracking-widest">TODO POR SOLO</p>
                            <p class="font-heading text-xl font-black">100€</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ============ PROCESO ============ -->
            <section class="rounded-3xl bg-white px-6 py-12 shadow-sm ring-1 ring-gray-100 sm:px-10">
                <div class="text-center">
                    <h2 v-editable="'recopilacion.proceso_titulo'" class="inline-block font-heading text-2xl font-black text-navy sm:text-3xl">
                        {{ t('recopilacion.proceso_titulo', '¿CÓMO FUNCIONA NUESTRO PROCESO?') }}
                    </h2>
                    <div class="mx-auto mt-3 h-1 w-24 rounded-full bg-teal"></div>
                </div>

                <div class="mt-12 flex flex-col items-stretch gap-4 lg:flex-row lg:items-start">
                    <template v-for="(p, i) in pasos" :key="p.title">
                        <div class="flex-1 text-center">
                            <div class="relative mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-bg-light ring-1 ring-gray-100">
                                <Icon :name="p.icon" class="h-9 w-9 text-teal" />
                                <span class="absolute -left-1 -top-1 flex h-7 w-7 items-center justify-center rounded-full bg-teal font-heading text-sm font-black text-white ring-2 ring-white">
                                    {{ i + 1 }}
                                </span>
                            </div>
                            <h3 v-editable="`recopilacion.paso${i + 1}.titulo`" class="mt-4 text-sm font-extrabold text-navy">{{ p.title }}</h3>
                            <p v-editable="`recopilacion.paso${i + 1}.texto`" class="mx-auto mt-2 max-w-xs text-[13px] leading-relaxed text-navy/60">{{ p.text }}</p>
                        </div>
                        <div v-if="i < pasos.length - 1" class="flex shrink-0 items-center justify-center self-center text-teal lg:pt-8">
                            <Icon name="arrow" class="h-7 w-7 rotate-90 lg:rotate-0" />
                        </div>
                    </template>
                </div>
            </section>

            <!-- ============ DOS COLUMNAS ============ -->
            <section class="grid gap-6 lg:grid-cols-2">
                <!-- Documentación requerida -->
                <div class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-gray-100">
                    <div class="flex items-center gap-3 bg-navy px-6 py-4">
                        <Icon name="folder" class="h-6 w-6 text-teal-light" />
                        <h3 v-editable="'recopilacion.docs_titulo'" class="text-sm font-extrabold tracking-wide text-white">{{ t('recopilacion.docs_titulo', 'DOCUMENTACIÓN HABITUALMENTE REQUERIDA') }}</h3>
                    </div>
                    <ul v-editable="'recopilacion.docs'" class="space-y-4 p-6">
                        <li v-for="d in documentacion" :key="d" class="flex items-start gap-3 text-navy/80">
                            <span class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full border-2 border-teal text-teal">
                                <Icon name="check" class="h-3.5 w-3.5" />
                            </span>
                            <span class="text-sm leading-relaxed">{{ d }}</span>
                        </li>
                    </ul>
                </div>

                <!-- Entrega del informe -->
                <div class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-gray-100">
                    <div class="flex items-center gap-3 bg-teal px-6 py-4">
                        <Icon name="document" class="h-6 w-6 text-white" />
                        <h3 v-editable="'recopilacion.entrega_titulo'" class="text-sm font-extrabold tracking-wide text-white">{{ t('recopilacion.entrega_titulo', 'ENTREGA DEL INFORME') }}</h3>
                    </div>
                    <div class="p-6">
                        <p v-editable="'recopilacion.entrega_intro'" class="text-sm font-semibold text-navy/70">
                            {{ t('recopilacion.entrega_intro', 'Una vez recibida la documentación, elaboraremos un informe ejecutivo con:') }}
                        </p>
                        <ul v-editable="'recopilacion.entrega'" class="mt-4 space-y-4">
                            <li v-for="e in entrega" :key="e" class="flex items-start gap-3 text-navy/80">
                                <span class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full border-2 border-teal text-teal">
                                    <Icon name="check" class="h-3.5 w-3.5" />
                                </span>
                                <span class="text-sm leading-relaxed">{{ e }}</span>
                            </li>
                        </ul>

                        <div class="mt-6 flex items-center gap-3 rounded-2xl bg-teal/10 p-4">
                            <Icon name="stopwatch" class="h-8 w-8 shrink-0 text-teal-dark" />
                            <p v-editable="'recopilacion.plazo'" class="text-sm font-extrabold leading-snug text-teal-dark">
                                {{ t('recopilacion.plazo', 'INFORME DISPONIBLE EN UN PLAZO MÁXIMO DE 24 HORAS POR SOLO 100 €.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ============ CTA SUBIR DOCUMENTOS ============ -->
            <section class="overflow-hidden rounded-3xl bg-navy px-6 py-10 text-center sm:px-10">
                <h2 v-editable="'recopilacion.cta_titulo'" class="font-heading text-2xl font-black text-white sm:text-3xl">
                    {{ t('recopilacion.cta_titulo', '¿Ya tiene su documentación lista?') }}
                </h2>
                <p v-editable="'recopilacion.cta_texto'" class="mx-auto mt-3 max-w-xl text-sm leading-relaxed text-white/65">
                    {{ t('recopilacion.cta_texto', 'Adjunte los documentos solicitados de forma segura y reciba su informe en un plazo máximo de 24 horas.') }}
                </p>
                <router-link
                    v-editable="'recopilacion.cta_boton'"
                    to="/subir-documentos"
                    class="mt-7 inline-flex items-center gap-2 rounded-full bg-teal px-7 py-3.5 text-sm font-bold text-white shadow-lg transition hover:bg-teal-light"
                >
                    <Icon name="upload" class="h-5 w-5" />
                    {{ t('recopilacion.cta_boton', 'Subir mi documentación') }}
                    <Icon name="arrow" class="h-4 w-4" />
                </router-link>
            </section>

            <!-- ============ ATENCIÓN PERSONALIZADA ============ -->
            <section class="grid gap-px overflow-hidden rounded-3xl bg-gray-100 shadow-sm ring-1 ring-gray-100 sm:grid-cols-2">
                <div class="flex items-start gap-4 bg-white p-7">
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-teal/10 text-teal">
                        <Icon name="headset" class="h-6 w-6" />
                    </span>
                    <div>
                        <h3 v-editable="'recopilacion.atencion_titulo'" class="text-base font-extrabold text-teal">{{ t('recopilacion.atencion_titulo', 'ATENCIÓN PERSONALIZADA') }}</h3>
                        <p v-editable="'recopilacion.atencion_texto'" class="mt-2 text-sm leading-relaxed text-navy/65">
                            {{ t('recopilacion.atencion_texto', 'Cada comunidad presenta características y necesidades diferentes. Por ello, nuestro proceso comienza siempre con una conversación individualizada que nos permite adaptar el análisis y ofrecer soluciones específicas para su caso.') }}
                        </p>
                    </div>
                </div>
                <div class="flex items-start gap-4 bg-white p-7">
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-teal/10 text-teal">
                        <Icon name="phone" class="h-6 w-6" />
                    </span>
                    <div>
                        <h3 v-editable="'recopilacion.listo_titulo'" class="text-base font-extrabold text-navy">{{ t('recopilacion.listo_titulo', '¿LISTO PARA EMPEZAR?') }}</h3>
                        <p v-editable="'recopilacion.listo_texto'" class="mt-2 text-sm leading-relaxed text-navy/65">
                            {{ t('recopilacion.listo_texto', 'Facilite su número de teléfono y tendrá una conversación totalmente personalizada. Le asesoraremos de la mejor manera posible.') }}
                        </p>
                    </div>
                </div>
            </section>

            <!-- ============ FOOTER ============ -->
            <footer class="rounded-3xl bg-navy px-6 py-10 sm:px-10">
                <div class="grid gap-8 text-center sm:grid-cols-3 sm:text-left">
                    <div v-for="f in footerCols" :key="f.title" class="flex flex-col items-center gap-2 sm:items-start">
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-white/10 text-teal-light">
                            <Icon :name="f.icon" class="h-6 w-6" />
                        </span>
                        <h4 class="mt-1 text-sm font-extrabold tracking-wide text-teal-light">{{ f.title }}</h4>
                        <p class="text-[13px] leading-relaxed text-white/55">{{ f.text }}</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import Icon from '../components/Icon.vue';
import { useContenido } from '../composables/contenido';

const { t, lista } = useContenido();

const pasosPorDefecto = [
    { icon: 'phone', title: 'SOLICITE SU REVISIÓN', text: 'Facilítenos un número de teléfono de contacto y uno de nuestros especialistas se pondrá en contacto con usted.' },
    { icon: 'users', title: 'ANÁLISIS PRELIMINAR PERSONALIZADO', text: 'Mantendremos una breve conversación para comprender la situación actual de la comunidad, sus principales necesidades y los objetivos de la revisión.' },
    { icon: 'upload', title: 'ENVÍO DE DOCUMENTACIÓN', text: 'Tras esta primera toma de contacto, le indicaremos la documentación específica que necesitamos analizar. Solo tendrá que adjuntar los archivos solicitados.' },
];

const pasos = computed(() => pasosPorDefecto.map((p, i) => ({
    icon: p.icon,
    title: t(`recopilacion.paso${i + 1}.titulo`, p.title),
    text: t(`recopilacion.paso${i + 1}.texto`, p.text),
})));

const documentacion = computed(() => lista('recopilacion.docs', [
    'Últimas actas de la comunidad.',
    'Presupuesto y liquidación anual.',
    'Contratos de mantenimiento y servicios.',
    'Información sobre incidencias o actuaciones pendientes.',
    'Cualquier otra documentación relevante para la evaluación.',
]));

const entrega = computed(() => lista('recopilacion.entrega', [
    'Estado general de la comunidad.',
    'Riesgos y oportunidades detectadas.',
    'Recomendaciones de mejora priorizadas.',
    'Posibles optimizaciones económicas y operativas.',
]));

const footerCols = [
    { icon: 'shield', title: 'RIGOR Y CONFIDENCIALIDAD', text: 'Tratamos su información con la máxima seguridad.' },
    { icon: 'target', title: 'ENFOQUE TÉCNICO', text: 'Análisis profesional y objetivo basado en datos reales.' },
    { icon: 'bulb', title: 'SOLUCIONES QUE SUMAN', text: 'Recomendaciones prácticas que generan valor real.' },
];
</script>
