(function($) {
    Drupal.behaviors.paymentMethods = {
        attach: function(context, settings) {
            $('#list-product-type').change(function(event) {
                var valueSelected = $(this).val();
                $('.views-row').removeClass('disabled');
                $('div.view-content h3.payment-channel').removeClass('disabled');
                if (valueSelected != Drupal.t('all')) {
                    var str1 = '.views-row:not(.';
                    var selector = str1.concat(valueSelected, ')');
                    $(selector).addClass('disabled');
                    $('div.view-content  h3.payment-channel').each(function() {
                        // Opción sin estilos
                        var count1 = $(this).nextUntil('div.view-content  h3.payment-channel', '.views-row').length;
                        var count2 = $(this).nxextUntil('div.view-content  h3.payment-channel', '.views-row.disabled').length;
                        if ((count1 - count2) <= 0) {
                            $(this).addClass('disabled');
                        }
                        //Opción con estilos
                        // $(this).parent('')
                    });
                }

            });

            $('select[name="field_product_type_target_id"]').change(function(event) {
                $('input[name="button-filter-product-type"]').click();
            });
            
            
        }
    }
})(jQuery);