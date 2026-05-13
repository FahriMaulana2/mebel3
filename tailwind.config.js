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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                serif: ['Playfair Display', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                // Primary palette - Warm brown (Scandinavian)
                primary: {
                    DEFAULT: '#8B5E3C',
                    dark: '#6B4A2E',
                    light: '#A87854',
                },
                // Secondary - Light gray/cream
                secondary: {
                    DEFAULT: '#F5F5F0',
                    dark: '#E8E8E3',
                    light: '#FFFFFF',
                },
                // Dark
                dark: {
                    DEFAULT: '#1F2937',
                    light: '#374151',
                },
                // Accent - Gold for badges
                accent: {
                    DEFAULT: '#C6A43F',
                    dark: '#A88A33',
                    light: '#D4B854',
                },
                // Soft pink for Sale badge
                sale: {
                    DEFAULT: '#E8B4B8',
                    light: '#F5D0D3',
                },
                // Text
                text: {
                    DEFAULT: '#4B5563',
                    light: '#6B7280',
                    dark: '#1F2937',
                },
                // Border
                border: '#E5E7EB',
                // Background
                background: '#FAFAF9',
                // Warm beige
                'warm-beige': '#F5F0E8',
            },
            boxShadow: {
                'premium': '0 4px 20px rgba(0, 0, 0, 0.08)',
                'premium-lg': '0 10px 40px rgba(0, 0, 0, 0.12)',
                'premium-hover': '0 20px 40px rgba(139, 94, 60, 0.2)',
                'card': '0 2px 8px rgba(0, 0, 0, 0.04)',
                'card-hover': '0 12px 32px rgba(0, 0, 0, 0.1)',
            },
            borderRadius: {
                '2xl': '1rem',
                '3xl': '1.5rem',
            },
            animation: {
                'fade-in': 'fadeIn 0.5s ease-out forwards',
                'slide-up': 'slideUp 0.5s ease-out forwards',
                'slide-in': 'slideIn 0.3s ease-out forwards',
                'scale-in': 'scaleIn 0.3s ease-out forwards',
                'float': 'float 3s ease-in-out infinite',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                slideUp: {
                    '0%': { opacity: '0', transform: 'translateY(20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                slideIn: {
                    '0%': { opacity: '0', transform: 'translateX(-20px)' },
                    '100%': { opacity: '1', transform: 'translateX(0)' },
                },
                scaleIn: {
                    '0%': { opacity: '0', transform: 'scale(0.95)' },
                    '100%': { opacity: '1', transform: 'scale(1)' },
                },
                float: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-10px)' },
                },
            },
            transitionTimingFunction: {
                'premium': 'cubic-bezier(0.4, 0, 0.2, 1)',
            },
        },
    },

    plugins: [forms],
};
