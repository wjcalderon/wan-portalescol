(function ($) {
  jQuery(document).ready(function () {
    $(".webform-submission-add-form").submit(function (e) {
      if (".webform-file-button") {
        console.log("archivos");
      }
      if (grecaptcha.getResponse(0) == "") {
        console.log("archivos");
      } else {
        $(this).submit();
      }
      if (grecaptcha.getResponse(1) == "") {
        console.log("archivos");
      } else {
        $(this).submit();
      }
      if (grecaptcha.getResponse(2) == "") {
        console.log("archivos");
      } else {
        $(this).submit();
      }
      e.preventDefault();
    });
  });
})(jQuery);
