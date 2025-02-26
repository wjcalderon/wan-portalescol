(function ($) {
  Drupal.behaviors.slickGallery = {
    attach: function (context, settings) {

      $(context).find('.slick-carousel').each(function () {
        var $carousel = $(this);

        if (!$carousel.hasClass('slick-initialized')) {
          $carousel.slick({
            dots: true,
            infinite: true,
            speed: 300,
            slidesToShow: 6,
            slidesToScroll: 1,
            adaptiveHeight: true,
            centerMode: false,
            prevArrow: '<button type="button" class="slick-prev custom-arrow-prev" aria-label="Previous" role="button"><span class="prev-arrow">←</span></button>',
            nextArrow: '<button type="button" class="slick-next custom-arrow-next" aria-label="Next" role="button"><span class="next-arrow">→</span></button>',
            responsive: [
              {
                breakpoint: 1024,
                settings: {
                  slidesToShow: 3,
                  slidesToScroll: 1,
                  infinite: true,
                  dots: true
                }
              },
              {
                breakpoint: 600,
                settings: {
                  slidesToShow: 1,
                  slidesToScroll: 1,
                  dots: true
                }
              }
            ]
          });
        }
      });

      $(context).find('.slick-item img').each(function() {
        var $image = $(this);

        $image.off('click').on('click', function() {

          if ($('.modal').length === 0) {

            var imageUrl = $(this).attr('src');
            var imageIndex = $(this).closest('.slick-item').index();
            var $carousel = $(this).closest('.slick-carousel');

            var modal = $('<div class="modal"><div class="modal-content"><img src="' + imageUrl + '" class="expanded-image"><button class="close-modal">X</button><a href="' + imageUrl + '" download>Descargar</a><button class="prev-image">←</button><button class="next-image">→</button></div></div>');
            $('body').append(modal);
            $('body').addClass('blur-background');

            modal.find('.expanded-image').css({
              'max-width': '90%',
              'max-height': '90%',
              'margin': 'auto',
              'display': 'block'
            });

            modal.find('.prev-image').click(function() {
              var prevIndex = imageIndex - 1;
              if (prevIndex < 0) {
                prevIndex = $carousel.find('.slick-item').length - 1;
              }
              var prevImage = $carousel.find('.slick-item').eq(prevIndex).find('img');
              var prevImageUrl = prevImage.attr('src');
              modal.find('.expanded-image').attr('src', prevImageUrl);
              imageIndex = prevIndex;
            });

            modal.find('.next-image').click(function() {
              var nextIndex = imageIndex + 1;
              if (nextIndex >= $carousel.find('.slick-item').length) {
                nextIndex = 0;
              }
              var nextImage = $carousel.find('.slick-item').eq(nextIndex).find('img');
              var nextImageUrl = nextImage.attr('src');
              modal.find('.expanded-image').attr('src', nextImageUrl);
              imageIndex = nextIndex;
            });

            modal.find('.close-modal').click(function() {
              modal.remove();
              $('body').removeClass('blur-background');
            });

            modal.click(function(event) {
              if (!$(event.target).closest('.modal-content').length) {
                modal.remove();
                $('body').removeClass('blur-background');
              }
            });
          }
        });
      });
    }
  };
})(jQuery);
