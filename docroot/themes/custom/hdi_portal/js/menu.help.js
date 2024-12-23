(function ($, Drupal, window, document) {
  "use strict";

  $("#block-hdi-portal-buscasayuda").on("click", "#show-menu-help", function (e) {
    e.preventDefault();

    let boton = $(this),
      menu = boton.parent("#block-hdi-portal-buscasayuda").find("ul.menu"),
      body = $("body");
    // console.log(boton.hasClass('active'));
    if (boton.hasClass("active")) {
      boton.removeClass("active");
      menu.addClass("is-hidden");
      if (body.hasClass("js-mobile")) {
        $(".overlay-buscayuda").remove();
        body.removeClass("abierto-azul");
      }
    } else {
      boton.addClass("active");
      menu.removeClass("is-hidden");
      if (body.hasClass("js-mobile")) {
        body.append('<div class="overlay-buscayuda"></div>');
        body.addClass("abierto-azul");
      }
    }
  });

  // Menu help
  Drupal.behaviors.menuHelpJS = {
    attach: function (context, settings) {
      $(function () {
        $(".unificacion-popup").on("click", function (e) {
          e.preventDefault()

          let modal = '#block-hdi-portal-modalconsultapolizas'
          if ($(this).hasClass('citasmedicas')) {
            modal = "#block-hdi-portal-citasmedicaspopup"
          }

          $('.unificacion-popup.unificacion-modal').css('z-index', '9999');
          $('.tb-megamenu .mega > .mega-dropdown-menu').css('z-index', '1');

          $(modal)
            .show()
            .addClass("is-fixed-global")
            .removeClass("is-hidden")
        })

        $('.unificacion-modal').on("click", '.close-button', function (e) {
          e.stopPropagation()

          $('.unificacion-modal').parent('.is-fixed-global')
            .removeClass("is-fixed-global")
            .addClass("is-hidden")
            .hide()
        })

        let modal_fallback = $(".modal-link-fallback-popup");
        if (!modal_fallback.hasClass("modal-close")) {
          if (modal_fallback.length > 0) {
            // Get dates
            let table = modal_fallback.find("table"),
              start_date = table.find("tr").eq(0).find("td").eq(1).text(),
              end_date = table.find("tr").eq(1).find("td").eq(1).text(),
              actual_date = new Date();

            // Remove table
            table.remove();

            // Compare dates
            if (
              Date.parse(start_date) < Date.parse(actual_date) &&
              Date.parse(end_date) > Date.parse(actual_date)
            ) {
              $("#blocks-necesecitas-ayuda")
                .addClass("is-fixed-global")
                .removeClass("is-hidden");
              modal_fallback.removeClass("is-hidden");
            }
          }
        } else {
          $("#blocks-necesecitas-ayuda")
            .addClass("is-fixed-global")
            .removeClass("is-hidden");
          modal_fallback.removeClass("is-hidden");
          modal_fallback
            .find("span.modal-close, span.button")
            .on("click", function () {
              $("#blocks-necesecitas-ayuda").removeClass("is-fixed-global");
              modal_fallback.addClass("is-hidden");
            });
        }
      });

      if (
        $("#block-sinisterthankyoumessage").hasClass(
          "block-sinister-notification-thankyou"
        )
      ) {
        $(".component__drupal-block").addClass("thankyou");
      }

      $("#block-hdi-portal-buscasayuda ul.menu").on("click", "li.close", function () {
        $("#block-hdi-portal-buscasayuda ul.menu").addClass("is-hidden");
        $("#block-hdi-portal-buscasayuda #show-menu-help").removeClass("active");
      });

      // Close modal on click outside modal content
      $("body").on("click", ".is-fixed-global", function (e) {
        if (e.target !== this) {
          return;
        }
        $("#blocks-necesecitas-ayuda .head-modal #close-mb").click();
      });

      // help menu
      $("#block-hdi-portal-buscasayuda ul.menu li a")
        .not(".chat, .nopopup")
        .on("click", function (e) {
          e.preventDefault();
          $("#block-hdi-portal-buscasayuda ul.menu").addClass("is-hidden");
          let id = $(this).attr("href"),
            menu_help = $("#blocks-necesecitas-ayuda"),
            block_help = menu_help.find(id),
            head_modal = block_help.find(".head-modal"),
            close_btn;

          // show block
          block_help.addClass("is-fixed-global").removeClass("is-hidden");

          // add close button
          if (head_modal.length > 0) {
            close_btn = "";
          } else {
            close_btn =
              '<div class="head-modal"><span id="close-mb" class="close"><img src="/themes/custom/liberty_public/images/icons/close.svg"></span></div>';
            block_help.find(".field--name-field-banner").prepend(close_btn);
          }

          // hide block
          block_help.find("#close-mb").on("click", function () {
            $(this)
              .parent()
              .parent()
              .parent()
              .addClass("is-hidden")
              .removeClass("is-fixed-global");
            menu_help.find("ul.menu").addClass("is-hidden");
            menu_help.find("#show-menu-help").removeClass("active");
            $(".overlay-buscayuda").remove();
          });

          switch (id) {
            // payment points
            case "#block-buscadorpuntosdepagopopup":
              block_help.addClass("no-transform-y");
              block_help.find("#edit-name, #edit-title").each(function () {
                $(this).val("");
              });
              block_help.find(".button").click();

              $("#filters-payment .button").click(function () {
                let ciudad = $("#filters-payment #edit-name").val();
                let nombre = $("#filters-payment #edit-title").val();
                block_help.find('.view-filters input[name="name"]').val(ciudad);
                block_help
                  .find('.view-filters input[name="title"]')
                  .val(nombre);
                block_help
                  .find('.view-filters input[type="submit"]')
                  .each(function () {
                    $(this).click();
                  });
              });

              block_help.find(".options-results li a").click(function (event) {
                event.preventDefault();
                let type = $(this).attr("cdata-type");
                block_help.find(".options-results li a").removeClass("active");
                $(this).addClass("active");
                if (type == "map") {
                  block_help
                    .find(".list-points-payment")
                    .addClass("is-desktop");
                  block_help
                    .find(".mapa-points-payment")
                    .removeClass("is-desktop");
                }
                if (type == "list") {
                  block_help
                    .find(".mapa-points-payment")
                    .addClass("is-desktop");
                  block_help
                    .find(".list-points-payment")
                    .removeClass("is-desktop");
                }
              });

              block_help.find(".show-filters").on("click", function (e) {
                e.preventDefault();
                let el = $(this);
                if (el.hasClass("filters-open")) {
                  el.children("a").text("Mostrar filtros");
                  el.removeClass("filters-open");
                  block_help.find(".filters").addClass("is-desktop");
                } else {
                  el.children("a").text("Ocultar filtros");
                  el.addClass("filters-open");
                  block_help.find(".filters").removeClass("is-desktop");
                }
              });

              break;
            // medical network
            case "#block-redmedicapopup":
              let block_search = block_help.find(".wrapper-form-search");
              block_help
                .find("#edit-plan-type input[name=plan_type]")
                .each(function (ind, el) {
                  let radio = $(el);
                  if (radio.is(":checked")) {
                    radio.prop("checked", false);
                  }
                })
                .find(".mapa-redmedica-popup")
                .addClass("is-hidden");
              if ($("body").hasClass("js-mobile")) {
                block_search.removeClass("transform-up, is-fixed");
                block_search
                  .find("#edit-plan-type .form-item")
                  .removeClass("is-desktop");
                block_help.find("#gp_form, .ctn-footer").each(function () {
                  $(this).addClass("is-hidden");
                });
                block_help.find(".form-item").removeClass("is-hidden");
                block_help.find(".close-filter").remove();

                // add cancel button
                if (block_help.find(".form-cancel").length === 0) {
                  block_help
                    .find(".ctn-footer")
                    .append(
                      '<div class="form-item">' +
                        '<input class="btn button form-cancel" ' +
                        'type="button" value="Cancelar"></div>'
                    );
                }
                // close on cancel
                block_help.on("click", ".form-cancel", function () {
                  block_help.find("#close-mb").click();
                });
              }

              block_help
                .find(".block-search-medical-network .ctn-footer")
                .on("click", ".form-submit", function (e) {
                  e.preventDefault();

                  let plan = block_help.find("input[name='plan_type']").val(),
                    city = block_help.find("input[name='h_city']").val(),
                    specialty = block_help.find("#edit-specialty").val(),
                    word = block_help.find("#edit-search-word").val();
                  if (
                    plan != "" &&
                    city != "" &&
                    specialty != "" &&
                    specialty != "none"
                  ) {
                    $(this).removeAttr("disabled");
                  }
                  block_help
                    .find(
                      '.mapa-redmedica-popup .view-filters select[name="field_type_plan_target_id"]'
                    )
                    .val(plan);
                  block_help
                    .find(
                      '.mapa-redmedica-popup .view-filters select[name="field_ubication_target_id"]'
                    )
                    .val(city);
                  block_help
                    .find(
                      '.mapa-redmedica-popup .view-filters select[name="field_speciality_target_id"]'
                    )
                    .val(specialty);
                  block_help
                    .find(
                      '.mapa-redmedica-popup .view-filters input[name="title"]'
                    )
                    .val(word);
                  block_help
                    .find(
                      '.mapa-redmedica-popup .view-filters input[type="submit"]'
                    )
                    .click();
                  if (
                    block_help
                      .find(".mapa-redmedica-popup")
                      .hasClass("is-hidden")
                  ) {
                    block_help
                      .find(".mapa-redmedica-popup")
                      .removeClass("is-hidden");
                  }
                });

              block_help.find("#edit-search").on("click", function () {
                block_help.addClass("no-transform-y");
                if ($("body").hasClass("js-mobile")) {
                  block_help.removeClass("no-transform-y");
                  if (block_search.hasClass("is-fixed")) {
                    block_search
                      .addClass("transform-up")
                      .removeClass("transform-media");
                  }
                }
              });

              break;
            // faqs
            case "#block-faqspopups":
              // reinit slick on mobile
              if ($("body").hasClass("js-mobile")) {
                setTimeout(function () {
                  block_help
                    .find(".slick-initialized")
                    .slick("unslick")
                    .slick();
                }, 10);
              }

              block_help.find(".form-buscador-popup #edit-title").val("");
              if (block_help.find(".frecuentes").hasClass("is-hidden")) {
                block_help.find(".frecuentes").removeClass("is-hidden");
              }
              if (
                block_help.find(".form-buscador-popup").hasClass("is-hidden")
              ) {
                block_help
                  .find(".form-buscador-popup")
                  .removeClass("is-hidden");
              }
              if (!block_help.find(".buscador").hasClass("is-hidden")) {
                block_help.find(".buscador").addClass("is-hidden");
              }
              if (
                block_help
                  .find(".component__view--categorias-documentos")
                  .hasClass("is-hidden")
              ) {
                block_help
                  .find(".component__view--categorias-documentos")
                  .removeClass("is-hidden");
              }

              block_help.find("#edit-submit-faqs").on("click", function (e) {
                e.preventDefault();

                if (
                  !block_help.find(".buscadoriew-filters").hasClass("is-hidden")
                ) {
                  block_help
                    .find(".buscador .view-filters")
                    .addClass("is-hidden");
                }

                let keywords = block_help.find("#edit-title").val(),
                  href =
                    drupalSettings.path.baseUrl +
                    "zona-de-cliente/preguntas-frecuentes?title=",
                  href_ver_mas = href + keywords;

                $.ajax({
                  url:
                    drupalSettings.path.baseUrl +
                    "views/ajax?_wrapper_format=drupal_ajax",
                  type: "POST",
                  dataType: "json",
                  data:
                    "view_name=faqs&view_display_id=block_4&title=" + keywords,
                  success: function (response) {
                    block_help.find(".buscador").html(response[3].data);
                  },
                }).done(function () {
                  block_help
                    .find(
                      ".buscador .view-faqs .view-filters .views-exposed-form"
                    )
                    .remove();
                });

                block_help
                  .find(".view-footer a.button")
                  .attr("href", href_ver_mas);
                block_help
                  .find(".buscador .view-filters #edit-title")
                  .val(keywords);
                block_help
                  .find(".buscador .view-filters #edit-submit-faqs")
                  .click();

                if (!block_help.find(".frecuentes").hasClass("is-hidden")) {
                  block_help.find(".frecuentes").addClass("is-hidden");
                }

                if (
                  !block_help
                    .find(".component__view--categorias-documentos")
                    .hasClass("is-hidden")
                ) {
                  block_help
                    .find(".component__view--categorias-documentos")
                    .addClass("is-hidden");
                }

                if (block_help.find(".buscador").hasClass("is-hidden")) {
                  block_help.find(".buscador").removeClass("is-hidden");
                }

                if (
                  $(".form-buscador-popup .title-buscador-faqs-popup").hasClass(
                    "is-hidden"
                  )
                ) {
                  $(
                    ".form-buscador-popup .title-buscador-faqs-popup"
                  ).removeClass("is-hidden");
                }

                $(document).ajaxStop(function () {
                  block_help
                    .find(".view-footer a.button")
                    .attr("href", href_ver_mas);
                });
              });

              break;
          }
        });

      // Get all cities
      $.getJSON("/cities-autocomplete/0/all", function (data) {
        $.each(data, function (key, val) {
          $("#filters-payment #edit-name").append(
            $("<option>", {
              value: val.label,
              text: val.label,
            })
          );
        });
      });
    },
  };
})(jQuery, Drupal, this, this.document);
