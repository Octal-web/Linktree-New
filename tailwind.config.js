import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.jsx',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['trebuchet-ms', ...defaultTheme.fontFamily.sans],
                secondary: ['Proxima Nova', 'sans-serif'],
            },
            container: {
                center: true,
                padding: '5%',
            },
            maxWidth: {
                small: "75rem",
                medium: "95rem",
                large: "104rem",
            },
            colors: {
                primary: '#6E8867',
                secondary: '#CAD1C1',
                'custom-gray': '#585957',
            },
            spacing: {
                '15': '3.75rem',
                '30': '7rem',
                '40': '9.375rem',
                '50': '12.5rem',
            },
            keyframes: {
                'slide-in-bottom': {
                    '0%': { transform: 'translateY(100%)' },
                    '100%': { transform: 'translateY(0)' },
                },
                'fade-in-down': {
                    '0%': { opacity: '0', transform: 'translate3d(0,-100px,0)' },
                    '100%': { opacity: '1', transform: 'none' },
                },
                'fade-out-down': {
                    '0%': { opacity: '1', transform: 'none' },
                    '100%': { opacity: '0', transform: 'translate3d(0, 100px,0)' },
                }
            },
            animation: {
                'fade-in-down': 'fade-in-down 200ms linear',
                'fade-out-down': 'fade-out-down 200ms linear',
            },
        },
    },
    
    plugins: [
        forms,
        function({ addComponents }) {
            addComponents({
                'p + p': {
                    marginTop: '0.6rem',
                },
            })
        }
    ],
};
