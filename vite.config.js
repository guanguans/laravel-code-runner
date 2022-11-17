import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            publicDirectory: 'resources/dist',
            input: ['resources/css/app.css', 'resources/js/app.js'],
            buildDirectory: 'resources/dist',
            refresh: true
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false
                }
            }
        })
    ],
    resolve: {
        alias: {
            // '@': '/resources/js'
        }
    }
});
