module.exports = {
  outputDir: 'dist',
  filenameHashing: false,
  productionSourceMap: true,
  css: {
    loaderOptions: {
      scss: {
        prependData: `@import "@/assets/styles.scss";`,
      },
    },
  },
}
