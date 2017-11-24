(function( $, doc, win ) {
    "use strict";
    if( inc_opt.is_upfront ) return;

	Optin = window.Optin || {};
    
	Optin.PopUp = Optin.View.extend({
		className: 'inc_opt_popup wpoi-animate inc_optin',
		type: 'popup'
	});
}(jQuery, document, window));