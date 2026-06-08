<template>
    <Navbar />
    <router-view v-slot="{ Component }">
        <component :is="Component" />
    </router-view>
</template>

<script setup>
import Navbar from './components/Navbar.vue';
</script>
