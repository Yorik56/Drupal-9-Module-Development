import GLightbox from 'glightbox';

/**
 * @file
 * blue2i behaviors.
 */
(function ($, Drupal) {

    'use strict';

    /**
     * Behavior description.
     */
    Drupal.behaviors.blue2i = {
        attach: function (context, settings) {
            console.log('It works!');
            const lightbox = GLightbox();
            $(".slider")
            .on('afterChange init', function(event, slick, direction){
                    // console.log('afterChange/init', event, slick, slick.$slides);
                    // remove all prev/next
                    slick.$slides.removeClass('prevSlide').removeClass('nextSlide');

                    // find current slide
                    for (var i = 0; i < slick.$slides.length; i++)
                    {
                        var $slide = $(slick.$slides[i]);
                        if ($slide.hasClass('slick-current')) {
                            // update DOM siblings
                            $slide.prev().addClass('prevSlide');
                            $slide.next().addClass('nextSlide');
                            break;
                        }
                    }
                }
            )
            .on('beforeChange', function(event, slick) {
                // optional, but cleaner maybe
                // remove all prev/next
                slick.$slides.removeClass('prevSlide').removeClass('nextSlide');
            })
            .slick({
                respondTo: 'slider'
            });

        }
    };

}(jQuery, Drupal));
