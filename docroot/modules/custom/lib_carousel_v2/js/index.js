/* eslint-disable */
Drupal.behaviors.libCarrousel = {
  attach(context) {
    let carrouselitem = document.querySelectorAll(".lib-comp-carrousel__item");
    let carrouselnav = document.querySelectorAll(".lib-comp-carrousel__circle");

    for (const nav of carrouselnav) {
      nav.addEventListener("click", function (event) {
        event.preventDefault();
        for (const item of carrouselitem) {
          if (item.classList.contains("is-active")) {
            item.classList.remove("is-active");
          }
        }
        carrouselitem[i].classList.add("is-active");
      });
    }
  },
};
