(function ($, Drupal) {

  if ($("#edit-name")) {
    if($("#edit-name").val().length > 0){
      $("#edit-name").parent().addClass("active");
      $("#edit-name").parent().prev().removeClass('item-label-transition');
  }
  }

    
    
      $("#edit-name").keyup(function(e){
          e.preventDefault();
          e.stopPropagation();
          $("#edit-name").parent().addClass("active");
          $("#edit-name").parent().prev().removeClass('item-label-transition');
      });
  
      $("#edit-pass").keyup(function(e){
        e.preventDefault();
        e.stopPropagation();
        $("#edit-pass").parent().addClass("active");
      });
  
  
      $("body").click(function(){
        if($("#edit-name").val().length == 0){
          $("#edit-name").parent().removeClass("active");
        }
        if ($("#edit-pass")) {
          if($("#edit-pass").val().length == 0){
            $("#edit-pass").parent().removeClass("active");
          }
        }
        
    });
  })(jQuery, Drupal);
  