/**
 * ESLint Configuration for Divi AI Page Builder
 *
 * @package DiviAI
 * @version 1.0.0
 */

module.exports = {
    root: true,
    extends: [
        'plugin:@wordpress/eslint-plugin/recommended',
        'airbnb',
        'airbnb/hooks',
    ],
    env: {
        browser: true,
        es2021: true,
        jquery: true,
    },
    globals: {
        wp: 'readonly',
        diviAI: 'readonly',
        ajaxurl: 'readonly',
    },
    parserOptions: {
        ecmaVersion: 'latest',
        sourceType: 'module',
        ecmaFeatures: {
            jsx: true,
        },
    },
    settings: {
        react: {
            version: 'detect',
        },
    },
    rules: {
        // WordPress compatibility
        'import/no-unresolved': 'off',

        // React rules
        'react/jsx-filename-extension': ['warn', { extensions: ['.js', '.jsx'] }],
        'react/prop-types': 'off',
        'react/react-in-jsx-scope': 'off',

        // Code style
        indent: ['error', 4],
        'react/jsx-indent': ['error', 4],
        'react/jsx-indent-props': ['error', 4],
        'no-tabs': 'off',
        'max-len': ['warn', { code: 120 }],

        // Allow console in development
        'no-console': process.env.NODE_ENV === 'production' ? 'error' : 'warn',

        // Allow underscore dangle for WordPress conventions
        'no-underscore-dangle': 'off',

        // Import ordering
        'import/order': [
            'error',
            {
                groups: ['builtin', 'external', 'internal', 'parent', 'sibling', 'index'],
                'newlines-between': 'always',
            },
        ],
    },
    overrides: [
        {
            files: ['**/*.test.js', '**/*.spec.js'],
            env: {
                jest: true,
            },
        },
    ],
};
