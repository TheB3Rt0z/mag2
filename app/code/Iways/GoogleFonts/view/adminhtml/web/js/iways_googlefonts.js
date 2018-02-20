function updatePreview(e)
{    
    var mainField = e.parent().siblings('select.admin__control-select'),
        customFieldsContainer = mainField.siblings('.iways-font-face-fields'),
        customFields = customFieldsContainer.children('input, select'),
        font_weight = customFields.eq(0).val(),
        font_value = customFields.eq(1).val() * 1,
        font_size = font_value
                  ? font_value + customFields.eq(2).val()
                  : 'initial',
        hiddenField = jQuery('input[name=' + mainField.attr('name') + '_variant]'),
        customResult = font_weight + ";" + font_size;
    
    e.css({
        'font-family': "'" + mainField.val().replace('+', ' ') + "'",
        'font-size': font_size,
        'font-weight': font_weight
    });
    
    hiddenField.val(customResult).trigger('change');
}

function populateFontFaceField(e, font_family)
{
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

        jQuery.get('https://fonts.googleapis.com/css?family=' + font_family + ':' + variants.join(','), function(data)
        {
            e.siblings('.iways-preview').children('style').text(data);
            
            updatePreview(e.siblings('.iways-preview'));
        });
    
        e.removeClass('loading');
    });
}

function resetFontFaceField(e, font_family)
{
    if (!(e instanceof jQuery)) {
        
        e = jQuery(e);
    }
    
    e.addClass('loading').empty();
    
    e.siblings('.iways-preview').children('style').empty();
    
    populateFontFaceField(e, font_family);
}

function checkFontFaceFields(val, input, e) 
{    
    var element = jQuery(e).children('select.iways-empty'),
        mainField = jQuery('.iways-font-face select.admin__control-select'),
        customFieldsContainer = mainField.siblings('.iways-font-face-fields'),
        customFields = customFieldsContainer.children('input, select');
  
    resetFontFaceField(element, mainField.val());
    
    mainField.on('change', function ()
    {
        var customFieldsContainer = jQuery(this).siblings('.iways-font-face-fields'),
            element = customFieldsContainer.children('select.iways-empty');
            
        resetFontFaceField(element, jQuery(this).val());
    });
    
    customFields.on('change keyup', function ()
    {
        updatePreview(jQuery(this).siblings('.iways-preview'));
    });
}
