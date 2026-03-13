import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue2'
import path from 'path'
export default defineConfig({
  plugins: [vue()],
  resolve: {
    alias: {
      '@': path.resolve(__dirname, './resources'),
    },
  },
  build: {
    outDir: "./public",
    rollupOptions: {
      input: './resources/main.js',
      output: {
        manualChunks: false,
        inlineDynamicImports: true,
        entryFileNames: '[name].js',
        assetFileNames: '[name].[ext]',
      },
    }
  },
})
