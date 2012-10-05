(function($) {
    $(function(){
        $('.nav a').click(function(e) {
            e.preventDefault();
            $.get($(this).attr('href'), function(data) {
                $('#main').html(data);
            });
        });
    });
})(jQuery);
