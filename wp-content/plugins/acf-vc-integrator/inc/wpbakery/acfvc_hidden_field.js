!function($) {

    /*Copy selected field name to hidden field*/
    function copy_field_name_to_hidden_field () {
        var dropdown_name_field = $('select[name^="field_from"]');

        $.each( dropdown_name_field, function( key, val ) {

            var field_name_dropdown_classList = $(this).closest('.vc_wrapper-param-type-dropdown')[0]["classList"];

            if ( !field_name_dropdown_classList.contains("vc_dependent-hidden") ) {

                var acf_field_name = $(this).find("option:selected").text();
                $('.acfvc_hidden-field').val(acf_field_name);

            }

        });

    }

    $('span[data-vc-ui-element="button-save"]').click(function(event) {
        copy_field_name_to_hidden_field();
    });

    $('span[data-vc-ui-element="button-close"]').click(function(event) {
        copy_field_name_to_hidden_field();
    });

}(window.jQuery);
