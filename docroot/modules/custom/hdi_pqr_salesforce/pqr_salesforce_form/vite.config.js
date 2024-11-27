import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'

// https://vite.dev/config/
export default defineConfig({
  base: '/modules/custom/hdi_pqr_salesforce/pqr_salesforce_form/dist',
  plugins: [react()],
  build: {
    rollupOptions: {
      output: {
        entryFileNames: 'pqr-salesforce.js',
        chunkFileNames: `[name].js`,
        assetFileNames: `[name].[ext]`,
        globals: {
          react: 'react',
        },
      },
    },
  },
})
