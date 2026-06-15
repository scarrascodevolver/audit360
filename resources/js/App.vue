<template>
    <Navbar />
    <router-view v-slot="{ Component }">
        <component :is="Component" />
    </router-view>
    <EditorTextos />
    <BannerCookies />
</template>

<script setup>
import Navbar from './components/Navbar.vue';
import EditorTextos from './components/EditorTextos.vue';
import BannerCookies from './components/BannerCookies.vue';
</script>
