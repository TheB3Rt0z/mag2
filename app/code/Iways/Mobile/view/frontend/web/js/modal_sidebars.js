require([
    'jquery',
    'matchMedia'
], function ($, mediaCheck) {
    
    var toggle_class = 'open',
        animation_delay = 125;

    mediaCheck({
        
        media: '(max-width: 768px)',
        
        entry: function () {
            
            $('.sidebar.title').each(function () {
                
                var content = $(this).next('.sidebar');
                
                content.hide();
                $(this).removeClass(toggle_class);
                
                $(this).on('click', function () {
                    
                    $(this).toggleClass(toggle_class);
                    content.toggle(animation_delay);
                });
            });
        },
    
        exit: function () {
            
            $('.sidebar.title').off('click').next('.sidebar').show();
        }
    });
});
