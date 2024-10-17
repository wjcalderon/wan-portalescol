(function ($, Drupal, window, document) {
  "use strict";

  // Example of Drupal behavior loaded.
  Drupal.behaviors.themeJS = {
    attach: function (context, settings) {
      // Set browser as document attribute
      document.documentElement.setAttribute(
        "data-browser",
        window.navigator.userAgent
      );

      // Check window width and add class to body on mobile
      let checkWindowWidth = function () {
        let windowWidth = $(window).width();
        if (windowWidth <= 978) {
          $("body").addClass("js-mobile");
        } else {
          $("body").removeClass("js-mobile");
        }
      };

      checkWindowWidth();
      $(window).resize(checkWindowWidth);

      $(document).ajaxStop(function () {
        checkWindowWidth();
      });

      //AddtoAny social networks
      $(".addtoany_list").insertAfter(".component__banner.cp-banner");

      // external links open in new window.
      $(".link__external").attr("target", "_blank");

      $(".link__anchor").on("click", function (e) {
        e.preventDefault();
        let strAncla = $(this).attr("href"); //id del ancla

        $("html, body")
          .stop(true, true)
          .animate(
            {
              scrollTop: $(strAncla).offset().top,
            },
            1000
          );
      });

      // Search box
      $('#nav__secundario')
        .on('click', '#buscador', function () {
          $('#nav__secundario').addClass('is-hidden')
          $(this).addClass('buscador__input--activo')
        })
        .on("blur, focusout", "#edit-keywords", function () {
          if ($(this).val() === undefined || $(this).val() === '') {
            $(this).removeClass('buscador__input--activo')
            $('#nav__secundario')
              .show(205)
              .removeClass('is-hidden')
          }
        })

      $("#buscador__close").click(function () {
        $("#navegacion").removeClass("is-visible");
      });

      let urlParam = function (name) {
        let results = new RegExp("[?&]" + name + "=([^&#]*)").exec(
          window.location.href
        );
        if (results == null) {
          return null;
        }
        return decodeURI(results[1]) || 0;
      };

      if (
        $(".alias--zona-de-cliente-condicionados-y-documentos").length > 0 ||
        $(".alias--zona-de-cliente-preguntas-frecuentes").length > 0
      ) {
        let bread = $(".breadcrumb ol li").last().text(),
          flag_is_landing = true,
          categoria = "",
          frecuentes = "",
          buscador = "";
        if (
          $("body").hasClass(
            "alias--zona-de-cliente-condicionados-y-documentos"
          )
        ) {
          categoria = ".documentos-por-categoria";
          buscador = ".buscador-documentos";
          frecuentes = ".documentos-frecuentes";
          if ($(".img-no-results").length > 1) {
            $(".viewsreference--view-title").css("display", "none");
          }
        }
        if ($("body").hasClass("alias--zona-de-cliente-preguntas-frecuentes")) {
          categoria = ".resultados-categoria";
          buscador = ".buscador-landing";
          frecuentes = ".items-frecuentes";
        }

        $(".breadcrumb ol li")
          .last()
          .html(
            '<a  href="' + window.location.pathname + '">' + bread + "</a>"
          );

        if (urlParam("category") !== null) {
          $(categoria).removeClass("is-hidden");
          flag_is_landing = false;
        }
        if (urlParam("title") !== null) {
          $(buscador).removeClass("is-hidden");
          flag_is_landing = false;
        }
        if (flag_is_landing) {
          $(".component__view--categorias-documentos").removeClass("is-hidden");
          $(frecuentes).removeClass("is-hidden");
        }
      }

      // FAQ's show question block
      $(".view-display-id-faqs_categories_block").on(
        "click",
        ".views-field-field-cta a",
        function (event) {
          event.preventDefault();
          let el = $(this),
            parent_row = el.parents(".views-row"),
            questions = parent_row.find(".preguntas"),
            heiRow = parent_row.height();

          if (questions.hasClass("is-hidden")) {
            $(".preguntas").addClass("is-hidden");
            questions.removeClass("is-hidden");
            let hei = questions.height();
            if ($("body").hasClass("js-mobile")) {
              questions.css("bottom", hei + "px");
              parent_row.css("height", parseInt(hei + heiRow + 30));
            }
          } else {
            questions.addClass("is-hidden");
            if ($("body").hasClass("js-mobile")) {
              parent_row.css("height", "auto");
            }
          }
        }
      );

      function initMap(lati, lngi, counter) {
        let centerLati = lati,
          image = {
            url: "",
            scaledSize: new google.maps.Size(60, 60),
          },
          numCounter = " ";

        if (counter !== undefined) {
          numCounter = counter;
        }

        if ($("body").hasClass("alias--oficinas")) {
          image.url =
            "/themes/custom/liberty_public/images/icons/icon-oficina.svg";
        } else {
          image.url =
            "/themes/custom/liberty_public/images/icons/pin-map-red.svg";
        }
        centerLati += 0.002;
        if ($("body").hasClass("alias--nuestras-oficinas")) {
          centerLati += 0.003;
        }
        let map = new google.maps.Map(document.getElementById("map"), {
          zoom: 16,
          center: { lat: centerLati, lng: lngi },
        });

        let beachMarker = new google.maps.Marker({
          position: { lat: lati, lng: lngi },
          optimized: false,
          map: map,
          icon: image,
          label: {
            text: numCounter,
            color: "#ffffff",
          },
        });
      }

      $(".verMapa").on("click", function () {
        let el = $(this),
          lati = el.attr("lat"),
          longi = el.attr("lng"),
          direc = el.attr("dir"),
          title = el.attr("title"),
          counter = el.attr("counter"),
          tel = el.attr("telephone"),
          schedule = el.children("i").html();

        $(".wrapper__map").removeClass("is-hidden");
        initMap(parseFloat(lati), parseFloat(longi), counter);
        if (el.hasClass("mapaSucursal")) {
          $("#infomap").html(
            "<div class='content__infomap'>" +
              '<div class="tooltip"><span class="tooltiptext">' +
              counter +
              "</span></div>" +
              '<span class="close"></span><h2>' +
              title +
              "</h2>" +
              '<div class="info">\n' +
              '<div class="info-right">\n' +
              '  <p class="red__direccion"><span>' +
              direc +
              "</span></p>\n" +
              '  <p class="red__telefonos"><span class="name-element-office">Tel\xE9fonos</span>' +
              tel +
              "</p>\n" +
              '  <p class="horarios"> \n' +
              '<span style="\n' +
              "    display: block;\n" +
              '">Horario de atenci\xF3n</span>\n' +
              "" +
              schedule +
              "\n" +
              "</p>\n" +
              "</div>\n" +
              "</div>"
          );
        } else {
          if (el.hasClass("payment_points")) {
            $("#infomap").html(
              "<div class='content__infomap'>" +
                '<span class="close"></span>' +
                "<h2>" +
                title +
                "</h2>" +
                '<div class="info">' +
                '<div class="red__direccion">' +
                '<p class="info-right">' +
                direc +
                "</p>" +
                "</div>" +
                '<p class="red__telefonos">' +
                tel +
                "</p>" +
                "</div></div></div>"
            );
          } else {
            $("#infomap").html(
              "<div class='content__infomap'>" +
                '<span class="close"></span>' +
                "<h2>" +
                title +
                "</h2>" +
                "<p>" +
                direc +
                "</p>" +
                "</div>"
            );
          }
        }
      });

      $(".verInfo").click(function () {
        let el = $(this);
        if (el.parent().hasClass("views-row")) {
          let wrapper = el.parent();
          wrapper.find(".popup-info").addClass("is-fixed-global");
        } else {
          let wrapper = el.parent().parent();
          wrapper.addClass("is-fixed-global");
        }
        wrapper.find(".info p").each(function () {
          let el = $(this);
          if (el.hasClass("is-desktop")) {
            el.removeClass("is-desktop");
            el.addClass("is-mobile");
          }
        });
      });

      $(".arrowBack").click(function () {
        let el = $(this);
        if (el.parent().hasClass("popup-info")) {
          let wrapper = el.parent();
        }

        wrapper
          .removeClass("is-fixed-global")
          .find(".info p")
          .each(function () {
            let el = $(this);
            if (el.hasClass("is-mobile")) {
              el.removeClass("is-mobile");
              el.addClass("is-desktop");
            }
          });
      });

      $(".info .header__info #close").click(function () {
        $(this).parent().parent().removeClass("is-active");
      });

      $(".wrapper__map").on("click", ".close, #close", function () {
        $(".wrapper__map").addClass("is-hidden");
      });
      $(".options-accordion .option .views-field-nothing").hover(
        function () {
          $(this)
            .siblings(
              ".options-accordion .option .views-field-description__value"
            )
            .addClass("open");
          $(this)
            .parent(".option")
            .parent(".options-accordion")
            .css("overflow", "initial");
        },
        function () {
          $(
            ".options-accordion .option .views-field-description__value"
          ).removeClass("open");
          $(".js-accordion-options").css("overflow", "hidden");
        }
      );
      //Ajustes

      function clickSection(button) {
        $(".component__form--red-medica .component__content").removeAttr(
          "href"
        );
        $(button).on("click", function (event) {
          // console.log('sip');
        });
        // $(button).on('click', function(event) {
        //     let target = $(this.getAttribute('href'));
        //     if (target.length) {
        //         event.preventDefault();
        //         $('.component__form--red-medica .component__content').stop().animate({
        //             scrollTop: target.offset().top
        //         }, 1000);
        //     }
        // });
      }
      clickSection(".component__form--red-medica .component__content");

      // workshops filter
      $(
        ".alias--siniestros-talleres-preferenciales .view-talleres .form-select"
      ).on("change", function () {
        $(
          ".alias--siniestros-talleres-preferenciales .view-talleres .js-form-submit"
        ).click();
      });

      $(".text_file_error_input").change(function () {
        let filename = $("input[type=file]").val().split("\\").pop();
        const myArr = filename.split(".").pop();

        if (
          myArr != "pdf" &&
          myArr != "gif" &&
          myArr != "jpg" &&
          myArr != "png" &&
          myArr != "txt" &&
          myArr != "doc" &&
          myArr != "docx" &&
          myArr != "ppt" &&
          myArr != "pptx" &&
          myArr != "xls" &&
          myArr != "xls" &&
          myArr != "zip"
        ) {
          $(".text_file_error").css("display", "block");
        } else {
          $(".text_file_error").css("display", "none");
        }
      });
      $(".text_file_error_input_2").change(function () {
        let inputfile = $(".text_file_error_input_2").find(
          'input[name="files[adjuntar_archivos]"]'
        );
        inputfile = inputfile.val().split("\\").pop();
        inputfile = inputfile.split(".").pop();
        console.log(inputfile);
        if (inputfile != "pdf") {
          $(".text_file_error2").css("display", "block");
        } else {
          $(".text_file_error2").css("display", "none");
        }
      });
      if ($(".form-item-adjuntar-archivos")) {
        let label_adjuntar = $(this).find("label").html();
        label_adjuntar = label_adjuntar + "<br>";
      }
    },
  };
})(jQuery, Drupal, this, this.document);
