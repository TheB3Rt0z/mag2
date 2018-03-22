var delay = 125,
    check = false;

jQuery(document).on('change keyup', 'input.iways-color', function (e)
{
    //clearTimeout(check);

    var input = jQuery(this),
        val = input.val().replace("#", '');
        
    if (!val || val.length >= 6) {
    
    	checkColorField(val, input);//check = setTimeout(checkColorField, delay * 4, val, jQuery(this));
    }
});

jQuery(document).on('change', '.iways-width-height select', function (e)
{
    var val = jQuery(this).val(),
        customFieldsContainer = jQuery(this).siblings('.iways-width-height-fields'),
        customFields = customFieldsContainer.children('input, select'),
        hiddenField = jQuery('input[name=' + jQuery(this).attr('name') + '_variant]');

    function customFieldsResult() {
        
        return customFields.eq(0).val() + ";" + customFields.eq(1).val() + ";"
             + customFields.eq(2).val() + ";" + customFields.eq(3).val();
    }

    if (val == 1) {
    
        customFieldsContainer.show(delay);
        hiddenField.val(customFieldsResult());
        customFields.on('change keyup', function (e)
        {
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

function checkWidthHeightFields(val, input, e) // @todo define here the onchange events
{
    jQuery(document).ready(function ()
    {
        if (val == 1) {

            var control = jQuery('[name=' + input + ']'),
                value = jQuery('[name=' + input + '_custom]').val(),
                values = value ? value.split(';') : [],
                container = jQuery(e);
            
            container.children('input, select').each(function (index)
            {
                jQuery(this).val(values[index]);
            });
            
            control.trigger('change').siblings('.iways-width-height-fields').children('select').trigger('change');
            
            container.show(delay);
        }
    });
}

function checkColorField(val, e)
{
    var color = tinycolor(val), // https://github.com/bgrins/TinyColor
        e = (typeof e == 'string') ? jQuery('#' + e) : e;

    if (val && color.isValid()) {
        
        var colorHex = color.toHexString();
        
        e.val(colorHex).css({
            'color': color.isLight() ? 'black' : 'white',
            'background-color': colorHex
        });
        
    } else {
        
        e.css({
            'color': 'initial',
            'background-color': 'initial'
        });
    }
  
    check = false;
}
