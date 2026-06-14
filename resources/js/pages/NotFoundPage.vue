<template>
    <section class="mx-auto flex min-h-[60vh] max-w-2xl flex-col items-center justify-center px-6 py-24 text-center">
        <p class="font-heading text-7xl font-black text-teal">404</p>
        <h1 class="mt-4 font-heading text-2xl font-bold text-navy">Página no encontrada</h1>
        <p class="mt-3 text-slate-500">La página que buscas no existe o se ha movido.</p>
        <router-link
            to="/"
            class="mt-8 rounded-full bg-teal px-7 py-3 font-semibold text-white transition hover:bg-teal-dark"
        >
            Volver al inicio
        </router-link>
    </section>
</template>
