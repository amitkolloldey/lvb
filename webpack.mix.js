const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/front-all.js', 'public/js/front-all.js')
    .sass('resources/sass/front-all.scss', 'public/css/front-all.css')
    .sass('resources/sass/app.scss', 'public/css');
