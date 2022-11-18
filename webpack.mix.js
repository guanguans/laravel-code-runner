const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

mix.setPublicPath('resources/dist')
    .setResourceRoot('resources')
    .js('resources/js/app.js', 'resources/dist')
    .postCss('resources/css/app.css', 'resources/dist', [tailwindcss('tailwind.config.js')])
    // .sourceMaps()
    .disableSuccessNotifications()
    .copyDirectory('resources/favicon', 'resources/dist/favicon')
    .version()
    .options({
        postCss: require('./postcss.config').plugins,
        processCssUrls: false,
        terser: {
            extractComments: false
        }
    });
