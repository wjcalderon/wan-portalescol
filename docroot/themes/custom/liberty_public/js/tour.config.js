(function ($, Drupal, window, document) {
  "use strict";

  function startIntro() {
    let intro = introJs();
    intro.setOptions({
      showBullets: false,
      skipLabel: "No volver a mostrar",
      nextLabel: "Siguiente",
      prevLabel: "Anterior",
      doneLabel: "Finalizar y no volver a mostrar",
      steps: [
        {
          element: document.getElementsByClassName("zona-clientes")[0],
          intro:
            "Disfruta de una sección<br /> diseñada <b><span>para ti</span></b>",
          highlightClass: "nuestros__productos",
          position: "bottom-right-aligned",
        },
        {
          element: document.getElementsByClassName("pagos-desk")[0],
          intro:
            "<b><span>Paga tus seguros</span></b> de forma<br /> rápida y efectiva",
          highlightClass: "menu__desk",
          position: "bottom-right-aligned",
        },
        {
          element: "#show-menu-help",
          intro:
            "Ahora tendrás <b><span> Fácil acceso</span></b> desde<br />cualquier página de nuestro sitio",
          highlightClass: "menu__help",
          position: "bottom",
        },
        {
          element: document.getElementsByClassName("te-paso-algo")[0],
          intro:
            "Reporta tu<b><span> siniestro</span></b> y conoce cómo <br /> podemos ayudarte de forma fácil",
          highlightClass: "nuestros__productos",
          position: "bottom-right-aligned",
        },
      ],
    });

    intro.start();
  }

  let miBoton;

  function startIntroMo() {
    let introM = introJs();
    introM.setOptions({
      showBullets: false,
      skipLabel: "No volver a mostrar",
      nextLabel: "Siguiente",
      doneLabel: "Finalizar y no volver a mostrar",
      steps: [
        {
          element: "#burguer-menu",
          intro:
            "Tendrás <b><span>fácil acceso</span></b><br />a las distintas<br /> opciones desde el<br />menú ",
          highlightClass: "menu-burguer",
          position: "bottom-right-aligned",
        },
        {
          element: "#show-menu-help",
          intro:
            "Ahora tendrás<br /> <b><span>fácil acceso</span></b> desde<br />cualquier página<br />de nuestro sitio",
          highlightClass: "menu-help-mobile",
          position: "bottom-right-aligned",
        },
      ],
    });

    introM.start();

    introM.onafterchange(function (targetElement) {
      // console.log('funciona');
      $(".introjs-nextbutton").addClass("tour-fran");
      $(".introjs-nextbutton").removeClass("introjs-disabled");
      miBoton = document.getElementsByClassName("tour-fran")[0];
      // console.log(miBoton);

      let miFuncion;

      $(miBoton).click(function () {
        $("body").addClass("abierto no-scroll");
        // console.log('ajustes');
        introJs().exit();
        // console.log('ajustes2');
        miFuncion = setTimeout(startIntroMoInt, 500);
      });
    });
  }

  function startIntroMoInt() {
    let introMm = introJs();
    introMm.setOptions({
      showBullets: false,
      skipLabel: "No volver a mostrar",
      nextLabel: "Siguiente",
      doneLabel: "Finalizar y no volver a mostrar",
      steps: [
        {
          element: "#block-menuprincipalpersonas",
          intro:
            "Encuentra<br /> <b><span>nuestros seguros</span></b><br />de forma fácil",
          highlightClass: "nuestros-produc",
          position: "bottom-right-aligned",
        },
        {
          element: document.getElementsByClassName("zona-cliente-mb")[0],
          intro:
            "Disfruta de una<br /> sección diseñada <br /> <b><span>para ti</span></b>",
          highlightClass: "zona-client",
          position: "bottom-right-aligned",
        },
        {
          element: document.getElementsByClassName("te-pasoalgo-mb")[0],
          intro:
            "Reporta <b><span>tu siniestro</span></b><br />y conoce cómo<br />podemos ayudarte<br />de forma fácil",
          highlightClass: "tepaso-algo",
          position: "bottom-right-aligned",
        },
        {
          element: document.getElementsByClassName("pagos-mb")[0],
          intro:
            "<b><span>Paga tus seguros</span></b><br />de forma rápida y<br />efectiva",
          highlightClass: "pagos-ob",
          position: "bottom-right-aligned",
        },
        {
          element: "#block-lateralsuperior",
          intro:
            "Ahora puedes<br /> saber más <b>sobre <br /><span>nosotros</span></b>",
          highlightClass: "acerca-mb",
          position: "bottom-right-aligned",
        },
      ],
    });

    introMm.start();
    $("body").removeClass("abierto no-scroll");
  }

  function getCookie(name) {
    if (localStorage != null) {
      return localStorage.getItem(name);
    } else {
      let dc = document.cookie;
      let prefix = name + "=";
      let begin = dc.indexOf("; " + prefix);
      if (begin == -1) {
        begin = dc.indexOf(prefix);
        if (begin != 0) return null;
      } else {
        begin += 2;
        let end = document.cookie.indexOf(";", begin);
        if (end == -1) {
          end = dc.length;
        }
      }
      return decodeURI(dc.substring(begin + prefix.length, end));
    }
  }
  let checkWindowWidth = function () {
    let windowWidth = $(window).width(),
      myCookie = getCookie("estado");

    if (myCookie == null) {
      if (windowWidth <= 978) {
        startIntroMo();
      } else {
        startIntro();
      }
    }
  };
  checkWindowWidth();

  $(document).ready(function () {
    function crearCookie() {
      if (localStorage != null) {
        localStorage.setItem("estado", "nomostrar2");
      } else {
        let d = new Date(),
          expires = "expires=" + d.toUTCString();
        d.setTime(d.getTime() + 365 * 24 * 60 * 60 * 1000);
        document.cookie = "estado=nomostrar2;" + expires + ";path=/";
      }
    }

    $(".introjs-skipbutton").on("click", function () {
      // console.log($(this));
      crearCookie();
    });
  });
})(jQuery, Drupal, this, this.document);
