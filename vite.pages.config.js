// Build estático del mockup para GitHub Pages (no usa Laravel).
// Uso: VITE_GH_PAGES=1 npx vite build --config vite.pages.config.js
import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    base: '/audit360/',
    publicDir: false,
    plugins: [
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    build: {
        outDir: 'dist',
        rollupOptions: {
            input: 'index.pages.html',
        },
    },
});
