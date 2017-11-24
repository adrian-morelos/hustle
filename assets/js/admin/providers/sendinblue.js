(function($,doc){
	'use strict';

    Optin.Mixins.add_services_mixin( 'sendinblue', function( service_tab_view ) {
        return new Optin.Provider({
			id: 'sendinblue',
			provider_args: {email_list: '#optin_email_list'},
			errors: {
				email_list: {
					name: 'optin_email_list',
					message: optin_vars.messages.infusionsoft.enter_account_name,
					iconClass: 'dashicons-warning-account_name'
				}
			},


            init: function() {

				/**
				 * Load more lists
				 * @param {*} e 
				 */
				var load_more_lists = function(e){
					var $this = $(e.target),
						$form = $this.closest("form"),
						$box = $("#wpoi-wizard-services"),
						data = $form.serialize(),
						$placeholder = $("#optin_new_provider_account_options");


					$("#wpoi-sendinblue-prev-group-args").empty();

					$placeholder.html( $( "#wpoi_loading_indicator" ).html() );

					data += "&action=refresh_provider_account_details&load_more=true";
					data += "&optin=sendinblue";
					$box.find("input,select,button").attr("disabled", true);

					/**
					 * Silently clear the args untill they are filled again
					 */
					Optin.step.services.provider_args.clear({silent: true});
					Optin.step.services.model.set( "optin_mail_list", "none" );

					$.post(ajaxurl, data, function( response ){

						$box.find("input,select,button").attr("disabled", false);

						if( response.success === true ){

							if( response.data.redirect_to ){
								window.location.href = response.data.redirect_to;
							}else {
								if ( ! response.data ) {
									$placeholder.html( optin_vars.messages.something_went_wrong );
								} else {
									$placeholder.html( response.data );
								}
								$(".sendinblue_optin_email_list").wpmuiSelect();
							}
						}else{
							if ( ! response.data ) {
								$placeholder.html( optin_vars.messages.something_went_wrong );
							} else {
								$placeholder.html( response.data  );
							}
						}

					}).fail(function( response ) {
						$placeholder.html( optin_vars.messages.something_went_wrong );
					});
				};

				$(doc).on("click", ".sendinblue_optin_load_more_lists", load_more_lists);
            }
		});
    });
}(jQuery,document));