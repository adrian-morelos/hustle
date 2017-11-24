(function($){
	'use strict';

	Optin.Mixins.add_services_mixin( 'infusionsoft', function() {
		return new Optin.Provider({
			id: 'infusionsoft',
			provider_args: {account_name: '#optin_account_name'},
			errors: {
				account_name: {
					name: 'optin_account_name',
					message: optin_vars.messages.infusionsoft.enter_account_name,
					iconClass: 'dashicons-warning-account_name'
				}
			}
		});
	});
}(jQuery,document));