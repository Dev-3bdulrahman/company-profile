/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
  ],
  darkMode: 'class',
  theme: {
    extend: {
      fontFamily: {
        sans: ['Instrument Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
      },
    },
  },
  plugins: [],
  safelist: [
    {
      pattern: /bg-(blue|purple|cyan|indigo|green|orange|red)-(50|100|500|600|900)/,
      variants: ['dark'],
    },
    {
      pattern: /text-(blue|purple|cyan|indigo|green|orange|red)-(400|600)/,
      variants: ['dark'],
    },
    {
      pattern: /ring-(blue|purple|cyan|indigo|green|orange|red)-500/,
    },
    'opacity-0', 'opacity-100', 'translate-y-4', 'sm:translate-y-0', 'scale-95', 'scale-100',
    'fixed', 'inset-0', 'z-50', 'overflow-y-auto', 'flex', 'items-end', 'justify-center',
    'min-h-screen', 'sm:block', 'sm:p-0', 'bg-gray-500', 'bg-opacity-75', 'transition-opacity',
    'inline-block', 'align-middle', 'bg-white', 'dark:bg-gray-900', 'rounded-xl', 'text-right',
    'overflow-hidden', 'shadow-xl', 'transform', 'transition-all', 'sm:my-8', 'sm:max-w-lg', 'sm:w-full'
  ],
}
