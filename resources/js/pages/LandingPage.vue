<template>
    <div>
        <!-- ============ HERO ============ -->
        <section class="relative overflow-hidden bg-white">
            <!-- Composición propia: foto de edificio + sellos (escritorio) -->
            <div v-reveal class="absolute inset-y-0 right-0 hidden w-[62%] lg:block">
                <img
                    :src="heroBuilding"
                    alt="Edificio residencial moderno en perspectiva bajo revisión"
                    class="h-full w-full object-cover object-center [-webkit-mask-image:linear-gradient(to_right,transparent,#000_46%)] [mask-image:linear-gradient(to_right,transparent,#000_46%)]"
                />

                <!-- Funde el pie de la imagen con la sección navy (sin canto) -->
                <div class="absolute inset-x-0 bottom-0 h-28 bg-gradient-to-b from-navy/0 to-navy"></div>

                <!-- Sello informe 24h (sobre el cielo, centro-izquierda) -->
                <div class="absolute left-[14%] top-[10%] z-10 flex h-36 w-36 flex-col items-center justify-center rounded-full bg-navy text-center text-white shadow-xl ring-4 ring-white/70">
                    <Icon name="stopwatch" class="h-6 w-6 text-white" />
                    <span v-editable="'hero.circulo_arriba'" class="mt-1 whitespace-pre-line text-[11px] font-bold leading-tight tracking-widest">{{ t('hero.circulo_arriba', 'INFORME\nEN SOLO') }}</span>
                    <span v-editable="'hero.circulo_numero'" class="font-heading text-4xl font-black leading-none text-teal-light">{{ t('hero.circulo_numero', '24') }}</span>
                    <span v-editable="'hero.circulo_abajo'" class="text-xs font-bold tracking-[0.25em]">{{ t('hero.circulo_abajo', 'HORAS') }}</span>
                </div>

                <!-- Sello 100€ pago único (donde estaba la lupa) -->
                <div class="absolute right-[11%] top-[38%] z-10 flex h-40 w-40 flex-col items-center justify-center rounded-full bg-gradient-to-br from-teal-light to-teal text-center text-navy shadow-2xl ring-4 ring-white/70">
                    <p v-editable="'hero.precio'" class="font-heading text-5xl font-black leading-none">{{ t('hero.precio', '100€') }}</p>
                    <p v-editable="'hero.precio_sub'" class="mt-1 text-xs font-extrabold tracking-[0.18em]">{{ t('hero.precio_sub', 'PAGO ÚNICO') }}</p>
                </div>
            </div>

            <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
                <div class="flex min-h-[34rem] max-w-xl flex-col justify-center py-16 sm:py-20 lg:min-h-[40rem] lg:py-24">
                    <p v-reveal v-editable="'hero.eslogan'" class="mb-4 text-xs font-bold tracking-[0.22em] text-navy/60">
                        {{ t('hero.eslogan', 'REVISAMOS. DETECTAMOS. SOLUCIONAMOS.') }}
                    </p>
                    <h1 v-reveal="90" class="font-heading text-4xl font-black leading-[1.05] sm:text-5xl xl:text-6xl">
                        <span v-editable="'hero.titulo_navy'" class="whitespace-pre-line text-navy">{{ t('hero.titulo_navy', 'REVISAMOS\nTU COMUNIDAD,') }}</span><br>
                        <span v-editable="'hero.titulo_teal'" class="whitespace-pre-line text-teal">{{ t('hero.titulo_teal', 'MEJORAMOS\nTU TRANQUILIDAD') }}</span>
                    </h1>
                    <p v-reveal="190" v-editable="'hero.parrafo'" class="mt-7 max-w-md border-l-4 border-teal pl-4 text-base leading-relaxed text-navy/70">
                        {{ t('hero.parrafo', 'Por solo 100 €, envíanos tu solicitud y en menos de 24 horas recibirás un informe claro con todas las mejoras que podemos aplicar en tu comunidad.') }}
                    </p>

                    <!-- Pilares (del cartel) dentro del hero -->
                    <div v-reveal="240" class="mt-8 grid max-w-md grid-cols-2 gap-x-5 gap-y-5 sm:grid-cols-4">
                        <div v-for="p in pilares" :key="p.clave" class="flex flex-col items-center text-center sm:items-start sm:text-left">
                            <span class="flex h-11 w-11 items-center justify-center rounded-full ring-2 ring-teal/40">
                                <Icon :name="p.icono" class="h-5 w-5 text-teal" />
                            </span>
                            <p v-editable="p.clave" class="mt-2 whitespace-pre-line text-[10px] font-bold uppercase leading-tight tracking-wide text-navy sm:text-[11px]">{{ t(p.clave, p.texto) }}</p>
                        </div>
                    </div>

                    <!-- Claim -->
                    <p v-reveal="280" class="mt-7 font-heading text-xl font-black uppercase sm:text-2xl">
                        <span v-editable="'hero.claim_1'" class="text-navy">{{ t('hero.claim_1', 'TODO INCLUIDO.') }}</span>
                        <span v-editable="'hero.claim_2'" class="text-teal">{{ t('hero.claim_2', 'CERO PREOCUPACIONES.') }}</span>
                    </p>

                    <div v-reveal="320" class="mt-8 flex flex-wrap items-center gap-3">
                        <router-link
                            v-editable="'hero.cta_primario'"
                            to="/solicitar"
                            class="inline-flex items-center gap-2 rounded-full bg-teal px-6 py-3 text-sm font-bold text-white shadow-md transition hover:bg-teal-dark hover:shadow-lg"
                        >
                            {{ t('hero.cta_primario', 'Contrátalo ahora') }}
                            <Icon name="arrow" class="h-4 w-4" />
                        </router-link>
                        <router-link
                            v-editable="'hero.cta_secundario'"
                            to="/recopilacion"
                            class="inline-flex items-center gap-2 rounded-full border-2 border-navy/15 px-6 py-3 text-sm font-bold text-navy transition hover:border-teal hover:text-teal"
                        >
                            {{ t('hero.cta_secundario', 'Cómo funciona') }}
                        </router-link>
                    </div>
                    <p v-reveal="360" v-editable="'hero.cta_nota'" class="mt-3 text-xs text-navy/50">
                        {{ t('hero.cta_nota', 'Un técnico se pondrá en contacto contigo a la mayor brevedad.') }}
                    </p>
                </div>
            </div>

            <!-- Composición para móvil -->
            <div v-reveal class="relative -mt-2 lg:hidden">
                <img
                    :src="heroBuilding"
                    alt="Edificio residencial moderno bajo revisión"
                    class="h-72 w-full object-cover object-center sm:h-96 [-webkit-mask-image:linear-gradient(to_top,transparent,#000_22%)] [mask-image:linear-gradient(to_top,transparent,#000_22%)]"
                />
                <!-- Sello 24h -->
                <div class="absolute left-5 top-6 flex h-24 w-24 flex-col items-center justify-center rounded-full bg-navy text-center text-white shadow-xl ring-4 ring-white/70">
                    <Icon name="stopwatch" class="h-4 w-4 text-white" />
                    <span v-editable="'hero.circulo_arriba'" class="mt-0.5 whitespace-pre-line text-[8px] font-bold leading-tight tracking-widest">{{ t('hero.circulo_arriba', 'INFORME\nEN SOLO') }}</span>
                    <span v-editable="'hero.circulo_numero'" class="font-heading text-2xl font-black leading-none text-teal-light">{{ t('hero.circulo_numero', '24') }}</span>
                    <span v-editable="'hero.circulo_abajo'" class="text-[9px] font-bold tracking-[0.25em]">{{ t('hero.circulo_abajo', 'HORAS') }}</span>
                </div>
                <!-- Sello 100€ -->
                <div class="absolute bottom-6 right-5 flex h-24 w-24 flex-col items-center justify-center rounded-full bg-gradient-to-br from-teal-light to-teal text-center text-navy shadow-xl ring-4 ring-white/70">
                    <p v-editable="'hero.precio'" class="font-heading text-2xl font-black leading-none">{{ t('hero.precio', '100€') }}</p>
                    <p v-editable="'hero.precio_sub'" class="mt-0.5 text-[9px] font-extrabold tracking-[0.15em]">{{ t('hero.precio_sub', 'PAGO ÚNICO') }}</p>
                </div>
            </div>
        </section>

        <!-- ============ SERVICIOS ============ -->
        <section class="bg-navy py-20">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="text-center">
                    <span v-reveal v-editable="'servicios.titulo'" class="inline-block rounded-full bg-teal px-6 py-2 text-sm font-extrabold tracking-wide text-white">
                        {{ t('servicios.titulo', '¿QUÉ INCLUYE NUESTRA REVISIÓN?') }}
                    </span>
                </div>

                <div class="mt-14 grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
                    <div
                        v-for="(s, i) in servicios"
                        :key="s.title"
                        v-reveal="i * 70"
                        class="group cursor-default rounded-2xl p-6 text-center ring-1 ring-transparent transition duration-300 hover:-translate-y-1.5 hover:bg-white/[0.06] hover:shadow-2xl hover:ring-white/10 lg:text-left"
                    >
                        <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-xl bg-white/10 text-teal-light transition duration-300 group-hover:scale-110 group-hover:bg-teal group-hover:text-white lg:mx-0">
                            <Icon :name="s.icon" class="h-7 w-7" />
                        </span>
                        <h3 v-editable="`servicios.${i + 1}.titulo`" class="mt-5 text-sm font-extrabold leading-tight tracking-wide text-white transition duration-300 group-hover:text-teal-light">
                            {{ s.title }}
                        </h3>
                        <p v-editable="`servicios.${i + 1}.texto`" class="mt-3 text-sm leading-relaxed text-white/55 transition duration-300 group-hover:text-white/75">
                            {{ s.text }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ============ PRECIO ============ -->
        <section class="bg-bg-light py-20">
            <div class="mx-auto grid max-w-7xl items-center gap-12 px-6 lg:grid-cols-2 lg:px-8">
                <!-- Izquierda -->
                <div>
                    <p v-reveal v-editable="'precio.kicker'" class="text-sm font-bold tracking-[0.2em] text-navy/60">{{ t('precio.kicker', 'TODO ESTO POR SOLO') }}</p>
                    <p v-reveal="90" v-editable="'precio.importe'" class="mt-1 font-heading text-7xl font-black text-teal sm:text-8xl">{{ t('precio.importe', '100€') }}</p>

                    <ul v-reveal="180" v-editable="'precio.checklist'" class="mt-8 space-y-4">
                        <li v-for="c in checklist" :key="c" class="flex items-center gap-3 text-lg font-semibold text-navy">
                            <span class="flex h-7 w-7 items-center justify-center rounded-full border-2 border-teal text-teal">
                                <Icon name="check" class="h-4 w-4" />
                            </span>
                            {{ c }}
                        </li>
                    </ul>
                </div>

                <!-- Derecha: preview informe -->
                <div v-reveal="120" class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-gray-100 sm:p-8">
                    <div class="text-center">
                        <span v-editable="'precio.informe_badge'" class="inline-block rounded-full bg-teal px-5 py-1.5 text-xs font-bold tracking-wide text-white">
                            {{ t('precio.informe_badge', 'RECIBIRÁS UN INFORME BREVE Y CLARO') }}
                        </span>
                    </div>

                    <div class="mt-6 rounded-2xl bg-bg-light p-5 ring-1 ring-gray-100">
                        <div class="grid grid-cols-3 gap-3">
                            <div class="col-span-1 row-span-2 flex flex-col rounded-lg bg-navy p-3 text-white">
                                <span class="text-[9px] font-bold leading-tight">INFORME DE REVISIÓN DE COMUNIDAD</span>
                                <span class="mt-2 flex-1 rounded bg-white/10"></span>
                            </div>
                            <div v-for="card in miniCards" :key="card.t" class="rounded-lg bg-white p-2.5 shadow-sm ring-1 ring-gray-100">
                                <span class="text-[8px] font-bold leading-tight text-navy">{{ card.t }}</span>
                                <div class="mt-2 flex items-end gap-0.5" :class="card.chart === 'pie' ? 'justify-center' : ''">
                                    <template v-if="card.chart === 'bars'">
                                        <span v-for="(h, n) in [6,10,7,12,9]" :key="n" class="w-1.5 rounded-sm bg-teal" :style="{ height: h + 'px' }"></span>
                                    </template>
                                    <span v-else class="h-7 w-7 rounded-full border-[5px] border-teal border-r-teal-light border-t-navy"></span>
                                </div>
                            </div>
                            <div class="col-span-2 rounded-lg bg-teal/10 p-2.5">
                                <span class="text-[9px] font-extrabold text-teal-dark">PLAN DE MEJORA</span>
                                <div class="mt-1.5 space-y-1">
                                    <span class="block h-1 w-full rounded bg-teal/40"></span>
                                    <span class="block h-1 w-3/4 rounded bg-teal/40"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <p v-editable="'precio.informe_nota'" class="mt-4 flex items-center justify-center gap-2 text-center text-sm font-semibold text-navy/70">
                        <Icon name="document" class="h-4 w-4 text-teal" />
                        {{ t('precio.informe_nota', 'Información clara. Recomendaciones accionables. Resultados reales.') }}
                    </p>
                </div>
            </div>
        </section>

        <!-- ============ FOOTER ============ -->
        <footer class="bg-navy py-12">
            <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-6 px-6 text-center md:flex-row md:text-left lg:px-8">
                <div class="flex items-center gap-4">
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-white/10 text-teal-light">
                        <Icon name="shield" class="h-7 w-7" />
                    </span>
                    <div>
                        <p v-editable="'footer.titulo'" class="text-lg font-extrabold text-teal-light">{{ t('footer.titulo', 'Tu comunidad en buenas manos.') }}</p>
                        <p v-editable="'footer.subtitulo'" class="text-sm text-white/60">{{ t('footer.subtitulo', 'Porque prevenir hoy, es ahorrar mañana.') }}</p>
                    </div>
                </div>

                <a v-if="tieneTelefono || edicion" :href="telHref" class="flex items-center gap-3 transition hover:opacity-80">
                    <Icon name="phone" class="h-7 w-7 shrink-0 text-teal-light" />
                    <div>
                        <p v-editable="'footer.telefono'" class="text-lg font-extrabold text-teal-light">{{ telefono || 'Añadir teléfono' }}</p>
                        <p class="text-sm text-white/60">Llámanos sin compromiso.</p>
                    </div>
                </a>

                <router-link to="/" class="flex items-center gap-3 transition hover:opacity-80">
                    <Icon name="globe" class="h-7 w-7 shrink-0 text-teal-light" />
                    <div>
                        <p v-editable="'footer.dominio'" class="text-lg font-extrabold text-teal-light">{{ t('footer.dominio', 'auditatucomunidad.com') }}</p>
                        <p v-editable="'footer.dominio_sub'" class="text-sm text-white/60">{{ t('footer.dominio_sub', 'Revisamos tu comunidad.') }}</p>
                    </div>
                </router-link>
            </div>
            <!-- Marca matriz: Yo Vivo Tranquilo (logo "yv" vectorizado en SVG) -->
            <div class="mt-8 flex items-center justify-center gap-2 text-white/50">
                <svg viewBox="0 0 28 24" class="h-5 w-6" fill="none" aria-hidden="true">
                    <path d="M3 3 L10 15 L10 21" stroke="#3dbdaf" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M10 15 L17 3" stroke="#3dbdaf" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M16 9 L21 19 L26 9" stroke="#ffffff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="text-xs font-bold uppercase tracking-wide">Una marca de Yo Vivo Tranquilo</span>
            </div>
            <div class="mt-6 flex flex-wrap items-center justify-center gap-x-5 gap-y-2 text-xs text-white/40">
                <router-link to="/aviso-legal" class="transition hover:text-white/70">Aviso legal</router-link>
                <router-link to="/privacidad" class="transition hover:text-white/70">Privacidad</router-link>
                <router-link to="/cookies" class="transition hover:text-white/70">Cookies</router-link>
                <a v-if="!esDemo" href="/admin" class="text-white/30 transition hover:text-white/60">Acceso administración</a>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import Icon from '../components/Icon.vue';
import Magnifier from '../components/Magnifier.vue';
import heroBuilding from '../../images/hero-building.jpg';
import { useContenido, edicion } from '../composables/contenido';

const { t, lista } = useContenido();
const esDemo = import.meta.env.VITE_GH_PAGES === '1';

const telefono = computed(() => t('footer.telefono', '').trim());
const tieneTelefono = computed(() => telefono.value.length > 0);
const telHref = computed(() => 'tel:+34' + telefono.value.replace(/\D/g, ''));

// Pilares del hero (mismos del cartel "Audita tu Comunidad 360")
const pilares = [
    { clave: 'hero.pilar_1', icono: 'bolt', texto: 'EFICIENCIA\nENERGÉTICA' },
    { clave: 'hero.pilar_2', icono: 'shield', texto: 'MÁXIMA\nSEGURIDAD' },
    { clave: 'hero.pilar_3', icono: 'wrench', texto: 'MANTENIMIENTO\nINCLUIDO' },
    { clave: 'hero.pilar_4', icono: 'euro', texto: 'CUOTAS\nCUBIERTAS' },
];

const serviciosPorDefecto = [
    { icon: 'building', title: 'ESTRUCTURA Y CONSERVACIÓN', text: 'Evaluamos el estado de las instalaciones, elementos comunes y mantenimiento.' },
    { icon: 'scale', title: 'GESTIÓN LEGAL', text: 'Revisamos el cumplimiento normativo, contratos y documentación de la comunidad.' },
    { icon: 'calculator', title: 'ANÁLISIS ECONÓMICO', text: 'Analizamos ingresos, gastos y contratos para optimizar recursos.' },
    { icon: 'shield', title: 'RIESGOS Y PREVENCIÓN', text: 'Detectamos posibles riesgos y aspectos críticos antes de que se conviertan en problemas.' },
    { icon: 'trending', title: 'PLAN DE MEJORA', text: 'Te entregamos recomendaciones prácticas y priorizadas para mejorar tu comunidad.' },
];

const servicios = computed(() => serviciosPorDefecto.map((s, i) => ({
    icon: s.icon,
    title: t(`servicios.${i + 1}.titulo`, s.title),
    text: t(`servicios.${i + 1}.texto`, s.text),
})));

const checklist = computed(() => lista('precio.checklist', ['Precio cerrado', 'Sin compromiso', 'Máxima transparencia']));

const miniCards = [
    { t: 'RESUMEN EJECUTIVO', chart: 'bars' },
    { t: 'ANÁLISIS ECONÓMICO', chart: 'pie' },
];
</script>
