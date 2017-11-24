(function($){
	'use strict';

	Optin.Mixins.add_services_mixin( 'convertkit', function() {
		return new Optin.Provider({
			id: 'convertkit',
			provider_args: {api_secret: '#optin_api_secret'},
			errors: {
				api_secret: {
					name: 'optin_api_secret',
					message: optin_vars.messages.convertkit.enter_api_secret,
					iconClass: 'dashicons-warning-account_name'
				}
			}
		});
	});
}(jQuery,document));