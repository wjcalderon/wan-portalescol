/*(function($) {
    Drupal.behaviors.Forms = {
        attach: function(context, settings) {
            $('.webform-submission-add-form', context).submit(function(e) {
                console.log(grecaptcha.getResponse());
                if (grecaptcha.getResponse() == "") {
                    e.preventDefault();
                    console.log(123);
                    //form.submit();
                }
                console.log(456);
            });
            console.log(678);
        }
    }
})(jQuery);*/