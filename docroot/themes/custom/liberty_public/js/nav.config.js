(function ($, Drupal, window, document) {
  "use strict";

  // Example of Drupal behavior loaded.
  Drupal.behaviors.themeNavJS = {
    attach: function (context, settings) {
      $(function () {
        if ($("body").hasClass("js-mobile")) {
          $(".links_cotizadores")
            .parent("li")
            .find("a")
            .not(".internal, .nav-submb__link")
            .attr("target", "_blank");
        }
      });

      $("#navigation-mb .nav__mb, #block-menufooter .nav__mb").on(
        "click",
        function () {
          let nav = $(this);
          if (nav.siblings("ul").hasClass("desplegado")) {
            nav.siblings("ul").css("height", 0);
            nav.siblings("ul").removeClass("desplegado");
            nav.removeClass("nav__mb--open");
          } else {
            let alto = nav.siblings("ul").children("li").height(),
              hijos = nav.siblings("ul").children("li").length,
              altoTotal = alto * hijos;
            nav.siblings("ul").addClass("desplegado");
            nav.siblings("ul").css("height", altoTotal);
            nav.addClass("nav__mb--open");
          }
        }
      );

      $(".item-erramienta--mb").click(function () {
        let nav = $("#navegacion");
        if (nav.hasClass("is-visible")) {
          nav.removeClass("is-visible");
        } else {
          nav.addClass("is-visible");
        }
      });

      $("#burguer-menu").click(function () {
        $("body").addClass("abierto no-scroll");
      });

      $("#close-mb").click(function () {
        $("body").removeClass("abierto no-scroll");
      });

      if ($("body").hasClass("js-mobile")) {
        $(".nav-contact, .nav__mb").removeAttr("href").css("cursor", "pointer");
      }

      $(".nav-contact").on("click", function () {
        let el = $(this),
          cont = $(".mb__info-cont");

        if (cont.hasClass("is-visible")) {
          cont.removeClass("is-visible");
          el.removeClass("nav-herramientas__link--active");
        } else {
          cont.addClass("is-visible");
          el.addClass("nav-herramientas__link--active");
        }
      });

      // Componente cuentanos de ti
      $(".component__select-cta .component__content button").click(function () {
        let value = $(
          ".component__select-cta .component__content .select-cta"
        ).val();
        if (value != "" && value != 0) {
          window.location.href = value;
        }
      });

      if (window.location.hash) {
        let id_tab = window.location.hash.substr(5, 1);
        $(".cp-tabs:visible")
          .find('a[href="#tab-' + id_tab + '"]')
          .click();
      }

      function PopupCenter(url, title, w, h) {
        // Fixes dual-screen position                         Most browsers      Firefox
        let dualScreenLeft =
            window.screenLeft != undefined ? window.screenLeft : window.screenX,
          dualScreenTop =
            window.screenTop != undefined ? window.screenTop : window.screenY,
          width = window.innerWidth
            ? window.innerWidth
            : document.documentElement.clientWidth
            ? document.documentElement.clientWidth
            : screen.width,
          height = window.innerHeight
            ? window.innerHeight
            : document.documentElement.clientHeight
            ? document.documentElement.clientHeight
            : screen.height,
          systemZoom = width / window.screen.availWidth,
          left = (width - w) / 2 / systemZoom + dualScreenLeft,
          top = (height - h) / 2 / systemZoom + dualScreenTop,
          newWindow = window.open(
            url,
            title,
            "scrollbars=yes, width=" +
              w / systemZoom +
              ", height=" +
              h / systemZoom +
              ", top=" +
              top +
              ", left=" +
              left
          );

        // Puts focus on the newWindow
        if (window.focus) newWindow.focus();
        window.resizing = false;
        newWindow.resizing = false;
      }

      // Cotizadores
      $(".links_cotizadores a")
        .not(".internal")
        .on("click", function (e) {
          e.preventDefault();
          PopupCenter($(this).attr("href"), $(this).text(), "600", "800");
        });

      // Noticias
      $("body.alias--noticias .view-display-id-block_news .view-content")
        .find(".views-row")
        .each(function () {
          let row = $(this),
            card = row.find(".item-noti"),
            link = card.find(".item-noti__cta a").attr("href");

          card.wrap('<a  href="' + link + '"></a>');
        });
    },
  };
})(jQuery, Drupal, this, this.document);
