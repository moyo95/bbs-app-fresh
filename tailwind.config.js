import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            keyframes: {
                sprite: {
                '0%': { 'background-position': '-2800px 0' },
                '100%': { 'background-position': '-2800px 0' },
                },
            },
            animation: {
                'sprite-heart': 'sprite 1s steps(28) forwards', // スプライトフレーム数に応じて steps(n) を調整
            }, 
        },
    },

    plugins: [forms],
};
