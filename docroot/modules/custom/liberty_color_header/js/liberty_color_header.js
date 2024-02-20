(function ($, Drupal, drupalSettings) {
  Drupal.behaviors.liberty_color_headerBehavior = {
    attach: function (context, settings) {
      // get color_body value with "drupalSettings.liberty_color_header.color_header"
      let color_header = drupalSettings.liberty_color_header.color_header;
      $("header").addClass("header-" + color_header);

      switch (color_header) {
        case "white":
          $("#logo_id").attr(
            "src",
            "/modules/custom/liberty_color_header/images/logo.svg"
          );
          $("#logo_id").attr("width", "141px");
          $("#logo_id").attr("height", "68px");
          break;

        case "yellow":
          $("#logo_id").attr(
            "src",
            "/modules/custom/liberty_color_header/images/logo.svg"
          );
          $("#logo_id").attr("width", "141px");
          $("#logo_id").attr("height", "68px");
          break;
      }
    },
  };
})(jQuery, Drupal, drupalSettings);
