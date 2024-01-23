/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
      ],
    safelist: [
        {
            pattern: /bg-(amber|gray|red|green|blue|pink|indigo|yellow|purple|emerald|lime|orange)-(50|100|200|300|400|500|600|700|800)/,
        },
        {
            pattern: /from-(amber|gray|red|green|blue|pink|indigo|yellow|purple|emerald|lime|orange)-(50|100|200|300|400|500|600|700|800)/,
        },
    ],
  theme: {
    extend: {},
  },
  plugins: [],
}

