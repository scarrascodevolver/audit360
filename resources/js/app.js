import './bootstrap';
import { createApp } from 'vue';
import { createRouter, createWebHistory, createWebHashHistory } from 'vue-router';

import App from './App.vue';
import LandingPage from './pages/LandingPage.vue';
import RecopilacionPage from './pages/RecopilacionPage.vue';
import DocumentosPage from './pages/DocumentosPage.vue';

// GitHub Pages no puede reescribir rutas al index, así que la demo usa hash history
const router = createRouter({
    history: import.meta.env.VITE_GH_PAGES ? createWebHashHistory() : createWebHistory(),
    routes: [
        { path: '/', name: 'landing', component: LandingPage },
        { path: '/recopilacion', name: 'recopilacion', component: RecopilacionPage },
        { path: '/subir-documentos', name: 'documentos', component: DocumentosPage },
    ],
    scrollBehavior() {
        return { top: 0 };
    },
});

createApp(App).use(router).mount('#app');
