/**
 * @file
 * Suscriptor file.
 */

(function ($, Drupal) {
  'use strict';

  // Validate email
  var validate_email = (function (email) {
      var re = /\S+@\S+\.\S+/;
      return re.test(String(email).toLowerCase());
    });

  // validate only numbers
  var validate_numbers = (function (number) {
      return /\D/.test(number);
    });

  // Validate form
  var validate_form = (function(form) {
    var validation_status = true,
      elements = form.find('input:visible, select:visible').each(function(index, el) {
      var elm = $(el),
        errors = new Array();
      if (!elm.attr('readonly') && !elm.attr('disabled')) {
        if (elm.attr('required') && (elm.val() === '' || elm.val() === undefined)) {
          errors.push('El campo es requerido');
        }
        if (elm.hasClass('form-email') && !validate_email('"' + elm.val() + '"')) {
          errors.push('Ingrese un correo electr\xF3nico v\xE1lido');
        }
        if (elm.attr('id') === 'edit-cellphone') {
          if (validate_numbers(elm.val())) {
            errors.push('Solo puede ingresar n\xFAmeros');
          }
          if (elm.val().toString().length > 10 || elm.val().toString().length < 10) {
            errors.push('El n\xFAmero debe tener 10 d\xEDgitos');
          }
        }
        // Show errors
        elm
          .removeClass('error')
          .parent()
          .find('label.error')
          .remove();
        if (errors.length > 0) {
          validation_status = false;
          elm
            .addClass('error')
            .parent()
            .append('<label class="error" for="' + elm.attr('name') + '">' + errors.join('<br>') + '</label>');
        }
      }

    });
      // return false;
    if (!validation_status) {
      return false;
    }

    return true;
  });

  /**
   * Change active header steps form
   * @param $form
   */
  function change_header_step_states(step, $form) {
    $form.find('.header-step').removeClass('active');
    switch(step) {
      case '1':
        $form.find('.header-step2').removeClass('not-complete').addClass('active');
        $form.find('.header-step1').removeClass('not-complete').addClass('complete');
        break;

      case '2':
        $form.find('.header-step3').removeClass('not-complete').addClass('active');
        $form.find('.header-step2').addClass('complete');
        $('.accordion-last-step-visible').removeClass('is-hidden');
        break;
    }
  }

  Drupal.behaviors.lib_quoting_validate = {
    attach: function (context) {

      var form = $('#autos-quoting-form'),
        ctn_hd_flds = form.find('.content-hd-fields'),
        submit = form.find('.submit-next');

      // Validate whitespace in plate
      $('#edit-num-plate').on('change', function() {
        var alNumRegex = /^([a-zA-Z0-9]+)$/;
        if (!alNumRegex.test($(this).val())) {
          $(this)
            .addClass('error')
            .parent()
            .append('<label id="field-error" class="error" for="field">Solo se aceptan letras y n\xFAmeros</label>');

            if (!$('#edit-next').attr('disabled')) {
              $('#edit-next').attr('disabled', true);
            }
        }
        else {
          $(this)
            .removeClass('error')
            .parent()
            .find('#field-error')
            .remove();
        }
      });

      submit.on('click', function(e) {
        e.preventDefault();
        var step = $(this).attr('step'),
          valid = validate_form(form);
        form.find('.header-step').removeClass('active');

        switch (step) {
          case '1':
          // console.log(valid);
          // console.log(!$('.content-hd-fields').hasClass('hidden') && valid);
            if (!$('.content-hd-fields').hasClass('hidden') && valid) {
              form.find('.step1').addClass('hidden').removeClass('active');
              form.find('.step2').removeClass('hidden').addClass('active');
              change_header_step_states(step, form);
            }
            break;
          case '2':
            if (valid) {
              form.find('.step2').addClass('hidden').removeClass('active');
              form.find('.step3').removeClass('hidden').addClass('active');
              change_header_step_states(step, form);
            }
            break;
        }
      });
		}
  }
} (jQuery, Drupal));




