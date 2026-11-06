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
                // Design tokens SIRAT RT 02 Graha Indah (stitch sirat/DESIGN.md)
                lime: '#C9F26B',
                dark: '#0F2E1A',
                mid: '#1F5130',
                soft: '#F3F5F0',
                surface: '#fafaeb',
                'surface-white': '#FFFFFF',
                'surface-bright': '#fafaeb',
                'surface-variant': '#e2e4d5',
                'surface-container-low': '#f4f5e6',
                'surface-container-high': '#e8e9db',
                'surface-container-highest': '#e2e4d5',
                primary: '#4c6700',
                'primary-container': '#c9f26b',
                'on-primary-container': '#526e00',
                secondary: '#46664d',
                'secondary-container': '#c5e9ca',
                'on-secondary-container': '#4a6a51',
                'tertiary-container': '#d5e4ff',
                'on-tertiary-container': '#57667c',
                error: '#ba1a1a',
                'error-container': '#ffdad6',
                'on-error-container': '#93000a',
                'on-surface': '#1a1d14',
                'on-surface-variant': '#444938',
                outline: '#757966',
                'outline-variant': '#c4c9b3',
                'inverse-surface': '#2f3128',
                'text-main': '#111111',
                'text-secondary': '#444444',
                'border-line': '#CCCCCC',
            },

            fontFamily: {
                sans: ['Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
                serif: ['Instrument Serif', 'serif'],
            },

            fontSize: {
                'headline-display': ['68px', { lineHeight: '1.05', fontWeight: '700' }],
                'headline-lg': ['48px', { lineHeight: '1.1', fontWeight: '700' }],
                'headline-md': ['34px', { lineHeight: '1.25', fontWeight: '600' }],
                'headline-sm': ['20px', { lineHeight: '1.3', fontWeight: '600' }],
                'body-lg': ['17px', { lineHeight: '1.5', fontWeight: '400' }],
                'body-md': ['14px', { lineHeight: '1.5', fontWeight: '400' }],
                'label-section': ['12px', { lineHeight: '1', letterSpacing: '0.08em', fontWeight: '600' }],
                chip: ['11px', { lineHeight: '1', fontWeight: '500' }],
            },

            borderRadius: {
                DEFAULT: '1rem',
                lg: '2rem',
                xl: '3rem',
            },
        },
    },

    plugins: [forms],
};
