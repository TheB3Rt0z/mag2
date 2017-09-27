var delay = 125;

jQuery(document).on('change keyup', '.iways-color input', function (e) {
    
    var val = jQuery(this).val();
    
    if (val.length >= 3) {
    
        var color = tinycolor(val); // https://github.com/bgrins/TinyColor
        
        if (color.isValid()) {
            
            var colorHex = color.toHexString();
            
            jQuery(this).val(colorHex)
            
            jQuery(this).css('color', color.isLight() ? 'black' : 'white')
                   .css('background-color', colorHex);
        } else {
            jQuery(this).css('color', 'initial')
                   .css('background-color', 'initial');
        }
    }
});

jQuery(document).on('change', '.iways-width-height select', function (e) {
    
    var val = jQuery(this).val(),
        customFieldsContainer = jQuery(this).siblings('.iways-custom-fields'),
        customFields = customFieldsContainer.children('input, select'),
        hiddenField = jQuery('input[name=' + jQuery(this).attr('name') + '_custom]');

    function customFieldsResult() {
        
        return customFields.eq(0).val() + ";" + customFields.eq(1).val() + ";"
             + customFields.eq(2).val() + ";" + customFields.eq(3).val();
    }

    if (val == 1) {
        customFieldsContainer.show(delay);
        hiddenField.val(customFieldsResult());
        customFields.on('change keyup', function (e) {
            if (jQuery(this).val() == 'auto') {
                jQuery(this).prev().val(0).hide(delay);
            } else {
                jQuery(this).prev().show(delay);
            }
            hiddenField.val(customFieldsResult()).trigger('change');
        });
    } else {
        customFieldsContainer.hide(delay);
    }
});

function checkCustomFields(val, input, e) {
    
    jQuery(document).ready(function() {

        if (val == 1) {

            var control = jQuery('[name=' + input + ']'),
                value = jQuery('[name=' + input + '_custom]').val(),
                values = value.split(';'),
                container = jQuery(e);
            
            container.children('input, select').each(function(index) {
                jQuery(this).val(values[index]);
            });
            
            control.trigger('change').siblings('.iways-custom-fields').children('select').trigger('change');
            
            container.show(delay);
        }
    });
}
