(function($){
	'use strict';

	Optin.Mixins.add_services_mixin( 'mautic', function() {
		return new Optin.Provider({
			id: 'mautic',
			provider_args: {
				url: '#optin_url',
				username: '#optin_username',
				password: '#optin_password'
			},
			errors: {
				url: {
					name: 'optin_url',
					message: optin_vars.messages.mautic.enter_url,
					iconClass: 'dashicons-warning-url'
				},
				username: {
					name: 'optin_username',
					message: optin_vars.messages.mautic.username,
					iconClass: ''
				},
				password: {
					name: 'optin_password',
					message: optin_vars.messages.mautic.password,
					iconClass: ''
				}
			}
		});
	});
}(jQuery,document));