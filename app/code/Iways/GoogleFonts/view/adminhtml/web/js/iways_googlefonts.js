var font_families = [];

function updatePreview(e)
{
    var mainField = e.parent().siblings('select.admin__control-select'),
        customFieldsContainer = mainField.siblings('.iways-font-face-fields'),
        customFields = customFieldsContainer.children('input, select'),
        font_weight = customFields.eq(0).val(),
        font_style = (font_weight.substr(font_weight.length - 1) == 'i') ? 'italic' : 'normal',
        font_value = customFields.eq(1).val() * 1,
        font_size = font_value
                  ? font_value + customFields.eq(2).val()
                  : 'initial',
        hiddenField = jQuery('input[name=' + mainField.attr('name') + '_variant]'),
        customResult = font_weight + ";" + font_value + ";" + customFields.eq(2).val()
                     + ";" + parseInt(font_weight) + ";" + font_style + ";" + font_size;

    e.css({
        'font-family': "'" + mainField.val().replace('+', ' ') + "'",
        'font-size': font_size,
        'font-style': font_style,
        'font-weight': parseInt(font_weight)
    });
    
    hiddenField.val(customResult).trigger('change');
}

function initFontFaceFields(e, data, font_family)
{
    var variants = [],
        container = e.parent(),
        control = container.siblings('select'),
        name = control.attr('name'),
        value = jQuery('[name=' + name + '_variant]').val(),
        values = value.split(';');

    for (var property in data) {
        
        if (data.hasOwnProperty(property)) {
        
            variants.push(property);
            
            e.append('<option value="' + property + '">' + data[property] + '</option>');
        }
    }
    
    container.children('input, select').each(function (index)
    {
        if (values[index]) {
            
            jQuery(this).val(values[index]);
        }
    });
    
    jQuery.get('https://fonts.googleapis.com/css?family=' + font_family + ':' + variants.join(','), function(data)
    {
        e.siblings('.iways-preview').children('style').text(data);
        
        updatePreview(e.siblings('.iways-preview'));
    });
    
    e.removeClass('loading');
}

function populateFontFaceFields(e, font_family)
{
    if (data = font_families[font_family]) {
        
        return initFontFaceFields(e, data, font_family);
    }
    
    jQuery.ajax({
        url: '/iways_googlefonts/font/get/font_family/' + font_family + '/',
        //async: false,
        dataType: 'json'
    }).done(function(data)
    {
        font_families[font_family] = data;
        
        initFontFaceFields(e, data, font_family);
    });
}

function resetFontFaceFields(e, font_family)
{
    if (!(e instanceof jQuery)) {
        
        e = jQuery(e);
    }
    
    e.addClass('loading').empty();
    
    e.siblings('.iways-preview').children('style').empty();
    
    populateFontFaceFields(e, font_family);
}

function checkFontFaceFields(val, input, e)
{
    var element = jQuery(e).children('select.iways-empty'),
        mainField = jQuery('.iways-font-face select.admin__control-select'),
        customFieldsContainer = mainField.siblings('.iways-font-face-fields'),
        customFields = customFieldsContainer.children('input, select');
  
    resetFontFaceFields(element, mainField.val());
    
    mainField.on('change', function ()
    {
        var customFieldsContainer = jQuery(this).siblings('.iways-font-face-fields'),
            element = customFieldsContainer.children('select.iways-empty');
            
        resetFontFaceFields(element, jQuery(this).val());
    });
    
    customFields.on('change keyup', function ()
    {
        updatePreview(jQuery(this).siblings('.iways-preview'));
    });
}

