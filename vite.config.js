import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: { host:'0.0.0.0' },
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/js/modal_create_author.js',
                'resources/js/modal_update_author.js',
                'resources/js/delete_author.js',
                'resources/js/modal_create_book.js',
                'resources/js/validate_update_book.js',
                'resources/js/validate_create_book.js',


            ],
            refresh: true,
        }),
    ],
});
