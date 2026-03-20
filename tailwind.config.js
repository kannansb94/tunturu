import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    darkMode: "class",
    theme: {
        extend: {
            fontFamily: {
                sans: ['Manrope', ...defaultTheme.fontFamily.sans],
                display: ["Manrope", "sans-serif"],
            },
            colors: {
                "primary": "#64b5f6",
                "primary-hover": "#42a5f5",
                "background-light": "#f0f2f5",
                "background-dark": "#0a192f",
                "surface-dark": "#172a45",
                "muted-teal": "#4db6ac",
                "lib-primary": "#a855f7",
                "lib-primary-hover": "#9333ea",
                "lib-secondary": "#ec4899",
                "lib-bg-dark": "#0a0a0f",
                "lib-surf-dark": "#1a1a24",
                "lib-surf-light": "#252535",
            },
            borderRadius: {
                "DEFAULT": "0.375rem",
                "lg": "0.5rem",
                "xl": "0.75rem",
                "full": "9999px"
            },
            backgroundImage: {
                'hero-gradient': 'linear-gradient(to bottom, rgba(10, 25, 47, 0.4), rgba(10, 25, 47, 0.9))',
                'blue-glow': 'radial-gradient(circle at center, rgba(100, 181, 246, 0.1) 0%, transparent 70%)',
            }
        },
    },

    plugins: [forms, require('@tailwindcss/container-queries')],
};
