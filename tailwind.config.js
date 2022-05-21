const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
    ],
    theme: {
        extend: {
            fontFamily: {
                'sans': ['Poppins', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [],
}

