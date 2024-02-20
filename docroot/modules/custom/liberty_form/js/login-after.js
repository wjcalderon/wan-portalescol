(($) => {
  Drupal.behaviors.libertycallcenterform = {
    attach(context) {
      $(document).ready(function () {
        $("label[for='edit-id-type']").css("display", "none");
        $("label[for='edit-id-number']").css("display", "none");
      });

      /**
       * @param String name
       * @return String
       */
      function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        let regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
          results = regex.exec(location.search);
        return results === null
          ? ""
          : decodeURIComponent(results[1].replace(/\+/g, " "));
      }

      const ramo = drupalSettings.ramo.value;
      $(".ramo_value").val(ramo);

      const sponsors = drupalSettings.sponsors.value;
      $(".sponsors_value").val(sponsors);

      let valor_product_token_url = getParameterByName("valor_product_token");
      valor_product_token_url = atob(valor_product_token_url);
      $(".product_value").val(valor_product_token_url);

      if (ramo != 2) {
        document
          .getElementById("edit-placa")
          .closest(".form-item").style.display = "none";
      }

      //validation
      $.validator.addMethod(
        "validar_nombre",
        function (value, element) {
          const name = /^[a-zA-ZÀ-ÿ\u00f1\u00d1\s]+$/;
          return name.test(value);
        },
        "El nombre no es válido no puede contener números"
      );
      $.validator.addMethod(
        "validar_apellido",
        function (value, element) {
          const name = /^[a-zA-ZÀ-ÿ\u00f1\u00d1\s]+$/;
          return lastname.test(value);
        },
        "El apellido no es válido no puede contener números"
      );
      $.validator.addMethod(
        "validar_email",
        function (value, element) {
          const email = /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
          return email.test(value);
        },
        "El email no es válido"
      );
      const terminos_uso_text = "El campo Aceptar Termino es obligatorio";
      $("#webform_submission_call_center").validate({
        onfocusout: function (element) {
          $(element).valid();
        },
        onsubmit: true,
        ignore: ".ignore",
        rules: {
          /*
          id_type: {
            required: true,
          }*/
          name: {
            required: true,
            validar_nombre: true,
          },
          last_name: {
            required: true,
            validar_apellido: true,
          },
          // id_number: {
          //   required: true,
          //   minlength: 5,
          //   maxlength: 15,
          //   number: true
          // },
          email: {
            required: true,
            email: true,
            validar_email: true,
          },
          phone: {
            required: true,
            minlength: 7,
            maxlength: 10,
            number: true,
          },
          placa: {
            maxlength: 6,
          },
          terminos_de_uso: {
            required: true,
          },
        },
        messages: {
          // id_type: {
          //   required: "Se requiere un tipo de identificación",
          // },
          name: {
            required: "El nombre no puede quedar vacío",
          },
          last_name: {
            required: "El apellido no puede quedar vacío",
          },
          // id_number: {
          //   number: "El número de identificación debe ser sólo numérico",
          //   required: "Se requiere un numero de identificación",
          //   minlength: "Este campo debe contener al menos 5 dígitos",
          //   maxlength: "Este campo debe contener máximo 10 dígitos",
          // },
          phone: {
            required: "El teléfono no puede quedar vacío",
            minlength: "Este campo debe contener al menos 7 dígitos",
            maxlength: "Este campo debe contener máximo 10 dígitos",
            number: "El teléfono debe ser sólo numérico",
          },
          email: {
            required: "El email es requerido ",
            email: "Este campo debe ser un correo electrónico",
          },
          placa: {
            maxlength: "La placa no puede ser superior a 6 caracteres",
          },
          terminos_de_uso: {
            required: terminos_uso_text,
          },
        },
        errorPlacement: function (error, element) {
          error.insertBefore("#edit-id-type");
        },
        submitHandler: function (form) {
          form.submit();
        },
      });
    },
  };
})(jQuery);
