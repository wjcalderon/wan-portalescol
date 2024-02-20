/* eslint-disable */
Drupal.behaviors.libCarrousel = {
<<<<<<< HEAD
    attach(context) {
  
      var carrouselitem = document.querySelectorAll('.lib-comp-carrousel__item');
      var carrouselnav = document.querySelectorAll('.lib-comp-carrousel__circle');

      for (let i = 0; i < carrouselnav.length; i++) {
        carrouselnav[i].addEventListener("click", function(event) {
          event.preventDefault();
          for (let q = 0; q < carrouselitem.length; q++) {
            const element = carrouselitem[q];
            if ( element.classList.contains('is-active')) {
              element.classList.remove('is-active');
            }
          }
          carrouselitem[i].classList.add('is-active');
        });
      };
    },
  };
  
=======
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
>>>>>>> main
