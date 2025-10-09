const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
    // Web
    .styles([
        'resources/views/web/assets/css/bootstrap.min.css',
        'resources/views/web/assets/css/style.css',
    ], 'public/web_assets/css/app.css')
    .scripts([
        'resources/views/web/assets/js/jquery-3.6.0.min.js',
        'resources/views/web/assets/js/popper.min.js',
        'resources/views/web/assets/js/bootstrap.min.js',
        'resources/views/web/assets/js/quantity-plan.js',
        'resources/views/web/assets/js/purchase.js',
    ], 'public/web_assets/js/scripts.js')
    .copyDirectory('resources/views/web/assets/img', 'public/web_assets/img')
    .copyDirectory('resources/views/web/assets/fonts', 'public/web_assets/fonts')

    // Dashboard
    .sass('resources/views/dashboard/assets/scss/app.scss', 'public/dashboard_assets/css')
    .scripts([
        'node_modules/jquery/dist/jquery.js',
        'resources/views/dashboard/assets/js/feather.min.js',
        'node_modules/perfect-scrollbar/dist/perfect-scrollbar.js',
        'node_modules/jquery-mask-plugin/dist/jquery.mask.js',
        'resources/views/dashboard/assets/js/app.js',
        'resources/views/dashboard/assets/js/main.js',
    ], 'public/dashboard_assets/js/scripts.js')
    .copyDirectory('resources/views/dashboard/assets/images', 'public/dashboard_assets/images')

    .version()
    .disableNotifications()
