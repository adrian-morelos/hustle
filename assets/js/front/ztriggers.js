(function( $, doc, win ) {
    "use strict";
    if( inc_opt.is_upfront ) return;

	// Listen to exit intent
	$(doc).on( 'mouseleave', $.proxy( Hustle.Events, 'trigger', 'exit_intended' ) );

	// Listen to resize event
	$(window).on( 'resize', $.proxy( Hustle.Events, 'trigger', 'hustle_resize' ) );

	// Opt-In
	$.each( _.keys(Optins), function(i, k){
		var opt = Optins[k],
			settings = opt.settings,
			optin_id = opt.data.optin_id,
			args = {key: k};

		// Check for enabled popup
		if ( settings.popup && settings.popup.enabled
			&& ! _.isTrue( Optin.cookie.get( Optin.POPUP_COOKIE_PREFIX + optin_id ) ) ) {
			new Optin.PopUp(args);
		}

		// Check for enabled slide_in
		if ( settings.slide_in && settings.slide_in.enabled
			&& ! _.isTrue( Optin.cookie.get( Optin.SLIDE_IN_COOKIE_HIDE_ALL ) ) ) {
			new Optin.SlideIn(args);
		}

		// Check for enabled after_content
		if ( settings.after_content && settings.after_content.enabled ) {
			var after_content = $('[data-id="' + optin_id + '"]').filter(function() {
				return $(this).is('.inc_opt_after_content_wrap');
			});

			if ( after_content.length ) {
				after_content.each(Optin.AfterContent);
			}
		}
	});

	// CUSTOM CONTENT
    // console.log(Hustle_Custom_Contents);
	$.each(Hustle_Custom_Contents, function(uniq_id, cc) {
		cc.id = uniq_id;

		if ( cc.should_display ) {
			// Check for enabled popup
			if ( _.isTrue(cc.should_display.popup) && _.isTrue(cc.popup.enabled) ) {
				cc.type = 'popup';
				new Optin.CCPopUp(cc);
			}

			// Check for enabled slide_in
			if ( _.isTrue(cc.should_display.slide_in) && _.isTrue(cc.slide_in.enabled) ) {
				cc.type = 'slide_in';
				new Optin.CCSlideIn(cc);
			}

			if ( cc.after_content && _.isTrue(cc.should_display.after_content) && _.isTrue(cc.after_content.enabled) ){
				cc.type = 'after_content';
				cc.uniq_id = uniq_id;
				new Optin.CCAfterContent(cc);
			}
		}
	});
    
    
    // SOCIAL SHARING
    _.each(Hustle_SS_Modules, function(ss, key) {
        if ( _.isTrue(ss.floating_social.enabled) && _.isTrue(ss.is_floating_social_allowed) ) {
            new Optin.SS_floating(ss);
        }
    });
    
}(jQuery, document, window));