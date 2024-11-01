document?.addEventListener("DOMContentLoaded", function () {
  const enlace = document.getElementById("external");
  enlace?.addEventListener("click", function (event) {
    event.preventDefault();
    let href = this.getAttribute("href");
    window.location.assign(href);
  });
});
