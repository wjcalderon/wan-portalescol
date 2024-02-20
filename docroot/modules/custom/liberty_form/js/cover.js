//creates a session with localstorage with node and time
(function ($, Drupal, drupalSettings) {
<<<<<<< HEAD
    $(document).ready(function () {
        setInterval(function () {
            ocultarButton();
        }, 1000);


        function ocultarButton() {
            for (let index = 0; index < 5; index++) {
                var link1 = $(`.form-item-field-cover-${index}-subform-field-cover-caracteristic-20-value`).find(`.edit-field-cover-${index}-subform-field-cover-caracteristic-20-value`);

                if (link1.prevObject.length !== 0) {
                    var button1 = $("div.clearfix").find(`input[name="field_cover_${index}_subform_field_cover_caracteristic_add_more"]`);
                    button1.css('display', 'none');
                } else {
                    var button1 = $("div.clearfix").find(`input[name="field_cover_${index}_subform_field_cover_caracteristic_add_more"]`);
                    button1.css('display', 'unset');
                }
            }

            for (let index2 = 0; index2 < 5; index2++) {
                var link2 = $(`.form-item-field-cover-${index2}-subform-field-benefits-12-value`).find(`.edit-field-cover-${index2}-subform-field-benefits-12-value`);
                if (link2.prevObject.length !== 0) {
                    var button2 = $("div.clearfix").find(`input[name="field_cover_${index2}_subform_field_benefits_add_more"]`);
                    button2.css('display', 'none');
                } else {
                    var button2 = $("div.clearfix").find(`input[name="field_cover_${index2}_subform_field_  benefits_add_more"]`);
                    button2.css('display', 'unset');
                }
            }

        }


    });
})(jQuery, Drupal, drupalSettings);
=======
  $(document).ready(function () {
    setInterval(function () {
      ocultarButton();
    }, 1000);

    function ocultarButton() {
      for (let index = 0; index < 5; index++) {
        let link1 = $(
          `.form-item-field-cover-${index}-subform-field-cover-caracteristic-20-value`
        ).find(
          `.edit-field-cover-${index}-subform-field-cover-caracteristic-20-value`
        );

        if (link1.prevObject.length !== 0) {
          let button1 = $("div.clearfix").find(
            `input[name="field_cover_${index}_subform_field_cover_caracteristic_add_more"]`
          );
          button1.css("display", "none");
        } else {
          let button1 = $("div.clearfix").find(
            `input[name="field_cover_${index}_subform_field_cover_caracteristic_add_more"]`
          );
          button1.css("display", "unset");
        }
      }

      for (let index2 = 0; index2 < 5; index2++) {
        let link2 = $(
          `.form-item-field-cover-${index2}-subform-field-benefits-12-value`
        ).find(`.edit-field-cover-${index2}-subform-field-benefits-12-value`);
        if (link2.prevObject.length !== 0) {
          let button2 = $("div.clearfix").find(
            `input[name="field_cover_${index2}_subform_field_benefits_add_more"]`
          );
          button2.css("display", "none");
        } else {
          let button2 = $("div.clearfix").find(
            `input[name="field_cover_${index2}_subform_field_  benefits_add_more"]`
          );
          button2.css("display", "unset");
        }
      }
    }
  });
})(jQuery, Drupal, drupalSettings);
>>>>>>> main
