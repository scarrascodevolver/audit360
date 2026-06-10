<template>
    <div class="min-h-screen bg-bg-light py-6 sm:py-10">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">

            <!-- ============ HERO ============ -->
            <section class="rounded-3xl bg-white px-6 py-12 text-center shadow-sm ring-1 ring-gray-100 sm:px-10">
                <span class="inline-block rounded-full bg-teal/10 px-4 py-1.5 text-xs font-bold tracking-widest text-teal-dark">
                    NUESTRO COMPROMISO
                </span>
                <h1 class="mt-4 font-heading text-2xl font-black text-navy sm:text-4xl">
                    NUESTRA <span class="text-teal">CUOTA SEGURA</span>
                </h1>
                <p class="mt-3 text-lg font-bold text-teal sm:text-xl">
                    No importa que un vecino no pague la comunidad
                </p>
                <p class="mx-auto mt-4 max-w-2xl leading-relaxed text-navy/65">
                    <strong class="font-bold text-navy">Nosotros nos haremos cargo de todo</strong>
                    para que esto no frene la vida de la comunidad.
                </p>

                <!-- Sello Cuota Segura -->
                <div class="mt-8 flex justify-center">
                    <div class="flex flex-col items-center justify-center rounded-full bg-navy px-10 py-8 text-white shadow-xl ring-4 ring-teal/30">
                        <Icon name="shield" class="h-12 w-12 text-teal-light" />
                        <span class="mt-2 font-heading text-xl font-black leading-none">
                            CUOTA <span class="text-teal-light">SEGURA</span>
                        </span>
                    </div>
                </div>
            </section>

            <!-- ============ CÓMO FUNCIONA ============ -->
            <section class="rounded-3xl bg-white px-6 py-12 shadow-sm ring-1 ring-gray-100 sm:px-10">
                <div class="text-center">
                    <h2 class="inline-block font-heading text-2xl font-black text-navy sm:text-3xl">
                        ¿CÓMO FUNCIONA?
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
                            <h3 class="mt-4 text-sm font-extrabold text-navy">{{ p.title }}</h3>
                            <p class="mx-auto mt-2 max-w-xs text-[13px] leading-relaxed text-navy/60">{{ p.text }}</p>
                        </div>
                        <div v-if="i < pasos.length - 1" class="flex shrink-0 items-center justify-center self-center text-teal lg:pt-8">
                            <Icon name="arrow" class="h-7 w-7 rotate-90 lg:rotate-0" />
                        </div>
                    </template>
                </div>

                <!-- Gastos que siguen cubiertos -->
                <div class="mt-12 rounded-2xl bg-bg-light p-6">
                    <p class="text-center text-xs font-bold tracking-widest text-navy/60">
                        LOS GASTOS COMUNES SE PAGAN A TIEMPO
                    </p>
                    <div class="mt-5 grid grid-cols-2 gap-4 sm:grid-cols-4">
                        <div v-for="g in gastos" :key="g.label" class="flex flex-col items-center gap-2">
                            <span class="flex h-12 w-12 items-center justify-center rounded-full bg-white text-teal shadow-sm ring-1 ring-gray-100">
                                <Icon :name="g.icon" class="h-6 w-6" />
                            </span>
                            <span class="text-[11px] font-extrabold tracking-wide text-navy">{{ g.label }}</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ============ POR QUÉ ES IMPORTANTE ============ -->
            <section class="rounded-3xl bg-navy px-6 py-12 sm:px-10">
                <div class="text-center">
                    <h2 class="font-heading text-xl font-black text-white sm:text-2xl">
                        ¿POR QUÉ ES TAN IMPORTANTE LA <span class="text-teal-light">CUOTA SEGURA</span>?
                    </h2>
                    <div class="mx-auto mt-3 h-1 w-24 rounded-full bg-teal"></div>
                </div>

                <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <div
                        v-for="b in beneficios"
                        :key="b.title"
                        class="rounded-2xl bg-white/[0.06] p-6 text-center ring-1 ring-white/10"
                    >
                        <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-teal text-white">
                            <Icon :name="b.icon" class="h-6 w-6" />
                        </span>
                        <h3 class="mt-4 text-sm font-extrabold tracking-wide text-white">{{ b.title }}</h3>
                        <p class="mt-2 text-[13px] leading-relaxed text-white/60">{{ b.text }}</p>
                    </div>
                </div>
            </section>

            <!-- ============ CIERRE / CTA ============ -->
            <section class="rounded-3xl bg-white px-6 py-12 text-center shadow-sm ring-1 ring-gray-100 sm:px-10">
                <div class="mx-auto flex max-w-2xl flex-col items-center">
                    <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-teal text-white shadow-md">
                        <Icon name="shield" class="h-8 w-8" />
                    </span>
                    <h2 class="mt-5 font-heading text-2xl font-black sm:text-3xl">
                        <span class="text-navy">PROTEGEMOS TU COMUNIDAD,</span><br>
                        <span class="text-teal">PARA QUE LA VIDA SIGA SU CURSO</span>
                    </h2>
                    <p class="mt-4 max-w-xl text-sm leading-relaxed text-navy/65">
                        ¿Quieres saber cómo funcionaría la Cuota Segura en tu comunidad?
                        Déjanos tus datos y te lo explicamos sin compromiso.
                    </p>
                    <button
                        type="button"
                        class="mt-7 inline-flex items-center gap-2 rounded-full bg-teal px-7 py-3.5 text-sm font-bold text-white shadow-lg transition hover:bg-teal-dark"
                    >
                        <Icon name="phone" class="h-5 w-5" />
                        Solicitar información
                        <Icon name="arrow" class="h-4 w-4" />
                    </button>
                </div>
            </section>
        </div>
    </div>
</template>

<script setup>
import Icon from '../components/Icon.vue';

const pasos = [
    { icon: 'alert', title: 'UN VECINO NO PAGA', text: 'Si algún vecino no paga su cuota de comunidad, se genera un faltante.' },
    { icon: 'shield', title: 'SE ACTIVA NUESTRA CUOTA SEGURA', text: 'Nuestra Cuota Segura cubre ese faltante automáticamente. La comunidad recibe el 100% de los ingresos necesarios.' },
    { icon: 'building', title: 'LA COMUNIDAD SIGUE ADELANTE', text: 'Los gastos comunes se pagan a tiempo y la calidad de vida de todos se mantiene.' },
];

const gastos = [
    { icon: 'shield', label: 'SEGURIDAD' },
    { icon: 'sparkles', label: 'LIMPIEZA' },
    { icon: 'bulb', label: 'SERVICIOS' },
    { icon: 'wrench', label: 'MANTENIMIENTO' },
];

const beneficios = [
    { icon: 'users', title: 'EQUIDAD', text: 'Un vecino moroso no afecta al resto.' },
    { icon: 'euro', title: 'CONTINUIDAD', text: 'La comunidad no se queda sin recursos.' },
    { icon: 'check', title: 'TRANQUILIDAD', text: 'Administración y vecinos sin preocupaciones.' },
    { icon: 'trending', title: 'VALOR', text: 'Se protege el patrimonio y la buena convivencia.' },
];
</script>
