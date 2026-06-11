import { reactive } from 'vue';

// Textos editables del sitio (clave → valor), servidos por GET /api/contenido.
// Cada texto tiene un valor por defecto hardcodeado en la página: si la API no
// responde (demo estática de Pages, dev sin BD), el sitio se ve igual.
const mapa = reactive({});

export async function cargarContenido() {
    if (import.meta.env.VITE_GH_PAGES === '1') return;
    try {
        const { data } = await window.axios.get('/api/contenido');
        Object.assign(mapa, data);
    } catch {
        // Sin backend: se quedan los textos por defecto.
    }
}

export function useContenido() {
    const t = (clave, porDefecto = '') => mapa[clave] ?? porDefecto;
    // Listas editables: un ítem por línea.
    const lista = (clave, porDefecto = []) =>
        mapa[clave] ? mapa[clave].split('\n').filter(Boolean) : porDefecto;

    return { t, lista };
}
