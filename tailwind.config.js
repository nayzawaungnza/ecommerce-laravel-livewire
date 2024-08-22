/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "node_modules/preline/dist/*.js",
    ],
    darkMode: "", // Set to 'media' or 'class' if you want to enable dark mode
    theme: {
        extend: {},
    },
    plugins: [require("preline/plugin")],
};
