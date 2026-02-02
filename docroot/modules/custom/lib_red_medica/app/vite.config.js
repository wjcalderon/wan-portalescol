import { defineConfig } from "vite";
import vue2 from "@vitejs/plugin-vue2";
import { fileURLToPath, URL } from "node:url";

export default defineConfig({
  base: "./",
  plugins: [vue2()],
  resolve: {
    alias: {
      "@": fileURLToPath(new URL("./src", import.meta.url)),
    },
  },
  build: {
    outDir: "dist",
    assetsDir: ".",
    sourcemap: true,
    rollupOptions: {
      output: {
        entryFileNames: "js/[name].js",
        chunkFileNames: "js/[name].js",
        assetFileNames: (assetInfo) => {
          const name = assetInfo.name || "";
          if (name.endsWith(".css")) return "css/[name][extname]";
          if (/\.(png|jpe?g|gif|webp|avif|svg)$/i.test(name))
            return "img/[name][extname]";
          if (/\.(woff2?|eot|ttf|otf)$/i.test(name))
            return "fonts/[name][extname]";
          if (/\.(mp4|webm|ogg|mp3|wav|flac|aac)$/i.test(name))
            return "media/[name][extname]";
          return "[name][extname]";
        },
        manualChunks(id) {
          if (id.includes("node_modules")) {
            return "chunk-vendors";
          }
        },
      },
    },
  },
});
