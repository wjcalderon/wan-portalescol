(function ($, Drupal, window, document) {
    'use strict';

    // Example of Drupal behavior loaded.
    Drupal.behaviors.cardAccordionJS = {
        attach: function (context, settings) {

            $('.component__grid-accordion__heading').click(function (e) {
                e.preventDefault();

                if ($(this).parent("div").find('.component__grid-accordion__open').hasClass('is-open')) {
                    $(this).parent("div").find('.component__grid-accordion__body').removeClass('is-active');
                    $(this).parent("div").find('.component__grid-accordion__open').removeClass('is-open');
                    $(this).find('.component__grid-accordion__open__song').html('Ver más');
                } else {
                    $(this).parent("div").find('.component__grid-accordion__body').addClass('is-active');
                    $(this).parent("div").find('.component__grid-accordion__open').addClass('is-open');
                    $(this).parent("div").find('.component__grid-accordion__open__song').html('Ver menos');
                }
            });
        }

    };
})(jQuery, Drupal, this, this.document);

