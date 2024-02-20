/**
 * @file
 * Suscriptor file.
 */

(function ($, Drupal) {
  "use strict";
  Drupal.behaviors.lib_rm = {
    attach: function (context) {
      // Init functions
      let form = $("form#search-medical-network-form .wrapper-form-search"),
        args = null;

      // Default values specilities
      let val_h_city = form.find(".h-city-rm").val(),
        val_plan_type = form.find('input[name="plan_type"]:checked').val(),
        val_h_speciality = form.find(".h-specialty-rm").val(),
        btn_form_submit = form.find(".form-submit");

      if (
        val_h_city.length > 0 &&
        val_plan_type.length > 0 &&
        val_h_speciality.length > 0
      ) {
        specialty_select(val_plan_type, val_h_city, val_h_speciality);
      }

      function sizeBackground() {
        if ($("body").hasClass("js-mobile")) {
          setTimeout(function () {
            if (
              !$("#search-medical-network-form .wrapper-form-search").hasClass(
                "is-fixed"
              )
            ) {
              $("#search-medical-network-form .wrapper-form-search").css(
                "height",
                "101%"
              );
            }
          }, 10);

          if (Math.abs(screen.height - $(window).height()) > 100) {
            $("#search-medical-network-form .wrapper-form-search").css(
              "height",
              "101%"
            );
          } else {
            $("#search-medical-network-form .wrapper-form-search").css(
              "height",
              "100vh"
            );
          }
        }
      }
      $(window).resize(sizeBackground);
      sizeBackground();

      $("#edit-plan-type input[name='plan_type']")
        .change(function () {
          $("#search-medical-network-form .city-rm").removeAttr("disabled");
          if ($("body").hasClass("js-mobile")) {
            $(
              "#search-medical-network-form .wrapper-form-search #edit-plan-type .form-item"
            ).addClass("is-desktop");
            $(this).parent().removeClass("is-desktop");
            $("#search-medical-network-form")
              .find("#gp_form, .ctn-footer")
              .each(function () {
                $(this).removeClass("is-hidden");
              });
            if (
              $("#search-medical-network-form").find(".close-filter").length ===
              0
            ) {
              $(
                "#search-medical-network-form .wrapper-form-search #edit-plan-type"
              ).prepend('<a  class="close-filter" cdata="show">Atrás</a>');
            }
            let pt = findGetParameter("pt");
            if (pt == null) {
              $(
                "#search-medical-network-form .wrapper-form-search .close-filter"
              ).addClass("primera-vez");
            }
            $(
              "#search-medical-network-form .wrapper-form-search .close-filter"
            ).click(function (event) {
              event.preventDefault();
              if ($(this).hasClass("primera-vez")) {
                $(
                  "#search-medical-network-form .wrapper-form-search #edit-plan-type .form-item"
                ).removeClass("is-desktop");
                $(
                  "#search-medical-network-form .wrapper-form-search .close-filter"
                ).remove();
                $(
                  "#search-medical-network-form .wrapper-form-search #gp_form"
                ).addClass("is-desktop");
                $(
                  "#search-medical-network-form .wrapper-form-search .ctn-footer"
                ).addClass("is-desktop");
                $(
                  "#search-medical-network-form .wrapper-form-search"
                ).removeClass("is-fixed transform-media transform-up");
              } else {
                let action = $(this).attr("cdata");
                if (action == "show") {
                  $(
                    "#search-medical-network-form .wrapper-form-search"
                  ).removeClass("transform-up");
                  $(
                    "#search-medical-network-form .wrapper-form-search"
                  ).addClass("transform-media");
                  $(this).text("Ocultar filtros");
                  $(this).attr("cdata", "hide");
                  $(
                    "#search-medical-network-form .wrapper-form-search .content-fields-rm"
                  ).show();
                  $(
                    "#search-medical-network-form .wrapper-form-search .ctn-footer"
                  ).show();
                }

                if (action == "hide") {
                  $(
                    "#search-medical-network-form .wrapper-form-search"
                  ).addClass("transform-up");
                  $(
                    "#search-medical-network-form .wrapper-form-search"
                  ).removeClass("transform-media");
                  $(this).text("Mostrar filtros");
                  $(this).attr("cdata", "show");
                  $(
                    "#search-medical-network-form .wrapper-form-search .content-fields-rm"
                  ).hide();
                  $(
                    "#search-medical-network-form .wrapper-form-search .content-fields-rm"
                  ).hide();
                  $(
                    "#search-medical-network-form .wrapper-form-search .ctn-footer"
                  ).hide();
                }
              }
            });

            $(
              "#search-medical-network-form .wrapper-form-search #gp_form"
            ).removeClass("is-desktop");
            $(
              "#search-medical-network-form .wrapper-form-search .ctn-footer"
            ).removeClass("is-desktop");
            $("#search-medical-network-form .wrapper-form-search").addClass(
              "is-fixed transform-media"
            );
            $("#search-medical-network-form .wrapper-form-search").removeClass(
              "transform-up"
            );
          }
        })
        .click(function () {
          let tipopl = $(this).val();
          if (tipopl.length > 0) {
            $(this).trigger("change");
          }
        });

      // Get geolocation
      if (navigator.geolocation) {
        let lat, lng;
        if (typeof Storage !== undefined) {
          if (localStorage.getItem("long") !== null) {
            lng = localStorage.getItem("long");
            lat = localStorage.getItem("lat");
          }
        }
        let data_browser = $("html").attr("data-browser");
        const reg_browser = new RegExp("Trident");

        // Explorer internet
        if (reg_browser.test(data_browser)) {
          let options = {
            enableHighAccuracy: false,
          };

          navigator.geolocation.getCurrentPosition(
            addAttrPositionFields,
            function (err) {
              $(".ctn-footer").insertBefore(
                '<p class="geolocation-not-support">Este navegador no soporta Geolocalizaci\xF3n</p>'
              );
              return false;
            },
            options
          );

          if (lat === null && lng === null) {
            lat = findGetParameter("lat");
            lng = findGetParameter("lng");
          }
          if ($.isNumeric(lat) && $.isNumeric(lng)) {
            form.find(".h-lat").attr("data-lat", lat);
            form.find(".h-long").attr("data-long", lng);
          }
        }
        // Others
        else {
          navigator.geolocation.getCurrentPosition(addAttrPositionFields);
        }
      } else {
        $(".ctn-footer").insertBefore(
          '<p class="geolocation-not-support">Este navegador no soporta Geolocalizaci\xF3n</p>'
        );
      }

      $(".city-rm")
        .on("focus", function () {
          $(this).val("");
          $(".speciality-rm-sr, .search-word-rm").val("");
        })
        .on("keyup", function () {
          citiesAutocomplete();
        });

      $(".speciality-rm-sr")
        .on("focus", function () {
          $(this).val("");
        })
        .on("keyup", function () {
          speciality_autocomplete();
        });

      add_value_hidden_of_select_specialties();
      execute_wordAutocomplete();

      // Check attribute disable submit button
      btn_form_submit.attr("disabled", "disabled");
      if (btn_form_submit.hasClass("vals-dflt")) {
        btn_form_submit.removeAttr("disabled");
      }

      // Check fields in submit
      $('input[name="around_me"]').click(function (e) {
        let wrapper = $(this).parents(".wrapper-form-search");
        assignPositionFields(wrapper);
      });

      // Filters used
      // if ($('ul.special-filters .item-filter').length > 0) {
      //    $('ul.special-filters .item-filter .link-filter').on('click', function(e){
      // 		e.preventDefault();
      // 		let current_url = window.location.href,
      // 		  url = current_url.substring(0, current_url.length - 1),
      // 		  removeKey = $(this).attr('cdata'),
      // 		  new_url = removeParamUrl(removeKey, url);
      // 		if (removeKey == 'c') {
      // 			new_url = removeParamUrl('e', new_url);
      // 		}
      // 		if (new_url.length > 0) {
      // 			window.location.replace(new_url);
      // 		}
      // 	})
      // }
      //

      // Click view mode results
      if (
        $(".block-render-view-search-medical-network .view-search-rm").length >
        0
      ) {
        let form_view = $(
          ".block-render-view-search-medical-network .view-search-rm"
        );
        let vm = findGetParameter("vm");
        form_view
          .children(".view-header")
          .find(".options-results-rm li." + vm)
          .addClass("active");
        form_view
          .children(".view-header")
          .find(".options-results-rm li.vm a")
          .click(function (e) {
            e.preventDefault();
            let form = $(this)
              .parents(".component__view--render-search-map")
              .prev()
              .find(".wrapper-form-search");
            form.find(".h-view_mode_results").val($(this).attr("cdata-type"));
            assignPositionFields(form);
            form.find(".form-submit").click();
          });
      }

      // Uncheck and hide on mobile
      if ($("body").hasClass("js-mobile")) {
        let search_form = $("#search-medical-network-form");
        search_form.find(".form-radio:checked").removeAttr("checked");
        //search_form.find('.js-form-wrapper, .ctn-footer').hide();
        search_form.find(".form-radio").on("change", function () {
          search_form.find(".js-form-wrapper, .ctn-footer").show();
        });
        let pt = findGetParameter("pt");
        if (pt !== null) {
          $("#component-371").before('<div id="ancla-resultados"></div>');
          $(
            "#search-medical-network-form .wrapper-form-search #edit-plan-type .form-item"
          ).addClass("is-desktop");
          if (
            $("#search-medical-network-form").find(".close-filter").length === 0
          ) {
            $(
              "#search-medical-network-form .wrapper-form-search #edit-plan-type"
            ).prepend(
              '<a  class="close-filter" cdata="show">Mostrar filtros</a>'
            );
          }
          $(
            "#search-medical-network-form .wrapper-form-search .close-filter"
          ).click(function (event) {
            event.preventDefault();
            if ($(this).hasClass("primera-vez")) {
              $(
                "#search-medical-network-form .wrapper-form-search .close-filter"
              ).remove();
              $(
                "#search-medical-network-form .wrapper-form-search #edit-plan-type .form-item"
              ).removeClass("is-desktop");
              $(
                "#search-medical-network-form .wrapper-form-search #gp_form"
              ).addClass("is-desktop");
              $(
                "#search-medical-network-form .wrapper-form-search .ctn-footer"
              ).addClass("is-desktop");
              $(
                "#search-medical-network-form .wrapper-form-search"
              ).removeClass("is-fixed transform-media transform-up");
            } else {
              let action = $(this).attr("cdata");
              if (action == "show") {
                $(this).text("Ocultar filtros");
                $(this).attr("cdata", "hide");
                $(
                  "#search-medical-network-form .wrapper-form-search #gp_form"
                ).removeClass("is-desktop");
                $(
                  "#search-medical-network-form .wrapper-form-search .ctn-footer"
                ).removeClass("is-desktop");
                $("#search-medical-network-form .wrapper-form-search").addClass(
                  "transform-media"
                );
                $(
                  "#search-medical-network-form .wrapper-form-search"
                ).removeClass("transform-up");
              }
              if (action == "hide") {
                $(this).text("Mostrar filtros");
                $(this).attr("cdata", "show");
                $(
                  "#search-medical-network-form .wrapper-form-search #gp_form"
                ).addClass("is-desktop");
                $(
                  "#search-medical-network-form .wrapper-form-search .ctn-footer"
                ).addClass("is-desktop");
                $(
                  "#search-medical-network-form .wrapper-form-search"
                ).removeClass("transform-media");
                $("#search-medical-network-form .wrapper-form-search").addClass(
                  "transform-up"
                );
              }
            }
          });
          $("#search-medical-network-form .wrapper-form-search").addClass(
            "is-fixed transform-up"
          );
          $("#block-renderviewsearchmedicalnetwork").append(
            '<div class="actions--footer"><a  href="/zona-cliente/red-medica#block-searchmedicalnetwork" class="button button--primary" id="nueva-busqueda">Nueva busqueda</a><a  href="/zona-cliente/red-medica#block-searchmedicalnetwork" id="cancelar">Cancelar</a><div>'
          );
          window.scrollTo(0, $("#special-filters").offset().top - 230);
          search_form.find("#is_mobile").val(1);
        }
      }

      if (findGetParameter("c") > 0) {
        form.find(".city-rm").parent("div").addClass("form__input--activo");
      }
      if (findGetParameter("e") > 0) {
        form
          .find(".speciality-rm-sr")
          .parent("div")
          .addClass("form__input--activo");
      }
      if (findGetParameter("t") !== null && findGetParameter("t") !== "") {
        form
          .find(".search-word-rm")
          .parent("div")
          .addClass("form__input--activo");
      }

      // load specilities if the filter is removed
      if (findGetParameter("c") > 0 && findGetParameter("e") == null) {
        let tid_city = form.find(".h-city-rm").val(),
          tid_plan = form.find(".plan-types:checked").val();
        specialty_select(tid_plan, tid_city);
      }

      // States fields gropus
      $(".plan-types").change(function () {
        if ($(this).hasClass("show-filter")) {
          return true;
        } else {
          let form = $(this).parents(".wrapper-form-search");
          form.find(".city-rm").val("");
          form.find(".speciality-rm-sr").val("");
          form.find(".search-word-rm").val("");
          form.find(".check-around-me").prop("checked", false);
          btn_form_submit.attr("disabled", "disabled");
        }
      });

      function addAttrPositionFields(position) {
        let wrapper = $("#search-medical-network-form"),
          hideen_lat = wrapper.find(".h-lat"),
          hideen_long = wrapper.find(".h-long"),
          long,
          lat;

        if (typeof Storage !== undefined) {
          if (
            localStorage.getItem("long") === null &&
            position.coords.longitude &&
            position.coords.latitude
          ) {
            localStorage.setItem("long", position.coords.longitude);
            localStorage.setItem("lat", position.coords.latitude);
          }
          long = localStorage.getItem("long");
          lat = localStorage.getItem("lat");

          // Update location info
          if (
            lat !== position.coords.latitude ||
            long !== position.coords.longitude
          ) {
            localStorage.setItem("long", position.coords.longitude);
            localStorage.setItem("lat", position.coords.latitude);
          }
        } else {
          long = position.coords.longitude;
          lat = position.coords.latitude;
        }

        if ($.isNumeric(long) && $.isNumeric(lat)) {
          hideen_lat.attr("data-lat", lat);
          hideen_long.attr("data-long", long);
        }
      }

      function assignPositionFields(wrapper) {
        if (wrapper.find(".check-around-me").prop("checked")) {
          wrapper.find(".h-lat").val(wrapper.find(".h-lat").attr("data-lat"));
          wrapper
            .find(".h-long")
            .val(wrapper.find(".h-long").attr("data-long"));
        } else {
          wrapper.find(".h-lat").val("");
          wrapper.find(".h-long").val("");
        }
      }

      // Add value hidden to select specialties
      function add_value_hidden_of_select_specialties() {
        let sl_specialty = form.find(".specialty-rm"),
          h_sl_specialty = form.find(".h-specialty-rm"),
          city_rm = form.find(".city-rm");

        sl_specialty.on("change", function () {
          if ($.isNumeric(sl_specialty.val())) {
            h_sl_specialty.val(sl_specialty.val());
            btn_form_submit.removeAttr("disabled");
          }
        });
        city_rm.focusout(function () {
          if ($.isNumeric(sl_specialty.val())) {
            h_sl_specialty.val(sl_specialty.val());
          }
        });
      }

      // Add autocomplete title
      function execute_word_autocomplete() {
        form
          .find(".search-word-rm")
          .on("focus", function () {
            $(this).val("");
          })
          .on("keyup", function () {
            wordAutocomplete();
          });
      }

      // Dinamical select specialties
      function specialty_select(tid_plan, tid_city, dflt_val) {
        dflt_val = dflt_val || null;
        if (
          tid_plan !== null &&
          tid_plan !== undefined &&
          tid_city !== null &&
          tid_city !== undefined
        ) {
          let url_json =
              "/specialty-select/" + tid_plan + "/" + tid_city + "/" + dflt_val,
            sl_specialty = null;
          $.getJSON(url_json, function (data) {
            sl_specialty = form
              .find(".specialty-rm")
              .empty()
              .removeAttr("disabled");
            $.each(data, function (i, val) {
              sl_specialty.append(new Option(val.label, val.value));
            });
            if (dflt_val !== null) {
              sl_specialty.val(dflt_val);
            }
          });
        }
      }

      // Autocomplete cities
      function citiesAutocomplete() {
        let city = form.find(".city-rm"),
          val_city = city.val(),
          tid_plan = form.find(".plan-types:checked").val(),
          url_json = "/cities-autocomplete/";

        if (tid_plan !== null && tid_plan !== undefined) {
          args = { tid_plan: tid_plan };
          customAutocomplete(city, url_json + tid_plan + "/" + val_city, args);
        }
      }

      // Autocomplete cities
      function speciality_autocomplete() {
        let tid_city = form.find(".h-city-rm").val(),
          tid_plan = form.find(".plan-types:checked").val();

        let speciality = form.find(".speciality-rm-sr"),
          val_speciality = speciality.val(),
          url_json = "/specialty-select/";

        if (
          tid_plan !== null &&
          tid_plan !== undefined &&
          tid_city !== undefined
        ) {
          args = { tid_plan: tid_plan, tid_city: tid_city };
          customAutocomplete(
            speciality,
            url_json + tid_plan + "/" + tid_city + "/" + val_speciality,
            args
          );
        }
      }

      // Search autocomplete
      function wordAutocomplete() {
        let word = form.find(".search-word-rm"),
          word_val = word.val(),
          tid_plan = form.find(".plan-types:checked").val(),
          tid_city = form.find(".h-city-rm").val(),
          tid_specialty = form.find(".h-specialty-rm").val(),
          url_json = "";

        url_json = "/word-autocomplete/" + word_val + "/" + tid_plan;
        if (tid_city !== "") {
          url_json += "/" + tid_city;
        }
        if (tid_specialty !== "") {
          url_json += "/" + tid_specialty;
        }
        customAutocomplete(word, url_json);
      }

      // Single autocomplete to all functions
      function customAutocomplete(element, url, args) {
        element.autocomplete({
          source: function (request, response) {
            $.getJSON(url, function (data) {
              response(
                $.map(data, function (v, k) {
                  return {
                    label: v.label,
                    id: v.value,
                  };
                })
              );
            });
          },
          minLength: 2,
          select: function (event, ui) {
            if (element.hasClass("city-rm")) {
              form.find(".speciality-rm-sr").removeAttr("disabled");
              form.find(".h-city-rm").val(ui.item.id);
            }
            if (element.hasClass("speciality-rm-sr")) {
              form.find(".h-specialty-rm").val(ui.item.id);
              btn_form_submit.removeAttr("disabled");
            }
            if (element.hasClass("search-word-rm")) {
              btn_form_submit.removeAttr("disabled");
            }
            this.value = ui.item.label;
            // return false;
          },
        });
      }

      // Remove param url
      function removeParamUrl(removeKey, sourceURL) {
        let rtn = sourceURL.split("?")[0],
          param,
          params_arr = [],
          queryString =
            sourceURL.indexOf("?") !== -1 ? sourceURL.split("?")[1] : "";
        if (queryString !== "") {
          params_arr = queryString.split("&");
          for (let i = params_arr.length - 1; i >= 0; i -= 1) {
            param = params_arr[i].split("=")[0];
            if (param === removeKey) {
              params_arr.splice(i, 1);
            }
          }
          rtn = rtn + "?" + params_arr.join("&");
        }
        return rtn;
      }

      // Find parameter get in url
      function findGetParameter(parameterName) {
        let result = null,
          tmp = [];
        let items = location.search.substr(1).split("&");
        for (let index = 0; index < items.length; index++) {
          tmp = items[index].split("=");
          if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
        }
        return result;
      }
    },
  };
})(jQuery, Drupal);
