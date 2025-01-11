import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import theme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    prefix: 'tw-',
    important:true,
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './app/Http/Controllers/**/*.php',
        './app/Models/**/*.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Roboto', ...defaultTheme.fontFamily.sans],
            },
            backgroundImage: {
                theme:"radial-gradient(circle, rgba(63,94,251,1) 0%, rgba(250,46,88,1) 100%)"
            },
            borderColor: {
                theme:"#C20E0E"
            },
            textColor: {
                theme:"#C20E0E"
            }
        },
    },

    plugins: [forms],
};
