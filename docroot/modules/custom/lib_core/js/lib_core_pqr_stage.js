(function($) {


    $(document).ready(function() {
        $('#00NG000000998UR').attr('minlength', '5');
        const label = $('.form-type-managed-file');


        console.log(label);
    });

    $('#00NG000000FWynB').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });



    /**
     * [show_confirm_msg description]
     * @param  {[type]} form [description]
     * @return {[type]}      [description]
     */
    function show_confirm_msg(form) {
        var block_msg = $('#block-pqrthankyoumessage');
        if (block_msg.length > 0) {
            var hd_tabs = $('.cp-tabs .cog--mq ul'),
                ht_links_tabs = hd_tabs.find('li .cta a');
            current_url = window.location.protocol + '//' +
                window.location.hostname +
                window.location.pathname;
            if (ht_links_tabs.length > 0) {
                ht_links_tabs.click(function() {
                    block_msg.hide();
                });
            }
            let hb = $('.cp-banner__image').height(),
                hct = $('.component__tabs .component__heading').height(),
                scrllForm = 600;
            if (hb && hct) {
                scrllForm = parseInt(hb) + parseInt(hct);
            }
            $('html, body').animate({ scrollTop: scrllForm }, 900);
            if ($(window).width() < 980) {
                block_msg.addClass('tabs active fix-msg');
                setTimeout(function() {
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
        // Case number
        $("#00N4A00000FkiKp").attr("disabled", 'disabled');
        $("#00NG000000FWyn9").change(function() {
            if ($(this).val() != 'SI') {
                $("#00N4A00000FkiKp").attr("disabled", 'disabled');
            } else {
                $("#00N4A00000FkiKp").removeAttr('disabled');
            }
        })

        // Plaque
        $("#00NG000000998UR").attr("disabled", 'disabled');
        $("#00N4A00000FkiL2").change(function() {
            if ($(this).val() == 'AUTOS' || $(this).val() == 'SOAT') {
                $("#00NG000000998UR").removeAttr('disabled');
            } else {
                $("#00NG000000998UR").attr("disabled", 'disabled');
            }
        })
    }

    /**
     * [validate_form description]
     * @param  {[type]} form [description]
     * @return {[type]}      [description]
     */
    function validate_form(form) {
        // Pqr Implement Jquery validate
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
                number: true,
                minlength: 10,
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
                required: $("#00N4A00000FkiL2").val() != 'AUTOS' &&
                    $("#00N4A00000FkiL2").val() != 'SOAT',
                minlength: 5,
            },
            // Descripcion
            'description': {
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
                number: 'Debe ingresar solo números',
                minlength: 'Por favor escribe mínimo 10 digitos',
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
                minlength: "La placa no puede ser inferior a 6 caracteres",
            },
            // Descripcion
            'description': {
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
    }



    Drupal.behaviors.lib_core_pqr = {
        attach: function(context, settings) {

            //--------------------
            // PQR
            //--------------------
            var form = $("#pqr-form");
            show_confirm_msg(form);
            states_fields();
            validate_form(form);

        }
    }
})(jQuery);