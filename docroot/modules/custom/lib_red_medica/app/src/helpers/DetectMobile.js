const detectedMobile = {
  data: function () {
    return {
      isMobile: false
    }
  },
  mounted: function () {
    if (window.innerWidth <= 768) {
      this.isMobile = true
    }

    window.onresize = () => {
      if (window.innerWidth <= 768) {
        this.isMobile = true
      }
      else {
        this.isMobile = false
      }
    }
  }
}

export default detectedMobile
