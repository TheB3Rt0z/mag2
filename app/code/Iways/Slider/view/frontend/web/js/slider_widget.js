define([
    "jquery",
    "iways_slider/unslider",
    "iways_slider/move",
    "iways_slider/swipe"
], function($, slider, move, swipe) {
    "use strict";
    $.widget( "iways.slider", {
        _create: function() {
            $(this.element).unslider({infinite: true, nav: false});
            $(this.element).unslider('initSwipe');
        },
    });
    return $.iways.slider
});