// Recuerda el teléfono/email que el cliente dejó en la solicitud (paso 1) para
// autorrellenar la subida de documentos (paso 2) sin que lo teclee de nuevo.
// Es solo una comodidad: si no hay nada guardado (otro navegador), los campos
// salen vacíos y el cliente los rellena a mano.

const CLAVE = 'audit_contacto';

export function guardarContacto({ telefono = '', email = '' }) {
    try {
        const datos = { telefono: telefono.trim(), email: email.trim() };
        if (!datos.telefono && !datos.email) return;
        localStorage.setItem(CLAVE, JSON.stringify(datos));
    } catch {
        // localStorage puede estar bloqueado (modo privado): no pasa nada.
    }
}

export function leerContacto() {
    try {
        const crudo = localStorage.getItem(CLAVE);
        if (!crudo) return { telefono: '', email: '' };
        const datos = JSON.parse(crudo);
        return { telefono: datos.telefono ?? '', email: datos.email ?? '' };
    } catch {
        return { telefono: '', email: '' };
    }
}
