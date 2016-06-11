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

elixir(function (mix) {
    mix.sass('app.scss', 'resources/assets/css', './resources');

    mix.styles([
        '../vendor/bootstrap/css/bootstrap.min.css',
        '../vendor/font-awesome.css',
        '../vendor/loading-bar/loading-bar.min.css',
        'app.css'
    ]);

    mix.scripts([
        '../vendor/jquery.min.js',
        '../vendor/moment.js',
        '../vendor/bootstrap/js/bootstrap.min.js',
        '../vendor/angular.min.js',
        '../vendor/angular-route.min.js',
        '../vendor/ngStorage.js',
        '../vendor/loading-bar/loading-bar.min.js',
        'app.js',
        'auth-controller.js',
        'meals-controller.js',
        'users-controller.js',
        'auth-service.js',
        'meals-service.js',
        'users-service.js',
        'globals-service.js'
    ]);

    mix.scripts([
        '../vendor/html5shiv.min.js',
        '../vendor/respond.min.js'
    ], 'public/js/ie9.min.js');

    mix.version([
        'css/all.css',
        'js/all.js'
    ]);

    mix.copy('resources/assets/fonts', 'public/build/fonts');
});
