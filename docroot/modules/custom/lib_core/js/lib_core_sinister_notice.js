(function ($) {
  Drupal.behaviors.sinister_notice = {
    attach: function (context, settings) {
      let $ctn_tabs = $(".component__tabs--sinister-notice .cp-tabs");
      let windowMobile = $("body").hasClass("js-mobile");
      $ctn_tabs.children(".tabs").addClass("is-hidden");
      $ctn_tabs
        .find(".header-tabs")
        .find("li .cta a")
        .on("click", context, function () {
          let id_tab = $(this).attr("href");
          $ctn_tabs
            .children(".tabs")
            .addClass("is-hidden")
            .removeClass("active");
          $ctn_tabs.find(id_tab).removeClass("is-hidden").addClass("active");

          $ctn_tabs.find(".header-tabs").addClass("is-hidden");
          if (windowMobile) {
            $(".component__tabs--sinister-notice .component__heading").addClass(
              "is-hidden"
            );
          }
          let type_form = $ctn_tabs
            .find(".tabs.active")
            .find(".form-ctn-notif-sinister")
            .attr("cdtype-form");
          let $ctn_form = $ctn_tabs.find(".tabs.active").find("form");
          copy_page_info_fields_groups($ctn_form, type_form);

          states_fields($ctn_form);

          $ctn_form
            .find(".cities-sinisters-notices")
            .attr("autocomplete", "off");
          $ctn_form
            .find(".brands-vehicles-sinister")
            .attr("autocomplete", "off");
        });

      $(".close").on("click", context, function () {
        $ctn_tabs.children(".tabs").addClass("is-hidden").removeClass("active");
        $(".component__tabs--sinister-notice .main-links").removeClass(
          "is-hidden"
        );
      });

      if ($(".ctn-msg-notif-sinister").length > 0) {
        $(".component__tabs--sinister-notice").addClass("is-hidden");
        $ctn_tabs.find(".header-tabs").removeClass("is-hidden");
      }

      $(
        "#sinister-notific-insured-form #date-field-insured," +
          "#sinister-notific-third-affectt-form #date-field-third"
      ).datetimepicker({
        timeFormat: "h:mm tt",
        closeText: "Cerrar",
        currentText: "Actual",
        dateFormat: "dd/mm/yy",
        timeText: "Hora",
        monthNames: [
          "Enero",
          "Febrero",
          "Marzo",
          "Abril",
          "Mayo",
          "Junio",
          "Julio",
          "Agosto",
          "Septiembre",
          "Octubre",
          "Noviembre",
          "Diciembre",
        ],
        monthNamesShort: [
          "Ene",
          "Feb",
          "Mar",
          "Abr",
          "May",
          "Jun",
          "Jul",
          "Ago",
          "Sep",
          "Oct",
          "Nov",
          "Dic",
        ],
        dayNames: [
          "Domingo",
          "Lunes",
          "Martes",
          "Miércoles",
          "Jueves",
          "Viernes",
          "Sábado",
        ],
        dayNamesShort: ["Dom", "Lun", "Mar", "Mié", "Juv", "Vie", "Sáb"],
        dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sá"],
        maxDate: "0",
      });

      jQuery.validator.addMethod(
        "lettersonly",
        function (value, element) {
          return (
            this.optional(element) || /^[a-zA-Z\u00C0-\u00FF\s]+$/i.test(value)
          );
        },
        "Solo letras y espacios"
      );

      jQuery.validator.addMethod(
        "alphanumeric",
        function (value, element) {
          return this.optional(element) || /^[0-9a-zA-Z#\s\-]+$/i.test(value);
        },
        "El campo solo debe contener números, letras o los caracteres (#, -)"
      );

      if ($("#sinister-notific-insured-form").length > 0) {
        let $form_insure = $("#sinister-notific-insured-form");
        let validate_rules = {
          "00N4A00000FkWpu": {
            required: true,
          },
          brand_insure: {
            required: true,
          },
          "00N4A00000FkWpk": {
            required: true,
          },
          "00N4A00000FkWpp": {
            required: true,
          },
          ins_veh_info_city: {
            required: true,
          },
          "00NG000000998UR": {
            required: true,
            maxlength: 6,
            minlength: 5,
          },
          "00N4A00000FgLGC": {
            required: true,
          },
          "00N4A00000FkWqE": {
            required: true,
            minlength: 5,
          },
          "00N4A00000FkWq9": {
            required: true,
            lettersonly: true,
          },
          "00N4A00000FkWqO": {
            required: true,
            number: true,
            minlength: 10,
            maxlength: 10,
          },
          "00N4A00000FkWqT": {
            required: true,
            isValidEmailAddress: true,
          },
          "00N4A00000FkWqY": {
            required: true,
          },
          "00NG000000FWyoW": {
            required: true,
          },
          "00NG000000FWyoI": {
            required: true,
            minlength: 5,
          },
          "00NG000000998UJ": {
            required: true,
            lettersonly: true,
          },
          "00N4A00000FkhdH": {
            required: true,
            number: true,
            minlength: 10,
            maxlength: 10,
          },
          "00N4A00000FkhdC": {
            required: true,
            isValidEmailAddress: true,
          },
          "00N4A00000FgLG8": {
            required: true,
            minlength: 6,
          },

          "00N4A00000FgLGD": {
            required: true,
          },
          "00N4A00000FkWqi": {
            required: true,
            minlength: 5,
          },
          "00N4A00000FkWqd": {
            required: true,
            lettersonly: true,
          },
          "00N4A00000FkWqs": {
            required: true,
            number: true,
            minlength: 10,
            maxlength: 10,
          },
          "00N4A00000FkWqn": {
            number: true,
            minlength: 7,
            maxlength: 10,
          },
          "00N4A00000FkWqJ": {
            number: true,
            minlength: 7,
            maxlength: 10,
          },
          "00N4A00000FkWqx": {
            required: true,
            isValidEmailAddress: true,
          },
          "00N4A00000FkWr2": {
            required: true,
          },
          "00N4A00000FkWr7": {
            required: true,
            minlength: 100,
            maxlength: 255,
          },
          "00N4A00000FkWrC": {
            required: true,
            alphanumeric: true,
          },
          "00N4A00000FkWrl": {
            required: true,
          },
          "00N4A00000Fkhd2": {
            required: true,
          },
          "00N4A00000FkWrW": {
            required: true,
          },
          "00N4A00000FkWrg": {
            required: true,
          },
          "00N7j0000026tc9": {
            required: true,
          },
          "00N4A00000Fkhd7": {
            required: true,
          },
          "00N4A00000FkjTs": {
            required: true,
          },
        };

        let validate_messages = {
          "00N4A00000FkhWk": {
            required: "Este campo es requerido",
          },
          "00NG000000FWynf": {
            required: "Este campo es requerido",
          },
          "00N4A00000FkWpu": {
            required: "Este campo es requerido",
          },
          brand_insure: {
            required: "Este campo es requerido",
          },
          "00N4A00000FkWpk": {
            required: "Este campo es requerido",
          },
          "00N4A00000FkWpp": {
            required: "Este campo es requerido",
          },
          ins_veh_info_city: {
            required: "Este campo es requerido",
          },
          "00NG000000998UR": {
            required: "Este campo es requerido",
            maxlength: "La placa no puede ser superior a 6 caracteres",
            minlength: "La placa no puede ser superior a 5 caracteres",
          },
          "00N4A00000FgLGC": {
            required: "Este campo es requerido",
          },
          "00N4A00000FkWqE": {
            required: "Este campo es requerido",
            number: "Debe ingresar solo números",
            minlength: "Mínimo 5 digitos",
          },
          "00N4A00000FkWq9": {
            required: "Este campo es requerido",
            lettersonly: "Solo esta permitido el ingreso de letras",
          },
          "00N4A00000FkWqO": {
            required: "Este campo es requerido",
            number: "Debe ingresar solo números",
            minlength: "Mínimo 10 digitos",
            maxlength: "Máximo 10 digitos",
          },
          "00N4A00000FkWqT": {
            required: "Este campo es requerido",
            isValidEmailAddress: "Correo electrónico no valido",
          },
          "00N4A00000FkWqY": {
            required: "Este campo es requerido",
          },
          "00NG000000FWyoW": {
            required: "Este campo es requerido",
          },
          "00NG000000FWyoI": {
            required: "Este campo es requerido",
            minlength: "Mínimo 5 digitos",
          },
          "00NG000000998UJ": {
            required: "Este campo es requerido",
            lettersonly: "Solo esta permitido el ingreso de letras",
          },
          "00N4A00000FkhdH": {
            required: "Este campo es requerido",
            number: "Debe ingresar solo números",
            minlength: "Mínimo 10 digitos",
            maxlength: "Máximo 10 digitos",
          },
          "00N4A00000FkhdC": {
            required: "Este campo es requerido",
            isValidEmailAddress: "Correo electrónico no valido",
          },

          "00N4A00000FgLGD": {
            required: "Este campo es requerido",
          },
          "00N4A00000FkWqi": {
            required: "Este campo es requerido",
            number: "Debe ingresar solo números",
            minlength: "Mínimo 5 digitos",
          },
          "00N4A00000FkWqd": {
            required: "Este campo es requerido",
            lettersonly: "Solo esta permitido el ingreso de letras",
          },
          "00N4A00000FkWqs": {
            required: "Este campo es requerido",
            number: "Debe ingresar solo números",
            minlength: "Mínimo 10 digitos",
            maxlength: "Máximo 10 digitos",
          },
          "00N4A00000FkWqn": {
            number: "Debe ingresar solo números",
            minlength: "Mínimo 7 digitos",
            maxlength: "Máximo 10 digitos",
          },
          "00N4A00000FkWqJ": {
            number: "Debe ingresar solo números",
            minlength: "Mínimo 7 digitos",
            maxlength: "Máximo 10 digitos",
          },
          "00N4A00000FkWqx": {
            required: "Este campo es requerido",
            isValidEmailAddress: "Correo electrónico no valido",
          },
          "00N4A00000FkWr2": {
            required: "Este campo es requerido",
          },
          "00N4A00000FgLG8": {
            required: "Este campo es requerido",
            minlength: "Mínimo 6 caracteres",
          },
          "00N4A00000FkWr7": {
            required: "Este campo es requerido",
            minlength: "La descripción debe tener al menos 100 caracteres.",
            maxlength: "La descripción no puede exceder los 255 caracteres.",
          },
          "00N4A00000FkWrC": {
            required: "Este campo es requerido",
            alphanumeric:
              "El campo solo debe contener números, letras o los caracteres (#, -)",
          },
          "00N4A00000FkWrl": {
            required: "Este campo es requerido",
          },
          "00N4A00000Fkhd2": {
            required: "Este campo es requerido",
          },
          "00N4A00000FkWrW": {
            required: "Este campo es requerido",
          },
          "00N4A00000FkWrg": {
            required: "Este campo es requerido",
          },
          "00N7j0000026tc9": {
            required: "Este campo es requerido",
          },
          "00N4A00000Fkhd7": {
            required: "Este campo es requerido",
          },
          "00N4A00000FkjTs": {
            required: "Este campo es requerido",
          },
        };

        $form_insure.validate({
          rules: validate_rules,
          messages: validate_messages,
        });

        $(
          "#sinister-notific-insured-form .header-steps.three-elements"
        ).addClass("active");
        $("#sinister-notific-insured-form #00N4A00000FkWpu").change(
          function () {
            if (
              $(this).val() ==
              "Daños en el vehículo a causa de un accidente o evento súbito e imprevisto."
            ) {
              $("#sinister-notific-insured-form .header-steps.three-elements")
                .addClass("active")
                .removeClass("is-hidden");
              $("#sinister-notific-insured-form .header-steps.two-elements")
                .removeClass("active")
                .addClass("is-hidden");
            } else {
              $("#sinister-notific-insured-form .header-steps.two-elements")
                .addClass("active")
                .removeClass("is-hidden");
              $("#sinister-notific-insured-form .header-steps.three-elements")
                .removeClass("active")
                .addClass("is-hidden");
            }
          }
        );

        $("#sinister-notific-insured-form .btn-submit-step", context).click(
          function (e) {
            e.preventDefault();
            let step = $form_insure.find(".steps.active").attr("step");
            let val_type_report = $(
              "#sinister-notific-insured-form #00N4A00000FkWpu"
            ).val();
            let cdtype = $(this).attr("cdtype");
            let new_step;
            if (cdtype == "back") {
              new_step = parseInt(step) - 1;
            } else if (cdtype == "next") {
              new_step = parseInt(step) + 1;
            }

            $form_insure.find(".btn-back").addClass("is-hidden");
            if (new_step > 1) {
              if (cdtype == "next" && new_step == 2) {
                if ($form_insure.valid()) {
                  $form_insure.find(".btn-back").removeClass("is-hidden");
                }
              } else {
                $form_insure.find(".btn-back").removeClass("is-hidden");
              }
            }

            if (cdtype == "next") {
              if ($form_insure.valid()) {
                if (
                  step == 2 &&
                  val_type_report != "" &&
                  val_type_report !=
                    "Daños en el vehículo a causa de un accidente o evento súbito e imprevisto."
                ) {
                  $form_insure.submit();
                  $("#edit-next--2").attr("disabled", true);

                  $("#edit-next").attr("disabled", true);
                } else if (
                  step == 3 &&
                  val_type_report != "" &&
                  val_type_report ==
                    "Daños en el vehículo a causa de un accidente o evento súbito e imprevisto."
                ) {
                  $form_insure.submit();
                  $("#edit-next--2").attr("disabled", true);

                  $("#edit-next").attr("disabled", true);
                } else {
                  let activeHeader = $(
                    "#sinister-notific-insured-form .header-steps.active.is-desktop"
                  );
                  if (windowMobile) {
                    let activeHeader = $(
                      "#sinister-notific-insured-form .header-steps.active.is-mobile"
                    );
                  }
                  activeHeader
                    .find("span")
                    .removeClass("active")
                    .removeClass("check");
                  activeHeader.find(".step-" + new_step).addClass("active");

                  $form_insure.find(".steps.active").removeClass("active");
                  $form_insure.find(".steps").addClass("is-hidden");
                  $form_insure.find(".step-" + new_step).addClass("active");
                  $form_insure
                    .find(".step-" + new_step)
                    .removeClass("is-hidden");

                  switch (new_step) {
                    case 2:
                      activeHeader.find(".step-1").addClass("check");
                      $("#edit-next").removeAttr("disabled");
                      $("#edit-next--2").removeAttr("disabled");
                      break;

                    case 3:
                      activeHeader.find(".step-1").addClass("check");
                      activeHeader.find(".step-2").addClass("check");
                      $("#edit-next").removeAttr("disabled");
                      $("#edit-next--2").removeAttr("disabled");
                      break;
                  }
                }
              }
            } else if (cdtype == "back") {
              $("#edit-next").removeAttr("disabled");
              $("#edit-next--2").removeAttr("disabled");
              let activeHeader = $(
                "#sinister-notific-insured-form .header-steps.active.is-desktop"
              );
              if (windowMobile) {
                let activeHeader = $(
                  "#sinister-notific-insured-form .header-steps.active.is-mobile"
                );
              }
              activeHeader
                .find("span")
                .removeClass("active")
                .removeClass("check");
              activeHeader.find(".step-" + new_step).addClass("active");

              $form_insure.find(".steps.active").removeClass("active");
              $form_insure.find(".steps").addClass("is-hidden");
              $form_insure.find(".step-" + new_step).addClass("active");
              $form_insure.find(".step-" + new_step).removeClass("is-hidden");

              switch (new_step) {
                case 2:
                  activeHeader.find(".step-1").addClass("check");
                  $form_insure.find(".btn-next").removeAttr("disabled");
                  break;

                case 3:
                  activeHeader.find(".step-1").addClass("check");
                  activeHeader.find(".step-2").addClass("check");
                  break;
              }
            }
          }
        );
      }

      if ($("#sinister-notific-third-affectt-form").length > 0) {
        let $form_third_affect = $("#sinister-notific-third-affectt-form");
        let validate_rules = {
          "00N4A00000FkWpu": {
            required: true,
          },

          ins_veh_info_brand: {
            required: true,
          },

          "00N4A00000FkWpk": {
            required: true,
          },

          "00NG000000998UR": {
            required: true,
            maxlength: 6,
            minlength: 5,
          },
          "00N4A00000FkjTv": {
            required: true,
          },
          "00N4A00000FkjTo": {
            required: true,
          },
          "00N4A00000FkjTt": {
            required: true,
          },
          "00N0t000000gbNQ": {
            required: true,
            number: true,
            minlength: 10,
            maxlength: 10,
          },
          "00N0t000000gbNV": {
            required: true,
          },
          "00N4A00000FkjTq": {
            required: true,
          },
          affect_vehic_own_brand: {
            required: true,
          },
          "00N4A00000FgLGE": {
            required: true,
          },
          "00N4A00000FgLGB": {
            required: true,
          },
          affect_vehic_own_city: {
            required: true,
          },

          "00N4A00000FgLGD": {
            required: true,
          },
          "00N4A00000FkWqi": {
            required: true,
            minlength: 5,
          },
          "00N4A00000FkWqd": {
            required: true,
            lettersonly: true,
          },
          "00N4A00000FkWqs": {
            required: true,
            number: true,
            minlength: 10,
            maxlength: 10,
          },
          "00N4A00000FkWqx": {
            required: true,
          },
          "00N4A00000FkWr2": {
            required: true,
          },
          "00N4A00000FkWr7": {
            required: true,
            minlength: 100,
            maxlength: 255,
          },
          "00N4A00000FkWrC": {
            required: true,
            alphanumeric: true,
          },
          "00N4A00000FkWrl": {
            required: true,
          },
          "00N4A00000Fkhd2": {
            required: true,
          },
          "00N4A00000FkWrW": {
            required: true,
          },
          "00N4A00000FkWrg": {
            required: true,
          },
          "00N4A00000Fkhd7": {
            required: true,
          },
          "00N4A00000FkjTs": {
            required: true,
          },
        };

        let validate_messages = {
          "00N4A00000FkWpu": {
            required: "Este campo es requerido",
          },
          ins_veh_info_brand: {
            required: "Este campo es requerido",
          },
          "00N4A00000FkWpk": {
            required: "Este campo es requerido",
          },
          "00NG000000998UR": {
            required: "Este campo es requerido",
            maxlength: "La placa no puede ser superior a 6 caracteres",
            minlength: "La placa no puede ser superior a 5 caracteres",
          },

          "00N4A00000FkjTv": {
            required: "Este campo es requerido",
          },
          "00N4A00000FkjTo": {
            required: "Este campo es requerido",
            number: "Debe ingresar solo números",
          },
          "00N4A00000FkjTt": {
            required: "Este campo es requerido",
          },
          "00N0t000000gbNQ": {
            required: "Este campo es requerido",
            number: "Debe ingresar solo números",
            minlength: "Mínimo 10 digitos",
            maxlength: "Máximo 10 digitos",
          },
          "00N0t000000gbNV": {
            required: "Este campo es requerido",
          },
          "00N4A00000FkjTq": {
            required: "Este campo es requerido",
          },
          affect_vehic_own_brand: {
            required: "Este campo es requerido",
          },
          "00N4A00000FgLGE": {
            required: "Este campo es requerido",
          },
          "00N4A00000FgLGB": {
            required: "Este campo es requerido",
          },
          affect_vehic_own_city: {
            required: "Este campo es requerido",
          },

          "00N4A00000FgLGD": {
            required: "Este campo es requerido",
          },
          "00N4A00000FkWqi": {
            required: "Este campo es requerido",
            minlength: "Mínimo 5 digitos",
          },
          "00N4A00000FkWqd": {
            required: "Este campo es requerido",
            lettersonly: "Solo esta permitido el ingreso de letras",
          },
          "00N4A00000FkWqs": {
            required: "Este campo es requerido",
            number: "Debe ingresar solo números",
            minlength: "Mínimo 7 digitos",
            maxlength: "Máximo 10 digitos",
          },
          "00N4A00000FkWqx": {
            required: "Este campo es requerido",
          },
          "00N4A00000FkWr2": {
            required: "Este campo es requerido",
          },

          "00N4A00000FkWr7": {
            required: "Este campo es requerido",
            minlength: "La descripción debe tener al menos 100 caracteres.",
            maxlength: "La descripción no puede exceder los 255 caracteres.",
          },
          "00N4A00000FkWrC": {
            required: "Este campo es requerido",
            alphanumeric:
              "El campo solo debe contener números, letras o los caracteres (#, -)",
          },
          "00N4A00000FkWrl": {
            required: "Este campo es requerido",
          },
          "00N4A00000Fkhd2": {
            required: "Este campo es requerido",
          },
          "00N4A00000FkWrW": {
            required: "Este campo es requerido",
          },
          "00N4A00000FkWrg": {
            required: "Este campo es requerido",
          },
          "00N4A00000Fkhd7": {
            required: "Este campo es requerido",
          },
          "00N4A00000FkjTs": {
            required: "Este campo es requerido",
          },
        };

        $form_third_affect.validate({
          rules: validate_rules,
          messages: validate_messages,
        });

        $(
          "#sinister-notific-third-affectt-form .header-steps.three-elements"
        ).addClass("active");

        $("#sinister-notific-third-affectt-form .btn-submit-step").on(
          "click",
          function (e) {
            e.preventDefault();
            let step = $form_third_affect.find(".steps.active").attr("step");
            let val_type_report = $(
              "#sinister-notific-third-affectt-form #00N4A00000FkWpu"
            ).val();
            let cdtype = $(this).attr("cdtype");

            if (cdtype == "back") {
              let new_step = parseInt(step) - 1;
            } else if (cdtype == "next") {
              let new_step = parseInt(step) + 1;
            }

            $form_third_affect.find(".btn-back").addClass("is-hidden");
            if (new_step > 1) {
              if (cdtype == "next" && new_step == 2) {
                if ($form_third_affect.valid()) {
                  $form_third_affect.find(".btn-back").removeClass("is-hidden");

                  let type_form = $ctn_tabs
                    .find(".tabs.active")
                    .find(".form-ctn-notif-sinister")
                    .attr("cdtype-form");
                  let $ctn_form = $ctn_tabs.find(".tabs.active").find("form");
                  copy_page_info_fields_groups($ctn_form, type_form, true);
                }
              } else {
                $form_third_affect.find(".btn-back").removeClass("is-hidden");
              }
            }

            if (cdtype == "next") {
              if ($form_third_affect.valid()) {
                if (
                  step == 3 &&
                  val_type_report != "" &&
                  val_type_report == "DOPUA"
                ) {
                  $form_third_affect.submit();
                  $form_third_affect
                    .find("#edit-next--2")
                    .attr("disabled", true);
                  $form_third_affect.find("#edit-next").attr("disabled", true);
                } else {
                  let activeHeader = $(
                    "#sinister-notific-third-affectt-form .header-steps.active.is-desktop"
                  );
                  if (windowMobile) {
                    let activeHeader = $(
                      "#sinister-notific-third-affectt-form .header-steps.active.is-mobile"
                    );
                  }
                  activeHeader
                    .find("span")
                    .removeClass("active")
                    .removeClass("check");
                  activeHeader.find(".step-" + new_step).addClass("active");

                  $form_third_affect
                    .find(".steps.active")
                    .removeClass("active");
                  $form_third_affect.find(".steps").addClass("is-hidden");
                  $form_third_affect
                    .find(".step-" + new_step)
                    .addClass("active");
                  $form_third_affect
                    .find(".step-" + new_step)
                    .removeClass("is-hidden");

                  switch (new_step) {
                    case 2:
                      activeHeader.find(".step-1").addClass("check");
                      break;

                    case 3:
                      activeHeader.find(".step-1").addClass("check");
                      activeHeader.find(".step-2").addClass("check");
                      $("#edit-next--3").click(function () {
                        $("#edit-next--3").attr("disabled", true);
                      });
                      break;
                  }
                }
              }
            } else if (cdtype == "back") {
              let activeHeader = $(
                "#sinister-notific-third-affectt-form .header-steps.active.is-desktop"
              );
              if (windowMobile) {
                let activeHeader = $(
                  "#sinister-notific-third-affectt-form .header-steps.active.is-mobile"
                );
              }
              activeHeader
                .find("span")
                .removeClass("active")
                .removeClass("check");
              activeHeader.find(".step-" + new_step).addClass("active");

              $form_third_affect.find(".steps.active").removeClass("active");
              $form_third_affect.find(".steps").addClass("is-hidden");
              $form_third_affect.find(".step-" + new_step).addClass("active");
              $form_third_affect
                .find(".step-" + new_step)
                .removeClass("is-hidden");

              switch (new_step) {
                case 2:
                  activeHeader.find(".step-1").addClass("check");
                  $form_third_affect
                    .find("#edit-next--2")
                    .removeAttr("disabled");
                  $form_third_affect.find("#edit-next").removeAttr("disabled");
                  break;

                case 3:
                  activeHeader.find(".step-1").addClass("check");
                  activeHeader.find(".step-2").addClass("check");
                  $form_third_affect
                    .find("#edit-next--2")
                    .removeAttr("disabled");
                  $form_third_affect.find("#edit-next").removeAttr("disabled");
                  break;
              }
            }
          }
        );
      }

      let area_vehicle_checked = {};
      $(".step-3")
        .find(":checkbox")
        .each(function () {
          let check = $(this),
            check_id = check.attr("id");
          check.on("change", function () {
            if (check.is(":checked")) {
              area_vehicle_checked[check_id] = check.val();
            } else {
              delete area_vehicle_checked[check_id];
            }

            if (Object.keys(area_vehicle_checked).length > 0) {
              if ($form_third_affect) {
                $form_third_affect.find("#edit-next").removeAttr("disabled");
                $form_third_affect.find("#edit-next--3").removeAttr("disabled");
              }
              if ($form_insure) {
                $form_insure.find("#edit-next").removeAttr("disabled");
                $form_insure.find("#edit-next--2").removeAttr("disabled");
              }
            } else {
              if ($form_third_affect) {
                $form_third_affect
                  .find("#edit-next")
                  .attr("disabled", "disabled");
                $form_third_affect
                  .find("#edit-next--3")
                  .attr("disabled", "disabled");
              }
              if ($form_insure) {
                $form_insure.find("#edit-next").attr("disabled", "disabled");
                $form_insure.find("#edit-next--2").attr("disabled", "disabled");
              }
            }
          });
        });

      $.validator.addMethod("isValidEmailAddress", function (value, element) {
        let pattern = new RegExp(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/);
        return pattern.test(value);
      });
      $.validator.setDefaults({ ignore: [".ignore"] });

      /**
       * [execute_autocompletes description]
       * @return {[type]} [description]
       */
      function execute_autocompletes() {
        let $ctn_form = $ctn_tabs.find(".tabs.active").find("form");
        // Autocomplete cities
        $ctn_form.find(".cities-sinisters-notices").keyup(function () {
          if ($(this).val().length > 1) {
            let cdatafh = $(this).attr("cdatafh");
            let $selectHidden = $(this)
              .parent()
              .next(".hidden-select")
              .find("#" + cdatafh);
          }
        });
      }

      /**
       * [states_fields description]
       * @param  {[type]} $active_form [description]
       * @return {[type]}              [description]
       */
      function states_fields(activeForm) {
        // Define a helper function to simplify element visibility toggling
        function toggleElementVisibility(element, show, select) {
          const formItem = element.parent(".form-item");
          if (show) {
            formItem.removeClass("is-hidden");
            element.removeClass("ignore");
          } else {
            formItem.addClass("is-hidden");
            element.addClass("ignore");
            if (element.is("select")) {
              element.val("No");
            } else if (element.is("input[type='text']")) {
              element.val("");
            }
          }
        }

        // Death number
        const deathInput = activeForm.find("#00N4A00000Fkhd2");
        toggleElementVisibility(deathInput, false, 0); // Hide by default
        activeForm.find("#00N4A00000FkWrl").change(function () {
          const showDeathNumber = $(this).val() === "Si";
          toggleElementVisibility(deathInput, showDeathNumber, 0);
        });

        const woundedInput = activeForm.find("#00N4A00000Fkhd7");
        toggleElementVisibility(woundedInput, false, 0); // Hide by default
        activeForm.find("#00N4A00000FkWrg").change(function () {
          const showWoundedNumber = $(this).val() === "Si";
          toggleElementVisibility(woundedInput, showWoundedNumber, 0);
        });

        const thirdPartiesInputs = [
          "#00N7j0000026tc5",
          "#00N7j0000026tc6",
          "#00N7j0000026tc7",
          "#00N7j0000026tc8",
          "#00N7j0000026tcA",
          "#00N7j0000026tcB",
          "#00N7j0000026tcC",
          "#00N7j0000026tcD",
        ];

        thirdPartiesInputs.forEach((inputId, index) => {
          const input = activeForm.find(inputId);
          toggleElementVisibility(input, false, 0);
        });

        activeForm.find("#00N7j0000026tc9").change(function () {
          const showTercerosInvolucrados = $(this).val() === "Si";
          if (showTercerosInvolucrados) {
            thirdPartiesInputs.forEach((inputId, index) => {
              if (index == 1) {
                const input = activeForm.find(inputId);
                toggleElementVisibility(input, showTercerosInvolucrados);
              }
            });
          } else {
            thirdPartiesInputs.forEach((inputId, index) => {
              const input = activeForm.find(inputId);
              toggleElementVisibility(input, showTercerosInvolucrados);
            });
          }
        });

        activeForm.find("#00N7j0000026tc6").change(function () {
          const showAdditionalInputs = $(this).val() === "Si";
          toggleElementVisibility(
            activeForm.find("#00N7j0000026tcB"),
            showAdditionalInputs
          );
          toggleElementVisibility(
            activeForm.find("#00N7j0000026tc5"),
            showAdditionalInputs,
            1
          );
        });

        activeForm.find("#00N7j0000026tc5").change(function () {
          const showAdditionalInput = $(this).val() === "Si";
          toggleElementVisibility(
            activeForm.find("#00N7j0000026tcA"),
            showAdditionalInput,
            1
          );

          toggleElementVisibility(
            activeForm.find("#00N7j0000026tc8"),
            showAdditionalInput,
            1
          );
        });

        activeForm.find("#00N7j0000026tc8").change(function () {
          const showAdditionalInput = $(this).val() === "Si";
          toggleElementVisibility(
            activeForm.find("#00N7j0000026tcC"),
            showAdditionalInput,
            1
          );

          if (!showAdditionalInput) {
            toggleElementVisibility(
              activeForm.find("#00N7j0000026tc7"),
              false,
              1
            );
            toggleElementVisibility(
              activeForm.find("#00N7j0000026tcD"),
              false,
              1
            );
          }
        });

        activeForm.find("#00N7j0000026tcC").change(function () {
          const showAdditionalInput = $(this).val() === "Si";
          toggleElementVisibility(activeForm.find("#00N7j0000026tc7"), true, 1);
        });

        activeForm.find("#00N7j0000026tc7").change(function () {
          const showAdditionalInput = $(this).val() === "Si";
          toggleElementVisibility(
            activeForm.find("#00N7j0000026tcD"),
            showAdditionalInput,
            1
          );
        });
      }

      /**
       * [copy_page_info_fields_groups description]
       * @param  {[type]} $active_form  [description]
       * @param  {[type]} type_form     [description]
       * @param  {[type]} fields_hidden [description]
       * @return {[type]}               [description]
       */
      function copy_page_info_fields_groups(
        $active_form,
        type_form,
        fields_hidden
      ) {
        if (fields_hidden === undefined) {
          fields_hidden = false;
        }

        switch (type_form) {
          case "insured":
            $("input[name='driver_same_insure']", context).click(function () {
              if ($(this).val() == "Si") {
                $active_form
                  .find(".insured_info-insured_id")
                  .val($active_form.find(".driver_info-driver_id").val())
                  .focus();
                $active_form
                  .find(".insured_info-insured_id_num")
                  .val($active_form.find(".driver_info-driver_id_num").val())
                  .focus();
                $active_form
                  .find(".insured_info-insured_name")
                  .val($active_form.find(".driver_info-driver_name").val())
                  .focus();
                $active_form
                  .find(".insured_info-insured_cellphone")
                  .val($active_form.find(".driver_info-driver_cellphone").val())
                  .focus();
                $active_form
                  .find(".insured_info-insured_email")
                  .val($active_form.find(".driver_info-driver_email").val())
                  .focus();
                $active_form
                  .find(".insured_info-insured_address")
                  .val($active_form.find(".driver_info-driver_address").val())
                  .focus();
              } else {
                $active_form
                  .find(".insured_info-insured_id")
                  .val("")
                  .focusout();
                $active_form
                  .find(".insured_info-insured_id_num")
                  .val("")
                  .focusout();
                $active_form
                  .find(".insured_info-insured_name")
                  .val("")
                  .focusout();
                $active_form
                  .find(".insured_info-insured_cellphone")
                  .val("")
                  .focusout();
                $active_form
                  .find(".insured_info-insured_email")
                  .val("")
                  .focusout();
                $active_form
                  .find(".insured_info-insured_address")
                  .val("")
                  .focusout();
              }
            });

            $("input[name='declarant_same_insure']", context).click(
              function () {
                if ($(this).val() == "Si") {
                  $active_form
                    .find(".declarant_info-declarant_id")
                    .val($active_form.find(".driver_info-driver_id").val())
                    .focus();
                  $active_form
                    .find(".declarant_info-declarant_id_num")
                    .val($active_form.find(".driver_info-driver_id_num").val())
                    .focus();
                  $active_form
                    .find(".declarant_info-declarant_name")
                    .val($active_form.find(".driver_info-driver_name").val())
                    .focus();
                  $active_form
                    .find(".declarant_info-declarant_cellphone")
                    .val(
                      $active_form.find(".driver_info-driver_cellphone").val()
                    )
                    .focus();
                  $active_form
                    .find(".declarant_info-declarant_phone")
                    .val($active_form.find(".driver_info-driver_phone").val())
                    .focus();
                  $active_form
                    .find(".declarant_info-declarant_email")
                    .val($active_form.find(".driver_info-driver_email").val())
                    .focus();
                  $active_form
                    .find(".declarant_info-declarant_address")
                    .val($active_form.find(".driver_info-driver_address").val())
                    .focus();
                } else {
                  $active_form
                    .find(".declarant_info-declarant_id")
                    .val("")
                    .focusout();
                  $active_form
                    .find(".declarant_info-declarant_id_num")
                    .val("")
                    .focusout();
                  $active_form
                    .find(".declarant_info-declarant_name")
                    .val("")
                    .focusout();
                  $active_form
                    .find(".declarant_info-declarant_cellphone")
                    .val("")
                    .focusout();
                  $active_form
                    .find(".declarant_info-declarant_phone")
                    .val("")
                    .focusout();
                  $active_form
                    .find(".declarant_info-declarant_email")
                    .val("")
                    .focusout();
                }
              }
            );
            break;

          case "third-affect":
            if (fields_hidden == true) {
            } else {
              $("input[name='declarant_same_third']", context).click(
                function () {
                  if ($(this).val() == "Si") {
                    $active_form
                      .find(".declarant_info-declarant_id")
                      .val(
                        $active_form
                          .find(".affect_vehic_own-third_doc_type")
                          .val()
                      )
                      .focus();
                    $active_form
                      .find(".declarant_info-declarant_id_num")
                      .val(
                        $active_form
                          .find(".affect_vehic_own-third_doc_num")
                          .val()
                      )
                      .focus();
                    $active_form
                      .find(".declarant_info-declarant_name")
                      .val(
                        $active_form.find(".affect_vehic_own-third_name").val()
                      )
                      .focus();
                    $active_form
                      .find(".declarant_info-declarant_cellphone")
                      .val(
                        $active_form
                          .find(".affect_vehic_own-third_cellphone")
                          .val()
                      )
                      .focus();
                    $active_form
                      .find(".declarant_info-declarant_phone")
                      .val(
                        $active_form.find(".affect_vehic_own-third_phone").val()
                      )
                      .focus();
                    $active_form
                      .find(".declarant_info-declarant_email")
                      .val(
                        $active_form.find(".affect_vehic_own-third_email").val()
                      )
                      .focus();
                    $active_form
                      .find(".declarant_info-declarant_address")
                      .val(
                        $active_form
                          .find(".affect_vehic_own-third_address")
                          .val()
                      )
                      .focus();
                  } else {
                    $active_form
                      .find(".declarant_info-declarant_id")
                      .val("")
                      .focusout();
                    $active_form
                      .find(".declarant_info-declarant_id_num")
                      .val("")
                      .focusout();
                    $active_form
                      .find(".declarant_info-declarant_name")
                      .val("")
                      .focusout();
                    $active_form
                      .find(".declarant_info-declarant_cellphone")
                      .val("")
                      .focusout();
                    $active_form
                      .find(".declarant_info-declarant_phone")
                      .val("")
                      .focusout();
                    $active_form
                      .find(".declarant_info-declarant_email")
                      .val("")
                      .focusout();
                    $active_form
                      .find(".declarant_info-declarant_address")
                      .val("")
                      .focusout();
                  }
                }
              );
            }
            break;
        }
      }

      $("body.js-mobile")
        .off()
        .on(
          "click",
          ".component__tabs--sinister-notice .component__card",
          function (e) {
            $(this).find(".cta a").triggerHandler("click");
            e.preventDefault();
          }
        );

      if (window.location.hash) {
        let id_tab = window.location.hash.substr(5, 1);
        $(".cp-tabs:visible")
          .find('a[href="#tab-' + id_tab + '"]')
          .click();
      }

      $(window).bind("hashchange", function (e) {
        location.reload(true);
      });
    },
  };
})(jQuery);
