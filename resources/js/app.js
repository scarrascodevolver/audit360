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
import NotFoundPage from './pages/NotFoundPage.vue';

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
        // Cualquier ruta inexistente → página 404 (en vez de pantalla en blanco).
        { path: '/:pathMatch(.*)*', name: 'not-found', component: NotFoundPage },
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

// v-reveal: el elemento aparece con un fundido+subida al entrar en pantalla
// (o al cargar, si ya es visible). Opcional v-reveal="120" = retardo en ms para
// escalonar. Al terminar quita las clases para no estorbar al hover.
app.directive('reveal', {
    mounted(el, binding) {
        el.classList.add('reveal');
        const delay = Number(binding.value) || 0;

        const observer = new IntersectionObserver(
            (entries, obs) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) return;
                    obs.unobserve(el);
                    el.style.animationDelay = `${delay}ms`;
                    el.classList.add('reveal-visible');
                    el.addEventListener(
                        'animationend',
                        () => {
                            el.classList.remove('reveal', 'reveal-visible');
                            el.style.animationDelay = '';
                        },
                        { once: true },
                    );
                });
            },
            { threshold: 0.12, rootMargin: '0px 0px -40px 0px' },
        );

        observer.observe(el);
    },
});

app.mount('#app');
