/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "*.php",
    "./CMS/*.php",
  ],
  theme: {
    extend: {
      colors: {
        'custom-bg': '#1a3139',
        'cms-bg': '#1b4250',
        'custom-text': '#e9ebec',
        'custom-button': '#92c5d6',
        'content-area': '#1d6b85',
        'form-invalid': '#f54949',
        'custom-border': '#92c5d6',
        'custom-button-hover': '#6faabf',
      },
    },
  },
  plugins: [],
}