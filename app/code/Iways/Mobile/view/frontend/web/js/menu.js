define([
    'jquery',
    'jquery/ui',
    'mage/menu'
], function ($) {
	
	$.widget('iways.menu', $.mage.menu, {
		
		options: {
            responsive: false,
            expanded: false,
            delay: 300,
            invert_direction: 0
        },

		_listen: function () {
            var controls = this.controls;
            var toggle = this.toggle;

            this._on(controls.toggleBtn, {'click': toggle});

            if (this.options.invert_direction)
            	this._on(controls.swipeArea, {'swiperight': toggle});
            else
            	this._on(controls.swipeArea, {'swipeleft': toggle});
        }
	});
	
	return $.iways.menu;
});
