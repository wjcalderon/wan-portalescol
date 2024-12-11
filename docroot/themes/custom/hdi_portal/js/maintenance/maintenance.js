(function ($, Drupal, window) {
  "use strict";

  Drupal.behaviors.maintenanceJS = {
    attach: function (context, settings) {
      $(window).on("load", function () {
        const settings = {
          mobileFirst: true,
          dots: true,
          arrows: false,
        }

        if ($(window).width() < 768) {
          $('.workers-content-cards').slick(settings)
        }
      })
    }
  }

})(jQuery, Drupal, this)

