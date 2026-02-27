export default defineNuxtConfig({
  css: ["~/assets/css/tailwind.css"],

  postcss: {
    plugins: {
      tailwindcss: {},
      autoprefixer: {},
    },
  },

  compatibilityDate: '2025-11-13',

  // ✅ TAMBAHKAN BAGIAN INI — PROXY KE LARAVEL
  nitro: {
    devProxy: {
      '/api': {
        target: 'http://localhost:8000',
        changeOrigin: true,
        headers: {
          'X-Forwarded-For': 'localhost',
        },
      },
    },
  },
})