//creates a session with localstorage with node and time
(function ($, Drupal, drupalSettings) {
<<<<<<< HEAD
    var node_id = drupalSettings.details;
    if (node_id) {
        node_id=btoa(node_id);
        localStorage.setItem('session', node_id);
    }

})(jQuery, Drupal, drupalSettings);
=======
  let node_id = drupalSettings.details;
  if (node_id) {
    node_id = btoa(node_id);
    localStorage.setItem("session", node_id);
  }
})(jQuery, Drupal, drupalSettings);
>>>>>>> main
