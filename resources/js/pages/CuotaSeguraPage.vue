<template>
    <div>
        <!-- ============ HERO ============ -->
        <section class="relative overflow-hidden bg-white">
            <!-- Composición: foto de edificio + sello Cuota Segura (escritorio) -->
            <div v-reveal class="absolute inset-y-0 right-0 hidden w-[58%] lg:block">
                <img
                    :src="edificioCuota"
                    alt="Edificio residencial moderno protegido por Cuota Segura"
                    class="h-full w-full object-cover object-center [-webkit-mask-image:linear-gradient(to_right,transparent,#000_46%)] [mask-image:linear-gradient(to_right,transparent,#000_46%)]"
                />

                <!-- Funde el pie de la imagen con la franja navy siguiente (sin canto) -->
                <div class="absolute inset-x-0 bottom-0 h-24 bg-gradient-to-b from-navy/0 to-navy"></div>

                <!-- Sello Cuota Segura sobre el cielo (z-10: el contenedor del texto
                     del hero se pinta encima y bloquea el hover/clic sin esto) -->
                <div class="absolute right-[14%] top-[18%] z-10 flex h-40 w-40 flex-col items-center justify-center rounded-full bg-navy text-center text-white shadow-2xl ring-4 ring-white/70 transition duration-300 hover:scale-105">
                    <Icon name="shield" class="h-10 w-10 text-teal-light" />
                    <span class="mt-1 font-heading text-base font-black leading-tight">
                        CUOTA<br><span class="text-teal-light">SEGURA</span>
                    </span>
                </div>
            </div>

            <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
                <div class="flex min-h-[30rem] max-w-xl flex-col justify-center py-16 sm:py-20 lg:min-h-[34rem]">
                    <p v-reveal v-editable="'cuota.kicker'" class="mb-4 text-xs font-bold tracking-[0.22em] text-navy/60">
                        {{ t('cuota.kicker', 'NUESTRO COMPROMISO') }}
                    </p>
                    <h1 v-reveal="90" class="font-heading text-4xl font-black leading-[1.05] sm:text-5xl">
                        <span v-editable="'cuota.titulo_navy'" class="whitespace-pre-line text-navy">{{ t('cuota.titulo_navy', 'NUESTRA') }}</span><br>
                        <span v-editable="'cuota.titulo_teal'" class="whitespace-pre-line text-teal">{{ t('cuota.titulo_teal', 'CUOTA SEGURA') }}</span>
                    </h1>
                    <p v-reveal="190" v-editable="'cuota.parrafo'" class="mt-7 max-w-md border-l-4 border-teal pl-4 text-base leading-relaxed text-navy/70">
                        {{ t('cuota.parrafo', 'No importa que un vecino no pague la comunidad: nosotros nos haremos cargo de todo para que esto no frene la vida de la comunidad.') }}
                    </p>
                    <div v-reveal="280" class="mt-8">
                        <component
                            :is="tieneTelefono ? 'a' : 'router-link'"
                            v-editable="'cuota.cta'"
                            :href="tieneTelefono ? telHref : null"
                            :to="tieneTelefono ? null : '/subir-documentos'"
                            class="inline-flex items-center gap-2 rounded-full bg-teal px-6 py-3 text-sm font-bold text-white shadow-md transition hover:bg-teal-dark hover:shadow-lg"
                        >
                            {{ t('cuota.cta', 'Solicitar información') }}
                            <Icon name="arrow" class="h-4 w-4" />
                        </component>
                    </div>
                </div>
            </div>

            <!-- Composición para móvil -->
            <div v-reveal class="relative -mt-2 lg:hidden">
                <img
                    :src="edificioCuota"
                    alt="Edificio residencial moderno protegido por Cuota Segura"
                    class="h-64 w-full object-cover object-center sm:h-80 [-webkit-mask-image:linear-gradient(to_top,transparent,#000_22%)] [mask-image:linear-gradient(to_top,transparent,#000_22%)]"
                />
                <div class="absolute right-[8%] top-1/2 flex h-32 w-32 -translate-y-1/2 flex-col items-center justify-center rounded-full bg-navy text-center text-white shadow-2xl ring-4 ring-white/70">
                    <Icon name="shield" class="h-8 w-8 text-teal-light" />
                    <span class="mt-1 font-heading text-sm font-black leading-tight">
                        CUOTA<br><span class="text-teal-light">SEGURA</span>
                    </span>
                </div>
            </div>
        </section>

        <!-- ============ FRANJA CARTEL "Cuota Segura 360" ============ -->
        <section class="relative overflow-hidden bg-navy py-14 text-white sm:py-16">
            <div class="pointer-events-none absolute inset-0 opacity-[0.06] [background-image:radial-gradient(circle_at_1px_1px,#fff_1px,transparent_0)] [background-size:22px_22px]"></div>

            <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
                <!-- Pilares + sello de precio -->
                <div class="flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between">
                    <div v-reveal class="grid grid-cols-2 gap-x-4 gap-y-6 sm:grid-cols-4 sm:gap-6">
                        <div v-for="p in pilares" :key="p.clave" class="flex flex-col items-center text-center sm:items-start sm:text-left">
                            <span class="flex h-12 w-12 items-center justify-center rounded-full ring-2 ring-teal-light/50">
                                <Icon :name="p.icono" class="h-6 w-6 text-teal-light" />
                            </span>
                            <p v-editable="p.clave" class="mt-2 whitespace-pre-line text-[11px] font-bold uppercase leading-tight tracking-wide sm:text-xs">{{ t(p.clave, p.texto) }}</p>
                        </div>
                    </div>

                    <div v-reveal="160" class="-skew-x-6 self-center rounded-lg bg-gradient-to-br from-teal-light to-teal px-7 py-4 text-navy shadow-lg shadow-teal/20">
                        <div class="skew-x-6 text-center">
                            <p v-editable="'cuota.precio'" class="font-heading text-4xl font-black leading-none sm:text-5xl">{{ t('cuota.precio', '100€') }}</p>
                            <p v-editable="'cuota.precio_sub'" class="mt-0.5 text-xs font-extrabold tracking-[0.18em]">{{ t('cuota.precio_sub', 'PAGO ÚNICO') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Claim -->
                <p v-reveal="200" class="mt-10 font-heading text-2xl font-black uppercase sm:text-3xl">
                    <span v-editable="'cuota.claim_1'" class="text-white">{{ t('cuota.claim_1', 'TODO INCLUIDO.') }}</span>
                    <span v-editable="'cuota.claim_2'" class="text-teal-light">{{ t('cuota.claim_2', 'CERO PREOCUPACIONES.') }}</span>
                </p>

                <!-- Marca: dominio + Yo Vivo Tranquilo -->
                <div v-reveal="240" class="mt-8 inline-flex flex-wrap items-center gap-x-4 gap-y-2 rounded-full border border-white/15 px-5 py-3">
                    <span class="flex items-center gap-2">
                        <Icon name="globe" class="h-5 w-5 text-teal-light" />
                        <span v-editable="'cuota.dominio'" class="text-sm font-bold tracking-wide sm:text-base"><span class="text-white">auditatu</span><span class="text-teal-light">comunidad</span><span class="text-white">.com</span></span>
                    </span>
                    <span class="hidden h-5 w-px bg-white/20 sm:block"></span>
                    <span class="flex items-center gap-2">
                        <!-- Monograma "yv" (vectorizado en SVG) -->
                        <svg viewBox="0 0 28 24" class="h-6 w-7" fill="none" aria-hidden="true">
                            <path d="M3 3 L10 15 L10 21" stroke="#3dbdaf" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M10 15 L17 3" stroke="#3dbdaf" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16 9 L21 19 L26 9" stroke="#ffffff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span class="text-[11px] font-bold uppercase leading-tight tracking-wide text-white/80">Yo Vivo<br>Tranquilo</span>
                    </span>
                </div>
            </div>
        </section>

        <!-- ============ CÓMO FUNCIONA ============ -->
        <section class="bg-bg-light py-20">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="text-center">
                    <span v-reveal v-editable="'cuota.como_titulo'" class="inline-block rounded-full bg-teal px-6 py-2 text-sm font-extrabold tracking-wide text-white">
                        {{ t('cuota.como_titulo', '¿CÓMO FUNCIONA?') }}
                    </span>
                </div>

                <div class="mt-14 flex flex-col items-stretch gap-4 lg:flex-row">
                    <template v-for="(p, i) in pasos" :key="p.title">
                        <div v-reveal="i * 70" class="group flex-1 rounded-2xl bg-white p-7 text-center shadow-sm ring-1 ring-gray-100 transition duration-300 hover:-translate-y-1.5 hover:shadow-xl">
                            <div class="relative mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-bg-light transition duration-300 group-hover:scale-110 group-hover:bg-teal">
                                <Icon :name="p.icon" class="h-9 w-9 text-teal transition duration-300 group-hover:text-white" />
                                <span class="absolute -left-1 -top-1 flex h-7 w-7 items-center justify-center rounded-full bg-navy font-heading text-sm font-black text-white ring-2 ring-white">
                                    {{ i + 1 }}
                                </span>
                            </div>
                            <h3 v-editable="`cuota.paso${i + 1}.titulo`" class="mt-5 text-sm font-extrabold tracking-wide text-navy transition duration-300 group-hover:text-teal">
                                {{ p.title }}
                            </h3>
                            <p v-editable="`cuota.paso${i + 1}.texto`" class="mx-auto mt-3 max-w-xs text-[13px] leading-relaxed text-navy/60">{{ p.text }}</p>
                            <span
                                v-editable="`cuota.paso${i + 1}.chip`"
                                class="mt-4 inline-block rounded-full px-3 py-1 text-[10px] font-extrabold tracking-widest"
                                :class="p.chipClass"
                            >
                                {{ p.chip }}
                            </span>
                        </div>
                        <div v-if="i < pasos.length - 1" class="flex shrink-0 items-center justify-center self-center text-teal">
                            <Icon name="arrow" class="h-7 w-7 rotate-90 lg:rotate-0" />
                        </div>
                    </template>
                </div>

                <!-- Gráfico: los ingresos caen con el impago y la Cuota Segura los recupera -->
                <div ref="graficoEl" class="mt-16" :class="{ 'grafico-activo': graficoVisible }">
                    <p v-editable="'cuota.grafico_titulo'" class="text-center text-xs font-bold tracking-widest text-navy/60">
                        {{ t('cuota.grafico_titulo', 'TUS INGRESOS NO SE RESIENTEN') }}
                    </p>
                    <div class="mx-auto mt-6 max-w-2xl rounded-3xl bg-white p-6 shadow-sm ring-1 ring-gray-100 sm:p-8">
                        <!-- Contador: de -1.000 € (rojo) a +1.000 € (verde) -->
                        <p class="text-center font-heading text-4xl font-black tabular-nums transition-colors duration-700 sm:text-5xl" :class="monto < 0 ? 'text-red-500' : 'text-teal'">
                            {{ montoTexto }}
                        </p>

                        <svg viewBox="0 0 600 300" class="mt-2 w-full" role="img" aria-label="Ilustración: las cuentas de la comunidad caen en rojo y se recuperan en verde, con la flecha subiendo en zig-zag.">
                            <!-- Cuadrícula suave -->
                            <line x1="40" y1="80" x2="560" y2="80" stroke="#eef2f4" stroke-width="2" />
                            <line x1="40" y1="140" x2="560" y2="140" stroke="#eef2f4" stroke-width="2" />
                            <line x1="40" y1="200" x2="560" y2="200" stroke="#eef2f4" stroke-width="2" />
                            <line x1="40" y1="266" x2="560" y2="266" stroke="#dbe3e7" stroke-width="2.5" stroke-linecap="round" />

                            <!-- Barras en valle: rojas bajan (fase 1), verdes suben (fase 2) -->
                            <rect
                                v-for="(b, i) in barras"
                                :key="i"
                                class="g-barra"
                                :style="{ '--d': b.d }"
                                :x="b.x"
                                :y="b.y"
                                :width="40"
                                :height="b.h"
                                rx="6"
                                :fill="b.c"
                            />

                            <!-- Línea en zig-zag por la punta de cada barra: cae (rojo) y remonta (verde), trazo continuo -->
                            <path class="g-linea g-dip" pathLength="1" d="M65,126 L125,186 L185,156 L245,211 L305,231" />
                            <path class="g-linea g-rise" pathLength="1" d="M305,231 L365,171 L425,196 L485,116 L545,61" />

                            <!-- Flecha que remonta (borde blanco fino para que recorte sobre las barras) -->
                            <path class="g-punta" d="M18,0 L-14,-16 L-14,16 Z" fill="#2a9d8f" stroke="#fff" stroke-width="3" stroke-linejoin="round" />
                        </svg>

                        <p class="mt-2 text-center text-sm font-semibold text-navy/70">
                            Cuando llega la morosidad tus cuentas caen… y con la Cuota Segura
                            <span class="font-bold text-teal-dark">vuelven a subir</span>.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ============ POR QUÉ ES IMPORTANTE ============ -->
        <section class="bg-navy py-20">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="text-center">
                    <span v-reveal v-editable="'cuota.importancia_titulo'" class="inline-block rounded-full bg-teal px-6 py-2 text-sm font-extrabold tracking-wide text-white">
                        {{ t('cuota.importancia_titulo', '¿POR QUÉ ES TAN IMPORTANTE LA CUOTA SEGURA?') }}
                    </span>
                </div>

                <div class="mt-14 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <div
                        v-for="(b, i) in beneficios"
                        :key="b.title"
                        v-reveal="i * 70"
                        class="group cursor-default rounded-2xl p-6 text-center ring-1 ring-transparent transition duration-300 hover:-translate-y-1.5 hover:bg-white/[0.06] hover:shadow-2xl hover:ring-white/10"
                    >
                        <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-xl bg-white/10 text-teal-light transition duration-300 group-hover:scale-110 group-hover:bg-teal group-hover:text-white">
                            <Icon :name="b.icon" class="h-7 w-7" />
                        </span>
                        <h3 v-editable="`cuota.beneficio${i + 1}.titulo`" class="mt-5 text-sm font-extrabold leading-tight tracking-wide text-white transition duration-300 group-hover:text-teal-light">
                            {{ b.title }}
                        </h3>
                        <p v-editable="`cuota.beneficio${i + 1}.texto`" class="mt-3 text-sm leading-relaxed text-white/55 transition duration-300 group-hover:text-white/75">
                            {{ b.text }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ============ CIERRE / CTA ============ -->
        <section class="bg-white py-20">
            <div v-reveal class="mx-auto flex max-w-2xl flex-col items-center px-6 text-center lg:px-8">
                <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-teal text-white shadow-md">
                    <Icon name="shield" class="h-8 w-8" />
                </span>
                <h2 class="mt-5 font-heading text-2xl font-black sm:text-3xl">
                    <span v-editable="'cuota.cierre_navy'" class="text-navy">{{ t('cuota.cierre_navy', 'PROTEGEMOS TU COMUNIDAD,') }}</span><br>
                    <span v-editable="'cuota.cierre_teal'" class="text-teal">{{ t('cuota.cierre_teal', 'PARA QUE LA VIDA SIGA SU CURSO') }}</span>
                </h2>
                <p v-editable="'cuota.cierre_texto'" class="mt-4 max-w-xl text-sm leading-relaxed text-navy/65">
                    {{ t('cuota.cierre_texto', '¿Quieres saber cómo funcionaría la Cuota Segura en tu comunidad? Déjanos tus datos y te lo explicamos sin compromiso.') }}
                </p>
                <component
                    :is="tieneTelefono ? 'a' : 'router-link'"
                    v-editable="'cuota.cierre_boton'"
                    :href="tieneTelefono ? telHref : null"
                    :to="tieneTelefono ? null : '/subir-documentos'"
                    class="mt-7 inline-flex items-center gap-2 rounded-full bg-teal px-7 py-3.5 text-sm font-bold text-white shadow-lg transition hover:bg-teal-dark hover:shadow-xl"
                >
                    <Icon name="phone" class="h-5 w-5" />
                    {{ t('cuota.cierre_boton', 'Solicitar información') }}
                    <Icon name="arrow" class="h-4 w-4" />
                </component>
            </div>
        </section>
    </div>
</template>

<script setup>
import { computed, ref, onMounted } from 'vue';
import Icon from '../components/Icon.vue';
import edificioCuota from '../../images/edificio-cuota.jpg';
import { useContenido } from '../composables/contenido';

const { t } = useContenido();

// La ilustración anima sus barras/flecha/contador al entrar en pantalla (no antes).
const graficoEl = ref(null);
const graficoVisible = ref(false);

// Barras en valle (zig-zag): rojas bajan, verdes suben; su --d marca el momento de su fase.
// La línea pasa por la punta de cada barra (centro = x + 20).
const barras = [
    { x: 45, y: 126, h: 140, c: '#ef4444', d: '0s' },
    { x: 105, y: 186, h: 80, c: '#ef4444', d: '.1s' },
    { x: 165, y: 156, h: 110, c: '#ef4444', d: '.2s' },
    { x: 225, y: 211, h: 55, c: '#ef4444', d: '.3s' },
    { x: 285, y: 231, h: 35, c: '#2a9d8f', d: '.45s' },
    { x: 345, y: 171, h: 95, c: '#2a9d8f', d: '.8s' },
    { x: 405, y: 196, h: 70, c: '#2a9d8f', d: '1s' },
    { x: 465, y: 116, h: 150, c: '#2a9d8f', d: '1.2s' },
    { x: 525, y: 61, h: 205, c: '#2a9d8f', d: '1.4s' },
];

// Contador de euros: cae a -1.000 (rojo) y, sin pausa, remonta a +1.000 (verde).
const monto = ref(0);
const montoTexto = computed(() => (monto.value > 0 ? '+' : '') + monto.value.toLocaleString('es-ES') + ' €');

function animarMonto() {
    // Si el usuario prefiere menos movimiento, mostramos el valor final.
    if (window.matchMedia?.('(prefers-reduced-motion: reduce)').matches) {
        monto.value = 1000;
        return;
    }

    const tCae = 800, tSube = 1500, fin = tCae + tSube;
    const inicio = performance.now();

    function paso(ahora) {
        const tt = ahora - inicio;
        let v;
        if (tt < tCae) {
            const p = tt / tCae;
            v = -1000 * (p * p); // cae acelerando
        } else if (tt < fin) {
            const p = (tt - tCae) / tSube;
            v = -1000 + 2000 * (1 - Math.pow(1 - p, 3)); // remonta sin pausa
        } else {
            v = 1000;
        }
        monto.value = Math.round(v);
        if (tt < fin) requestAnimationFrame(paso);
    }
    requestAnimationFrame(paso);
}

onMounted(() => {
    if (!graficoEl.value) return;
    const observer = new IntersectionObserver(
        (entries, obs) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                graficoVisible.value = true;
                animarMonto();
                obs.unobserve(entry.target);
            });
        },
        { threshold: 0.3 },
    );
    observer.observe(graficoEl.value);
});

const telefono = computed(() => t('footer.telefono', '').trim());
const tieneTelefono = computed(() => telefono.value.length > 0);
const telHref = computed(() => 'tel:+34' + telefono.value.replace(/\D/g, ''));

// Pilares de la cabecera (mismos del cartel "Cuota Segura 360")
const pilares = [
    { clave: 'cuota.pilar_1', icono: 'bolt', texto: 'EFICIENCIA\nENERGÉTICA' },
    { clave: 'cuota.pilar_2', icono: 'shield', texto: 'MÁXIMA\nSEGURIDAD' },
    { clave: 'cuota.pilar_3', icono: 'wrench', texto: 'MANTENIMIENTO\nINCLUIDO' },
    { clave: 'cuota.pilar_4', icono: 'euro', texto: 'CUOTAS\nCUBIERTAS' },
];

const pasosPorDefecto = [
    {
        icon: 'alert',
        title: 'UN VECINO NO PAGA',
        text: 'Cuando uno o varios vecinos dejan de abonar su cuota, la comunidad deja de ingresar el dinero que necesita para funcionar. Ese faltante recae sobre el resto de propietarios y pone en riesgo el pago de los servicios del día a día.',
        chip: 'CUOTA NO PAGADA',
        chipClass: 'bg-red-500/10 text-red-500',
    },
    {
        icon: 'shield',
        title: 'SE ACTIVA NUESTRA CUOTA SEGURA',
        text: 'En cuanto se produce el impago, nuestra Cuota Segura entra en acción y cubre ese faltante. La comunidad recibe el 100% de los ingresos previstos, como si todos los vecinos hubieran pagado, sin tener que adelantar nada ni recurrir a derramas.',
        chip: 'CUBIERTA AL 100%',
        chipClass: 'bg-teal/10 text-teal-dark',
    },
    {
        icon: 'building',
        title: 'LA COMUNIDAD SIGUE ADELANTE',
        text: 'Con los ingresos garantizados, los gastos comunes se pagan puntualmente: seguridad, limpieza, mantenimiento y servicios siguen funcionando con normalidad. La convivencia y el bienestar de todos los vecinos se mantienen, sin tensiones por la morosidad.',
        chip: 'TODO EN ORDEN',
        chipClass: 'bg-navy/10 text-navy',
    },
];

const pasos = computed(() => pasosPorDefecto.map((p, i) => ({
    ...p,
    title: t(`cuota.paso${i + 1}.titulo`, p.title),
    text: t(`cuota.paso${i + 1}.texto`, p.text),
    chip: t(`cuota.paso${i + 1}.chip`, p.chip),
})));

const beneficiosPorDefecto = [
    { icon: 'users', title: 'EQUIDAD', text: 'Un vecino moroso no afecta al resto.' },
    { icon: 'euro', title: 'CONTINUIDAD', text: 'La comunidad no se queda sin recursos.' },
    { icon: 'check', title: 'TRANQUILIDAD', text: 'Administración y vecinos sin preocupaciones.' },
    { icon: 'trending', title: 'VALOR', text: 'Se protege el patrimonio y la buena convivencia.' },
];

const beneficios = computed(() => beneficiosPorDefecto.map((b, i) => ({
    icon: b.icon,
    title: t(`cuota.beneficio${i + 1}.titulo`, b.title),
    text: t(`cuota.beneficio${i + 1}.texto`, b.text),
})));
</script>

<style scoped>
/* Estado inicial: barras sin crecer, líneas sin trazar, flecha oculta. */
.g-barra {
    transform: scaleY(0);
    transform-box: fill-box;
    transform-origin: bottom;
}
.g-linea {
    fill: none;
    stroke-width: 10;
    stroke-linecap: round;
    stroke-linejoin: round;
    stroke-dasharray: 1;
    stroke-dashoffset: 1;
    filter: drop-shadow(0 3px 4px rgba(0, 0, 0, 0.1));
}
.g-dip {
    stroke: #ef4444;
}
.g-rise {
    stroke: #2a9d8f;
}
.g-punta {
    opacity: 0;
    offset-path: path('M305,231 L365,171 L425,196 L485,116 L545,61');
    offset-rotate: auto;
    offset-distance: 0%;
}

/* Al entrar en pantalla: la V es un trazo continuo — cae (rojo, acelerando) y
   enseguida remonta (verde, algo más rápido) sin pausa; las barras crecen en su fase. */
.grafico-activo .g-barra {
    animation: crecer 0.6s var(--d) cubic-bezier(0.22, 1, 0.36, 1) forwards;
}
.grafico-activo .g-dip {
    animation: trazar 0.8s 0s cubic-bezier(0.45, 0, 0.9, 0.5) forwards;
}
.grafico-activo .g-rise {
    animation: trazar 1.5s 0.8s cubic-bezier(0.3, 0.05, 0.35, 1) forwards;
}
.grafico-activo .g-punta {
    animation: volar-punta 1.5s 0.8s cubic-bezier(0.3, 0.05, 0.35, 1) forwards;
}

@keyframes crecer {
    to {
        transform: scaleY(1);
    }
}
@keyframes trazar {
    to {
        stroke-dashoffset: 0;
    }
}
@keyframes volar-punta {
    0% {
        offset-distance: 0%;
        opacity: 0;
    }
    8% {
        opacity: 1;
    }
    100% {
        offset-distance: 100%;
        opacity: 1;
    }
}

/* Accesibilidad: sin animación, se muestra el estado final directamente. */
@media (prefers-reduced-motion: reduce) {
    .g-barra {
        transform: scaleY(1);
    }
    .g-linea {
        stroke-dashoffset: 0;
    }
    .g-punta {
        opacity: 1;
        offset-distance: 100%;
    }
    .grafico-activo .g-barra,
    .grafico-activo .g-linea,
    .grafico-activo .g-punta {
        animation: none;
    }
}
</style>
