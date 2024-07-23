import './bootstrap';
import $ from 'jquery';
import 'select2';
$(document).ready(function() {
    $('#author').select2();
});

// Don't forget to compile your assets using Laravel Mix
// webpack.mix.js
mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css');