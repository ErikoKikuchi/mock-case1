import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js',
        'resources/js/index.js',
        'resources/js/login.js',
        'resources/js/register.js',
        'resources/js/address.js',
        'resources/js/profile-edit.js',
        'resources/js/detail.js',
        'resources/js/mypage.js',
        'resources/js/purchase.js',
        'resources/js/exhibition.js',
        'resources/js/verify-email.js',],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
    build:{
        outDir: 'public/build',
        emptyOutDir:true,
    },
});
