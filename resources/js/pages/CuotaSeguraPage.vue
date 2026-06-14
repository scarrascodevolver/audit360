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

                <!-- Funde el pie de la imagen con la sección clara siguiente -->
                <div class="absolute inset-x-0 bottom-0 h-24 bg-gradient-to-b from-bg-light/0 to-bg-light"></div>

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

                <!-- Gastos que siguen cubiertos -->
                <div class="mt-14">
                    <p v-reveal v-editable="'cuota.gastos_titulo'" class="text-center text-xs font-bold tracking-widest text-navy/60">
                        {{ t('cuota.gastos_titulo', 'LOS GASTOS COMUNES SE PAGAN A TIEMPO') }}
                    </p>
                    <div class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-4">
                        <div
                            v-for="(g, i) in gastos"
                            :key="g.label"
                            v-reveal="i * 70"
                            class="group flex flex-col items-center gap-2 rounded-2xl bg-white py-5 shadow-sm ring-1 ring-gray-100 transition duration-300 hover:-translate-y-1 hover:shadow-lg"
                        >
                            <span class="flex h-12 w-12 items-center justify-center rounded-full bg-bg-light text-teal transition duration-300 group-hover:scale-110 group-hover:bg-teal group-hover:text-white">
                                <Icon :name="g.icon" class="h-6 w-6" />
                            </span>
                            <span class="text-[11px] font-extrabold tracking-wide text-navy transition duration-300 group-hover:text-teal">{{ g.label }}</span>
                        </div>
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
import { computed } from 'vue';
import Icon from '../components/Icon.vue';
import edificioCuota from '../../images/edificio-cuota.jpg';
import { useContenido } from '../composables/contenido';

const { t } = useContenido();

const telefono = computed(() => t('footer.telefono', '').trim());
const tieneTelefono = computed(() => telefono.value.length > 0);
const telHref = computed(() => 'tel:+34' + telefono.value.replace(/\D/g, ''));

const pasosPorDefecto = [
    {
        icon: 'alert',
        title: 'UN VECINO NO PAGA',
        text: 'Si algún vecino no paga su cuota de comunidad, se genera un faltante.',
        chip: 'CUOTA NO PAGADA',
        chipClass: 'bg-red-500/10 text-red-500',
    },
    {
        icon: 'shield',
        title: 'SE ACTIVA NUESTRA CUOTA SEGURA',
        text: 'Nuestra Cuota Segura cubre ese faltante automáticamente. La comunidad recibe el 100% de los ingresos necesarios.',
        chip: 'CUBIERTA AL 100%',
        chipClass: 'bg-teal/10 text-teal-dark',
    },
    {
        icon: 'building',
        title: 'LA COMUNIDAD SIGUE ADELANTE',
        text: 'Los gastos comunes se pagan a tiempo y la calidad de vida de todos se mantiene.',
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

const gastos = [
    { icon: 'shield', label: 'SEGURIDAD' },
    { icon: 'sparkles', label: 'LIMPIEZA' },
    { icon: 'bulb', label: 'SERVICIOS' },
    { icon: 'wrench', label: 'MANTENIMIENTO' },
];

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
