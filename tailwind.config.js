module.exports = {
    darkMode: 'class',

    content: ['./resources/**/*.blade.php'],
    safelist: process.env.NODE_ENV === 'development' ? [{ pattern: /.*/ }] : [],
    plugins: [
        require('@tailwindcss/typography'),
    ],
};
