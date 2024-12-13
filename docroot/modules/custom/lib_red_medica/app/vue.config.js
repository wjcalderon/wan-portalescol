module.exports = {
  publicPath: "/modules/custom/lib_red_medica/app/dist",
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
