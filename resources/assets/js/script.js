(function($) {
    $(function(){
        $('.nav a').click(function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            $.get(url, function(data) {
                $('#main').html(data);
                window.history.pushState(null, null, url);
            });
        });
    });
})(jQuery);
