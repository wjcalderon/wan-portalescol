(function ($, Drupal, window, document) {
  Drupal.behaviors.themeSlickConfig = {
    attach: function (context, settings) {
      // config
      let slick_options = {
        dots: false,
        arrows: true,
        infinite: false,
        speed: 800,
        slidesToShow: 3,
        slidesToScroll: 3,
        prevArrow: '<button type="button" class="slick-prev">Previous</button>',
        nextArrow: '<button type="button" class="slick-next">Next</button>',
        responsive: [
          {
            breakpoint: 978,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
              infinite: true,
              dots: true,
              arrows: false,
            },
          },
        ],
      };

      let slick_options_mobile = {
        dots: true,
        arrows: false,
        infinite: true,
        speed: 300,
        centerMode: true,
        slidesToShow: 1,
        slidesToScroll: 1,
      };

      let slick_options_mobile_no_center = {
        dots: true,
        arrows: false,
        infinite: true,
        speed: 300,
        centerMode: false,
        slidesToShow: 4,
        slidesToScroll: 1,
      };

      // Mobile sliders
      if ($("body").hasClass("js-mobile")) {
        $(
          ".component.js-slider-mobile .cog--items, .component.js-slider-mobile .view-content, .component .tabs ul.js-slider-mobile"
        )
          .not(".slick-initialized")
          .slick(slick_options_mobile);
        $(".component.js-slider-mobile-nc .cog--items")
          .not(".slick-initialized")
          .slick(slick_options_mobile_no_center);

        $(".cp-tabs .js-slider-nondk, .documents_requiered_tabs .js-slider")
          .not(".slick-initialized")
          .slick();

        if ($("body").hasClass("alias--financia-ya")) {
          $(".cp-tabs.is-shorcut .main-links").not(".slick-initialized").slick({
            dots: false,
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            infinite: false,
            touchMove: true,
            variableWidth: true,
          });
        } else {
          $(".cp-tabs.is-shorcut .main-links").not(".slick-initialized").slick({
            dots: false,
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            infinite: true,
            touchMove: true,
            variableWidth: true,
          });
        }

        $(".cp-tabs.is-shorcut .main-links > .slick-list").css(
          "height",
          "5rem"
        );

        $(".features.js-slider").not(".slick-initialized").slick(slick_options);

        $(".next-arrow").on("click", function () {
          $(".js-slider").slickNext();
        });
        $(".prev-arrow").on("click", function () {
          $(".js-slider").slickPrev();
        });
      }

      $(
        ".component.js-slider .cog--items, .component .view-content.js-slider, .component .tabs ul.js-slider, #block-tabsdocumentosrequeridos .cp-tabs .js-slider"
      )
        .not(".slick-initialized")
        .slick(slick_options);
      $(".features.js-slider").not(".slick-initialized").slick(slick_options);
      $(".next-arrow").on("click", function () {
        $(".js-slider").slickNext();
      });
      $(".prev-arrow").on("click", function () {
        $(".js-slider").slickPrev();
      });

      $(".component.component__slider .cog--items")
        .not(".slick-initialized")
        .slick({
          dots: true,
          infinite: true,
          speed: 1200,
          slidesToShow: 1,
          slidesToScroll: 1,
          lazyLoad: "ondemand",
          adaptiveHeight: true,
          autoplay: true,
          autoplaySpeed: 4000,
        });

      $(
        "#tab-0 .grid--carousel .view-content, #tab-2 .grid--carousel .view-content, #tab-3 .grid--carousel .view-content, #tab-4 .grid--carousel .view-content"
      )
        .not(".slick-initialized")
        .slick({
          infinite: true,
          speed: 300,
          slidesToShow: 1,
          slidesToScroll: 1,
          dots: true,
          arrows: false,
          lazyLoad: "ondemand",
          adaptiveHeight: true,
          autoplay: false,
          autoplaySpeed: 4000,
          mobileFirst: true,
          responsive: [
            {
              breakpoint: 767,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 1,
                arrows: true,
                dots: false,
              },
            },
          ],
        });

      $(
        "#block-tabsasistencias .cp-tabs .js-slider, .documents_requiered_tabs .js-slider"
      )
        .not(".slick-initialized")
        .slick();

      $(".component__card-person-list .field__items").slick({
        infinite: true,
        speed: 500,
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: true,
        adaptiveHeight: true,
        autoplay: true,
        autoplaySpeed: 4000,
        mobileFirst: true,
        responsive: [
          {
            breakpoint: 767,
            settings: "unslick",
          },
        ],
      });
    },
  };
})(jQuery, Drupal, this, this.document);
