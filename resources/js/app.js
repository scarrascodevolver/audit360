import './bootstrap';
import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';

import App from './App.vue';
import LandingPage from './pages/LandingPage.vue';
import RecopilacionPage from './pages/RecopilacionPage.vue';
import DocumentosPage from './pages/DocumentosPage.vue';

const router = createRouter({
    history: createWebHistory(),
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
