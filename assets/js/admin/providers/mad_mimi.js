(function($){
	'use strict';

	Optin.Mixins.add_services_mixin( 'mad_mimi', function() {
		return new Optin.Provider({
			id: 'mad_mimi',
			provider_args: {username: '#optin_username'},
			errors: {
				username: {
					name: 'optin_username',
					message: optin_vars.messages.sendy.enter_url,
					iconClass: 'dashicons-warning-url'
				}
			}
		});
	});

}(jQuery,document));