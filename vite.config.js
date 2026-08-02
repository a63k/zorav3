import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { viteStaticCopy } from 'vite-plugin-static-copy';
import fs from 'fs';

const plugins = [
    laravel({
        input: [
            'resources/scss/app.scss',
            'resources/js/app.js',
        ],
        refresh: true,
    }),
];

if (fs.existsSync('vendor/tinymce/tinymce')) {
    plugins.push(
        viteStaticCopy({
            targets: [
                {
                    src: 'vendor/tinymce/tinymce',
                    dest: 'vendor/js'
                }
            ]
        })
    );
}

export default defineConfig({
    plugins
});
