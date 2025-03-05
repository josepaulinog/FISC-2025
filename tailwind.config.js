/** @type {import('tailwindcss').Config} config */
import daisyui from 'daisyui';

const config = {
  content: [
    './app/**/*.php',
    './resources/**/*.{php,vue,js}',
    './resources/views/login.blade.php',
  ],
  safelist: [
    // Only keep color classes that are actually used in dynamic contexts
    {
      pattern: /bg-(slate|gray|zinc|neutral|stone|red|orange|amber|yellow|lime|green|emerald|teal|cyan|sky|blue|indigo|violet|purple|fuchsia|pink|rose)-(500|700|900)/,
    },
    'bg-transparent','hero',
    'min-h-[300px]',
    'relative',
    'hero-overlay',
    'bg-opacity-80',
    'before:absolute',
    'before:inset-0',
    'before:bg-gradient-to-t',
    'before:from-[#181818]',
    'before:to-transparent',
    'hero-content',
    'text-center',
    'text-white',
    'max-w-md',
    'mb-5',
    'text-5xl',
    'font-bold',
    'space-x-4',
    'mr-16',
    'bg-gray-50',
    'gap-20',
    'grid-cols-6',
    'grid-cols-4',
    'h-96',
    'h-auto',
    'aspect-video',
    'w-1/3',
    'w-2/3',
    'rounded-box',
    'flex',
    'flex-col',
    'bg-gradient-to-b',
    'from-primary',
    'to-primary',
  ],
  darkMode: ['class', '[data-theme="dark"]'],
  theme: {
    extend: {
      colors: {
        'custom-primary': '#fd6b18',
        'custom-secondary': '#4b9981',
        'custom-gray': '#e8e8e8',
      },
      boxShadow: {
        xs: "0 0 0 1px rgba(0, 0, 0, 0.05)",
        sm: "0 1px 2px 0 rgba(0, 0, 0, 0.05)",
        default:
          "0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06)",
        md:
          "0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)",
        lg:
          "0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)",
        xl:
          "0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)",
        "2xl": "0 25px 50px -12px rgba(0, 0, 0, 0.25)",
        inner: "inset 0 2px 4px 0 rgba(0, 0, 0, 0.06)",
        outline: "0 0 0 3px rgba(66, 153, 225, 0.5)",
        none: "none",
      },
      fontFamily: {
        sans: ['Open Sans, sans-serif'],
      },
    },
    container: {
      center: true,
      padding: '2rem',
      screens: {
        sm: '640px',
        md: '768px',
        lg: '1024px',
        xl: '1280px',
        '2xl': '1280px',
      },
    },
  },
  plugins: [
    function ({ addUtilities }) {
      const newUtilities = {
        '.range-gradient': {
          '--range-shdw': 'linear-gradient(to right, #000000, #8bc34a, #ffe066, #ff3e00)', 
        },
      };
      addUtilities(newUtilities, ['responsive', 'hover']);
    },
    daisyui,
  ],
  daisyui: {
    themes: [
      {
        light: {
          "primary": "#fd6b18", // Custom primary color
          "secondary": "#4b9981", // Custom secondary color
          "accent": "#37cdbe",
          "neutral": "#3d4451",
          "base-100": "#ffffff",
          "info": "#2094f3",
          "success": "#009485",
          "warning": "#ff9900",
          "error": "#ff5724",
          "--dropdown-content-shadow": "0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)",
        },
      },
      {
        dark: {
          "primary": "#fd6b18", 
          "secondary": "#4b9981",
          "accent": "#37cdbe",
          "neutral": "#191d24",
          "base-100": "#2a2e37",
          "info": "#2094f3",
          "success": "#009485",
          "warning": "#ff9900",
          "error": "#ff5724",
          "--dropdown-content-shadow": "0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)",
        },
      },
    ],
  },
};

export default config;
