const mix = require('laravel-mix');

mix.setPublicPath('resources/dist')
    .js('resources/js/app.js', 'resources/dist')
    .postCss('resources/css/app.css', 'resources/dist', [require('tailwindcss')])
    // .sourceMaps()
    .version()
    .options({
        postCss: require('./postcss.config').plugins
        // processCssUrls: false
    });
