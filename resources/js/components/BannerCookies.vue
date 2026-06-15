<template>
    <Transition name="banner">
        <div
            v-if="!decisionTomada"
            class="fixed inset-x-0 bottom-0 z-[60] border-t-4 border-teal-light bg-navy/95 px-4 py-4 text-white shadow-2xl backdrop-blur sm:px-6"
            role="dialog"
            aria-live="polite"
            aria-label="Aviso de cookies"
        >
            <div class="mx-auto flex max-w-5xl flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <p class="text-sm leading-relaxed text-white/90">
                    Usamos cookies propias y de terceros para analizar el uso del sitio y medir
                    nuestras campañas publicitarias. Puede aceptarlas todas o rechazarlas; las
                    técnicas, imprescindibles, se mantienen siempre. Más detalle en la
                    <router-link to="/cookies" class="font-bold text-teal-light underline underline-offset-2">
                        política de cookies</router-link>.
                </p>
                <div class="flex shrink-0 gap-3">
                    <button
                        type="button"
                        class="rounded-lg border border-white/40 px-5 py-2.5 text-sm font-bold text-white transition hover:bg-white/10"
                        @click="rechazarTodo"
                    >
                        Rechazar
                    </button>
                    <button
                        type="button"
                        class="rounded-lg bg-teal-light px-5 py-2.5 text-sm font-extrabold text-navy transition hover:bg-teal"
                        @click="aceptarTodo"
                    >
                        Aceptar
                    </button>
                </div>
            </div>
        </div>
    </Transition>
</template>

<script setup>
import { decisionTomada, aceptarTodo, rechazarTodo } from '../composables/consent';
</script>

<style scoped>
.banner-enter-active {
    transition: transform 0.35s ease, opacity 0.35s ease;
}
.banner-enter-from {
    transform: translateY(100%);
    opacity: 0;
}
</style>
