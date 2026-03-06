import { solidtimeTheme } from './tailwind.theme.js';

module.exports = {
    darkMode: 'class',
  content: [
    './resources/views/filament/**/*.blade.php',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.vue',
    './resources/js/**/*.ts',
    './resources/js/**/*.js',
    './vendor/filament/**/*.blade.php',
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './vendor/laravel/jetstream/**/*.blade.php',
    './storage/framework/views/*.php',
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
    safelist: [
        'bg-background',
    ],
};
