import vue from '@vitejs/plugin-vue'
import { defineConfig } from 'vite'

// https://vite.dev/config/
export default defineConfig({
  plugins: [vue()],
  server: {
    proxy: {
      '/api': {
        target: 'http://AmanahTinsCenter.dev',
        changeOrigin: true,
      },
      '/storage': {
        target: 'http://AmanahTinsCenter.dev',
        changeOrigin: true,
      },
    },
  },
})
