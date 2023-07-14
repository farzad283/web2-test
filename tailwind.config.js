/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    extend: {
      colors: {
        'dark-red': '#251322',
        'red': '#9B0738',
        'pale-pink': '#FB7F6',
        'gold': '#927A50',
      },
      maxWidth:{
        '100': '100px',
        '150': '150px',
        '200': '200px'
      }
    },
  },
  plugins: [],
}

