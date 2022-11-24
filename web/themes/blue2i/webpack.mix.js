// webpack.mix.js

let mix = require('laravel-mix');

mix.js('js/blue2i.js', 'dist').setPublicPath('dist');
mix.sass('scss/style.scss', 'css').setPublicPath('');
