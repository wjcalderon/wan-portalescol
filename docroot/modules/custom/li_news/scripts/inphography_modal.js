(function ($, Drupal) {
  Drupal.behaviors.inphographyModal = {
    attach: function (context, settings) {
      $(".info-modal", context)
        .once("inpho-initialized")
        .each(function (index, item) {
          const $container = $(item);

          const $img = $container.find("img");
          const $closeButton = $container.find(".close-modal");
          console.log($img.attr("src"));
          const modal = `<div class="modal"><div class="content-modal"><div class="close-modal"></div><img src="${$img.attr(
            "src"
          )}"></div></div>`;
          $("body").append(modal);

          $img.click((e) => {
            $(".modal").addClass("active");
          });

          $(".close-modal").click((e) => {
            $(".modal").removeClass("active");
          });
        });
    },
  };
})(jQuery, Drupal);
