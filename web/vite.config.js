import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            // Skrip slider dipisah per halaman agar hanya dimuat di halaman yang memakainya.
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/pembuka.js',
                'resources/js/beranda.js',
                'resources/js/sejarah.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
