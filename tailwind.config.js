module.exports = {
  purge: [
    './storage/framework/views/*.php',
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    container: {
        center: true,
        padding: '2rem',
    },
    extend: {},
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
