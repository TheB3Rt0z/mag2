function initInputTypeNumber(wrapper = null)
{
    var check = true;
    
    jQuery.ajax({
        url: '/iways_base/configuration/get/input/style_type_number/',
        dataType: 'json',
        async: false
    }).done(function(data) {
        check = data.input.style_type_number * 1;
    });

    if (!check) {
        return; // blocks execution if boolean setting returns false
    }
    
    jQuery((wrapper ? wrapper + ' ' : '') + 'input[type="number"]').each(function () {
        var input = jQuery(this),
            down = jQuery('<span class="number-nav input-down">&#x25bc;</span>').insertAfter(input),
            up = jQuery('<span class="number-nav input-up">&#x25b2;</span>').insertAfter(input),
            min = input.attr('min'),
            max = input.attr('max');
        
        if (!min) {
            min = 1;
            input.attr('min', min);
        }
        
        if (!input.prop('disabled')) {
            up.on('click', function () {
                var current = parseFloat(input.val());
                if (!max || (current < max)) {
                    input.val(current + 1).trigger('change').trigger('input').trigger('keyup');
                }
            });
            
            down.on('click', function () {
                var current = parseFloat(input.val());
                if (current > min) {
                    input.val(current - 1).trigger('change').trigger('input').trigger('keyup');
                }
            });
        }
        
        input.addClass('iways-base-theme');
    });
}

require([
    'jquery'
], function ($) {
    $(function () {
        initInputTypeNumber();
    });
});
