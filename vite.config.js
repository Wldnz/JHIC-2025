import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import * as glob from 'glob';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                ...glob.globSync('resources/js/**/*', { nodir: true }),
                ...glob.globSync('resources/css/**/*.css', { nodir: true }),
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
