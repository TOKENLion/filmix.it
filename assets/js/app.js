/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
window.$ = require('jquery');

require('bootstrap');

// Alert plugin
window.toastr = require('toastr/build/toastr.min');

// window.dt = require('datatables.net/js/jquery.dataTables');
window.dt = require('datatables.net-bs4/js/dataTables.bootstrap4.min');

// Home/Film page
require('./pages/film');

// Actor page
require('./pages/actor');

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');
