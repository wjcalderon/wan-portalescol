(function ($) {
  jQuery(document).ready(function () {
    $(".webform-submission-add-form").submit(function (e) {
      if (".webform-file-button") {
        console.log("archivos");
      }

      if (grecaptcha.getResponse(0) == "") {
      } else {
        $(this).submit();
      }
      if (grecaptcha.getResponse(1) == "") {
      } else {
        $(this).submit();
      }
      if (grecaptcha.getResponse(2) == "") {
      } else {
        $(this).submit();
      }
      e.preventDefault();
    });
  });

  Drupal.behaviors.Forms = {
    attach: function (context, settings) {},
  };
})(jQuery);
