import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';
import { solidtimeTheme } from './resources/js/packages/ui/tailwind.theme.js';

export default {
    darkMode: 'class',
    content: [
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        './resources/js/**/*.ts',
        './vendor/filament/**/*.blade.php',
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        '!./resources/js/**/node_modules',
    ],
    theme: {
        extend: {
            colors: {
                ...solidtimeTheme.colors,
            },
            boxShadow: {
                ...solidtimeTheme.boxShadow,
            },
            containers: {
                ...solidtimeTheme.containers,
            },
            fontSize: {
                ...solidtimeTheme.fontSize,
            },
            borderRadius: {
                ...solidtimeTheme.borderRadius,
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [
        forms,
        typography,
        require('@tailwindcss/container-queries'),
        require('tailwindcss-animate'),
    ],
};
