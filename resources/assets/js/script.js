(function($) {
    $(function(){
        // Only if supports pushState
        if (!(window.history && window.history.pushState)) {
            return;
        }

        /**
         * Loads main content.
         *
         * @param String url
         */
        var loadContent = function(url) {
            $.get(url, function(data) {
                $('#main').html(data);
            });
        };

        // Handle back and forward
        var loaded = false;
        window.onpopstate = function() {
            if (!loaded) {
                loaded = true;
                return;
            }

            loadContent(document.location.pathname);
        };

        // Ajaxify main navigation
        $('.nav a').click(function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            loadContent(url);
            window.history.pushState(true, null, url);
        });
    });
})(jQuery);
