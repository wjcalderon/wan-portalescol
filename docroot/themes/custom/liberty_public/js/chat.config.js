(function ($, Drupal, window, document) {
  "use strict";

  // Example of Drupal behavior loaded.
  Drupal.behaviors.themeChatJS = {
    attach: function (context, settings) {
      // let chatSettings = {
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

      // let startChat = function () {
      //   let chat = new Webchat("962b7ae3c4765c4a8cc9c47ccb91c49b20fb", chatSettings);
      //   chat.init();
      //   chat.expandChat();
      // };

      // $('.tb-megamenu-menu-con .tb-megamenu-item .tb-megamenu-item a').on('click', function(e) {
      //   if ($(this).parents('.tb-megamenu-item').data('label') === 'Chat') {
      //     e.preventDefault();
      //     startChat();
      //   }
      // });

      $(".closeButton").click(function (e) {
        if ($(".embeddedServiceSidebarHeader").not("noAnimate")) {
          alert("va");
        }
      });

      console.log("ok");
    },
  };
})(jQuery, Drupal, this, this.document);
