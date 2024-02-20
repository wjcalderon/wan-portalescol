<<<<<<< HEAD
(function($) {
    jQuery(document).ready(function() {
        $('.webform-submission-add-form').submit(function(e) {
            //console.log(grecaptcha.getResponse());

            if ('.webform-file-button') {
                console.log('archivos');
            }

            if (grecaptcha.getResponse(0) == "") {
                //form.submit();
            } else {
                $(this).submit();
            }
            if (grecaptcha.getResponse(1) == "") {
                //form.submit();
            } else {
                $(this).submit();
            }
            if (grecaptcha.getResponse(2) == "") {
                //form.submit();
            } else {
                $(this).submit();
            }
            e.preventDefault();
            //console.log(4343);
        });
        /*if ($('.alias--zona-de-cliente-contactanos').length > 0) {
        setTimeout(function() {
            $('.alias--zona-de-cliente-contactanos').find('.alerta-form').hide();
        }, 20000);

        //}*/

    });

    Drupal.behaviors.Forms = {
        attach: function(context, settings) {

        }
    }


})(jQuery);
=======
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
>>>>>>> main
