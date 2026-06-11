import './bootstrap';
import { createApp } from 'vue';
import { createRouter, createWebHistory, createWebHashHistory } from 'vue-router';

import App from './App.vue';
import { cargarContenido, comprobarAdmin, edicion, abrirEditor } from './composables/contenido';
import LandingPage from './pages/LandingPage.vue';
import CuotaSeguraPage from './pages/CuotaSeguraPage.vue';
import RecopilacionPage from './pages/RecopilacionPage.vue';
import DocumentosPage from './pages/DocumentosPage.vue';
import LegalPage from './pages/LegalPage.vue';

// GitHub Pages no puede reescribir rutas al index, así que la demo usa hash history
const router = createRouter({
    history: import.meta.env.VITE_GH_PAGES ? createWebHashHistory() : createWebHistory(),
    routes: [
        { path: '/', name: 'landing', component: LandingPage },
        { path: '/cuota-segura', name: 'cuota-segura', component: CuotaSeguraPage },
        { path: '/recopilacion', name: 'recopilacion', component: RecopilacionPage },
        { path: '/subir-documentos', name: 'documentos', component: DocumentosPage },
        { path: '/aviso-legal', name: 'aviso-legal', component: LegalPage },
        { path: '/privacidad', name: 'privacidad', component: LegalPage },
        { path: '/cookies', name: 'cookies', component: LegalPage },
    ],
    scrollBehavior() {
        return { top: 0 };
    },
});

cargarContenido();
comprobarAdmin();

const app = createApp(App).use(router);

// v-editable="'clave'": en modo edición, el elemento se resalta y al hacer
// clic abre el editor en vivo (sin navegar ni recargar).
app.directive('editable', {
    mounted(el, binding) {
        el.dataset.editable = binding.value;
        el.addEventListener(
            'click',
            (evento) => {
                if (!edicion.value) return;
                evento.preventDefault();
                evento.stopPropagation();
                abrirEditor(binding.value, el.textContent.trim());
            },
            true,
        );
    },
});

app.mount('#app');
