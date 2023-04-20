(function ($, Drupal, window) {
    Drupal.behaviors.helpers = {
      attach: function (context, settings) {
        'use strict';
  
        $("#webform_submission_call_center").submit(function(e) {
            $.ajax({
                url: "www.site.com/page",
                success: function(data){ 
                    $('#data').text(data);
                },
                error: function(){
                    alert("There was an error.");
                }
            });
        });
      }
    };
  })(jQuery, Drupal, window);