/**
 * Konfigurasi Tailwind untuk panel admin: tema sama persis dengan halaman publik
 * (tailwind.config.js), tetapi hanya memindai view dan skrip admin.
 *
 * @type {import('tailwindcss').Config}
 */
import dasar from './tailwind.config.js';

export default {
    ...dasar,
    content: [
        './resources/views/admin/**/*.blade.php',
        './public/js/admin.js',
        './config/admin.php',
    ],
};
