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

mix.js('resources/js/admin.js', 'public/js')
    .js('resources/js/guest.js', 'public/js')
    .js('resources/js/user.js', 'public/js')
    .sass('resources/sass/admin.scss', 'public/css')
    .sass('resources/sass/guest.scss', 'public/css')
    .sass('resources/sass/user.scss', 'public/css');

mix.extract([
    'bootstrap',
    'jquery',
    'popper.js',
    'lodash',
    'axios',
    'vue',
    'sweetalert',
    '@fortawesome/fontawesome-free',
]);

mix.autoload({
    jquery: ['$']
});

mix.version();
