function getIdButton(id) {
<<<<<<< HEAD
  let selector = document.getElementsByName('producto')
  selector[0].value = id
}

;(function ($, Drupal, drupalSettings) {
  const randomes = Math.floor(Math.random() * 100000)

  for (let q = 0; q < 5; q++) {
    var cover_text = $(`#cover_${q}`).find('.card-service__heading').text()
    cover_text = cover_text.replace(/\r?\n|\r/g, ' ')
    cover_text = cover_text.replace('       ', '')
    cover_text = cover_text.replace('   ', '')
    $(`#cover_${q}`).find('.card-service__heading').text(cover_text)
  }

  const nid = drupalSettings.path.currentPath
  const enviroment = drupalSettings.enviroment
  
  var nid_single = nid.split('/')
  nid_single = nid_single[1]
  var nid_token = btoa(nid_single)
  var nid_token_response = atob(nid_token)

  const valor_product = $('#cover_1').find('h2').find('p').text()
  var valor_product_token = btoa(valor_product)

  if (enviroment == "prod") {
    link = `/node/55666?nid=${nid_token}&valor_product_token=${valor_product_token}`
  }else{
    link = `/node/6211?nid=${nid_token}&valor_product_token=${valor_product_token}`
  }
  
  $('#banner__button__href').attr('href', link)

  for (let w = 0; w < 5; w++) {
    var button_href = $(`#cover_${w}`).find('h2').find('p').text()
    button_href = btoa(button_href)
    if (enviroment == "prod") {
      link = `/node/55666?nid=${nid_token}&valor_product_token=${button_href}`
    }else{
      link = `/node/6211?nid=${nid_token}&valor_product_token=${button_href}`
    }
    $(`#cover_${w}`).find('.banner__button__href').attr('href', link)
=======
  let selector = document.getElementsByName("producto");
  selector[0].value = id;
}

(function ($, Drupal, drupalSettings) {
  const randomes = Math.floor(Math.random() * 100000);

  for (let q = 0; q < 5; q++) {
    let cover_text = $(`#cover_${q}`).find(".card-service__heading").text();
    cover_text = cover_text.replace(/\r?\n|\r/g, " ");
    cover_text = cover_text.replace("       ", "");
    cover_text = cover_text.replace("   ", "");
    $(`#cover_${q}`).find(".card-service__heading").text(cover_text);
  }

  const nid = drupalSettings.path.currentPath;
  const enviroment = drupalSettings.enviroment;

  let nid_single = nid.split("/");
  nid_single = nid_single[1];
  let nid_token = btoa(nid_single);
  let nid_token_response = atob(nid_token);

  const valor_product = $("#cover_1").find("h2").find("p").text();
  let valor_product_token = btoa(valor_product);

  if (enviroment == "prod") {
    link = `/node/55666?nid=${nid_token}&valor_product_token=${valor_product_token}`;
  } else {
    link = `/node/6211?nid=${nid_token}&valor_product_token=${valor_product_token}`;
  }

  $("#banner__button__href").attr("href", link);

  for (let w = 0; w < 5; w++) {
    let button_href = $(`#cover_${w}`).find("h2").find("p").text();
    button_href = btoa(button_href);
    if (enviroment == "prod") {
      link = `/node/55666?nid=${nid_token}&valor_product_token=${button_href}`;
    } else {
      link = `/node/6211?nid=${nid_token}&valor_product_token=${button_href}`;
    }
    $(`#cover_${w}`).find(".banner__button__href").attr("href", link);
>>>>>>> main
  }

  /**
   * @param String name
   * @return String
   */
  function getParameterByName(name) {
<<<<<<< HEAD
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]')
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)'),
      results = regex.exec(location.search)
    return results === null
      ? ''
      : decodeURIComponent(results[1].replace(/\+/g, ' '))
  }

  var nidurl = getParameterByName('nid')
  nidurl = atob(nidurl)
  link_node = `/es/node/${nidurl}`
  $('.backtohome__home').attr('href', link_node)
  $('.landing_url').attr('value', link_node)

  $('.edit-submit-cancel_form_sponsors').click(function (e) {
    e.preventDefault()
    var nidurl = getParameterByName('nid')
    nidurl = atob(nidurl)
    link_node = `/es/node/${nidurl}`
    window.location.href = link_node
  })

  var valor_product_token_url = getParameterByName('valor_product_token')
  valor_product_token_url = atob(valor_product_token_url)
  valor_title_modal = $('.form-modal-title').html()
  valor_title = `<h3>${valor_title_modal} ${valor_product_token_url}</h3>`
  $('.form-modal-title').html(valor_title)

  $('#webform_submission_call_center')
    .find('.input[name="producto"]')
    .val(valor_product_token_url)

  $('#webform_submission_call_center').find('.id_rand').val(randomes)
  $(function () {
    if ($('#edit-id-type').val().length == 0) {
      $('#edit-id-type').parent().prev().addClass('item-label-transition')
    }
  })
  $(document).ready(function () {
    $('.form-modal').click(function () {
      $('.form-modal-wrap').addClass('display')
    })

    $('.form-modal-close').click(function () {
      $('.form-modal-wrap').removeClass('display')
    })

    $('.terms-modal').click(function () {
      $('.terms-modal-wrap').addClass('display')
    })

    $('.terms-modal-close').click(function () {
      $('.terms-modal-wrap').removeClass('display')
    })

    $('#modal_acept_terms').click(function () {
      $('.terms-modal-wrap').removeClass('display')
    })

    $('#edit-id-type').focus(function (e) {
      e.preventDefault()
      e.stopPropagation()
      $('#edit-id-type').parent().parent().addClass('active')
      $('#edit-id-type').parent().prev().removeClass('item-label-transition')
    })

    $('#edit-id-number').focus(function (e) {
      e.preventDefault()
      e.stopPropagation()
      $('#edit-id-number').parent().addClass('active')
    })

    $('#edit-email').focus(function (e) {
      e.preventDefault()
      e.stopPropagation()
      $('#edit-email').parent().addClass('active')
    })

    $('#edit-phone').focus(function (e) {
      e.preventDefault()
      e.stopPropagation()
      $('#edit-phone').parent().addClass('active')
    })

    $('#edit-placa').focus(function (e) {
      e.preventDefault()
      e.stopPropagation()
      $('#edit-placa').parent().addClass('active')
    })

    $('#edit-name').focus(function (e) {
      e.preventDefault()
      e.stopPropagation()
      $('#edit-name').parent().addClass('active')
    })

    $('#edit-last-name').focus(function (e) {
      e.preventDefault()
      e.stopPropagation()
      $('#edit-last-name').parent().addClass('active')
    })

    $('#edit-actions-submit').click(function () {
      $('#edit-id-type').parent().prev().removeClass('item-label-transition')
    })

    $('body').focus(function () {
      if ($('#edit-id-type').val().length == 0) {
        $('#edit-id-type').parent().parent().removeClass('active')
        $('#edit-id-type').parent().prev().addClass('item-label-transition')
      }
      if ($('#edit-id-number').val().length == 0) {
        $('#edit-id-number').parent().removeClass('active')
      }
      if ($('#edit-email').val().length == 0) {
        $('#edit-email').parent().removeClass('active')
      }
      if ($('#edit-phone').val().length == 0) {
        $('#edit-phone').parent().removeClass('active')
      }
      if ($('#edit-placa').val().length == 0) {
        $('#edit-placa').parent().removeClass('active')
      }
      if ($('#edit-name').val().length == 0) {
        $('#edit-name').parent().removeClass('active')
      }
      if ($('#edit-last-name').val().length == 0) {
        $('#edit-last-name').parent().removeClass('active')
      }
    })

    $('.accordion-term__tab1').click(function (e) {
      e.preventDefault()

      if ($(this).hasClass('is-active')) {
        $(this).removeClass('is-active')
        $('.accordion-term__content1').removeClass('is-open')
      } else {
        $(this).addClass('is-active')
        $('.accordion-term__content1').addClass('is-open')
      }
    })

    $('.accordion-term__tab2').click(function (e) {
      e.preventDefault()

      if ($(this).hasClass('is-active')) {
        $(this).removeClass('is-active')
        $('.accordion-term__content2').removeClass('is-open')
      } else {
        $(this).addClass('is-active')
        $('.accordion-term__content2').addClass('is-open')
      }
    })

    $('.terms-modal-box')
      .find('span')
      .click(function (e) {
        e.preventDefault()
        $('#edit-terminos-de-uso').prop('checked', true)
        $('.terms-modal-wrap').removeClass('display')
      })

    $('.terms-modal-box').find('span').addClass('button')
    $('.terms-modal-box').find('span').addClass('form-modal')
    $('.terms-modal-box').find('span').attr('id', 'modal_acept_terms')
  })

  $(document).ready(function () {
    setTimeout(function () {
      $('.ajax-progress').addClass('ajax_display')
    }, 2000)
  })
})(jQuery, Drupal, drupalSettings)
=======
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    let regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
      results = regex.exec(location.search);
    return results === null
      ? ""
      : decodeURIComponent(results[1].replace(/\+/g, " "));
  }

  let nidurl = getParameterByName("nid");
  nidurl = atob(nidurl);
  link_node = `/es/node/${nidurl}`;
  $(".backtohome__home").attr("href", link_node);
  $(".landing_url").attr("value", link_node);

  $(".edit-submit-cancel_form_sponsors").click(function (e) {
    e.preventDefault();
    let nidurl = getParameterByName("nid");
    nidurl = atob(nidurl);
    link_node = `/es/node/${nidurl}`;
    window.location.href = link_node;
  });

  let valor_product_token_url = getParameterByName("valor_product_token");
  valor_product_token_url = atob(valor_product_token_url);
  valor_title_modal = $(".form-modal-title").html();
  valor_title = `<h3>${valor_title_modal} ${valor_product_token_url}</h3>`;
  $(".form-modal-title").html(valor_title);

  $("#webform_submission_call_center")
    .find('.input[name="producto"]')
    .val(valor_product_token_url);

  $("#webform_submission_call_center").find(".id_rand").val(randomes);
  $(function () {
    if ($("#edit-id-type").val().length == 0) {
      $("#edit-id-type").parent().prev().addClass("item-label-transition");
    }
  });
  $(document).ready(function () {
    $(".form-modal").click(function () {
      $(".form-modal-wrap").addClass("display");
    });

    $(".form-modal-close").click(function () {
      $(".form-modal-wrap").removeClass("display");
    });

    $(".terms-modal").click(function () {
      $(".terms-modal-wrap").addClass("display");
    });

    $(".terms-modal-close").click(function () {
      $(".terms-modal-wrap").removeClass("display");
    });

    $("#modal_acept_terms").click(function () {
      $(".terms-modal-wrap").removeClass("display");
    });

    $("#edit-id-type").focus(function (e) {
      e.preventDefault();
      e.stopPropagation();
      $("#edit-id-type").parent().parent().addClass("active");
      $("#edit-id-type").parent().prev().removeClass("item-label-transition");
    });

    $("#edit-id-number").focus(function (e) {
      e.preventDefault();
      e.stopPropagation();
      $("#edit-id-number").parent().addClass("active");
    });

    $("#edit-email").focus(function (e) {
      e.preventDefault();
      e.stopPropagation();
      $("#edit-email").parent().addClass("active");
    });

    $("#edit-phone").focus(function (e) {
      e.preventDefault();
      e.stopPropagation();
      $("#edit-phone").parent().addClass("active");
    });

    $("#edit-placa").focus(function (e) {
      e.preventDefault();
      e.stopPropagation();
      $("#edit-placa").parent().addClass("active");
    });

    $("#edit-name").focus(function (e) {
      e.preventDefault();
      e.stopPropagation();
      $("#edit-name").parent().addClass("active");
    });

    $("#edit-last-name").focus(function (e) {
      e.preventDefault();
      e.stopPropagation();
      $("#edit-last-name").parent().addClass("active");
    });

    $("#edit-actions-submit").click(function () {
      $("#edit-id-type").parent().prev().removeClass("item-label-transition");
    });

    $("body").focus(function () {
      if ($("#edit-id-type").val().length == 0) {
        $("#edit-id-type").parent().parent().removeClass("active");
        $("#edit-id-type").parent().prev().addClass("item-label-transition");
      }
      if ($("#edit-id-number").val().length == 0) {
        $("#edit-id-number").parent().removeClass("active");
      }
      if ($("#edit-email").val().length == 0) {
        $("#edit-email").parent().removeClass("active");
      }
      if ($("#edit-phone").val().length == 0) {
        $("#edit-phone").parent().removeClass("active");
      }
      if ($("#edit-placa").val().length == 0) {
        $("#edit-placa").parent().removeClass("active");
      }
      if ($("#edit-name").val().length == 0) {
        $("#edit-name").parent().removeClass("active");
      }
      if ($("#edit-last-name").val().length == 0) {
        $("#edit-last-name").parent().removeClass("active");
      }
    });

    $(".accordion-term__tab1").click(function (e) {
      e.preventDefault();

      if ($(this).hasClass("is-active")) {
        $(this).removeClass("is-active");
        $(".accordion-term__content1").removeClass("is-open");
      } else {
        $(this).addClass("is-active");
        $(".accordion-term__content1").addClass("is-open");
      }
    });

    $(".accordion-term__tab2").click(function (e) {
      e.preventDefault();

      if ($(this).hasClass("is-active")) {
        $(this).removeClass("is-active");
        $(".accordion-term__content2").removeClass("is-open");
      } else {
        $(this).addClass("is-active");
        $(".accordion-term__content2").addClass("is-open");
      }
    });

    $(".terms-modal-box")
      .find("span")
      .click(function (e) {
        e.preventDefault();
        $("#edit-terminos-de-uso").prop("checked", true);
        $(".terms-modal-wrap").removeClass("display");
      });

    $(".terms-modal-box").find("span").addClass("button");
    $(".terms-modal-box").find("span").addClass("form-modal");
    $(".terms-modal-box").find("span").attr("id", "modal_acept_terms");
  });

  $(document).ready(function () {
    setTimeout(function () {
      $(".ajax-progress").addClass("ajax_display");
    }, 2000);
  });
})(jQuery, Drupal, drupalSettings);
>>>>>>> main
