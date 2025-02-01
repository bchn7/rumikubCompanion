// webpack.config.js
const Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('app', './assets/app.js')
    // enable CSS processing
    .enablePostCssLoader()
// ... other configurations
;

module.exports = Encore.getWebpackConfig();
