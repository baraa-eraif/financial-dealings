const dotenvExpand = require('dotenv-expand');
dotenvExpand(require('dotenv').config({path: '../../.env'/*, debug: true*/}));

const mix = require('laravel-mix');
const path = require('path');
require('laravel-mix-merge-manifest');
mix.setPublicPath('../../public').mergeManifest();

mix.js(__dirname + '/Resources/js/app.js', 'js/seller/app.js')
    .vue({version: 3})
    .sass(__dirname + '/Resources/sass/app.scss', 'css/seller/app.css')
    .copy(__dirname + '/Resources/assets', '../../public/assets/seller');

const AutoImport = require('unplugin-auto-import/webpack');
const Components = require('unplugin-vue-components/webpack');
const {ElementPlusResolver} = require('unplugin-vue-components/resolvers');

const CompressionPlugin = require('compression-webpack-plugin');
mix.alias({
    '@': path.join(__dirname, 'Resources/js/'),
}).webpackConfig({
    output: {
        chunkFilename: "js/seller/[name].js" + (mix.inProduction() ? "?id=[chunkhash]" : "")
    },
    module: {
        rules: [{
            test: /\.mjs$/,
            resolve: {fullySpecified: false},
            include: /node_modules/,
            type: "javascript/auto"
        }]
    },
    plugins: [
        new CompressionPlugin({
            filename: '[path][name][ext].gz[query]',
            algorithm: 'gzip',
            test: /\.js$|\.css$|\.html$|\.svg$/,
            threshold: 10240,
            minRatio: 0.8,
        }),
        AutoImport({
            resolvers: [ElementPlusResolver()],
        }),
        Components({
            resolvers: [ElementPlusResolver()],
        }),
    ]
});

if (mix.inProduction()) {
    mix.version();
}
