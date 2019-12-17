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

// noinspection JSUnresolvedFunction
mix.js('resources/js/app.ts', 'public/js')
    .css('resources/sass/app.scss', 'public/css')
    .options({
        vue: {
            esModule: true
        }
    })
    .webpackConfig({
        module: {
            rules: [
                {
                    test: /\.tsx?$/,
                    loader: "ts-loader",
                    exclude: /node_modules/
                }
            ]
        },
        resolve: {
            extensions: ['*', '.ts', '.tsx', '.vue']
        }
    });

// noinspection JSUnresolvedFunction
mix.disableNotifications();
