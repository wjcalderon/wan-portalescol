document.addEventListener("DOMContentLoaded", function () {
  var enlace = document.getElementById("external");
  enlace.addEventListener("click", function (event) {
    event.preventDefault();

    var href = this.getAttribute("href");

    window.location.replace(href);
  });
});
