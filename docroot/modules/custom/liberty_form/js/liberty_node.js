//creates a session with localstorage with node and time
(function ($, Drupal, drupalSettings) {
  let node_id = drupalSettings.node_id;
  let session = localStorage.getItem("session");
  if (session == null) {
    //if you do not have session redirect
    window.location.replace("/welcome/" + node_id);
  } else {
    session = atob(session);
    if (session == node_id) {
    } else {
      //if you do not have session redirect
      window.location.replace("/welcome/" + node_id);
    }
  }
})(jQuery, Drupal, drupalSettings);
