(($, Drupal, drupalSettings) => {
  Drupal.behaviors.libertyFormValidations = {
    attach(context) {
      //add class input active form
      $(function () {
        if ($("#form-prev").val().length == 0) {
          $("#form-prev").parent().prev().css({ background: "white" });
        }
      });

      $(document).ready(function () {
        $("#form-prev").focus(function (e) {
          e.preventDefault();
          e.stopPropagation();
          $("#form-prev").parent().parent().addClass("active");
          $("#form-prev").parent().prev().css({ background: "" });
        });
        $("#edit-identification-number").focus(function (e) {
          e.preventDefault();
          e.stopPropagation();
          $("#edit-identification-number").parent().addClass("active");
        });
        $("body").focus(function () {
          if ($("#edit-identification-number").val().length == 0) {
            $("#edit-identification-number").parent().removeClass("active");
          }
          if ($("#form-prev").val().length == 0) {
            $("#form-prev").parent().parent().removeClass("active");
            $("#form-prev").parent().prev().css({ background: "white" });
          }
        });
      });
      $("#edit-submit").click(function (e) {
        e.preventDefault();
        e.stopPropagation();
        $("#form-prev").parent().prev().css({ background: "" });
      });

      // Validation
      $(".forms__welcome").change(function () {
        if ($("#libertydocumentvalidationform").validate().checkForm()) {
          $("#libertydocumentvalidationform .form-submit").prop(
            "disabled",
            false
          );
          $("#libertydocumentvalidationform .form-submit").removeClass(
            "is-disabled"
          );
        } else {
          $("#libertydocumentvalidationform .form-submit").prop(
            "disabled",
            true
          );
          $("#libertydocumentvalidationform .form-submit").addClass(
            "is-disabled"
          );
        }
      });

      $("#libertydocumentvalidationform").validate({
        ignore: ".ignore",
        rules: {
          identification_type: {
            required: true,
          },
          identification_number: {
            required: true,
            maxlength: 15,
          },
        },
        messages: {
          identification_type: {
            required: "Se requiere un tipo de identificación",
          },
          identification_number: {
            required: "El numero de documento no puede quedar vacío",
            maxlength: "Por favor ingresa máximo 15 caracteres solo numéricos",
          },
        },
        errorPlacement: function (error, element) {
          error.insertBefore("#form-prev");
        },
      });
    },
  };
})(jQuery, Drupal, drupalSettings);
