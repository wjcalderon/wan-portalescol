<<<<<<< HEAD
window.addEventListener('load', function () {
    var locationion = window.location.pathname;
    var splites = locationion.split('/');
    var sitio = splites.pop();

    function mensaje() {
        var classnameExists = !!document.getElementsByClassName("ui-icon-closethick");
        if (document.querySelector(".ui-icon-closethick")) {
            var nidurl = getParameterByName('nid');
            nidurl = atob(nidurl);
            window.location.href = `/es/node/${nidurl}`;
        }
    }

    setTimeout(mensaje, 5000);

    /**
     * @param String name
     * @return String
     */
    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
        return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }



});
=======
window.addEventListener("load", function () {
  let locationion = window.location.pathname;
  let splites = locationion.split("/");
  let sitio = splites.pop();

  function mensaje() {
    let classnameExists =
      !!document.getElementsByClassName("ui-icon-closethick");
    if (document.querySelector(".ui-icon-closethick")) {
      let nidurl = getParameterByName("nid");
      nidurl = atob(nidurl);
      window.location.href = `/es/node/${nidurl}`;
    }
  }

  setTimeout(mensaje, 5000);

  /**
   * @param String name
   * @return String
   */
  function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    let regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
      results = regex.exec(location.search);
    return results === null
      ? ""
      : decodeURIComponent(results[1].replace(/\+/g, " "));
  }
});
>>>>>>> main
