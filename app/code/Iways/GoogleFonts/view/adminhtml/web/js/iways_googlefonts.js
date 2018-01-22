function updatePreview(e) {
    
    e.css({
	'font-family': "'" + jQuery('.iways-font-face select.admin__control-select').val().replace('+', ' ') + "'"
    });
}

function populateFontFaceField(e, font_family) {
    
    jQuery.ajax({
        url: '/iways_googlefonts/font/get/font_family/' + font_family + '/',
        dataType: 'json',
        async: false
    }).done(function(data)
    {
	var variants = [];
	
	for (var property in data) {
	    
	    if (data.hasOwnProperty(property)) {
		
		variants.push(property);
		
		e.append('<option value="' + property + '">' + data[property] + '</option>');
	    }
	}
	
	jQuery.get('https://fonts.googleapis.com/css?family=' + font_family + ':' + variants.join(','), function(data) {
		
	    e.siblings('.iways-preview').children('style').text(data);
	    
	    updatePreview(e.siblings('.iways-preview'));
    	});

	e.removeClass('loading');
    });
}

function resetFontFaceField(e, font_family) {
    
    e.addClass('loading').empty();
    
    e.siblings('.iways-preview').children('style').empty();
    
    populateFontFaceField(e, font_family);
}

function checkFontFaceFields(val, input, e) {
    
    var element = jQuery(e).children('select');
  
    resetFontFaceField(element, 'Open+Sans');
}

jQuery(document).on('change', '.iways-font-face select.admin__control-select', function (e) {
    
    var customFieldsContainer = jQuery(this).siblings('.iways-font-face-fields'),
        element = customFieldsContainer.children('select');
    
    resetFontFaceField(element, jQuery(this).val());
});

/*var delay = 125,
    check = false;

jQuery(document).on('change keyup', '.iways-color input', function (e) {
    
    clearTimeout(check);

    var val = jQuery(this).val();
        
    if (val.length >= 3) {
	
	check = setTimeout(checkColorField, delay * 4, val, jQuery(this));
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

function checkColorField(val, e) {
    
    var color = tinycolor(val); // https://github.com/bgrins/TinyColor
    
    if (color.isValid()) {
        
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
}*/
