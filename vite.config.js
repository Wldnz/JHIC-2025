import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/handle/image-product.js',
                'resources/js/handle/variant-product.js',
                'resources/js/handle/transactions.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
