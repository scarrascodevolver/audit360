<template>
    <header
        class="sticky top-0 z-50 border-b border-gray-200 bg-white/85 backdrop-blur"
    >
        <nav class="mx-auto flex max-w-7xl items-center justify-between gap-1.5 px-3 py-3 sm:px-6 lg:px-8">
            <!-- Logo (compacto en móvil para dejar sitio al CTA y la hamburguesa) -->
            <router-link to="/" class="flex min-w-0 shrink items-center gap-2 sm:gap-2.5">
                <!-- Marca yv "Yo Vivo Tranquilo" (logo vectorizado en SVG) -->
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-navy sm:h-10 sm:w-10">
                    <svg viewBox="0 0 28 24" class="h-5 w-6 sm:h-6 sm:w-7" fill="none" aria-hidden="true">
                        <path d="M3 3 L10 15 L10 21" stroke="#3dbdaf" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M10 15 L17 3" stroke="#3dbdaf" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M16 9 L21 19 L26 9" stroke="#ffffff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                <span class="flex min-w-0 flex-col leading-none">
                    <span class="whitespace-nowrap font-heading text-base font-black sm:text-lg">
                        <span class="text-navy">Audita Tu </span><span class="text-teal">Comunidad</span>
                        <span class="hidden align-top text-[10px] font-extrabold text-navy/60 min-[400px]:inline">360°</span>
                    </span>
                    <span class="mt-0.5 hidden text-[9px] font-bold uppercase tracking-[0.18em] text-navy/45 sm:block">Yo Vivo Tranquilo</span>
                </span>
            </router-link>

            <!-- Links (escritorio) -->
            <div class="hidden items-center gap-8 md:flex">
                <router-link
                    v-for="l in links"
                    :key="l.to"
                    :to="l.to"
                    class="text-sm font-semibold text-navy/70 transition hover:text-teal"
                    active-class="!text-teal"
                >
                    {{ l.label }}
                </router-link>
            </div>

            <div class="flex shrink-0 items-center gap-1.5 sm:gap-2">
                <!-- CTA: solo icono en pantallas muy pequeñas -->
                <router-link
                    to="/subir-documentos"
                    class="flex items-center gap-2 rounded-full bg-teal p-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-teal-dark sm:px-5 sm:py-2.5"
                >
                    <Icon name="upload" class="h-4 w-4" />
                    <span class="hidden sm:inline">Subir documentación</span>
                </router-link>

                <!-- Hamburguesa (móvil) -->
                <button
                    type="button"
                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl text-navy transition hover:bg-bg-light md:hidden"
                    :aria-expanded="abierto"
                    aria-label="Abrir el menú"
                    @click="abierto = !abierto"
                >
                    <svg v-if="!abierto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" class="h-6 w-6">
                        <path d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" class="h-6 w-6">
                        <path d="M6 6l12 12M18 6L6 18" />
                    </svg>
                </button>
            </div>
        </nav>

        <!-- Menú desplegable (móvil) -->
        <div v-if="abierto" class="border-t border-gray-100 bg-white md:hidden">
            <router-link
                v-for="l in links"
                :key="l.to"
                :to="l.to"
                class="block px-6 py-3.5 text-sm font-semibold text-navy/80 transition hover:bg-bg-light hover:text-teal"
                active-class="!text-teal"
                @click="abierto = false"
            >
                {{ l.label }}
            </router-link>
        </div>
    </header>
</template>

<script setup>
import { ref } from 'vue';
import Icon from './Icon.vue';

const abierto = ref(false);

const links = [
    { to: '/', label: 'Inicio' },
    { to: '/cuota-segura', label: 'Cuota Segura' },
    { to: '/recopilacion', label: 'Proceso' },
    { to: '/subir-documentos', label: 'Documentación' },
];
</script>
