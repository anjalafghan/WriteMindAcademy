/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    '../../*.{html,php,js}', // Root directory files
    '../../healing_studio/**/*.{html,php,js}',
    '*.{html,php,js}' // Files in healing_studio and its subdirectories
  ],

  theme: {
    extend: {},
  },
  plugins: [],
}

