/* eslint-disable */
Drupal.behaviors.tabsLib = {
  attach: function (context, settings) {

    console.log('hola me cargue');
    const tabsLink = document.querySelectorAll(".nav-tabs .nav-link_button a");
    var hash = document.location.hash;
    // Si se detecta un ancla en la url

    if (tabsLink) {
      tabsLink.forEach((link) => {
        link.addEventListener("click", (e) => {
          e.preventDefault();
        });
      });
    }

    if (hash) {
      // Definicion de variables.
      const active_title = document.querySelector(
        '.nav-tabs .nav-link_button a[href="' + hash + '"]'
      );
      const active_id = "tab-" + hash.slice(1);
      const active_tab_content = document.getElementById(active_id);
      const tabs = active_title.parentNode.parentNode.parentNode.parentNode;
      const tabs_children_nav = tabs.querySelectorAll(".nav-link_button");
      const tabs_children_content = tabs.querySelectorAll(".tab-pane_content");

      // Remove el active a los elementos.
      Array.from(tabs_children_nav).forEach((item) => {
        item.classList.remove("active");
      });

      Array.from(tabs_children_content).forEach((item) => {
        item.classList.remove("show", "active");
      });

      active_title.parentNode.classList.add("active");
      active_tab_content.classList.add("show", "active");
    }
  },
};
