/**
 * Integration of none-too-complicated providers.
 **/

(function($){
	'use strict';

	var providers = ['getresponse', 'campaignmonitor','aweber'];

	_.each( providers, function( provider ) {
		Optin.Mixins.add_services_mixin( provider, function() {
			return new Optin.Provider({id: provider});
		});
	});
}(jQuery,document));