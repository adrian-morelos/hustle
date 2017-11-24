(function($){
	'use strict';

	Optin.Mixins.add_services_mixin( 'sendy', function() {
		return new Optin.Provider({
			id: 'sendy',
			provider_args: {installation_url: '#optin_sendy_installation_url'},
			errors: {
				installation_url: {
					name: 'optin_sendy_installation_url',
					message: optin_vars.messages.sendy.enter_url,
					iconClass: 'dashicons-warning-url'
				}
			}
		});
	});
}(jQuery,document));