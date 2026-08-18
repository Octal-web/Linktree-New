import js from '@eslint/js';
import prettierConfig from 'eslint-config-prettier';
import react from 'eslint-plugin-react';
import reactHooks from 'eslint-plugin-react-hooks';
import simpleImportSort from 'eslint-plugin-simple-import-sort';
import { defineConfig, globalIgnores } from 'eslint/config';

export default defineConfig([
    globalIgnores(['dist']),
    {
        plugins: {
            react,
            'react-hooks': reactHooks,
            'simple-import-sort': simpleImportSort,
        },
        files: ['resources/**/*.{js,jsx}'],

        extends: [js.configs.recommended, react.configs.flat.recommended, reactHooks.configs.flat.recommended, prettierConfig],
        languageOptions: {
            ecmaVersion: 'latest',
            sourceType: 'module',
            globals: {
                document: 'readonly',
                navigator: 'readonly',
                window: 'readonly',
                localStorage: 'readonly',
                alert: 'readonly',
                setInterval: 'readonly',
                clearInterval: 'readonly',
                route: 'readonly',
                setTimeout: 'readonly',
                clearTimeout: 'readonly',
                console: 'readonly',
            },
        },
        settings: {
            react: {
                version: 'detect',
            },
        },
        rules: {
            'react/react-in-jsx-scope': 'off',
            'react/prop-types': 'off',
            'no-unused-vars': ['warn', { argsIgnorePattern: '^_' }],
            'simple-import-sort/imports': 'warn',
            'simple-import-sort/exports': 'warn',
            'react-hooks/set-state-in-effect': 'off',
        },
    },
]);
