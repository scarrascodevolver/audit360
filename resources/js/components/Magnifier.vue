<template>
    <svg viewBox="0 0 230 230" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <!-- Mango -->
        <line x1="158" y1="158" x2="210" y2="210" stroke="#0f1d2b" stroke-width="17" stroke-linecap="round" />
        <line x1="158" y1="158" x2="210" y2="210" stroke="#33536e" stroke-width="7" stroke-linecap="round" />

        <!-- Cristal (casi transparente, deja ver el edificio) -->
        <circle cx="92" cy="92" r="84" fill="#ffffff" fill-opacity="0.04" />
        <circle cx="92" cy="92" r="84" fill="url(#glassShine)" fill-opacity="0.16" />

        <!-- Aro metálico (delgado) -->
        <circle cx="92" cy="92" r="84" stroke="#0f1d2b" stroke-width="8" />
        <circle cx="92" cy="92" r="79" stroke="#ffffff" stroke-width="1.5" stroke-opacity="0.5" />

        <!-- Check teal -->
        <path d="M58 94 l22 23 l46 -52" stroke="#2a9d8f" stroke-width="12" stroke-linecap="round" stroke-linejoin="round" />

        <!-- Brillo del cristal -->
        <path d="M42 74 a64 64 0 0 1 40 -36" stroke="#ffffff" stroke-width="5" stroke-opacity="0.5" stroke-linecap="round" />

        <defs>
            <linearGradient id="glassShine" x1="32" y1="32" x2="152" y2="152" gradientUnits="userSpaceOnUse">
                <stop stop-color="#ffffff" />
                <stop offset="1" stop-color="#ffffff" stop-opacity="0" />
            </linearGradient>
        </defs>
    </svg>
</template>

<script setup></script>
