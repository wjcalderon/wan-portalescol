(function ($, Drupal, drupalSettings) {
  Drupal.behaviors.libertycallcenterform = {
    attach(context) {
      $(document).ready(function () {
        $("#edit-placa").attr("maxlength", "6");

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

        let valor_product_token_url = getParameterByName("valor_product_token");
        valor_product_token_url = atob(valor_product_token_url);
        $(".product_value").val(valor_product_token_url);

        const ramo = drupalSettings.ramo.value;
        $(".ramo_value").val(ramo);

        if (ramo == 2) {
          $("#edit-placa").parent().css("display", "unset");
        }
        const sponsors = drupalSettings.sponsors.value;
        $(".sponsors_value").val(sponsors);

        if (ramo != 2) {
          document
            .getElementById("edit-placa")
            .closest(".form-item").style.display = "none";
        }
      });

      // Validation
      $.validator.addMethod(
        "validar_cantidad_patente",
        function (value, element) {
          const name = /^[a-zA-ZÀ-ÿ\u00f1\u00d1\s]+$/;
          return name.test(value);
        },
        "El nombre no es válido no puede contener números"
      );
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
          const lastname = /^[a-zA-ZÀ-ÿ\u00f1\u00d1\s]+$/;
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

      $.validator.addMethod(
        "validar_number",
        function (value, element) {
          const number = /^[0-9]*$/;
          return number.test(value);
        },
        "El número de identificación no es valido"
      );

      const terminos_uso_text = "El campo Aceptar Termino es obligatorio";
      $("#webform_submission_call_center").validate({
        onkeyup: function (element) {
          $(element).valid();
        },
        onsubmit: true,
        ignore: ".ignore",
        rules: {
          id_type: {
            required: true,
          },
          name: {
            required: true,
            validar_nombre: true,
          },
          last_name: {
            required: true,
            validar_apellido: true,
          },

          id_number: {
            required: true,
            minlength: 1,
            maxlength: 10,
            validar_number: true,
          },
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
            minlength: 6,
            maxlength: 6,
          },
          terminos_de_uso: {
            required: true,
          },
        },
        messages: {
          id_type: {
            required: "Se requiere un tipo de identificación",
          },
          name: {
            required: "El nombre no puede quedar vacío",
          },
          last_name: {
            required: "El apellido no puede quedar vacío",
          },
          id_number: {
            required: "Se requiere un número de identificación",
            minlength:
              "El número de identificación debe contener al menos 1 dígitos",
            maxlength:
              "El número de identificación debe contener máximo 10 dígitos",
          },
          phone: {
            required: "El teléfono no puede quedar vacío",
            minlength: "El teléfono debe contener al menos 7 dígitos",
            maxlength: "El teléfono debe contener máximo 10 dígitos",
            number: "El teléfono debe ser sólo numérico",
          },
          email: {
            required: "El email es requerido ",
            email: "El email debe ser un correo electrónico",
          },
          placa: {
            minlength: "La patente debe contener al menos 6 dígitos",
            maxlength: "La patente no puede ser superior a 6 caracteres",
          },
          terminos_de_uso: {
            required: terminos_uso_text,
          },
        },
        errorPlacement: function (error, element) {
          error.insertAfter(element);
        },
        submitHandler: function (form) {
          form.submit();
        },
      });
    },
  };
})(jQuery, Drupal, drupalSettings);
