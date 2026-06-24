import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        tailwindcss(), 
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],

    build: {
        // Memisahkan CSS agar tidak chaining dengan JS
        cssCodeSplit: true, 
        
        // Menggunakan 'esbuild' sebagai default yang sangat cepat, 
        // atau gunakan 'terser' jika kamu sudah install (npm install -D terser)
        minify: 'esbuild', 
        
        rollupOptions: {
            output: {
                // Memisahkan library berat ke file 'vendor' agar app.js tetap ramping
                manualChunks: {
                    vendor: ['alpinejs'],
                }
            }
        }
    }
});