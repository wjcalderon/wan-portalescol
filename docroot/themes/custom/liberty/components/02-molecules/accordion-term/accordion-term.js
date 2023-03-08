(function ($, Drupal, window, document) {
    'use strict';

    // Example of Drupal behavior loaded.
    Drupal.behaviors.accordionTerms = {
        attach: function (context, settings) {

            $('.accordion-term__tab1').click(function (e) {
                e.preventDefault();

                if ($(this).hasClass('is-active')) {
                    $(this).removeClass('is-active');
                    $('.accordion-term__content1').removeClass('is-open');
                } else {
                    $(this).addClass('is-active');
                    $('.accordion-term__content1').addClass('is-open');
                }
            });

            $('.accordion-term__tab2').click(function (e) {
                e.preventDefault();

                if ($(this).hasClass('is-active')) {
                    $(this).removeClass('is-active');
                    $('.accordion-term__content2').removeClass('is-open');
                } else {
                    $(this).addClass('is-active');
                    $('.accordion-term__content2').addClass('is-open');
                }
            });
        }
        
    };
})(jQuery, Drupal, this, this.document);