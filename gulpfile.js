const elixir = require('laravel-elixir');

// require('laravel-elixir-vue');

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
elixir.config.sourcemaps = false;

elixir(mix => {
    // mix.sass('app.scss')
       // .webpack('app.js');
    mix.styles([
    	'bootstrap/dist/css/bootstrap.css',
    	'font-awesome/css/font-awesome.css',
        'datatables.net-bs/css/dataTables.bootstrap.css',
        'iCheck/skins/flat/green.css',
        '../../sweetalert/dist/sweetalert.css',
        '../build/css/custom.css',
    ], 'public/css/style.css', 'bower_components/gentelella/vendors')
    	.scripts([
    	'jquery/dist/jquery.js',
    	'bootstrap/dist/js/bootstrap.js',
        'datatables.net/js/jquery.dataTables.js',
        'datatables.net-bs/js/dataTables.bootstrap.js',
        'Chart.js/dist/Chart.js',
        'iCheck/icheck.min.js',
        '../../sweetalert/dist/sweetalert.min.js',
        '../build/js/custom.js',
    ], 'public/js/script.js', 'bower_components/gentelella/vendors')
    	.copy('bower_components/gentelella/vendors/bootstrap/dist/fonts', 'public/fonts')
    	.copy('bower_components/gentelella/vendors/font-awesome/fonts', 'public/fonts');
});
