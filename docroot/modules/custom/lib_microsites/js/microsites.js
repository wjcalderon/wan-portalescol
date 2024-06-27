(function ($) {
  Drupal.behaviors.microsites = {
    attach: function (context, settings) {

      $(function () {
        let frm = $('iframe');
        setTimeout(function() {
          frm.css('height', frm.contents().find('body').prop('scrollHeight'));
        }, 1000);
      });

    }
  }
})(jQuery);
