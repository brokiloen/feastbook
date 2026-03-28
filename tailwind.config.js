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
            colors: {
                parchment: '#f4e4bc',
                'parchment-dark': '#e8d4a8',
                burgundy: '#722f37',
                'burgundy-dark': '#5a252c',
                wood: '#3d2314',
                'wood-light': '#5c3a2d',
                gold: '#c9a227',
                'gold-light': '#dbb84d',
            },
            fontFamily: {
                'sans': ['Inter', ...defaultTheme.fontFamily.sans],
                'logo': ['Cinzel', 'serif'],
                'medieval': ['Cormorant Garamond', 'serif'],
                'medieval-bg': ['Cormorant Garamond', 'serif'],
                'body': ['Crimson Text', 'serif'],
            },
        },
    },

    plugins: [forms],
};
