require([
    'jquery',
    'matchMedia'
], function ($, mediaCheck) {
    
    var toggleClass = 'open',
        animationDelay = 125;

    mediaCheck({
        
        media: '(max-width: 768px)',
        
        entry: function () {
            
            $('.sidebar.title').each(function () {
                
                var content = $(this).next('.sidebar');
                
                content.hide();
                $(this).removeClass(toggleClass);
                
                $(this).on('click', function () {
                    
                    $(this).toggleClass(toggleClass);
                    content.toggle(animationDelay);
                });
            });
        },
    
        exit: function () {
            
            $('.sidebar.title').off('click').next('.sidebar').show();
        }
    });
});
