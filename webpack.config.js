/**
 * Webpack Configuration for Divi AI Page Builder
 *
 * @package DiviAI
 * @version 1.0.0
 */

const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const defaultConfig = require('@wordpress/scripts/config/webpack.config');

const isProduction = process.env.NODE_ENV === 'production';

module.exports = {
    ...defaultConfig,

    entry: {
        // Admin scripts
        'admin': './src/admin/index.js',

        // Wizard components
        'wizard': './src/wizard/index.js',

        // Template browser
        'template-browser': './src/template-browser/index.js',

        // Customizer panel
        'customizer': './src/customizer/index.js',

        // Divi Builder integration
        'builder': './src/builder/index.js',
    },

    output: {
        path: path.resolve(__dirname, 'assets/dist'),
        filename: 'js/[name].js',
        clean: true,
    },

    module: {
        rules: [
            {
                test: /\.jsx?$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: [
                            '@babel/preset-env',
                            '@babel/preset-react'
                        ],
                    },
                },
            },
            {
                test: /\.s?css$/,
                use: [
                    isProduction ? MiniCssExtractPlugin.loader : 'style-loader',
                    'css-loader',
                    'postcss-loader',
                    'sass-loader',
                ],
            },
            {
                test: /\.(png|jpg|jpeg|gif|svg)$/i,
                type: 'asset/resource',
                generator: {
                    filename: 'images/[name][hash][ext]',
                },
            },
            {
                test: /\.(woff|woff2|eot|ttf|otf)$/i,
                type: 'asset/resource',
                generator: {
                    filename: 'fonts/[name][hash][ext]',
                },
            },
        ],
    },

    plugins: [
        ...defaultConfig.plugins,
        new MiniCssExtractPlugin({
            filename: 'css/[name].css',
        }),
    ],

    resolve: {
        extensions: ['.js', '.jsx', '.json'],
        alias: {
            '@components': path.resolve(__dirname, 'src/components/'),
            '@hooks': path.resolve(__dirname, 'src/hooks/'),
            '@services': path.resolve(__dirname, 'src/services/'),
            '@utils': path.resolve(__dirname, 'src/utils/'),
            '@admin': path.resolve(__dirname, 'src/admin/'),
            '@wizard': path.resolve(__dirname, 'src/wizard/'),
        },
    },

    externals: {
        react: 'React',
        'react-dom': 'ReactDOM',
        '@wordpress/element': 'wp.element',
        '@wordpress/components': 'wp.components',
        '@wordpress/i18n': 'wp.i18n',
        '@wordpress/api-fetch': 'wp.apiFetch',
        '@wordpress/hooks': 'wp.hooks',
        jquery: 'jQuery',
    },

    optimization: {
        ...defaultConfig.optimization,
        splitChunks: {
            cacheGroups: {
                vendor: {
                    test: /[\\/]node_modules[\\/]/,
                    name: 'vendors',
                    chunks: 'all',
                },
            },
        },
    },

    devtool: isProduction ? 'source-map' : 'eval-source-map',

    performance: {
        hints: isProduction ? 'warning' : false,
        maxEntrypointSize: 512000,
        maxAssetSize: 512000,
    },
};
