const mix = require('laravel-mix');
require('dotenv').config()
let webpack = require('webpack')
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
// const SentryWebpackPlugin = require("@sentry/webpack-plugin");
const DeleteSourceMapWebpackPlugin = require('delete-sourcemap-webpack-plugin')
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
const prod = mix.inProduction();
let dotenvplugin = new webpack.DefinePlugin({
    'process.env': {
        APP_NAME: JSON.stringify(process.env.APP_NAME || 'Default app name'),
        NODE_ENV: JSON.stringify(process.env.NODE_ENV || 'development')
    }
})
mix.js('resources/js/app.js', 'public/js')
    .extract()
    .vue({
        version: 2,
        globalStyles: 'resources/sass/_variables.scss',
    })
    .webpackConfig({
        output:{
            chunkFilename:'js/chunks/[contenthash].js',
        },
        plugins: [
            new CleanWebpackPlugin({
              verbose: true,
              cleanOnceBeforeBuildPatterns: ['./js/chunks/*']
            }),
            dotenvplugin,
        ]
    })
    .sass('resources/sass/app.scss', 'public/css')
    .options({
        processCssUrls: false,
        postCss: [
            require('autoprefixer')({
                grid: 'no-autoplace'
            })
        ]
    })
    .browserSync('marella.local')
    .disableNotifications()
    if (prod) {
        mix.version()
        // .webpackConfig({
        //     plugins: [
        //         new SentryWebpackPlugin({
        //             authToken: "37ae2a240bdd4a6f9756732af4d07442e8f138de3a5542718f4b131a8809c2fb",
        //             org: "appelsin",
        //             project: "donato",
        //             include: ".",
        //             ignore: ["node_modules", "webpack.mix.js", "nova", "_gsdata_", "vendor", "resources"],
        //         }),
        //         new DeleteSourceMapWebpackPlugin()
        //     ]
        // })
    }
