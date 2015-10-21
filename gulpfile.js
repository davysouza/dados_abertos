var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('app.scss');
    mix.styles([
        'style.css',
        'preloader.css',
        'icon_font/style.css',
        'icon_font/owl.carousel.css',
        'icon_font/owl.theme.default.css',
        'animate.css',
        'bootstrap.min.css',
        'responsive.css'
    ], 'public/css/final.css', 'public/css');

    mix.version('public/css/all.css');
});
