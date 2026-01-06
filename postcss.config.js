/**
 * PostCSS Configuration for Divi AI Page Builder
 *
 * @package DiviAI
 * @version 1.0.0
 */

module.exports = {
    plugins: [
        require('postcss-preset-env')({
            stage: 3,
            features: {
                'nesting-rules': true,
                'custom-properties': true,
                'custom-media-queries': true,
            },
            autoprefixer: {
                grid: true,
            },
        }),
    ],
};
