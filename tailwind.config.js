/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue", // Make sure this line is present!
  ],
  theme: {
    extend: {},
  },
  plugins: [], // Keep this empty unless you have specific Tailwind plugins
};