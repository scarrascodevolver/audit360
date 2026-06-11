<template>
    <!-- Barra del modo edición -->
    <div
        v-if="edicion"
        class="fixed inset-x-0 bottom-0 z-[90] flex items-center justify-center gap-4 bg-navy px-4 py-3 text-white shadow-2xl"
    >
        <Icon name="check" class="h-5 w-5 shrink-0 text-teal-light" />
        <p class="text-sm font-semibold">
            Modo edición: haz clic en cualquier texto resaltado para cambiarlo.
        </p>
        <button
            class="rounded-full border border-white/30 px-4 py-1.5 text-xs font-bold transition hover:bg-white/10"
            @click="salirEdicion"
        >
            Salir
        </button>
    </div>

    <!-- Editor de texto -->
    <div
        v-if="editor.abierto"
        class="fixed inset-0 z-[100] flex items-center justify-center bg-navy/50 p-4"
        @click.self="cerrarEditor"
    >
        <div class="w-full max-w-lg rounded-3xl bg-white p-6 shadow-2xl">
            <h3 class="font-heading text-lg font-black text-navy">Editar texto</h3>
            <p class="mt-1 text-xs text-navy/50">
                El cambio se publica al guardar y se ve al instante. En las listas, cada línea es un elemento.
            </p>
            <textarea
                v-model="editor.valor"
                :rows="filas"
                class="mt-4 w-full rounded-xl border border-gray-200 bg-bg-light px-4 py-3 text-sm text-navy outline-none transition focus:border-teal focus:ring-2 focus:ring-teal/20"
            ></textarea>
            <p v-if="editor.error" class="mt-2 text-sm font-semibold text-red-500">{{ editor.error }}</p>
            <div class="mt-4 flex justify-end gap-2">
                <button
                    class="rounded-full px-5 py-2.5 text-sm font-bold text-navy/60 transition hover:bg-bg-light"
                    @click="cerrarEditor"
                >
                    Cancelar
                </button>
                <button
                    class="rounded-full bg-teal px-6 py-2.5 text-sm font-bold text-white shadow-md transition hover:bg-teal-dark disabled:opacity-60"
                    :disabled="editor.guardando"
                    @click="guardarEditor"
                >
                    {{ editor.guardando ? 'Guardando…' : 'Guardar' }}
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import Icon from './Icon.vue';
import { edicion, editor, cerrarEditor, guardarEditor, salirEdicion } from '../composables/contenido';

const filas = computed(() => Math.min(10, Math.max(3, editor.valor.split('\n').length + 1)));
</script>
