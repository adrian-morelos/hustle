(function( $ ) {
    Optin = Optin || {};
    Optin.handle_scroll = function( $el, type, optin ){
        var $win =  $(window),
            $doc = $(document);

        $win.on('scroll', _.debounce( function (evt) {

            var el = $el[0];

            var rect = el.getBoundingClientRect();

            if (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) && /*or $(window).height() */
                rect.right <= (window.innerWidth || document.documentElement.clientWidth) /*or $(window).width() */
            ) {
                $win.off(evt);
                $el.addClass("wpoi-show");
                $doc.trigger("wpoi:display", [type, $el, optin ]);
            }

        }, 5, true) );

    }
	Optin.handle_cc_scroll = function( $el, type, id ){
        var $win =  $(window),
            $doc = $(document);

        $win.on('scroll', _.debounce( function (evt) {

            var el = $el[0];

            var rect = el.getBoundingClientRect();

            if (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.right <= (window.innerWidth || document.documentElement.clientWidth)
            ) {
                $win.off(evt);
                
                var cc = _.find(Hustle_Custom_Contents, function (opt) {
                    return id == opt.content.optin_id;
                });
                
                if (!cc) return;
                
                if ( cc.tracking_types != null && _.isTrue( cc.tracking_types[type] ) ) {
                    $doc.trigger("wpoi:cc_shortcode_or_widget_viewed", [type, id]);
                }
            }

        }, 5, true) );

    }
}(jQuery));