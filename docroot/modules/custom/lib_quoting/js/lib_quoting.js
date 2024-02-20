/**
 * @file
 * Quoting file.
 */

<<<<<<< HEAD
(function ($, Drupal) {'use strict';

  // Globales
  var bool_client_info = false,
=======
(function ($, Drupal) {
  "use strict";

  // Globales
  let bool_client_info = false,
>>>>>>> main
    bool_car_info = false,
    base_url = window.location.origin;

  /**
   * Assign plugin datetime to field
   * @param $arguments
   */

<<<<<<< HEAD
  $('#edit-birthdate')
    .attr('readonly', true)
    .datetimepicker({
      closeText: 'Cerrar',
      currentText: 'Actual',
      dateFormat: 'dd/mm/yy',
      monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio',
        'Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
      monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep',
        'Oct','Nov','Dic'],
      dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes',
        'Sábado'],
      dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
      dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
      changeMonth: true,
      changeYear: true,
      minDate: '-60y',
      maxDate: '-18y',
      yearRange: '1950:2019',
      timepicker: false,
      showTimepicker: false,
      onSelect: function(date, el) {
        $('#' + el.id).parent().addClass('form__input--activo');
=======
  $("#edit-birthdate")
    .attr("readonly", true)
    .datetimepicker({
      closeText: "Cerrar",
      currentText: "Actual",
      dateFormat: "dd/mm/yy",
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
      changeMonth: true,
      changeYear: true,
      minDate: "-60y",
      maxDate: "-18y",
      yearRange: "1950:2019",
      timepicker: false,
      showTimepicker: false,
      onSelect: function (date, el) {
        $("#" + el.id)
          .parent()
          .addClass("form__input--activo");
>>>>>>> main
      },
    });

  /**
   * Consume assig client info
   * @param $arguments
   */
  function assign_client_info($form, info) {
<<<<<<< HEAD
    var $fld_names = $form.find('#edit-names'),
        $fld_lastnames = $form.find('#edit-lastnames'),
        $fld_gender_m = $form.find('#edit-gender-masculino'),
        $fld_gender_f = $form.find('#edit-gender-femenino'),
        $fld_mail = $form.find('#edit-mail'),
        $fld_cellphone = $form.find('#edit-cellphone'),
        $fld_birthdate = $form.find('#edit-birthdate');

    var $fld_mkp_names = $form.find('.mkp-field-names .content'),
        $fld_mkp_lastnames = $form.find('.mkp-field-lastnames .content'),
        $fld_mkp_gender = $form.find('.mkp-field-gender'),
        $fld_mkp_mail = $form.find('.mkp-field-mail .content'),
        $fld_mkp_cellphone = $form.find('.mkp-field-cellphone .content'),
        $fld_mkp_birthdate = $form.find('.mkp-field-birthdate .content');

    $form.find('.step1 .field-markup').hide();

    if (!$.isEmptyObject(info)) {
      bool_client_info = true;
      $form.find('.step1 .field-markup').show();

      $fld_names
      .val(info.names).parent().hide();
      $fld_mkp_names.text($fld_names.val());

      $fld_lastnames
      .val(info.lastnames).parent().hide();
      $fld_mkp_lastnames.text($fld_lastnames.val());

      $fld_gender_f
      .attr('checked', 'checked');
      $fld_gender_m.removeAttr('checked')
      .attr('disabled', 'disabled')
      .parents('.form-item-gender').hide();
      $fld_mkp_gender.find('.female').addClass('active');

      $fld_mail
      .val(info.mail).parent().hide();
      $fld_mkp_mail.text($fld_mail.val());

      $fld_cellphone
      .val(info.cellphone).parent().hide();
      $fld_mkp_cellphone.text($fld_cellphone.val());

      $fld_birthdate
      .val(info.birthdate).parent().hide();
=======
    let $fld_names = $form.find("#edit-names"),
      $fld_lastnames = $form.find("#edit-lastnames"),
      $fld_gender_m = $form.find("#edit-gender-masculino"),
      $fld_gender_f = $form.find("#edit-gender-femenino"),
      $fld_mail = $form.find("#edit-mail"),
      $fld_cellphone = $form.find("#edit-cellphone"),
      $fld_birthdate = $form.find("#edit-birthdate");

    let $fld_mkp_names = $form.find(".mkp-field-names .content"),
      $fld_mkp_lastnames = $form.find(".mkp-field-lastnames .content"),
      $fld_mkp_gender = $form.find(".mkp-field-gender"),
      $fld_mkp_mail = $form.find(".mkp-field-mail .content"),
      $fld_mkp_cellphone = $form.find(".mkp-field-cellphone .content"),
      $fld_mkp_birthdate = $form.find(".mkp-field-birthdate .content");

    $form.find(".step1 .field-markup").hide();

    if (!$.isEmptyObject(info)) {
      bool_client_info = true;
      $form.find(".step1 .field-markup").show();

      $fld_names.val(info.names).parent().hide();
      $fld_mkp_names.text($fld_names.val());

      $fld_lastnames.val(info.lastnames).parent().hide();
      $fld_mkp_lastnames.text($fld_lastnames.val());

      $fld_gender_f.attr("checked", "checked");
      $fld_gender_m
        .removeAttr("checked")
        .attr("disabled", "disabled")
        .parents(".form-item-gender")
        .hide();
      $fld_mkp_gender.find(".female").addClass("active");

      $fld_mail.val(info.mail).parent().hide();
      $fld_mkp_mail.text($fld_mail.val());

      $fld_cellphone.val(info.cellphone).parent().hide();
      $fld_mkp_cellphone.text($fld_cellphone.val());

      $fld_birthdate.val(info.birthdate).parent().hide();
>>>>>>> main
      $fld_mkp_birthdate.text($fld_birthdate.val());
    }
  }

<<<<<<< HEAD

=======
>>>>>>> main
  /**
   * Execute web services AXIS - SISA
   * @param $arguments
   */
  function assign_car_info(form, info, info_arr, vehicle) {
<<<<<<< HEAD

    var $fld_vehicle_use = form.find('#edit-vehicle-use'),
        $fld_vehicle_brand = form.find('#edit-vehicle-brand'),
        $fld_vehicle_class = form.find('#edit-vehicle-class'),
        $fld_vehicle_version = form.find('#edit-vehicle-version'),
        $fld_vehicle_type = form.find('#edit-vehicle-type'),
        $fld_vehicle_model = form.find('#edit-vehicle-model'),
        $fld_vehicle_com_value = form.find('#edit-vehicle-com-value');

    var $fld_mkp_vehicle_brand = form.find('.mkp-field-brand .content'),
        $fld_mkp_vehicle_class = form.find('.mkp-field-class .content'),
        $fld_mkp_vehicle_version = form.find('.mkp-field-version .content'),
        $fld_mkp_vehicle_type = form.find('.mkp-field-type .content'),
        $fld_mkp_vehicle_model = form.find('.mkp-field-model .content'),
        $fld_mkp_vehicle_com_value = form.find('.mkp-field-com-value .content');
=======
    let $fld_vehicle_use = form.find("#edit-vehicle-use"),
      $fld_vehicle_brand = form.find("#edit-vehicle-brand"),
      $fld_vehicle_class = form.find("#edit-vehicle-class"),
      $fld_vehicle_version = form.find("#edit-vehicle-version"),
      $fld_vehicle_type = form.find("#edit-vehicle-type"),
      $fld_vehicle_model = form.find("#edit-vehicle-model"),
      $fld_vehicle_com_value = form.find("#edit-vehicle-com-value");

    let $fld_mkp_vehicle_brand = form.find(".mkp-field-brand .content"),
      $fld_mkp_vehicle_class = form.find(".mkp-field-class .content"),
      $fld_mkp_vehicle_version = form.find(".mkp-field-version .content"),
      $fld_mkp_vehicle_type = form.find(".mkp-field-type .content"),
      $fld_mkp_vehicle_model = form.find(".mkp-field-model .content"),
      $fld_mkp_vehicle_com_value = form.find(".mkp-field-com-value .content");
>>>>>>> main

    if (!$.isEmptyObject(info)) {
      if (!info.veh_brand) {
        $fld_mkp_vehicle_brand.parent().hide();
      } else {
<<<<<<< HEAD
        $fld_vehicle_brand
          .val(info.veh_brand);
=======
        $fld_vehicle_brand.val(info.veh_brand);
>>>>>>> main
        $fld_mkp_vehicle_brand.text($fld_vehicle_brand.val());
        $fld_mkp_vehicle_brand.parent().show();
        $fld_vehicle_brand.parent().hide();
      }
      if (!info.veh_class) {
        $fld_mkp_vehicle_class.parent().hide();
      } else {
        $fld_vehicle_class.val(info.veh_class);
        $fld_mkp_vehicle_class.text(info.veh_class);
        $fld_mkp_vehicle_class.parent().show();
        $fld_vehicle_class.parent().hide();
      }

      if (!info.veh_version) {
        $fld_mkp_vehicle_version.parent().hide();
      } else {
<<<<<<< HEAD
        $fld_vehicle_version
          .val(info.veh_version);
=======
        $fld_vehicle_version.val(info.veh_version);
>>>>>>> main
        $fld_mkp_vehicle_version.text($fld_vehicle_version.val());
        $fld_mkp_vehicle_version.parent().show();
        $fld_vehicle_version.parent().hide();
      }
      if (!info.veh_type) {
        $fld_mkp_vehicle_type.parent().hide();
      } else {
<<<<<<< HEAD
        $fld_vehicle_type
          .val(info.veh_type);
=======
        $fld_vehicle_type.val(info.veh_type);
>>>>>>> main
        $fld_mkp_vehicle_type.text($fld_vehicle_type.val());
        $fld_mkp_vehicle_type.parent().show();
        $fld_vehicle_type.parent().hide();
      }
      if (!info.veh_model) {
        $fld_mkp_vehicle_model.parent().hide();
      } else {
<<<<<<< HEAD
        $fld_vehicle_model
          .val(info.veh_model);
=======
        $fld_vehicle_model.val(info.veh_model);
>>>>>>> main
        $fld_mkp_vehicle_model.text($fld_vehicle_model.val());
        $fld_mkp_vehicle_model.parent().show();
        $fld_vehicle_model.parent().hide();
      }
      if (!info.veh_com_value) {
        $fld_mkp_vehicle_com_value.parent().hide();
      } else {
<<<<<<< HEAD
        $fld_vehicle_com_value
          .val(info.veh_com_value);
=======
        $fld_vehicle_com_value.val(info.veh_com_value);
>>>>>>> main
        $fld_mkp_vehicle_com_value.text($fld_vehicle_com_value.val());
        $fld_mkp_vehicle_com_value.parent().show();
        $fld_vehicle_com_value.parent().hide();
      }
    } else {
      $fld_mkp_vehicle_brand.parent().hide();
      $fld_mkp_vehicle_class.parent().hide();
      $fld_mkp_vehicle_version.parent().hide();
      $fld_mkp_vehicle_type.parent().hide();
      $fld_mkp_vehicle_model.parent().hide();
      $fld_mkp_vehicle_com_value.parent().hide();
    }

<<<<<<< HEAD

    if (info_arr !== undefined) {
    // Hidden fields
=======
    if (info_arr !== undefined) {
      // Hidden fields
>>>>>>> main
      if (info_arr[2]) {
        form.append(
          '<input type="hidden" name="vehicle_code" value="' +
            info_arr[2] +
            '">'
        );
        form.append(
          '<input type="hidden" name="vehicle_marc" value="' +
            info_arr[2].substring(0, 3) +
            '">'
        );
        form.append(
          '<input type="hidden" name="vehicle_class" value="' +
            info_arr[2].substring(4, 5) +
            '">'
        );
      }
      if (info_arr[7]) {
        form.append(
          '<input type="hidden" name="vehicle_grouper" value="' +
            info_arr[7] +
            '">'
        );
      }
      if (info_arr[5]) {
<<<<<<< HEAD
        var today = new Date();
=======
        let today = new Date();
>>>>>>> main
        form.append(
          '<input type="hidden" name="vehicle_age" value="' +
            (today.getFullYear() - info_arr[5]) +
            '">'
        );
      }
      if (info_arr[9]) {
        form.append(
          '<input type="hidden" name="vehicle_displacement" value="' +
            info_arr[9] +
            '">'
        );
      }
      if (info_arr[8]) {
        form.append(
          '<input type="hidden" name="vehicle_doors" value="' +
            info_arr[8] +
            '">'
        );
      }
      if (info_arr[11]) {
        form.append(
          '<input type="hidden" name="vehicle_weight" value="' +
            info_arr[11] +
            '">'
        );
      }
      if (info_arr[10]) {
        form.append(
          '<input type="hidden" name="vehicle_fuel" value="' +
            info_arr[10] +
            '">'
        );
      }
      if (info_arr[12]) {
        form.append(
          '<input type="hidden" name="vehicle_gear_box" value="' +
            info_arr[12] +
            '">'
        );
      }
      if (info_arr[13]) {
        form.append(
          '<input type="hidden" name="vehicle_transmition" value="' +
            info_arr[13] +
            '">'
        );
      }
      if (vehicle !== undefined) {
        if (vehicle.identificacion.motor) {
          form.append(
            '<input type="hidden" name="vehicle_motor" value="' +
              vehicle.identificacion.motor +
              '">'
          );
        }
        if (vehicle.identificacion.chasis) {
          form.append(
            '<input type="hidden" name="vehicle_chasis" value="' +
              vehicle.identificacion.chasis +
              '">'
          );
        }
        if (vehicle.otrosDatos.transportaCombustible) {
          form.append(
            '<input type="hidden" name="vehicle_transmition" value="' +
<<<<<<< HEAD
              (vehicle.otrosDatos.transportaCombustible === 0 ? 'No' : 'Si') +
=======
              (vehicle.otrosDatos.transportaCombustible === 0 ? "No" : "Si") +
>>>>>>> main
              '">'
          );
        }
      }
    }
  }

  /**
   * Consume web services AXIS - SISA
   * @param val_plate_type
   * @param val_num_plate
   */
  function consume_ws_car_info(data, $form, step) {
<<<<<<< HEAD
    var info = {},
      bool_ws_car_info = 1;

    $('.form-item-vehicle-use')
      .addClass('form__input--activo')
      .find('select')
      .attr('disabled', true);

    if (data) { {

        if (data.vehicle_info.vehiculoEncontradoIAXIS) {
          get_fasecolda($form, data.vehicle_info.datosVehiculo);
        }
        else {
          var sisa_data = {},
            val_plate_type = $form.find('#edit-type-plate').val(),
            val_num_plate = $form.find('#edit-num-plate').val();

          $.post('/api/query_auto_sisa', {
              'type_plate': val_plate_type,
              'plate': val_num_plate
            })
            .done(function(data) {
              if (data.vehicle_info.HistoricoPolizaSisa !== null) {
                sisa_data['identificacion'] = {
                  'codigoFasecolda': data.vehicle_info.HistoricoPolizaSisa[0].CodigoGuia,
                  'descripcion': data.vehicle_info.HistoricoPolizaSisa[0].Tipo,
                  'modelo': data.vehicle_info.HistoricoPolizaSisa[0].Modelo
                };
                sisa_data['otrosDatos'] = {
                  'valor': data.vehicle_info.HistoricoPolizaSisa[0].ValorAsegurado
                };
                get_fasecolda($form, sisa_data);
              }
              else {
                $('.wrapper-form-step2').find('.field-markup').hide();
              }
            })
            .fail(function() {
              $('.wrapper-form-error h3')
                .html('<span>Error - 10500</span> | Servicio de consulta, temporalmente fuera de línea. Intente de nuevo en unos minutos');
              $('.wrapper-form-step1').removeClass('active').addClass('hidden');
              $('.wrapper-form-error').addClass('active').fadeIn('fast');
            });
        }
      };
    }
  }

  var get_fasecolda = (function(form, vehicle) {
    var info = {},
      info_arr = new Array(),
      v_brand = form.find('.mkp-field-brand .content'),
      v_class = form.find('.mkp-field-class .content'),
      v_version = form.find('.mkp-field-version .content'),
      url_info = base_url +
        '/vehicle-get-info-fasecolda/' +
        vehicle.identificacion.codigoFasecolda + '/' +
=======
    let info = {},
      bool_ws_car_info = 1;

    $(".form-item-vehicle-use")
      .addClass("form__input--activo")
      .find("select")
      .attr("disabled", true);

    if (data) {
      {
        if (data.vehicle_info.vehiculoEncontradoIAXIS) {
          get_fasecolda($form, data.vehicle_info.datosVehiculo);
        } else {
          let sisa_data = {},
            val_plate_type = $form.find("#edit-type-plate").val(),
            val_num_plate = $form.find("#edit-num-plate").val();

          $.post("/api/query_auto_sisa", {
            type_plate: val_plate_type,
            plate: val_num_plate,
          })
            .done(function (data) {
              if (data.vehicle_info.HistoricoPolizaSisa !== null) {
                sisa_data["identificacion"] = {
                  codigoFasecolda:
                    data.vehicle_info.HistoricoPolizaSisa[0].CodigoGuia,
                  descripcion: data.vehicle_info.HistoricoPolizaSisa[0].Tipo,
                  modelo: data.vehicle_info.HistoricoPolizaSisa[0].Modelo,
                };
                sisa_data["otrosDatos"] = {
                  valor:
                    data.vehicle_info.HistoricoPolizaSisa[0].ValorAsegurado,
                };
                get_fasecolda($form, sisa_data);
              } else {
                $(".wrapper-form-step2").find(".field-markup").hide();
              }
            })
            .fail(function () {
              $(".wrapper-form-error h3").html(
                "<span>Error - 10500</span> | Servicio de consulta, temporalmente fuera de línea. Intente de nuevo en unos minutos"
              );
              $(".wrapper-form-step1").removeClass("active").addClass("hidden");
              $(".wrapper-form-error").addClass("active").fadeIn("fast");
            });
        }
      }
    }
  }

  let get_fasecolda = function (form, vehicle) {
    let info = {},
      info_arr = new Array(),
      v_brand = form.find(".mkp-field-brand .content"),
      v_class = form.find(".mkp-field-class .content"),
      v_version = form.find(".mkp-field-version .content"),
      url_info =
        base_url +
        "/vehicle-get-info-fasecolda/" +
        vehicle.identificacion.codigoFasecolda +
        "/" +
>>>>>>> main
        vehicle.identificacion.modelo,
      date = new Date(),
      year = date.getFullYear();

    $.getJSON(url_info, function (data) {
      if (Object.keys(data).length > 0) {
<<<<<<< HEAD
        info_arr = data[vehicle.identificacion.codigoFasecolda].split('|');
=======
        info_arr = data[vehicle.identificacion.codigoFasecolda].split("|");
>>>>>>> main
        v_brand.text(info_arr[0]);
        v_class.text(info_arr[3]);
        v_version.text(info_arr[1]);

        info = {
<<<<<<< HEAD
          'veh_brand': v_brand.text(),
          'veh_class': v_class.text(),
          'veh_version': v_version.text(),
          'veh_type': vehicle.identificacion.descripcion,
          'veh_model': vehicle.identificacion.modelo,
          'veh_com_value': vehicle.otrosDatos.valor,
=======
          veh_brand: v_brand.text(),
          veh_class: v_class.text(),
          veh_version: v_version.text(),
          veh_type: vehicle.identificacion.descripcion,
          veh_model: vehicle.identificacion.modelo,
          veh_com_value: vehicle.otrosDatos.valor,
>>>>>>> main
        };

        // Validate value
        if (vehicle.otrosDatos.valor > 200000000) {
<<<<<<< HEAD
          $('.wrapper-form-step1').removeClass('active').addClass('hidden');
          $('.wrapper-form-error').addClass('active').fadeIn('fast');
=======
          $(".wrapper-form-step1").removeClass("active").addClass("hidden");
          $(".wrapper-form-error").addClass("active").fadeIn("fast");
>>>>>>> main
          return false;
        }

        // Validate vehicle age
<<<<<<< HEAD
        if ((year - vehicle.identificacion.modelo) > 30) {
          $('.wrapper-form-step1').removeClass('active').addClass('hidden');
          $('.wrapper-form-error').addClass('active').fadeIn('fast');
=======
        if (year - vehicle.identificacion.modelo > 30) {
          $(".wrapper-form-step1").removeClass("active").addClass("hidden");
          $(".wrapper-form-error").addClass("active").fadeIn("fast");
>>>>>>> main
          return false;
        }
        assign_car_info(form, info, info_arr, vehicle);

<<<<<<< HEAD
        form.find('.find-vehicle').parent().remove();
      }
      else {
=======
        form.find(".find-vehicle").parent().remove();
      } else {
>>>>>>> main
        assign_car_info(form, info);
      }
    });

    return info;
<<<<<<< HEAD
  });
=======
  };
>>>>>>> main

  /**
   * Consume web services get quoting value
   * @param $form
   */
  function consume_ws_get_quoting_value($form) {
<<<<<<< HEAD
    var data = $form.serialize();

     $(document)
      .ajaxStart(function() {
        $('.content-steps').addClass('opacity-loading');
        $('.loading').fadeIn('fast');
      });

    $.post('/api/query_policy', data)
      .done(function(info) {
        var valor_total = info.policy_info[0][5][1][1],
          valor_mensual = Math.round(valor_total / 12),
          valor_anual = info.policy_info[0][1][1][1],
          valor_expedicion = info.policy_info[0][3][1][1],
          valor_iva = (info.policy_info[0][2][1][1] + info.policy_info[0][4][1][1]);

        $('.prima_mensual').html('$ ' + valor_mensual.toLocaleString());
        $('.prima_total').html('$ ' + valor_total.toLocaleString());

        $form.append(
          '<input type="hidden" name="price_total" value="' +
            valor_total +
            '">'
        );
        $form.append(
          '<input type="hidden" name="price_anual" value="' +
            valor_anual +
            '">'
=======
    let data = $form.serialize();

    $(document).ajaxStart(function () {
      $(".content-steps").addClass("opacity-loading");
      $(".loading").fadeIn("fast");
    });

    $.post("/api/query_policy", data)
      .done(function (info) {
        let valor_total = info.policy_info[0][5][1][1],
          valor_mensual = Math.round(valor_total / 12),
          valor_anual = info.policy_info[0][1][1][1],
          valor_expedicion = info.policy_info[0][3][1][1],
          valor_iva =
            info.policy_info[0][2][1][1] + info.policy_info[0][4][1][1];

        $(".prima_mensual").html("$ " + valor_mensual.toLocaleString());
        $(".prima_total").html("$ " + valor_total.toLocaleString());

        $form.append(
          '<input type="hidden" name="price_total" value="' + valor_total + '">'
        );
        $form.append(
          '<input type="hidden" name="price_anual" value="' + valor_anual + '">'
>>>>>>> main
        );
        $form.append(
          '<input type="hidden" name="price_expedition" value="' +
            valor_expedicion +
            '">'
        );
        $form.append(
<<<<<<< HEAD
          '<input type="hidden" name="price_iva" value="' +
            valor_iva +
            '">'
        );
      })
      .fail(function() {
        $('.wrapper-form-error h3')
          .html('<span>Error - 10500</span> | Servicio de consulta, temporalmente fuera de línea. Intente de nuevo en unos minutos');
        $('.wrapper-form-step1').removeClass('active').addClass('hidden');
        $('.wrapper-form-error').addClass('active').fadeIn('fast');
      });
  }


=======
          '<input type="hidden" name="price_iva" value="' + valor_iva + '">'
        );
      })
      .fail(function () {
        $(".wrapper-form-error h3").html(
          "<span>Error - 10500</span> | Servicio de consulta, temporalmente fuera de línea. Intente de nuevo en unos minutos"
        );
        $(".wrapper-form-step1").removeClass("active").addClass("hidden");
        $(".wrapper-form-error").addClass("active").fadeIn("fast");
      });
  }

>>>>>>> main
  /**
   * Consume web services get quoting value
   * @param $form
   */
  function assign_options_to_field_select($field, opts, val_dflt) {
    $field.empty();
    $.each(opts, function (i, item) {
<<<<<<< HEAD
      $field.append($('<option>',{
        value: i,
        text : item
      }));
=======
      $field.append(
        $("<option>", {
          value: i,
          text: item,
        })
      );
>>>>>>> main
    });
    if (val_dflt !== undefined) {
      $field.val($val_dflt);
    }
  }

  /**
   * Autocomplete fields
   * @param element
   * @param url
   * @param $field
   */
  function customAutocomplete(element, url, $form) {
<<<<<<< HEAD
    $(document)
      .ajaxStart(function() {
        $('.content-steps').removeClass('opacity-loading');
        $('.loading').hide();
      });
=======
    $(document).ajaxStart(function () {
      $(".content-steps").removeClass("opacity-loading");
      $(".loading").hide();
    });
>>>>>>> main

    element.autocomplete({
      source: function (request, response) {
        $.getJSON(url, function (data) {
<<<<<<< HEAD
          response($.map(data, function (v, k) {
            return {
              value: v.value,
              id: v.id,
              code: v.code
            }
          }));
=======
          response(
            $.map(data, function (v, k) {
              return {
                value: v.value,
                id: v.id,
                code: v.code,
              };
            })
          );
>>>>>>> main
        });
      },
      minLength: 2,
      select: function (event, ui) {
<<<<<<< HEAD
        if (element.hasClass('find-vehicle')) {
          var url_info = base_url + '/vehicle-get-info/' + ui.item.id;
          $.getJSON(url_info, function (data) {
            var info_arr = data[ui.item.id].split('|');
            var info = {
              'veh_brand': info_arr[0],
              'veh_class': info_arr[3],
              'veh_version': info_arr[1],
              'veh_type': info_arr[4],
              'veh_model': info_arr[5],
              'veh_com_value': info_arr[6],
=======
        if (element.hasClass("find-vehicle")) {
          let url_info = base_url + "/vehicle-get-info/" + ui.item.id;
          $.getJSON(url_info, function (data) {
            let info_arr = data[ui.item.id].split("|");
            let info = {
              veh_brand: info_arr[0],
              veh_class: info_arr[3],
              veh_version: info_arr[1],
              veh_type: info_arr[4],
              veh_model: info_arr[5],
              veh_com_value: info_arr[6],
>>>>>>> main
            };
            return assign_car_info($form, info, info_arr);
          });
        }
        this.value = ui.item.value;
        if (ui.item.code !== undefined) {
          $form.append(
            '<input type="hidden" name="city_code" value="' +
              ui.item.code +
              '">'
          );
        }
      },
    });
  }

  /**
   * Consume web services AXIS
   * @param $field
   */
  function check_fields_values($step, $form) {
<<<<<<< HEAD
    var bool_resp = false;
    if ($step == '1') {
      var val_doc_type = $form.find('#edit-type-doc').val(),
        val_num_doc = $form.find('#edit-num-doc').val(),
        val_plate_type = $form.find('#edit-type-plate').val(),
        val_num_plate = $form.find('#edit-num-plate').val(),
        val_names = $form.find('#edit-names').val(),
        val_lastnames = $form.find('#edit-lastnames').val(),
        val_mail = $form.find('#edit-mail').val(),
        val_cell = $form.find('#edit-cellphone').val(),
        val_city = $form.find('#edit-circulation-city').val();
      if (val_doc_type && val_num_doc && val_plate_type && val_num_plate && val_names
       && val_lastnames && val_mail && val_cell && val_city) {
        bool_resp = true;
      }
    }
    else if ($step == '2') {
      var val_veh_use = $form.find('#edit-vehicle-use').val(),
        val_veh_brand = $form.find('#edit-vehicle-brand').val();
=======
    let bool_resp = false;
    if ($step == "1") {
      let val_doc_type = $form.find("#edit-type-doc").val(),
        val_num_doc = $form.find("#edit-num-doc").val(),
        val_plate_type = $form.find("#edit-type-plate").val(),
        val_num_plate = $form.find("#edit-num-plate").val(),
        val_names = $form.find("#edit-names").val(),
        val_lastnames = $form.find("#edit-lastnames").val(),
        val_mail = $form.find("#edit-mail").val(),
        val_cell = $form.find("#edit-cellphone").val(),
        val_city = $form.find("#edit-circulation-city").val();
      if (
        val_doc_type &&
        val_num_doc &&
        val_plate_type &&
        val_num_plate &&
        val_names &&
        val_lastnames &&
        val_mail &&
        val_cell &&
        val_city
      ) {
        bool_resp = true;
      }
    } else if ($step == "2") {
      let val_veh_use = $form.find("#edit-vehicle-use").val(),
        val_veh_brand = $form.find("#edit-vehicle-brand").val();
>>>>>>> main
      if (val_veh_use && val_veh_brand) {
        bool_resp = true;
      }
    }
    return bool_resp;
  }

  /** Calculate age */
  function getAge(birthDate) {
<<<<<<< HEAD
      var today = new Date(),
        newDate = birthDate.split('/').reverse().join('-'),
        birthDate = new Date(newDate),
        age = today.getFullYear() - birthDate.getFullYear(),
        m = today.getMonth() - birthDate.getMonth();
      if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age = age - 1;
      }
      return age;
  }

  var filled = {},
    alfa_numeric = /^([a-zA-Z0-9]+)$/,
    col_plate = /\b[a-zA-Z]{3}\d{3}\b/,
    only_digits = /^\d+$/,
    digits_doc_type = ['36', '35', '34'],
    plate_col_type = '12';

  $('.wrapper-form-step1')
    .find('#edit-use-data, #edit-type-doc, #edit-num-doc, #edit-type-plate, #edit-num-plate')
      .on('change', function() {
        var inp = $(this);

        if (inp.hasClass('form-checkbox')) {
          if (inp.is(':checked')) {
            filled.edit_use_data = 1;
          }
          else {
            delete filled.edit_use_data;
          }
        }
        else {
          var el = inp.attr('id'),
            valid = true,
            message_invalid,
            valid_el;

          switch (el) {
            case 'edit-num-doc':
              if (digits_doc_type.indexOf($('#edit-type-doc').val()) >= 0) {
                valid = only_digits.test(inp.val());
                message_invalid = 'Solo se aceptan n\xFAmeros';
              }
              else {
                valid = alfa_numeric.test(inp.val());
                message_invalid = 'Solo se aceptan letras y n\xFAmeros';
              }
              valid_el = $('#edit-num-doc');
              break;
            case 'edit-num-plate':
              if ($('#edit-type-plate').val() === plate_col_type) {
                valid = col_plate.test(inp.val());
                message_invalid = 'Solo se aceptan placas en formato ABC123';
              }
              else {
                valid = alfa_numeric.test(inp.val());
                message_invalid = 'Solo se aceptan letras y n\xFAmeros';
              }
              valid_el = $('#edit-num-plate');
              break;
            case 'edit-type-doc':
              $('#edit-num-doc').val('');
              valid_el = $('#edit-num-doc');
              break;
            case 'edit-type-plate':
              $('#edit-num-plate').val('');
              valid_el = $('#edit-num-plate');
              break;
          }

          if (inp.val() !== '' && valid) {
            filled[el] = inp.val();
            valid_el
              .removeClass('error')
              .parent()
              .find('label.error')
              .remove();
          }
          else {
            delete filled[el];
            valid_el
              .addClass('error')
              .parent()
              .append('<label id="field-error-' + el +
                '" class="error" for="field">' + message_invalid +
                '</label>'
              );
          }
        }

        if (Object.keys(filled).length === 5) {
          $('#edit-next')
            .removeAttr('disabled');
        }
        else {
          $('#edit-next')
            .attr('disabled', 'disabled');
        }
      });

  Drupal.behaviors.lib_quoting = {
    attach: function (context) {

      $(document)
        .ajaxStart(function() {
          $('.content-steps').addClass('opacity-loading');
          $('.loading').fadeIn('fast');
        })
        .ajaxStop(function() {
          $('.content-steps').removeClass('opacity-loading');
          $('.loading').fadeOut('fast');
        });

      var $form = $('#autos-quoting-form'),
        $ctn_hd_flds = $form.find('.content-hd-fields'),
        $fld_birthdate = $form.find('#edit-birthdate'),
        $fld_autocomplete = $form.find('.field-autocomplete'),
        $fld_type = $form.find('#edit-vehicle-type'),
        $fld_class = $form.find('#edit-vehicle-class'),
        $fld_model = $form.find('#edit-vehicle-model');
        // $fld_model = $form.find('#edit-vehicle-model');

      $fld_autocomplete
        .bind('paste', function(e) {
          setTimeout(function() {
            $(this).trigger('keyup');
          }
          , 30);
        })
        .keyup(function() {
          var url;
          if ($(this).hasClass('cir-city')) {
            url = base_url + '/vehicle-circulation-city-autocomplete/' + $(this).val();
          }
          else if ($(this).hasClass('find-vehicle')) {
            url = base_url + '/vehicle-label-autocomplete/' + $(this).val();
=======
    let today = new Date(),
      newDate = birthDate.split("/").reverse().join("-"),
      birthDate = new Date(newDate),
      age = today.getFullYear() - birthDate.getFullYear(),
      m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
      age = age - 1;
    }
    return age;
  }

  let filled = {},
    alfa_numeric = /^([a-zA-Z0-9]+)$/,
    col_plate = /\b[a-zA-Z]{3}\d{3}\b/,
    only_digits = /^\d+$/,
    digits_doc_type = ["36", "35", "34"],
    plate_col_type = "12";

  $(".wrapper-form-step1")
    .find(
      "#edit-use-data, #edit-type-doc, #edit-num-doc, #edit-type-plate, #edit-num-plate"
    )
    .on("change", function () {
      let inp = $(this);

      if (inp.hasClass("form-checkbox")) {
        if (inp.is(":checked")) {
          filled.edit_use_data = 1;
        } else {
          delete filled.edit_use_data;
        }
      } else {
        let el = inp.attr("id"),
          valid = true,
          message_invalid,
          valid_el;

        switch (el) {
          case "edit-num-doc":
            if (digits_doc_type.indexOf($("#edit-type-doc").val()) >= 0) {
              valid = only_digits.test(inp.val());
              message_invalid = "Solo se aceptan n\xFAmeros";
            } else {
              valid = alfa_numeric.test(inp.val());
              message_invalid = "Solo se aceptan letras y n\xFAmeros";
            }
            valid_el = $("#edit-num-doc");
            break;
          case "edit-num-plate":
            if ($("#edit-type-plate").val() === plate_col_type) {
              valid = col_plate.test(inp.val());
              message_invalid = "Solo se aceptan placas en formato ABC123";
            } else {
              valid = alfa_numeric.test(inp.val());
              message_invalid = "Solo se aceptan letras y n\xFAmeros";
            }
            valid_el = $("#edit-num-plate");
            break;
          case "edit-type-doc":
            $("#edit-num-doc").val("");
            valid_el = $("#edit-num-doc");
            break;
          case "edit-type-plate":
            $("#edit-num-plate").val("");
            valid_el = $("#edit-num-plate");
            break;
        }

        if (inp.val() !== "" && valid) {
          filled[el] = inp.val();
          valid_el.removeClass("error").parent().find("label.error").remove();
        } else {
          delete filled[el];
          valid_el
            .addClass("error")
            .parent()
            .append(
              '<label id="field-error-' +
                el +
                '" class="error" for="field">' +
                message_invalid +
                "</label>"
            );
        }
      }

      if (Object.keys(filled).length === 5) {
        $("#edit-next").removeAttr("disabled");
      } else {
        $("#edit-next").attr("disabled", "disabled");
      }
    });

  Drupal.behaviors.lib_quoting = {
    attach: function (context) {
      $(document)
        .ajaxStart(function () {
          $(".content-steps").addClass("opacity-loading");
          $(".loading").fadeIn("fast");
        })
        .ajaxStop(function () {
          $(".content-steps").removeClass("opacity-loading");
          $(".loading").fadeOut("fast");
        });

      let $form = $("#autos-quoting-form"),
        $ctn_hd_flds = $form.find(".content-hd-fields"),
        $fld_birthdate = $form.find("#edit-birthdate"),
        $fld_autocomplete = $form.find(".field-autocomplete"),
        $fld_type = $form.find("#edit-vehicle-type"),
        $fld_class = $form.find("#edit-vehicle-class"),
        $fld_model = $form.find("#edit-vehicle-model");
      // $fld_model = $form.find('#edit-vehicle-model');

      $fld_autocomplete
        .bind("paste", function (e) {
          setTimeout(function () {
            $(this).trigger("keyup");
          }, 30);
        })
        .keyup(function () {
          let url;
          if ($(this).hasClass("cir-city")) {
            url =
              base_url +
              "/vehicle-circulation-city-autocomplete/" +
              $(this).val();
          } else if ($(this).hasClass("find-vehicle")) {
            url = base_url + "/vehicle-label-autocomplete/" + $(this).val();
>>>>>>> main
          }
          customAutocomplete($(this), url, $form);
        });

<<<<<<< HEAD
      $('#edit-type-doc').on('change', function() {
        var list_type = {
          36: 'CC',
          33: 'CE',
          44: 'CD',
          40: 'Pasaporte',
          34: 'TI',
          35: 'RC',
          38: 'NUIP',
          37: 'NIT'
        }
        $('.type_doc').remove();
=======
      $("#edit-type-doc").on("change", function () {
        let list_type = {
          36: "CC",
          33: "CE",
          44: "CD",
          40: "Pasaporte",
          34: "TI",
          35: "RC",
          38: "NUIP",
          37: "NIT",
        };
        $(".type_doc").remove();
>>>>>>> main
        $form.append(
          '<input type="hidden" name="type_doc" class="type_doc" value="' +
            list_type[$(this).val()] +
            '">'
        );
      });

<<<<<<< HEAD
      $('#edit-birthdate').on('change', function() {
        $('.age').remove();
=======
      $("#edit-birthdate").on("change", function () {
        $(".age").remove();
>>>>>>> main
        $form.append(
          '<input type="hidden" name="age" class="age" value="' +
            getAge($(this).val()) +
            '">'
        );
      });

<<<<<<< HEAD
      $('.submit-next').click(function(e) {
        e.preventDefault();

        var step = $(this).attr('step'),
          bool_check_flds_vals;

        switch(step) {
          case '1':
            var val_doc_type = $form.find('#edit-type-doc').val(),
              val_num_doc = $form.find('#edit-num-doc').val(),
              val_plate_type = $form.find('#edit-type-plate').val(),
              val_num_plate = $form.find('#edit-num-plate').val();

            if ($('#edit-num-plate').hasClass('error')) {
              return false;
            }

            if ($ctn_hd_flds.hasClass('hidden')) {
              if (val_doc_type && val_num_doc && val_plate_type && val_num_plate) {
                // Ws 1 - client info

                $.post(
                  '/api/query_person', {
                    'document_type': val_doc_type,
                    'document_number': val_num_doc
                  }, function(data) {

                    if (!data.person_info.personaRestringida) {
                       // Validate vehicle
                      $.post('/api/query_auto', {
                          'type_plate': val_plate_type,
                          'plate': val_num_plate
                        })
                        .done(function(info_auto) {
                          if (info_auto.vehicle_info.vehiculoRestringido === true ||
                              info_auto.vehicle_info.vehiculoActivoIAXIS === true) {
                            $('.wrapper-form-step1').removeClass('active').addClass('hidden');
                            $('.wrapper-form-error').addClass('active').fadeIn('fast');
                          }
                          else {
                            consume_ws_car_info(info_auto, $form, step);
                            $('.form-item-use-data').hide();
                            $ctn_hd_flds.removeClass('hidden');
                          }
                        })
                        .fail(function() {
                          $('.wrapper-form-error h3').html('<span>Error - 10500</span> | Servicio de consulta, temporalmente fuera de línea. Intente de nuevo en unos minutos');
                          $('.wrapper-form-step1').removeClass('active').addClass('hidden');
                          $('.wrapper-form-error').addClass('active').fadeIn('fast');
                        });

                      if (data.person_info.personaEncontradaIAXIS) {
                        var person = data.person_info.persona,
                          name = (
                            person.personaNatural.primerNombre +
                            ' ' +
                            (person.personaNatural.segundoNombre !== null ? person.personaNatural.segundoNombre : '')
                          ),
                          lastnames = (
                            person.personaNatural.primerApellido +
                            ' ' +
                            (person.personaNatural.segundoApellido !== null ? person.personaNatural.segundoApellido : '')
                          );

                        $('.content-hd-fields .field-markup').removeClass('is-hidden');

                        $('.mkp-field-names .content').html(name);
                        $('#edit-names').val(name);

                        $('.mkp-field-lastnames .content').html(lastnames);
                        $('#edit-lastnames').val(lastnames);
=======
      $(".submit-next").click(function (e) {
        e.preventDefault();

        let step = $(this).attr("step"),
          bool_check_flds_vals;

        switch (step) {
          case "1":
            let val_doc_type = $form.find("#edit-type-doc").val(),
              val_num_doc = $form.find("#edit-num-doc").val(),
              val_plate_type = $form.find("#edit-type-plate").val(),
              val_num_plate = $form.find("#edit-num-plate").val();

            if ($("#edit-num-plate").hasClass("error")) {
              return false;
            }

            if ($ctn_hd_flds.hasClass("hidden")) {
              if (
                val_doc_type &&
                val_num_doc &&
                val_plate_type &&
                val_num_plate
              ) {
                // Ws 1 - client info

                $.post(
                  "/api/query_person",
                  {
                    document_type: val_doc_type,
                    document_number: val_num_doc,
                  },
                  function (data) {
                    if (!data.person_info.personaRestringida) {
                      // Validate vehicle
                      $.post("/api/query_auto", {
                        type_plate: val_plate_type,
                        plate: val_num_plate,
                      })
                        .done(function (info_auto) {
                          if (
                            info_auto.vehicle_info.vehiculoRestringido ===
                              true ||
                            info_auto.vehicle_info.vehiculoActivoIAXIS === true
                          ) {
                            $(".wrapper-form-step1")
                              .removeClass("active")
                              .addClass("hidden");
                            $(".wrapper-form-error")
                              .addClass("active")
                              .fadeIn("fast");
                          } else {
                            consume_ws_car_info(info_auto, $form, step);
                            $(".form-item-use-data").hide();
                            $ctn_hd_flds.removeClass("hidden");
                          }
                        })
                        .fail(function () {
                          $(".wrapper-form-error h3").html(
                            "<span>Error - 10500</span> | Servicio de consulta, temporalmente fuera de línea. Intente de nuevo en unos minutos"
                          );
                          $(".wrapper-form-step1")
                            .removeClass("active")
                            .addClass("hidden");
                          $(".wrapper-form-error")
                            .addClass("active")
                            .fadeIn("fast");
                        });

                      if (data.person_info.personaEncontradaIAXIS) {
                        let person = data.person_info.persona,
                          name =
                            person.personaNatural.primerNombre +
                            " " +
                            (person.personaNatural.segundoNombre !== null
                              ? person.personaNatural.segundoNombre
                              : ""),
                          lastnames =
                            person.personaNatural.primerApellido +
                            " " +
                            (person.personaNatural.segundoApellido !== null
                              ? person.personaNatural.segundoApellido
                              : "");

                        $(".content-hd-fields .field-markup").removeClass(
                          "is-hidden"
                        );

                        $(".mkp-field-names .content").html(name);
                        $("#edit-names").val(name);

                        $(".mkp-field-lastnames .content").html(lastnames);
                        $("#edit-lastnames").val(lastnames);
>>>>>>> main

                        // Experian score
                        if (data.person_info.informacionExperian) {
                          $form.append(
                            '<input type="hidden" name="experian" value="' +
<<<<<<< HEAD
                            data.person_info.informacionExperian.puntaje +
                            '">'
=======
                              data.person_info.informacionExperian.puntaje +
                              '">'
>>>>>>> main
                          );
                        }

                        if (person.personaNatural.genero.codigo !== null) {
                          $form.append(
                            '<input type="hidden" name="gender" value="' +
<<<<<<< HEAD
                              (person.personaNatural.genero.codigo == 2 ? 'F' : 'M') +
                              '">'
                          );
                          if(person.personaNatural.genero.codigo == 2) {
                            $('#edit-gender-femenino').prop('checked', true);
                            $('.mkp-field-gender .male').removeClass('active');
                            $('.mkp-field-gender .female').addClass('active');
                          }
                          else {
                            $('#edit-gender-masculino').prop('checked', true);
                            $('.mkp-field-gender .female').removeClass('active');
                            $('.mkp-field-gender .male').addClass('active');
                          }
                          $('#edit-gender .option').click(function(e) {
                            e.preventDefault();
                          })
                        }
                        else {
                          $('.form-item-gender').removeClass('is-hidden');
                        }

                        var fechaNacimiento = data.person_info.persona.personaNatural.fechaNacimiento;
                        if (fechaNacimiento !== null) {
                          var d = fechaNacimiento.split('T')[0].split('-'),
                          birthdate = (
                            d[2] + '/' +
                            d[1] + '/' +
                            d[0]
                          );
                          $('#edit-birthdate')
                            .val(birthdate)
                            .attr('readonly', true)
                            .datepicker("destroy");
                          $('.form-item-birthdate')
                            .removeClass('is-hidden')
                            .addClass('form__input--activo');
=======
                              (person.personaNatural.genero.codigo == 2
                                ? "F"
                                : "M") +
                              '">'
                          );
                          if (person.personaNatural.genero.codigo == 2) {
                            $("#edit-gender-femenino").prop("checked", true);
                            $(".mkp-field-gender .male").removeClass("active");
                            $(".mkp-field-gender .female").addClass("active");
                          } else {
                            $("#edit-gender-masculino").prop("checked", true);
                            $(".mkp-field-gender .female").removeClass(
                              "active"
                            );
                            $(".mkp-field-gender .male").addClass("active");
                          }
                          $("#edit-gender .option").click(function (e) {
                            e.preventDefault();
                          });
                        } else {
                          $(".form-item-gender").removeClass("is-hidden");
                        }

                        let fechaNacimiento =
                          data.person_info.persona.personaNatural
                            .fechaNacimiento;
                        if (fechaNacimiento !== null) {
                          let d = fechaNacimiento.split("T")[0].split("-"),
                            birthdate = d[2] + "/" + d[1] + "/" + d[0];
                          $("#edit-birthdate")
                            .val(birthdate)
                            .attr("readonly", true)
                            .datepicker("destroy");
                          $(".form-item-birthdate")
                            .removeClass("is-hidden")
                            .addClass("form__input--activo");
>>>>>>> main

                          $form.append(
                            '<input type="hidden" name="age" class="age" value="' +
                              getAge(fechaNacimiento) +
                              '">'
                          );
                        }

                        //Ocultar campos de formulario y mostrar markup
<<<<<<< HEAD
                        $('.form-item-names').addClass('is-hidden');
                        $('.form-item-lastnames').addClass('is-hidden');

                        // Hidden fields
                        if (data.person_info.persona.personaNatural.estadoCivil.nombre) {
                          $form.append(
                            '<input type="hidden" name="civil_status" value="' +
                              data.person_info.persona.personaNatural.estadoCivil.nombre +
                              '">'
                          );
                        }
                        if (data.person_info.persona.personaNatural.ocupacion.codigo) {
                          $form.append(
                            '<input type="hidden" name="ocupation" value="' +
                              data.person_info.persona.personaNatural.ocupacion.codigo +
=======
                        $(".form-item-names").addClass("is-hidden");
                        $(".form-item-lastnames").addClass("is-hidden");

                        // Hidden fields
                        if (
                          data.person_info.persona.personaNatural.estadoCivil
                            .nombre
                        ) {
                          $form.append(
                            '<input type="hidden" name="civil_status" value="' +
                              data.person_info.persona.personaNatural
                                .estadoCivil.nombre +
                              '">'
                          );
                        }
                        if (
                          data.person_info.persona.personaNatural.ocupacion
                            .codigo
                        ) {
                          $form.append(
                            '<input type="hidden" name="ocupation" value="' +
                              data.person_info.persona.personaNatural.ocupacion
                                .codigo +
>>>>>>> main
                              '">'
                          );
                          $form.append(
                            '<input type="hidden" name="ocupation_name" value="' +
<<<<<<< HEAD
                              data.person_info.persona.personaNatural.ocupacion.nombre +
                              '">'
                          );
                        }
                        if (data.person_info.informacionAniosExperiencia.aniosExperiencia) {
                          $form.append(
                            '<input type="hidden" name="experience" value="' +
                              data.person_info.informacionAniosExperiencia.aniosExperiencia +
=======
                              data.person_info.persona.personaNatural.ocupacion
                                .nombre +
                              '">'
                          );
                        }
                        if (
                          data.person_info.informacionAniosExperiencia
                            .aniosExperiencia
                        ) {
                          $form.append(
                            '<input type="hidden" name="experience" value="' +
                              data.person_info.informacionAniosExperiencia
                                .aniosExperiencia +
>>>>>>> main
                              '">'
                          );
                        }
                        if (data.person_info.persona.direccion) {
<<<<<<< HEAD
                          if (data.person_info.persona.direccion[0].textoDireccion) {
                            $form.append(
                              '<input type="hidden" name="address" value="' +
                                data.person_info.persona.direccion[0].textoDireccion +
                                '">'
                            );
                          }
                          if (data.person_info.persona.direccion[0].departamento.codigo) {
                            $form.append(
                              '<input type="hidden" name="department_id" value="' +
                                data.person_info.persona.direccion[0].departamento.codigo +
                                '">'
                            );
                          }
                          if (data.person_info.persona.direccion[0].ciudad.codigo) {
                            $form.append(
                              '<input type="hidden" name="city_id" value="' +
                                data.person_info.persona.direccion[0].ciudad.codigo +
=======
                          if (
                            data.person_info.persona.direccion[0].textoDireccion
                          ) {
                            $form.append(
                              '<input type="hidden" name="address" value="' +
                                data.person_info.persona.direccion[0]
                                  .textoDireccion +
                                '">'
                            );
                          }
                          if (
                            data.person_info.persona.direccion[0].departamento
                              .codigo
                          ) {
                            $form.append(
                              '<input type="hidden" name="department_id" value="' +
                                data.person_info.persona.direccion[0]
                                  .departamento.codigo +
                                '">'
                            );
                          }
                          if (
                            data.person_info.persona.direccion[0].ciudad.codigo
                          ) {
                            $form.append(
                              '<input type="hidden" name="city_id" value="' +
                                data.person_info.persona.direccion[0].ciudad
                                  .codigo +
>>>>>>> main
                                '">'
                            );
                          }
                        }
<<<<<<< HEAD
                      }
                      else {
                        //Ocultar markup y mostrar campos de formulario
                        $('.content-hd-fields .field-markup').addClass('is-hidden');
                        $('.form-item-names').removeClass('is-hidden');
                        $('.form-item-lastnames').removeClass('is-hidden');
                        $('.form-item-mail').removeClass('is-hidden');
                        $('.form-item-cellphone').removeClass('is-hidden');
                        $('.form-item-birthdate').removeClass('is-hidden');
                      }

                      $('#edit-num-doc, #edit-num-plate')
                        .attr('readonly', true);
                      $('#edit-type-doc, #edit-type-plate').find('option')
                        .not(':selected')
                        .attr('disabled', true);
                    }
                    else {
                      $('.wrapper-form-step1').removeClass('active').addClass('hidden');
                      $('.wrapper-form-error').addClass('active').fadeIn('fast');
                    }
                })
                .fail(function() {
                  $('.wrapper-form-error h3').html('<span>Error - 10500</span> | Servicio de consulta, temporalmente fuera de línea. Intente de nuevo en unos minutos');
                  $('.wrapper-form-step1').removeClass('active').addClass('hidden');
                  $('.wrapper-form-error').addClass('active').fadeIn('fast');
                });
              }
            }
            else {
              bool_check_flds_vals = check_fields_values(step, $form);
              var $fld_vehicle_find = $form.find('.find-vehicle');
              if (bool_check_flds_vals) {
                // Ws 2 - car info
                e.preventDefault();
                // var info_car = consume_ws_car_info(val_plate_type, val_num_plate, $form, step);

=======
                      } else {
                        //Ocultar markup y mostrar campos de formulario
                        $(".content-hd-fields .field-markup").addClass(
                          "is-hidden"
                        );
                        $(".form-item-names").removeClass("is-hidden");
                        $(".form-item-lastnames").removeClass("is-hidden");
                        $(".form-item-mail").removeClass("is-hidden");
                        $(".form-item-cellphone").removeClass("is-hidden");
                        $(".form-item-birthdate").removeClass("is-hidden");
                      }

                      $("#edit-num-doc, #edit-num-plate").attr(
                        "readonly",
                        true
                      );
                      $("#edit-type-doc, #edit-type-plate")
                        .find("option")
                        .not(":selected")
                        .attr("disabled", true);
                    } else {
                      $(".wrapper-form-step1")
                        .removeClass("active")
                        .addClass("hidden");
                      $(".wrapper-form-error")
                        .addClass("active")
                        .fadeIn("fast");
                    }
                  }
                ).fail(function () {
                  $(".wrapper-form-error h3").html(
                    "<span>Error - 10500</span> | Servicio de consulta, temporalmente fuera de línea. Intente de nuevo en unos minutos"
                  );
                  $(".wrapper-form-step1")
                    .removeClass("active")
                    .addClass("hidden");
                  $(".wrapper-form-error").addClass("active").fadeIn("fast");
                });
              }
            } else {
              bool_check_flds_vals = check_fields_values(step, $form);
              let $fld_vehicle_find = $form.find(".find-vehicle");
              if (bool_check_flds_vals) {
                // Ws 2 - car info
                e.preventDefault();
                // let info_car = consume_ws_car_info(val_plate_type, val_num_plate, $form, step);
>>>>>>> main
              }
              // $form.find('.step1').addClass('hidden').removeClass('active');
              // $form.find('.step2').removeClass('hidden').addClass('active');
              // change_header_step_states(step, $form);
            }
            break;

<<<<<<< HEAD
          case '2':
=======
          case "2":
>>>>>>> main
            bool_check_flds_vals = check_fields_values(step, $form);
            if (bool_check_flds_vals) {
              // Ws 3 - get quoting values
              e.preventDefault();
<<<<<<< HEAD
              consume_ws_get_quoting_value(
                $form
              );
              // $form.find('.step2').addClass('hidden').removeClass('active');
              // $form.find('.step3').removeClass('hidden').addClass('active');
              // change_header_step_states(step, $form);
              $('.js-accordion-row').each(function() {
                var el = $(this),
                  op = el.find('.option');
                el
                  .find('.js-accordion')
                  .prepend('<span class="accordion-number">' + op.length + '</span>')
=======
              consume_ws_get_quoting_value($form);
              // $form.find('.step2').addClass('hidden').removeClass('active');
              // $form.find('.step3').removeClass('hidden').addClass('active');
              // change_header_step_states(step, $form);
              $(".js-accordion-row").each(function () {
                let el = $(this),
                  op = el.find(".option");
                el.find(".js-accordion").prepend(
                  '<span class="accordion-number">' + op.length + "</span>"
                );
>>>>>>> main
              });
            }
            break;
        }
<<<<<<< HEAD
      })

    }
  }
} (jQuery, Drupal));
=======
      });
    },
  };
})(jQuery, Drupal);
>>>>>>> main
