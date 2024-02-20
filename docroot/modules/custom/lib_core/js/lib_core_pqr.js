(function ($) {
  $(document).ready(function () {
    $("#00NG000000998UR").attr("disabled", "disabled");
    $("#00NG000000998UR").attr("minlength", "5");
  });

  function limpiarInput(inputElement) {
    inputElement.value = inputElement.value.replace(/\D/g, "");
    let valor = inputElement.value.replace(/^0*/, "");
    inputElement.value = valor;
  }

  $("#00NG000000FWyoU").on("input", function () {
    limpiarInput(this);
  });

  $("#00NG000000FWynB").on("input", function () {
    limpiarInput(this);
  });

  /**
   * [show_confirm_msg description]
   * @param  {[type]} form [description]
   * @return {[type]}      [description]
   */
  function show_confirm_msg(form) {
    let block_msg = $("#block-pqrthankyoumessage");
    if (block_msg.length > 0) {
      let hd_tabs = $(".cp-tabs .cog--mq ul"),
        ht_links_tabs = hd_tabs.find("li .cta a");
      let current_url =
        window.location.protocol +
        "//" +
        window.location.hostname +
        window.location.pathname;
      if (ht_links_tabs.length > 0) {
        ht_links_tabs.click(function () {
          block_msg.hide();
        });
      }
      let hb = $(".cp-banner__image").height(),
        hct = $(".component__tabs .component__heading").height(),
        scrllForm = 600;
      if (hb && hct) {
        scrllForm = parseInt(hb) + parseInt(hct);
      }
      $("html, body").animate({ scrollTop: scrllForm }, 900);
      if ($(window).width() < 980) {
        block_msg.addClass("tabs active fix-msg");
        setTimeout(function () {
          window.location.href = current_url;
        }, 10000);
      }
    }
  }

  /**
   * [states_fields description]
   * @return {[type]} [description]
   */
  function states_fields() {
    function handleCondEspecialChange() {
      $("#cond_especial").change(function () {
        if ($(this).val() === "SI") {
          $("#00n05000000y11p").attr("required", true);
        } else {
          $("#00n05000000y11p").removeAttr("required");
        }
      });
    }

    function handleGenerdChange() {
      $("#00ng000000fwyow").change(function () {
        if ($(this).val() === "NIT") {
          handleNITSelection();
        } else {
          handleNonNITSelection();
        }
      });
    }

    function handleNITSelection() {
      $("#00n05000000xuss").empty();
      $("#00n05000000xuss").append("<option value=''>- Seleccionar -</option>");
      $("#00n05000000xuss").append(
        "<option value='No aplica'>No aplica</option>"
      );
    }

    function handleNonNITSelection() {
      $("#00n05000000xuss").empty();
      $("#00n05000000xuss").append("<option value=''>- Seleccionar -</option>");
      const genderOptions = ["Masculino", "Femenino", "Trans", "No Binario"];
      genderOptions.forEach((option) => {
        $("#00n05000000xuss").append(
          `<option value='${option}'>${option}</option>`
        );
      });
    }

    handleCondEspecialChange();
    handleGenerdChange();

    // Case number
    $("#00n4a00000fkikp").attr("disabled", "disabled");


    $("#00ng000000fwyn9").change(function () {
      if ($(this).val() != "SI") {
        $("#00n4a00000fkikp").attr("disabled", "disabled");
      } else {
        $("#00n4a00000fkikp").removeAttr("disabled");
      }
    });

    // Plaque
    $("#00NG000000998UR").attr("disabled", "disabled");
    $("#00N4A00000FkiL2").change(function () {
      if ($(this).val() == "AUTOS" || $(this).val() == "SOAT") {
        $("#00NG000000998UR").removeAttr("disabled");
      } else {
        $("#00NG000000998UR").attr("disabled", "disabled");
      }
    });
  }

  /**
   * [validate_form description]
   * @param  {[type]} form [description]
   * @return {[type]}      [description]
   */

  $.validator.addMethod(
    "validar_nombre",
    function (value, element) {
      const nameRegex = /^[a-zA-ZÀ-ÿ\u00f1\u00d1\s]+$/;
      return nameRegex.test(value) && value.trim() !== "";
    },
    "El nombre no es válido, no puede contener números"
  );

  function validate_form(form) {
    // Pqr Implement Jquery validate
    let validate_rules = {
      // Reconsideracion
      "00NG000000FWyn9": {
        required: true,
      },
      // Número de caso
      "00N4A00000FkiKp": {
        required: $("#00N4A00000FkiKp").val() != "SI",
      },
      // Tipo identificacion
      "00NG000000FWyoW": {
        required: true,
      },
      // Número identificacion
      "00NG000000FWyoI": {
        required: true,
        maxlength: 18,
        number: true,
      },
      // Nombres y apellidos
      "00n4a00000fkiko": {
        required: true,
        validar_nombre: true,
      },
      // Direccion
      "00NG000000FWynx": {
        required: true,
      },
      // Celular
      "00NG000000FWynB": {
        required: true,
        number: true,
        minlength: 10,
      },
      "00NG000000FWyoU": {
        required: true,
        number: true,
        maxlength: 18,
      },
      // Correo
      mail: {
        required: true,
        email: true,
        isValidEmailAddress: true,
      },
      // Producto
      "00N4A00000FkiL2": {
        required: true,
      },
      // Medio de envio
      "00NG000000FWynl": {
        required: true,
      },
      // Placa
      "00NG000000998UR": {
        required: true,
        minlength: 5,
        // isValidPlaque: true,
      },
      adjuntar_archivos: {
        extension: "pdf",
      },
    };
    let validate_messages = {
      // Reconsideracion
      "00NG000000FWyn9": {
        required: "Este campo es requerido",
      },
      // Número de caso
      "00n4a00000fkikp": {
        required: "Este campo es requerido",
      },
      // Tipo identificacion
      "00NG000000FWyoW": {
        required: "Este campo es requerido",
      },
      // Número identificacion
      "00NG000000FWyoI": {
        required: "Este campo es requerido",
        number: "Debe ingresar solo números",
        maxlength: "Por favor escribe máximo 18 digitos",
      },
      // Nombres y apellidos
      "00n4a00000fkiko": {
        required: "Este campo es requerido",
      },
      // Direccion
      "00NG000000FWynx": {
        required: "Este campo es requerido",
      },
      // Celular
      "00NG000000FWynB": {
        required: "Este campo es requerido",
        number: "Debe ingresar solo números",
        minlength: "Por favor escribe mínimo 10 digitos",
      },
      // Fijo
      "00NG000000FWyoU": {
        required: "Este campo es requerido",
        number: "Debe ingresar solo números",
        maxlength: "Por favor escribe máximo 18 digitos",
      },
      // Correo
      mail: {
        required: "Este campo es requerido",
        email: "Este campo debe ser un correo valido",
        isValidEmailAddress: "Este campo debe ser un correo valido",
      },
      // Producto
      "00N4A00000FkiL2": {
        required: "Este campo es requerido",
      },
      // Medio de envio
      "00NG000000FWynl": {
        required: "Este campo es requerido",
      },
      // Placa
      "00NG000000998UR": {
        required: "Este campo es requerido",
        minlength: "La placa no puede ser inferior a 6 caracteres",
        // isValidPlaque:
        //   'El valor debe contener valores alfanumericos ej: QWE123',
      },
      adjuntar_archivos: {
        extension: "seleccione un formato de archivo de entrada válido",
      },
    };
    form.validate({
      rules: validate_rules,
      messages: validate_messages,
    });
    $.validator.addMethod("isValidEmailAddress", function (value, element) {
      let pattern = new RegExp(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/);
      return pattern.test(value);
    });
    $.validator.addMethod("isValidPlaque", function (value, element) {
      let pattern = new RegExp(/[A-Za-z][\d]/);
      return pattern.test(value);
    });
  }

  Drupal.behaviors.lib_core_pqr = {
    attach: function (context, settings) {
      //--------------------
      // PQR
      //--------------------
      let form = $("#pqr-form");
      show_confirm_msg(form);
      validate_form(form);
      states_fields();
    },
  };

  $(".title_terms ").click(function () {
    $(".terms-modal-wrap").addClass("display");
  });
  $(".terms-modal-close").click(function () {
    $(".terms-modal-wrap").removeClass("display");
  });

  $(".form-item-cond-especial").addClass("is-hidden");
  $("#modal_acept_terms").click(function (e) {
    e.preventDefault();
    if (!$("#00n05000001ccds")[0].checked) {
      $("#00n05000001ccds").prop("checked", true);
      $(".terms-modal-wrap").removeClass("display");
      $("#edit-00n05000000y1hp--wrapper").removeClass("is-hidden");
      $(".form-item-cond-especial").removeClass("is-hidden");
    } else {
      $("#00n05000001ccds").prop("checked", false);
      $(".terms-modal-wrap").removeClass("display");
      $("#edit-00n05000000y1hp--wrapper").addClass("is-hidden");
      $(".form-item-cond-especial").addClass("is-hidden");
    }
  });

  $(".form-item-_0n05000000y11p").addClass("is-hidden");
  $("#cond_especial").change(function () {
    if ($(this).val() == "SI") {
      $(".form-item-_0n05000000y11p").removeClass("is-hidden");
    } else {
      $(".form-item-_0n05000000y11p").addClass("is-hidden");
    }
  });
  $("#pais").parent("div").addClass("form__input--activo");

  $("#edit-00n05000000y1hp--wrapper").addClass("is-hidden");

  $(".terms_checkbox").click(function () {
    if ($(".terms_checkbox:checkbox:checked").val() == 1) {
      $(".itemsLg").removeClass("is-hidden");
      $(".separador").removeClass("is-hidden");
    } else {
      $(".itemsLg").addClass("is-hidden");
      $(".separador").addClass("is-hidden");
    }
  });
})(jQuery);
