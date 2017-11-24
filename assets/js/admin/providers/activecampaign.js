(function($){
	'use strict';

	Optin.Mixins.add_services_mixin( 'activecampaign', function() {
		return new Optin.Provider({
			id: 'activecampaign',
			provider_args: {url: '#optin_url'},
			errors: {
				url: {
					name: 'optin_url',
					message: optin_vars.messages.activecampaign.enter_url,
					iconClass: 'dashicons-warning-account_name'
				}
			}
		});
	});
}(jQuery,document));