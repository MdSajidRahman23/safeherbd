import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
// tailwind.config.js
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        primary: "#DF2E38",       // red
        background: "#F3FDE8",    // very light green
        softgreen: "#C6EBC5",     // mid green
        forestgreen: "#79AC78",   // dark green
      },
    },
  },
  plugins: [],
}
