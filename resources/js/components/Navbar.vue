<template>
    <header
        class="sticky top-0 z-50 border-b border-gray-200 bg-white/85 backdrop-blur"
    >
        <nav class="mx-auto flex max-w-7xl items-center justify-between gap-2 px-4 py-3 sm:px-6 lg:px-8">
            <!-- Logo -->
            <router-link to="/" class="flex shrink-0 items-center gap-2.5">
                <span class="relative flex h-10 w-10 items-center justify-center rounded-xl bg-navy text-white">
                    <Icon name="building" class="h-6 w-6" />
                    <span class="absolute -bottom-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-teal text-white ring-2 ring-white">
                        <Icon name="check" class="h-3 w-3" />
                    </span>
                </span>
                <span class="font-heading text-lg font-black leading-none">
                    <span class="text-navy">Comunidad</span><span class="text-teal">Audit</span>
                    <span class="align-top text-[10px] font-extrabold text-navy/60">360°</span>
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

            <div class="flex shrink-0 items-center gap-2">
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
                    class="flex h-10 w-10 items-center justify-center rounded-xl text-navy transition hover:bg-bg-light md:hidden"
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
