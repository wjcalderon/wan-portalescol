(function ($, Drupal, window, document) {
  'use strict';

  Drupal.behaviors.libertyMasonryConfig = {
    attach: function (context, settings) {

      $('.grid').masonry({
        // options
        itemSelector: '.grid-item',
        columnWidth: 300
      });

    }
  }
} (jQuery, Drupal, this, this.document));
