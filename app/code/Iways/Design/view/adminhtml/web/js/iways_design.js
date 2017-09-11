$(document).on('change keyup', '.iways-color input', function (e) {
    
    var val = $(this).val();
    
    if (val.length >= 3) {
    
        var color = tinycolor(val); // https://github.com/bgrins/TinyColor
        
        if (color.isValid()) {
            
            var color_hex = color.toHexString();
            
            $(this).val(color_hex)
            
            $(this).css('color', color.isLight() ? 'black' : 'white')
                   .css('background-color', color_hex);
        } else {
            $(this).css('color', 'initial')
                   .css('background-color', 'initial');
        }
    }
});
