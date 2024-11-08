(function ($) {
  $(document).ready(function () {
    $('#user-login-form #edit-name').focus()
  })

  $('#user-login-form #edit-name, #user-login-form #edit-pass')
    .on('focus', function () {
      $(this).parent().addClass("active")
    })
    .on('blur', function () {
      if ($(this).val() === '') {
        $(this).parent().removeClass("active")
      }
    })
  })(jQuery)
