/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
  ],
  theme: {
    extend: {
      colors: {
        rosewoodBr: '#a8342f',
        adminBg: '#14110d',
        adminBgHover: '#262019',
        adminText: '#cbbfa9',
        adminAccent: '#d9a441',
        adminPageBg: '#f6f4f0',
        adminBorder: '#e4dfd6',
        adminInk: '#2b241a',
                adminTextStrong: '#ffffff'
              },
      fontFamily: {
        sans: ['Instrument Sans', 'ui-sans-serif', 'system-ui', 'Segoe UI', 'Noto Color Emoji'],
      }
    },
  },
  plugins: [],
};