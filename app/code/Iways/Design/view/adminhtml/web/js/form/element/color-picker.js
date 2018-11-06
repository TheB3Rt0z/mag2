define([
    'Magento_Ui/js/form/element/abstract',
    'mageUtils',
    'jquery',
    'jquery/colorpicker/js/colorpicker'
], function (element, mageUtils, $) {
	
    'use strict';

    return element.extend({
        defaults: {
            visible: true,
            label: '',
            error: '',
            uid: mageUtils.uniqueid(),
            disabled: false,
            links: {
                value: '${$.provider}:${$.dataScope}'
            }
        },

        initialize: function ()
        {	
            this._super();
        },

        initColorPickerCallback: function (element)
        {
            var self = this,
                reset = $(element).siblings('.admin__field-fallback-reset');
            
            checkColorField($(element).val(), $(element));

            $(element).ColorPicker(
            {
                onChange: function (hsb, hex, rgb)
                {
                    self.value("#" + hex);
                    
                    var input = $(element);
                    
                    checkColorField(hex, input);
                },
            	onSubmit: function (hsb, hex, rgb, el)
                {
                	var input = $(el);
                	
                    self.value('#' + hex);
                    
                    input.ColorPickerHide();
                    
                    checkColorField(input.val(), input);
                },
                onBeforeShow: function ()
                {
                	$(this).ColorPickerSetColor(this.value);
                }
            }).bind('keyup', function ()
            {
                $(this).ColorPickerSetColor(this.value);
            });
            
            reset.on('click', function ()
            {
            	checkColorField(false, $(element));
            });
        }
    });
});
