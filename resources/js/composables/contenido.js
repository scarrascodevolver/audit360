import { reactive, ref } from 'vue';

// Textos editables del sitio (clave → valor), servidos por GET /api/contenido.
// Cada texto tiene un valor por defecto hardcodeado en la página: si la API no
// responde (demo estática de Pages, dev sin BD), el sitio se ve igual.
const mapa = reactive({});

// ----- Modo edición (solo admins, estilo WordPress) -----
export const esAdmin = ref(false);
export const edicion = ref(false);
export const editor = reactive({
    abierto: false,
    clave: '',
    valor: '',
    guardando: false,
    error: '',
});

export async function cargarContenido() {
    if (import.meta.env.VITE_GH_PAGES === '1') return;
    try {
        const { data } = await window.axios.get('/api/contenido');
        Object.assign(mapa, data);
    } catch {
        // Sin backend: se quedan los textos por defecto.
    }
}

// Si hay sesión de admin, la web muestra la barra de administrador.
// Con ?edicion=1 (botón del panel) entra directo en modo edición.
export async function comprobarAdmin() {
    if (import.meta.env.VITE_GH_PAGES === '1') return;
    try {
        const { data } = await window.axios.get('/api/contenido/estado-edicion');
        esAdmin.value = data.admin === true;
        if (esAdmin.value && new URLSearchParams(window.location.search).has('edicion')) {
            activarEdicion();
        }
    } catch {
        esAdmin.value = false;
    }
}

export function activarEdicion() {
    edicion.value = true;
    document.body.classList.add('modo-edicion');
}

export function salirEdicion() {
    edicion.value = false;
    document.body.classList.remove('modo-edicion');
    const url = new URL(window.location.href);
    url.searchParams.delete('edicion');
    window.history.replaceState({}, '', url);
}

export function abrirEditor(clave, valorPorDefecto = '') {
    editor.clave = clave;
    editor.valor = mapa[clave] ?? valorPorDefecto;
    editor.error = '';
    editor.abierto = true;
}

export function cerrarEditor() {
    editor.abierto = false;
}

export async function guardarEditor() {
    editor.guardando = true;
    editor.error = '';
    try {
        const { data } = await window.axios.put(`/api/contenido/${editor.clave}`, {
            valor: editor.valor,
        });
        // Vue repinta el texto al instante: sin recargas.
        mapa[data.clave] = data.valor;
        editor.abierto = false;
    } catch (e) {
        editor.error = e.response?.status === 401
            ? 'La sesión de administrador ha caducado. Vuelve a entrar al panel.'
            : 'No se pudo guardar el cambio. Inténtalo de nuevo.';
    } finally {
        editor.guardando = false;
    }
}

export function useContenido() {
    const t = (clave, porDefecto = '') => mapa[clave] ?? porDefecto;
    // Listas editables: un ítem por línea.
    const lista = (clave, porDefecto = []) =>
        mapa[clave] ? mapa[clave].split('\n').filter(Boolean) : porDefecto;

    return { t, lista };
}
