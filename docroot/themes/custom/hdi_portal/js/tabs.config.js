(function ($, Drupal, window, document) {
  "use strict";

  Drupal.behaviors.tabsJS = {
    attach: function (context, settings) {
      $(".cp-tabs").not(".is-shorcut, .popup-no-tabs").tabs();

      if ($("body").hasClass("js-mobile")) {
        // Asistencias view more
        $(".sub-tab__row").each(function () {
          let row = $(this),
            steps = row.find(".sub-tab__content ol li"),
            num_steps = steps.length,
            visible_steps = steps.slice(0, 3);
          if (num_steps > 3) {
            steps.each(function () {
              $(this).hide();
            });
            visible_steps.each(function () {
              $(this).show();
            });
            row.children(".view-more").css("visibility", "visible");
          }
        });

        // Tabs contact
        if ($(".component__tabs--contact").length > 0) {
          // Add click card in mobile
          $(".component__tabs--contact .cp-tabs .component__card").on(
            "click",
            function () {
              let id_tab = $(this).children(".cta").children("a").attr("href");
              if ($(this).parents(".cp-tabs").hasClass("popup-no-tabs")) {
                window.location.replace(id_tab);
                return false;
              }
              $(this).parents(".cp-tabs").children(id_tab).addClass("active");
            }
          );
        }
      }

      let fix_subtabs_assistances = function (select, tab) {
        select
          .find("option:eq(0)")
          .attr("selected", "selected")
          .trigger("change");
        select.triggerHandler("focus");
        if (tab.find(".sub-tabs").tabs("instance") !== undefined) {
          if (
            tab.parents(
              ".block-tabs-assistances, .block-tabs-documents-required"
            ).length > 0
          ) {
            tab.find(".sub-tabs").tabs("destroy");
          }
        }
      };

      $(function () {
        let id_tab = $(
            "#tabs .component__heading ul li.ui-state-active a"
          ).attr("href"),
          tab = $(id_tab),
          select = tab.find(".select--tabs");

        fix_subtabs_assistances(select, tab);
      });

      $(".cp-tabs ul li a").on("click", function (e) {
        if (!($(this).hasClass('popup-no-tabs'))) {
          let el = $(this),
            id_body_tab = el.attr("href"),
            body_tab = el.parents(".cp-tabs").children(id_body_tab),
            js_slider = body_tab.find(".js-slider-mobile"),
            select = body_tab.find(".select--tabs");

          if (select.length > 0) {
            fix_subtabs_assistances(select, $(id_body_tab));
          }

          if (js_slider.length > 0) {
            setTimeout(function () {
              js_slider.find(".cog--items").slick("setPosition");
            }, 10);
          }
        }
      });

      let getUrlParameter = function (sParam) {
        const urlParams = new URL(document.location)
        if (urlParams?.hash.includes(sParam)) {
          return urlParams?.hash.split('-')[1]
        }

        return false
      }

      $(function () {
        let active_tab = getUrlParameter("tab")
        if (active_tab !== undefined) {
          $('a[href="#tab-' + active_tab + '"]').trigger('click')
        }
      })

      $(".cp-tabs.is-shorcut .normal-tab a").on("click", function (e) {
        e.preventDefault();
        $(".cp-tabs.is-shorcut .normal-tab a").removeClass("active");
        $(this).addClass("active");
        let strAncla = $(this).attr("href"); //id del ancla

        let pop = $(strAncla).offset().top;
        console.log(pop);
        $("html, body")
          .stop(true, true)
          .animate(
            {
              scrollTop: $(strAncla).offset().top - 100,
            },
            1000
          );
      });

      // Tabs
      $(".select--tabs").change(function () {
        if (
          $(this)
            .parent()
            .parent()
            .parent()
            .parent()
            .find(".sub-tab__container").length > 0
        ) {
          $(this)
            .parent()
            .parent()
            .parent()
            .parent()
            .find(".sub-tab__container")
            .hide();
          let id = $(this).val();
          $("#" + id).show();
        } else {
          $(".tabs").hide();
          $("#" + $(this).val()).show();
        }
      });

      // Tabs contact
      if ($(".component__tabs--contact").length > 0) {
        // Add active tabs contact
        $(".component__tabs--contact .cp-tabs li").removeClass(
          "ui-tabs-active ui-state-active"
        );
        $(".component__tabs--contact .cp-tabs li .component__card a").click(
          function (e) {
            if(!($(this).hasClass('popup-no-tabs'))) {
              e.preventDefault();
              $(this)
                .parents(".component__tabs--contact .cp-tabs li")
                .addClass("ui-tabs-active ui-state-active");
              let $id_tab = $(this).attr("href");
              $id_tab = $id_tab.substr(1);
              $(this).parents(".cp-tabs").find(".tabs").removeClass("active");
              $(this)
                .parents(".cp-tabs")
                .find("#" + $id_tab)
                .addClass("active");
            }
          }
        );
        $(".component__tabs--contact .cp-tabs .tabs form #close").click(
          function (e) {
            $(this).parents(".tabs").removeClass("active");
          }
        );
      }

      // Hide subtabs if only exist 1 tab, show arrows on enterprise assitances
      $("#sub-tabs .component__heading").each(function () {
        let sub_tab = $(this),
          select = sub_tab.find(".select--tabs"),
          product_sub_tabs = select.find("option").length;

        if (product_sub_tabs === 1) {
          sub_tab.hide();
        }
      });

      $(".sub-tab__row .view-more").on("click", function (e) {
        e.preventDefault();
        let parent = $(this).parents(".sub-tab__row");
        parent.addClass("popup");
        parent.find(".sub-tab__heading-img").addClass("card__img--oval");
        parent.find(".sub-tab__content ol li").each(function () {
          $(this).show();
        });
      });

      $(".sub-tab__row .popup-close").on("click", function (e) {
        e.preventDefault();
        let parent = $(this).parents(".sub-tab__row");
        parent.find(".sub-tab__heading-img").removeClass("card__img--oval");
        parent.find(".sub-tab__content ol li").each(function (ind) {
          if (ind > 2) {
            $(this).hide();
          }
        });
        parent.removeClass("popup");
      });

      $(function () {
        // Componente menutabs fixed scroll detalle producto
        let menu = $(".is-shorcut .main-links");
        if (menu.length > 0) {
          let menuFixed = Math.ceil(menu.offset().top),
            menuFixedheight = menuFixed - 20;

          $(window).scroll(function () {
            let windowHeight = $(window).scrollTop();
            if (windowHeight > menuFixedheight) {
              menu
                .addClass("fixed")
                .parent(".cog--mq")
                .addClass("is-fixed")
                .css("margin-bottom", "5.25rem");
              $('body').addClass('menu-fixed')
            } else {
              menu
                .removeClass("fixed")
                .parent(".cog--mq")
                .removeClass("is-fixed")
                .css("margin-bottom", "");
              $('body').removeClass('menu-fixed')
            }
          });
        }
      });

      $(function () {
        // Highlight actual component link on scroll
        let menu = $(".is-shorcut");
        if (menu.length > 0) {
          $(window).scroll(function () {
            menu.find("div.tabs").each(function () {
              let el = $(this),
                id = el.attr("id"),
                menuFixed = Math.ceil(el.offset().top) - 150,
                menuFixedheight = menuFixed,
                windowHeight = $(window).scrollTop();

              if (windowHeight > menuFixedheight) {
                menu.find("a.active").removeClass("active");
                menu.find('a[href="#' + id + '"]').addClass("active");
              }
            });
          });
        }
      });

      $(".component__shorcuts .sticky-item a").on("click", function (e) {
        e.preventDefault();
        $(
          ".component__shorcuts .sticky-item, .component__shorcuts .sticky-item a"
        ).removeClass("active");
        $(this).parent().addClass("active");
        $(this).addClass("active");
        let strAncla = $(this).attr("href"); //id del ancla

        let pop2 = $(strAncla).offset().top;
        $("html, body")
          .stop(true, true)
          .animate(
            {
              scrollTop: $(strAncla).offset().top - 70,
            },
            1000
          );
        e.stopPropagation();
      });

      $(function () {
        // Componente menutabs fixed scroll detalle producto
        let menu = $(".component__shorcuts .sticky-wrapper");
        if (menu.length > 0) {
          let menuFixed = Math.ceil(menu.offset().top),
            menuFixedheight = menuFixed + 16;

          $(window).scroll(function () {
            let windowHeight = $(window).scrollTop();
            if (windowHeight > menuFixedheight) {
              menu
                .addClass("is-fixed")
                .parent(".sticky-container")
                .css("margin-bottom", "11.25rem");
            } else {
              menu
                .removeClass("is-fixed")
                .parent(".sticky-container")
                .css("margin-bottom", "");
            }
          });
        }
      });

      $(function () {
        // Highlight actual component link on scroll
        let menu = $(".block-system-main-block");
        if (menu.length > 0) {
          $(window).scroll(function () {
            menu.find("div.shortcut-item").each(function () {
              let el = $(this),
                id = el.attr("id"),
                menuFixed = Math.ceil(el.offset().top) - 80,
                menuFixedheight = menuFixed,
                windowHeight = $(window).scrollTop();

              if (windowHeight > menuFixedheight) {
                menu.find(".sticky-item").removeClass("active");
                menu.find(".sticky-item a").removeClass("active");
                menu
                  .find('.sticky-item a[href="#' + id + '"]')
                  .parent()
                  .addClass("active");
                menu
                  .find('.sticky-item a[href="#' + id + '"]')
                  .addClass("active");
              }
            });
          });
        }
      });

      $(window).bind("hashchange", function (e) {
        location.reload(true);
      });

      // Agregando tabindex a cada tab
      $(".cp-tabs").find("ul").children('li[role="tab"]').attr("tabindex", "0");

      //menu mobile
      $(".tabs--menu-mobile .tab--first a").click(function (e) {
        e.preventDefault();
        if (!$(".tab--first").hasClass("active")) {
          $(".tab--second").removeClass("active");
          $(".tab--first").addClass("active");

          $(".tab-content--first").removeClass("is-desktop");
          $(".tab-content--second").addClass("is-desktop");
        }
      });

      $(".tabs--menu-mobile .tab--second a").click(function (e) {
        e.preventDefault();
        if (!$(".tab--second").hasClass("active")) {
          $(".tab--first").removeClass("active");
          $(".tab--second").addClass("active");

          $(".tab-content--second").removeClass("is-desktop");
          $(".tab-content--first").addClass("is-desktop");
        }
      });

      // tabs mobile formas pago
      $(".tabs--pagos-online .component__card").click(function (e) {
        e.preventDefault();
        $(".tabs--pagos-online .component__card").removeClass("item-active");
        $(this).addClass("item-active");

        $(".tabs__formas-de-pago #tab-0 .component").removeClass("is-hide-mb");
        if ($(this).hasClass("item-first")) {
          $(
            ".tabs__formas-de-pago #tab-0 .js-item-second, .tabs__formas-de-pago #tab-0 .js-item-third"
          ).addClass("is-hide-mb");
        }
        if ($(this).hasClass("item-second")) {
          $(
            ".tabs__formas-de-pago #tab-0 .js-item-first, .tabs__formas-de-pago #tab-0 .js-item-third"
          ).addClass("is-hide-mb");
        }
        if ($(this).hasClass("item-third")) {
          $(
            ".tabs__formas-de-pago #tab-0 .js-item-first, .tabs__formas-de-pago #tab-0 .js-item-second"
          ).addClass("is-hide-mb");
        }
      });

      $(".tabs--financia .component__card").click(function (e) {
        e.preventDefault();
        $(".tabs--financia .component__card").removeClass("item-active");
        $(this).addClass("item-active");

        $(".tabs__formas-de-pago #tab-1 .component").removeClass("is-hide-mb");
        if ($(this).hasClass("item-first")) {
          $(
            ".tabs__formas-de-pago #tab-1 .js-item-second, .tabs__formas-de-pago #tab-1 .js-item-third"
          ).addClass("is-hide-mb");
        }
        if ($(this).hasClass("item-second")) {
          $(
            ".tabs__formas-de-pago #tab-1 .js-item-first, .tabs__formas-de-pago #tab-1 .js-item-third"
          ).addClass("is-hide-mb");
        }
        if ($(this).hasClass("item-third")) {
          $(
            ".tabs__formas-de-pago #tab-1 .js-item-first, .tabs__formas-de-pago #tab-1 .js-item-second"
          ).addClass("is-hide-mb");
        }
      });

      $(".tabs--otras-formas-pago .component__card").click(function (e) {
        e.preventDefault();
        $(".tabs--otras-formas-pago .component__card").removeClass(
          "item-active"
        );
        $(this).addClass("item-active");

        $(
          ".canales-pago .payment-row:nth-child(2), .canales-pago .payment-row:nth-child(3)"
        ).hide();
        if ($(this).hasClass("item-first")) {
          $(
            ".canales-pago .payment-row:nth-child(2), .canales-pago .payment-row:nth-child(3)"
          ).hide();
          $(".canales-pago .payment-row:nth-child(1)").show();
        }
        if ($(this).hasClass("item-second")) {
          $(
            ".canales-pago .payment-row:nth-child(1), .canales-pago .payment-row:nth-child(3)"
          ).hide();
          $(".canales-pago .payment-row:nth-child(2)").show();
        }
        if ($(this).hasClass("item-third")) {
          $(
            ".canales-pago .payment-row:nth-child(1), .canales-pago .payment-row:nth-child(2)"
          ).hide();
          $(".canales-pago .payment-row:nth-child(3)").show();
        }
      });
    },
  };
})(jQuery, Drupal, this, this.document);
