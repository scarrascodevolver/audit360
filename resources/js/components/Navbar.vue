<template>
    <header
        class="sticky top-0 z-50 border-b border-gray-200 bg-white/85 backdrop-blur"
    >
        <nav class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
            <!-- Logo -->
            <router-link to="/" class="flex items-center gap-2.5">
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

            <!-- Links -->
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

            <!-- CTA -->
            <router-link
                to="/subir-documentos"
                class="flex items-center gap-2 rounded-full bg-teal px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-teal-dark sm:px-5"
            >
                <Icon name="upload" class="h-4 w-4" />
                <span class="hidden sm:inline">Subir documentación</span>
                <span class="sm:hidden">Documentos</span>
            </router-link>
        </nav>
    </header>
</template>

<script setup>
import Icon from './Icon.vue';

const links = [
    { to: '/', label: 'Inicio' },
    { to: '/recopilacion', label: 'Proceso' },
    { to: '/subir-documentos', label: 'Documentación' },
];
</script>
