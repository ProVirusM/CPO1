/** @type {import('tailwindcss').Config} */
export default {
  content: [],
  purge: ['./index.html', './src/**/*.{vue,js,ts,jsx,tsx}'],
  theme: {
    extend: {
      fontFamily: {
        golos: ['GolosTest', 'sans-serif'],
      },
    },
  },
  plugins: [],
}
