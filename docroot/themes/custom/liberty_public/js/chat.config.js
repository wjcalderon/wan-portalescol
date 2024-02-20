(function ($, Drupal, window, document) {
<<<<<<< HEAD
  'use strict';
=======
  "use strict";
>>>>>>> main

  // Example of Drupal behavior loaded.
  Drupal.behaviors.themeChatJS = {
    attach: function (context, settings) {
<<<<<<< HEAD

      // var chatSettings = {
=======
      // let chatSettings = {
>>>>>>> main
      //   header_text: 'Web Chat',
      //   header_status: 'En linea',
      //   login_text: 'Comenzar',
      //   welcome_text: '¡Hola!',
      //   subtitle_text: 'Ingresa la siguiente información y cuéntanos en qué te podemos ayudar',
      //   message_placeholder: 'Escriba un mensaje...',
      //   login_fields: ['Nombre', 'Email'],
      //   send_color: '#cb1e74',
      //   header_background_color: '#FFFFFF',
      //   header_font_color: '#FFFFFF',
      //   locale: 'es',
      //   name_field: 'Nombre',
      //   button_login_color: 'white',
      //   button_login_bg: 'rgb(223, 141, 51)',
      //   field_font_color: '#525252',
      //   welcome_color: '#525252',
      //   subtitle_color: '#525252',
      //   preserve_history: false,
      //   bg_menu: '#1f1f1f',
      //   geo_active: true,
      // };

<<<<<<< HEAD
      // var startChat = function () {
      //   var chat = new Webchat("962b7ae3c4765c4a8cc9c47ccb91c49b20fb", chatSettings);
=======
      // let startChat = function () {
      //   let chat = new Webchat("962b7ae3c4765c4a8cc9c47ccb91c49b20fb", chatSettings);
>>>>>>> main
      //   chat.init();
      //   chat.expandChat();
      // };

      // $('.tb-megamenu-menu-con .tb-megamenu-item .tb-megamenu-item a').on('click', function(e) {
      //   if ($(this).parents('.tb-megamenu-item').data('label') === 'Chat') {
      //     e.preventDefault();
      //     startChat();
      //   }
      // });

<<<<<<< HEAD
$('.closeButton').click(function(e){
       if ($('.embeddedServiceSidebarHeader').not('noAnimate')) {
          alert('va');
        }
});
      $('#block-buscasayuda ul.menu li a.chat').click(function(e){
        e.preventDefault();
        $(this).parent("li").addClass('is-hidden');
        $('#blocks-necesecitas-ayuda .menu').addClass('is-hidden');
        $('#show-menu-help').removeClass('active');
        $('.helpButton').removeClass('d-none');
        $('.helpButton').css("display","block");


       
        // $('#block-buscasayuda ul.menu').addClass('is-hidden');
        // $('#block-buscasayuda #show-menu-help').removeClass('active');
        // $('.overlay-buscayuda').remove();
        // if ($('#webchat-widget-container').length > 0) {
        //   $('#block-buscasayuda #show-menu-help #show-menu-help').click();
        // }
        // else {
        //   startChat();
        // }

      });
    }
  };
}) (jQuery, Drupal, this, this.document);
=======
      $(".closeButton").click(function (e) {
        if ($(".embeddedServiceSidebarHeader").not("noAnimate")) {
          alert("va");
        }
      });

      console.log("ok");
    },
  };
})(jQuery, Drupal, this, this.document);
>>>>>>> main
