require([
    'jquery'
], function ($)
{
    var toggle_class = 'closed',
        animation_delay = 125;
    
    $('.sidebar .block .block-title').each(function ()
    {
        var content = $(this).next('.block-content');
    
        $(this).on('click', function ()
        {
            $(this).toggleClass(toggle_class);
            content.toggle(animation_delay);
        });
    });

    $('.sidebar .block .filter-options-title').each(function ()
    {
        var content = $(this).next('.filter-options-content');
    
        $(this).on('click', function ()
        {
            $(this).toggleClass(toggle_class);
            content.toggle(animation_delay);
        });
    });
});
