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
    console.log('Compiling in', elixir.config.production ? 'PRODUCTION' : 'DEVELOPMENT', 'mode.' );

    mix.sass('app.sass');

    mix.scripts([
        //'libs/jquery.min.js',
        //'libs/owl.carousel.min.js',
        //'libs/jquery.formstyler.js',
        //'libs/jquery-ui.js',
        //'libs/jquery.fancybox.js',
        //'libs/jquery.maskedinput.min.js',
        //'libs/loader.js',
        //'libs/inject_params.js',
        //'libs/cart.js',
        //'libs/defer.js',
        //'libs/thank.js',
        //'libs/slick.min.js',
        //'cart.js',
        //'defer.js',
        //'fastbuy.js',
        //'subscribe.js',
        //'filters.js',
        //'home.filters.js',
        //'reviews.js',
        //'search.js',
        //'contacts.js',
        //'app.js',
        'a/libs.min.js',
        'a/jquery.maskedinput.min.js',
        'a/main.js',
        'a/scripts.js'
    ], 'public/js/app.js');

    mix.version([
        'css/app.css',
        'js/app.js'
    ]);
});
