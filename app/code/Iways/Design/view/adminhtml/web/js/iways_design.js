var delay = 125;

$(document).on('change keyup', '.iways-color input', function (e) {
    
    var val = $(this).val();
    
    if (val.length >= 3) {
    
        var color = tinycolor(val); // https://github.com/bgrins/TinyColor
        
        if (color.isValid()) {
            
            var colorHex = color.toHexString();
            
            $(this).val(colorHex)
            
            $(this).css('color', color.isLight() ? 'black' : 'white')
                   .css('background-color', colorHex);
        } else {
            $(this).css('color', 'initial')
                   .css('background-color', 'initial');
        }
    }
});

$(document).on('change', '.iways-width-height select', function (e) {
    
    var val = $(this).val(),
        customFieldsContainer = $(this).siblings('.iways-custom-fields'),
        customFields = customFieldsContainer.children('input, select'),
        hiddenField = $('input[name=' + $(this).attr('name') + '_custom]');
    
    function customFieldsResult() {
        
        return customFields.eq(0).val() + ";" + customFields.eq(1).val() + ";"
             + customFields.eq(2).val() + ";" + customFields.eq(3).val();
    }

    if (val == 1) {
        customFieldsContainer.show(delay);
        hiddenField.val(customFieldsResult());
        customFields.on('change keyup', function (e) {
            hiddenField.val(customFieldsResult()).trigger('change');
        });
    } else {
        customFieldsContainer.hide(delay);
    }
});
