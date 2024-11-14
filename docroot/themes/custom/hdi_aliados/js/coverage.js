/* eslint-disable */

(function ($, Drupal) {
    Drupal.behaviors.coverage = {
        attach(context) {
            $('.form-modal', context).click(function () {
                $('.form-modal-wrap').addClass('display');
            });
        },
    };
}(jQuery,Drupal));
