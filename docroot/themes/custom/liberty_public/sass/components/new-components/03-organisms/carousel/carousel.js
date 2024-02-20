/* eslint-disable */
Drupal.behaviors.cardCarousel = {
  attach(context) {
    let elms = document.getElementsByClassName("splide");

    for (let i = 0; i < elms.length; i++) {
      new Splide(elms[i]).mount();
    }
  },
};
