import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'public/css/app.css',
                'public/js/app.js',
                'public/css/admin-app.css',
                'public/js/admin-app.js',
                'public/css/error-app.css',
                'public/js/error-app.js',
                'public/css/auth-app.css',
                'public/js/auth-app.js',
                'public/js/quill-editor.js',
                'public/css/quill-editor.css',
                'public/js/admin-table.js',
                'public/css/admin-table.css',
            ],
            refresh: true,
        }),
    ],
    build: {
        rollupOptions: {

        },
        commonjsOptions: {
          transformMixedEsModules: true,
        }
    }
});
