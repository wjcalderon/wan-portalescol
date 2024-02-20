(function ($, Drupal, window, document) {
<<<<<<< HEAD
    'use strict';

    Drupal.behaviors.themeAccordionConfig = {
        attach: function (context, settings) {

            // if is mobile
            if ($('body').hasClass('js-mobile') || $('body').hasClass('alias--cotiza-en-linea-cotizador-autos') || $("body").find(".accordion--block").length > 0) {
                var accordion = $('.js-accordion');

                accordion.parent('div').not('section').addClass('js-accordion-row');
                accordion.removeClass('desplegado');
                accordion.next('.js-accordion-options').css("height", 0).css('overflow', 'hidden');

                if (accordion.find('.icon-arrow').length === 0) {
                    accordion.append('<span class="icon-arrow"></span>');
                }

                $('body').off().on('click', '.js-accordion', function () {
                    var acc = $(this),
                        alto = 0,
                        el;

                    if (acc.hasClass('desplegado')) {
                        acc.removeClass('desplegado');
                        acc.next('.js-accordion-options').css("height", 0).css('overflow', 'hidden');
                    } else {
                        acc.next('.js-accordion-options').children('section, div').not('.cog--flex, .component__content, .cog--mq').each(function (i, e) {
                            el = $(e);
                            alto = alto + el.height() + 25;
                        });

                        acc.addClass('desplegado');
                        acc.next('.js-accordion-options').css("height", 'auto');

                        $('.js-accordion').not(acc).removeClass('desplegado');
                        $('.js-accordion').not(acc).next('.js-accordion-options').css("height", 0).css('overflow', 'hidden');
                    }
                });
            }

            // $('.js-accordion').next('.js-accordion-options').css("height", '100%').css('overflow', 'show');
        }
    }

    const accordions = Array.from(document.querySelectorAll('.accordion-ls'))

    accordions.forEach(accordion => {
      const accordionHeader = accordion.querySelector('.accordion-ls__header')

      accordionHeader.addEventListener('click', event => {
        accordion.classList.toggle('is-open')
      })
    })
}(jQuery, Drupal, this, this.document));
=======
  "use strict";

  Drupal.behaviors.themeAccordionConfig = {
    attach: function (context, settings) {
      // if is mobile
      if (
        $("body").hasClass("js-mobile") ||
        $("body").hasClass("alias--cotiza-en-linea-cotizador-autos") ||
        $("body").find(".accordion--block").length > 0
      ) {
        let accordion = $(".js-accordion");

        accordion.parent("div").not("section").addClass("js-accordion-row");
        accordion.removeClass("desplegado");
        accordion
          .next(".js-accordion-options")
          .css("height", 0)
          .css("overflow", "hidden");

        if (accordion.find(".icon-arrow").length === 0) {
          accordion.append('<span class="icon-arrow"></span>');
        }

        $("body")
          .off()
          .on("click", ".js-accordion", function () {
            let acc = $(this),
              alto = 0,
              el;

            if (acc.hasClass("desplegado")) {
              acc.removeClass("desplegado");
              acc
                .next(".js-accordion-options")
                .css("height", 0)
                .css("overflow", "hidden");
            } else {
              acc
                .next(".js-accordion-options")
                .children("section, div")
                .not(".cog--flex, .component__content, .cog--mq")
                .each(function (i, e) {
                  el = $(e);
                  alto = alto + el.height() + 25;
                });

              acc.addClass("desplegado");
              acc.next(".js-accordion-options").css("height", "auto");

              $(".js-accordion").not(acc).removeClass("desplegado");
              $(".js-accordion")
                .not(acc)
                .next(".js-accordion-options")
                .css("height", 0)
                .css("overflow", "hidden");
            }
          });
      }

      // $('.js-accordion').next('.js-accordion-options').css("height", '100%').css('overflow', 'show');
    },
  };

  const accordions = Array.from(document.querySelectorAll(".accordion-ls"));

  accordions.forEach((accordion) => {
    const accordionHeader = accordion.querySelector(".accordion-ls__header");

    accordionHeader.addEventListener("click", (event) => {
      accordion.classList.toggle("is-open");
    });
  });
})(jQuery, Drupal, this, this.document);
>>>>>>> main
