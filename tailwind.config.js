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
        screens: {
            'xs': '430px',
            ...defaultTheme.screens,
          },
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                "light-primary": "#F9DBBB",
                "light-secondary" : "#",
                "dark-primary": "#",
                "dark-secondary": "#",
                "logo-orange": "#e78215",
                "logo-gray": "#5e6c72",
                "light-bg-color": "#EDE8E2",
                "light-font-color": "#333333",
                "light-darker-bg-color": '#dcd5cf',
                "light-dark-bg-color": "#333333",
                "light-dark-font-color": "#EDE8E2",
                "light-button-color": "#474543",
                "button-compl-color": "#768eaa"
            },
            gridTemplateColumns:{
                "1fr-2fr": "minmax(0, 1fr) minmax(0, 2fr)",
                "2fr-1fr": "minmax(0, 2fr) minmax(0, 1fr)",
                "searchbar": "minmax(50px, 2fr) minmax(50px, 2fr) minmax(0, 1fr) minmax(0, 1fr)",
            }
        },
    },

    plugins: [forms],
};
