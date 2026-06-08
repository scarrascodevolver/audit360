/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            colors: {
                navy: '#1a3047',
                teal: '#2a9d8f',
                'teal-light': '#3dbdaf',
                'teal-dark': '#1f7a6e',
                'bg-light': '#f4f7f9',
            },
            fontFamily: {
                heading: ['Raleway', 'sans-serif'],
                body: ['"Open Sans"', 'sans-serif'],
            },
        },
    },
    plugins: [],
};
