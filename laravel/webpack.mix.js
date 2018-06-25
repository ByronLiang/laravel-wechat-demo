const {mix} = require('laravel-mix');

const path = require('path');
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */
let networkInterfaces = require('os').networkInterfaces();
let host;

if (networkInterfaces.en0) {
    for (let i of networkInterfaces.en0) {
        if (i.family === 'IPv4') host = i.address;
    }
} else {
    host = '127.0.0.1';
}
if (mix.inProduction()) {
    mix.version();
}

mix
    .setPublicPath('public')
    .js('resources/assets/admin/app.js', 'static/js/adminapp.js')
    .sass('resources/assets/admin/scss/app.scss', 'static/css/adminapp.css')
    .js('resources/assets/js/app.js', 'static/js/web.js')
    .sass('resources/assets/sass/app.scss', 'static/css/web.css')
    .webpackConfig({
        output: {
            publicPath: process.argv.includes('--hot') ? 'http://' + host + ':8080/' : '/',
            chunkFilename: 'static/js/[name].js'+(Config.versioning ? '?[chunkhash]' : ''),
        },
        // module: {
        //     rules: [
        //         {
        //             test: /\.(js|vue)$/,
        //             loader: 'eslint-loader',
        //             enforce: 'pre',
        //             exclude: /(node_modules)/,
        //             options: {
        //                 // fix: true,
        //                 formatter: require('eslint-friendly-formatter'),
        //             },
        //         },
        //     ],
        // },
        resolve: {
            alias: {
                'axios': 'axios/dist/axios.min.js',
            },
            modules: [
                path.resolve(__dirname, 'node_modules'),
                path.resolve(__dirname, 'resources/assets'),
            ],
        },
        devServer: {
            host,
        },
    })
    .autoload({
        'jquery': ['$', 'window.jQuery'],
    });
