(function ($, Drupal, window, document) {
  'use strict';

  Drupal.behaviors.themeFormsJS = {
    attach: function (context, settings) {

      // reload window
      var reload_document = (function(time) {
        window.setTimeout(function () { document.location.reload(true); }, time);
      });

      $('.webform-section-wrapper').find('input').on('input', function (e) {
        $(e.currentTarget).attr('data-empty', !e.currentTarget.value);
      });

      // Mobile
      if ($('body').hasClass('js-mobile')) {
        if ($('body').find('.webform-confirmation').length > 0) {
          reload_document(3500);
        }
      }

      $(".form-text, .form-email, .form-number, .form-select, .form-item textarea, .form-item .select--tabs").each(function () {
        var el = $(this), item = el.parents('.form-item');
        if (el.parents('form').prop('autocomplete') !== 'off') {
          el.parents('form').prop('autocomplete', 'off');
        }
        el.prop('autocomplete', 'off');

        // if IE 11 add class to labels
        if (!!navigator.userAgent.match(/Trident.*rv\:11\./) && el.hasClass('form-select')) {
          item.addClass('form__input--activo');
          el.focus().trigger('click');
        } else {

          if (el.attr('autofocus') !== undefined) {
            setTimeout(function() {
              el.focus();
            }, 50);
          }

          el.on('focus', function () {
            item.addClass('form__input--activo');
          })
          .on('blur', function () {
            var valorBucar = el.val().length;
            if (valorBucar === 0) {
              item.removeClass('form__input--activo');
            }
          });
        }
      });

      $( ".webform-submission-form .messages--error" ).remove();

      $('.component__single-text--interesado .component__content .single_text_class p a').click(function (e) {
        e.preventDefault();
        $('.form-interesado').removeClass('is-hidden');
        $("body").addClass("no-scroll");
      })

      // Detail product
      // Show webform
      // $('body.nodetype--product .component__single-text--interesado p a').click(function(e){
      //   e.preventDefault();
      //   $('.form-interesado').removeClass('is-hidden');
      //   $("body").addClass("no-scroll");
      // });
      // Hide webform
      $('.form-interesado .form-confirmation, .form-interesado').on('click', '#close', function(e) {
        e.preventDefault();
        $('.form-interesado').addClass('is-hidden');
        $("body").removeClass("no-scroll");
      });

      $('.glosario-ls__link').click(function (e) {
        e.preventDefault();
        $('.form-glossary-word').addClass('is-open');
        // $("body").addClass("no-scroll");
      });

      $('.jsModalClose').click(function (e) {
        e.preventDefault();
        $('.form-glossary-word').removeClass('is-open');
        // $("body").addClass("no-scroll");
      });

      // video modal component.
      $('.video__link').click(function (e) {
        e.preventDefault();
        var src_iframe = $(this).attr('data-atr');
        $('.videoModalOverlay iframe').attr('src', src_iframe);
        $('.videoModalOverlay').addClass('is-open');
      });


      $('.videoModalClose').click(function (e) {
        e.preventDefault();
        $(this).closest('.videoModalOverlay').removeClass('is-open');
        // $("body").addClass("no-scroll");
      });




      //--------------------
      // PQR
      //--------------------

      // Pqr form - Add url action
      /*if ($('body').hasClass('alias--zona-de-cliente-contactanos')) {
        if ($(".salesforce-form-pqr").length > 0) {
          var url_action = 'https://webto.salesforce.com/servlet/servlet.WebToCase?encoding=UTF-8';
          $(".salesforce-form-pqr").attr('action', url_action);
        }
      }*/

      if ($(".webform-submission-pqr-form").length > 0) {

        // --------------------------
        // PQRS - FIELDS IDS SALEFORCE VALIDATION
        // --------------------------
        // Pqr field states
        /*if ($("#00NG000000FWyn9").val() != 'SI') {
          $("#00N4A00000FkiKp").attr("disabled", 'disabled');
        }
        $("#00NG000000FWyn9").change(function(){
          if ($(this).val() != 'SI') {
            $("#00N4A00000FkiKp").attr("disabled", 'disabled');
          }
          else {
            $("#00N4A00000FkiKp").removeAttr('disabled');
          }
        })

        if ($("#00N4A00000FkiL2").val() != 'AUTOS' || $("#00N4A00000FkiL2").val() != 'SOAT') {
          $("#00NG000000998UR").attr("disabled", 'disabled');
        }
        $("#00N4A00000FkiL2").change(function(){
          if ($(this).val() == 'AUTOS' || $(this).val() == 'SOAT') {
            $("#00NG000000998UR").removeAttr('disabled');
          }
          else {
            $("#00NG000000998UR").attr("disabled", 'disabled');
          }
        })

        // Pqr Implement Jquery validate
        var form = $(".salesforce-form-pqr");
        var validate_rules = {
          // Reconsideracion
          '00NG000000FWyn9': {
            required: true,
          },
          // Número de caso
          '00N4A00000FkiKp': {
            required: $("#00N4A00000FkiKp").val() != 'SI',
          },
          // Tipo identificacion
          '00NG000000FWyoW': {
            required: true,
          },
          // Número identificacion
          '00NG000000FWyoI': {
            required: true,
            number: true,
          },
          // Nombres y apellidos
          '00N4A00000FkiKo': {
            required: true,
          },
          // Ciudades
          '00NG000000FWynf': {
            required: true,
          },
          // Direccion
          '00NG000000FWynx': {
            required: true,
          },
          // Celular
          '00NG000000FWynB': {
            required: true,
          },
          // Correo
          '00NG000000FWynb': {
            required: true,
            isValidEmailAddress: true,
          },
          // Producto
          '00N4A00000FkiL2': {
            required: true,
          },
          // Medio de envio
          '00NG000000FWynl': {
            required: true,
          },
          // Placa
          '00NG000000998UR': {
            required: true,
          },
          // Descripcion
          'descripcion': {
            required: true,
          },
        };

        var validate_messages = {
          // Reconsideracion
          '00NG000000FWyn9': {
            required: 'Este campo es requerido',
          },
          // Número de caso
          '00N4A00000FkiKp': {
            required: 'Este campo es requerido',
          },
          // Tipo identificacion
          '00NG000000FWyoW': {
            required: 'Este campo es requerido',
          },
          // Número identificacion
          '00NG000000FWyoI': {
            required: 'Este campo es requerido',
            number: 'Debe ingresar solo números',
          },
          // Nombres y apellidos
          '00N4A00000FkiKo': {
            required: 'Este campo es requerido',
          },
          // Ciudades
          '00NG000000FWynf': {
            required: 'Este campo es requerido',
          },
          // Direccion
          '00NG000000FWynx': {
            required: 'Este campo es requerido',
          },
          // Celular
          '00NG000000FWynB': {
            required: 'Este campo es requerido',
          },
          // Correo
          '00NG000000FWynb': {
            required: 'Este campo es requerido',
            isValidEmailAddress: 'Correo electrónico no valido',
          },
          // Producto
          '00N4A00000FkiL2': {
            required: 'Este campo es requerido',
          },
          // Medio de envio
          '00NG000000FWynl': {
            required: 'Este campo es requerido',
          },
          // Placa
          '00NG000000998UR': {
            required: 'Este campo es requerido',
          },
          // Descripcion
          'descripcion': {
            required: 'Este campo es requerido',
          },
        };
        form.validate({
          rules: validate_rules,
          messages: validate_messages,
        });
        $.validator.addMethod("isValidEmailAddress",
          function(value, element) {
            var pattern = new RegExp(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/);
            return pattern.test(value);
          }
        );*/



        // --------------------------
        // PQRS FIELDS NAMES VALIDATION
        // --------------------------
        // Pqr field states

        //if ($("#edit-reconsideracion").val() != 'SI') {
          $("#edit-numero-caso").attr("disabled", 'disabled');
        //}
        $("#edit-reconsideracion").change(function(){
          if ($(this).val() != 'SI') {
            $("#edit-numero-caso").attr("disabled", 'disabled');
          }
          else {
            $("#edit-numero-caso").removeAttr('disabled');
          }
        })
        //if ($("#edit-producto--2").val() != 'AUTOS' || $("#edit-producto--2").val() != 'SOAT') {
          $("#edit-placa").attr("disabled", 'disabled');
        //}
        $("#edit-producto--2").change(function(){
          if ($(this).val() == 'AUTOS' || $(this).val() == 'SOAT') {
            $("#edit-placa").removeAttr('disabled');
          }
          else {
            $("#edit-placa").attr("disabled", 'disabled');
          }
        })


        var form = $(".webform-submission-pqr-form"),
            msg_confirm = form.children('.webform-confirmation');

        // Pqr show confirmation message
        if (msg_confirm.length > 0) {
          var ht_tab_pqr = $('.alias--zona-de-cliente-contactanos .cp-tabs .ui-tabs-nav li:nth-child(2)');
          if (ht_tab_pqr.length > 0) {
            ht_tab_pqr.find('.cta a').click();
            let hb = $('.cp-banner__image').height(),
                hct = $('.component__tabs .component__heading').height(),
                scrllForm = 600;
            if (hb && hct) {
              scrllForm = parseInt(hb) + parseInt(hct);
            }
            $('html, body').animate( { scrollTop : scrllForm }, 900);
          }
        }

        // Pqr Implement Jquery validate
        var validate_rules = {
          // Reconsideracion
          'reconsideracion': {
            required: true,
          },
          // Número de caso
          'numero_caso': {
            required: $("#edit-numero-caso").val() != 'SI',
          },
          // Tipo identificacion
          'tipo_de_identificacion': {
            required: true,
          },
          // Número identificacion
          'numero_de_identificacion': {
            required: true,
            number: true,
          },
          // Nombres y apellidos
          'nombres_y_apellidos_razon_social_': {
            required: true,
          },
          // Ciudades
          'ciudad': {
            required: true,
          },
          // Direccion
          'direccion_si': {
            required: true,
          },
          // Celular
          'celular_contacto': {
            required: true,
          },
          // Correo
          'correo_electronico': {
            required: true,
            isValidEmailAddress: true,
          },
          // Producto
          'producto': {
            required: true,
          },
          // Medio de envio
          'medio_envio': {
            required: true,
          },
          // Placa
          'placa': {
            required: true,
          },
          // Descripcion
          'descripcion': {
            required: true,
          },
        };

        var validate_messages = {
          // Reconsideracion
          'reconsideracion': {
            required: 'Este campo es requerido',
          },
          // Número de caso
          'numero_caso': {
            required: 'Este campo es requerido',
          },
          // Tipo identificacion
          'tipo_de_identificacion': {
            required: 'Este campo es requerido',
          },
          // Número identificacion
          'numero_de_identificacion': {
            required: 'Este campo es requerido',
            number: 'Debe ingresar solo números',
          },
          // Nombres y apellidos
          'nombres_y_apellidos_razon_social_': {
            required: 'Este campo es requerido',
          },
          // Ciudades
          'ciudad': {
            required: 'Este campo es requerido',
          },
          // Direccion
          'direccion_si': {
            required: 'Este campo es requerido',
          },
          // Celular
          'celular_contacto': {
            required: 'Este campo es requerido',
          },
          // Correo
          'correo_electronico': {
            required: 'Este campo es requerido',
            isValidEmailAddress: 'Correo electrónico no valido',
          },
          // Producto
          'producto': {
            required: 'Este campo es requerido',
          },
          // Medio de envio
          'medio_envio': {
            required: 'Este campo es requerido',
          },
          // Placa
          'placa': {
            required: 'Este campo es requerido',
          },
          // Descripcion
          'descripcion': {
            required: 'Este campo es requerido',
          },
        };
        form.validate({
          rules: validate_rules,
          messages: validate_messages,
        });
        $.validator.addMethod("isValidEmailAddress",
          function(value, element) {
            var pattern = new RegExp(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/);
            return pattern.test(value);
          }
        );

        // Redirect to page after submit
        /*form.on('submit', function(e) {
          e.preventDefault();
          if (form.find('.error').length === 0) {
            let dataForm = form.serialize(),
              url = form.attr('action');
            $.post(url, dataForm)
            .always(function() {
              document.location.replace("/agradecimiento");
            });
          }
        });*/
      }




      // Message webform ajax inline
      $('.js-form-errors-inline .form-submit').click(function(){
        $(document).ajaxComplete(function() {
          $('.js-form-errors-inline .error').each(function() {
            var el = $(this),
              msn_error = el.attr('data-webform-required-error'),
              parent = el.parents('.form-item');
            if (el.hasClass('js-field-errors-inline')) {
              parent.find('.element-msn-error').remove();
              if (typeof msn_error !== typeof undefined && msn_error !== false) {
                parent.append('<span class="element-msn-error">'+ msn_error +'</span>');
              }
            }
          });
          // reload page on confirmation
          if ($('body').find('.webform-confirmation').length > 0) {
            reload_document(6500);
          }
        })
      });
    }
  }
}) (jQuery, Drupal, this, this.document);
