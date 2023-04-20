(function ($) {
  Drupal.behaviors.microsites = {
    attach: function (context, settings) {

      $(function () {
        let frm = $('iframe');
          // src = frm.attr('src').replace('sites/default/files/microsites/', ''),
          // frm_images = frm.contents().find('img');

        // frm_images.each(function (i, e) {
        //   let el = $(e),
        //     img_src = src.replace('/index.html');
        //   el.attr('src', img_src + '/' + el.attr('src'));
        // });

        setTimeout(function() {
          frm.css('height', frm.contents().find('body').prop('scrollHeight'));
        }, 1000);
      });

    }
  }
})(jQuery);
