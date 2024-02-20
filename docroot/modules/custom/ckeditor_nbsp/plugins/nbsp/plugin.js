/**
 * @file insert Non-Breaking Space for CKEditor
 * Copyright (C) 2016 Kevin Wenger of Antistatique
 * Create a command and enable the Ctrl+Space shortcut
 * to insert a non-breaking space in CKEditor
 * Also add a non-breaking space button
 */

/* global jQuery Drupal CKEDITOR */

(function($, Drupal, CKEDITOR) {
  "use strict";

  CKEDITOR.plugins.add("nbsp", {
    icons: "nbsp",
    hidpi: true,

    beforeInit: function(editor) {
      editor.addContentsCss(this.path + "css/ckeditor.nbsp.css");
    },
    init: function(editor) {
<<<<<<< HEAD
      //Add &shy; widget
=======
>>>>>>> main
      editor.widgets.add("insertNbsp", {
        template: '<span class="nbsp">&nbsp;</span>',
        draggable: false,
        allowedContent: ['span(!nbsp)'],
<<<<<<< HEAD
        //position cursor after widget so users can keep on typing
        init: function(){
          this.once( 'focus', function() {
            var range = editor.createRange();
=======
        init: function(){
          this.once( 'focus', function() {
            let range = editor.createRange();
>>>>>>> main
            range.moveToPosition( this.wrapper, CKEDITOR.POSITION_AFTER_END );
            range.select();
          }, this );
        },
        upcast: function (element, data) {
          return element.name == 'span' && element.hasClass('shy');
        }
      });
<<<<<<< HEAD
      // Insert  if Ctrl+Space is pressed:
      editor.setKeystroke(CKEDITOR.CTRL + 32 /* space */, "insertNbsp");
=======
      editor.setKeystroke(CKEDITOR.CTRL + 32 , "insertNbsp");
>>>>>>> main

      // Register the toolbar button.
      if (editor.ui.addButton) {
        editor.ui.addButton("DrupalNbsp", {
          label: Drupal.t("Non-breaking space"),
          command: "insertNbsp",
          icon: this.path + "icons/nbsp.png"
        });
      }
    }
  });
})(jQuery, Drupal, CKEDITOR);
