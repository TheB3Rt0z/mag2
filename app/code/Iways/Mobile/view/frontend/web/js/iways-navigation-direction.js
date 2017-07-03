define([
    'jquery',
    'jquery/ui',
    'mage/menu'
], function ($) {
	
	$.widget('iways.menu', $.mage.menu, {
		
		_listen: function () {
            var controls = this.controls;
            var toggle = this.toggle;

            this._on(controls.toggleBtn, {'click': toggle});
            this._on(controls.swipeArea, {'swiperight': toggle});
        }
	});
	
	return $.iways.menu;
});
