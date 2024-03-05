document.addEventListener("DOMContentLoaded", function () {
  var enlace = document.getElementById("external");
  console.log(enlace);
  enlace.addEventListener("click", function (event) {
    event.preventDefault();

    var href = this.getAttribute("href");

    window.location.replace(href);
  });
});
