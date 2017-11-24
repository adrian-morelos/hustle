(function($,doc){
	'use strict';

	Optin.Mixins.add_services_mixin( 'mailchimp', function( service_tab_view ) {
		return new Optin.Provider({
			id: 'mailchimp',
			provider_args: {email_list: '#optin_email_list'},
			errors: {
				email_list: {
					name: 'optin_email_list',
					message: optin_vars.messages.infusionsoft.enter_account_name,
					iconClass: 'dashicons-warning-account_name'
				}
			},
			render_in_previewr: function($preview){
				var $_preview = $preview.$el ? $preview.$el : $preview;
				if( !Optin.step.services.provider_args.isEmpty() && "mailchimp" === Optin.step.services.model.get("optin_provider") ){
					var provider_args_template = Optin.template( "optin-" + Optin.step.services.model.get("optin_provider") + "-args"  );
                    var provider_args_data = Optin.step.services.provider_args.toJSON();
                    provider_args_data.cta_button = Optin.step.design.model.get('cta_button');
					$_preview.find(".wpoi-provider-args").html( provider_args_template( provider_args_data ) );
				}
			},
			init: function() {
				var tab = service_tab_view,
				$form = tab.$("#hustle_service_details_form"),
				$prev_args = $("#wpoi-mailchimp-prev-group-args"),
				$_preview = false;

				/**
				* Updates list groups on list change
				*
				**/
			   var update_list_groups = function(e){
				   var $this = $(e.target),
					   $wrapper = $('.wpoi-list-groups'),
					   $interests_wrapper = $(".wpoi-list-group-interests-wrap"),
					   data = _.reduce( $form.serializeArray(), function(obj, item){
						   obj[ item['name'] ] = item['value'];
						   return obj;
					   }, {});
	   
				   data.action = 'hustle_mailchimp_get_list_groups';
	   
				   data._ajax_nonce = $this.data("nonce");
	   
				   //clear provider model
				   Optin.step.services.provider_args.clear({silent: true});
				   $interests_wrapper.empty();
				   $prev_args.empty();
	   
				   $.get( ajaxurl, data)
					   .done(function(res){
                            if( res ){
							   if ( res.success ) {
									$wrapper.html( res.data );
							   		$wrapper.find("select").wpmuiSelect();
							   		$('.mailchimp_optin_load_more_lists').show();
							   } else {
								   	$('.mailchimp_optin_load_more_lists').hide();
							   		$wrapper.empty();
							   }
							   
						   }
					   });
	   
			   };

			   /**
				* Updates group interests on group change
				*
				**/
			   var update_group_interests = function(e){
	   
				   var $wrapper = $(".wpoi-list-group-interests-wrap"),
					   $this = $(e.target),
					   data = _.reduce( $form.serializeArray(), function(obj, item){
						   obj[ item['name'] ] = item['value'];
						   return obj;
					   }, {});
	   
				   if( ["-1", "0"].indexOf(e.target.value) !== -1 ){ // return if selection is not meaningful
					   $wrapper.empty();
					   return;
				   }
	   
				   data._ajax_nonce = $this.data("nonce");
				   data.action = 'hustle_mailchimp_get_group_interests';
	   
				   $.get( ajaxurl, data )
					   .done(function(res){
						   if( res && res.success ){
	   
							   $wrapper.html( res.data.html );
	   
							   Optin.step.services.provider_args.set( "group", res.data.group );
	   
							   $wrapper.find("select").wpmuiSelect();
							   /**
								* Select all interests
								**/
							   if( res.data.group && res.data.group.groups && _.isArray( res.data.group.groups ) ) {
								   var group = Optin.step.services.provider_args.get("group");
							   }
	   
						   }
	   
						   if( res && !res.success )
							   $wrapper.empty();
					   })
					   .fail(function(res){
	   
					   });
			   };
	   
			   var update_selected_group_interests = function(e){
				   var $this = $(e.target),
					   val;
	   
				   if( $this.is(":radio") || $this.is("select") )
					   val = $this.val();
	   
				   if( $this.is(":checkbox") ){
					   val = [];
					   $( "[name='" + e.target.name + "'" ).filter( ":checked" ).each(function(){
						 val.push( this.value );
					   });
	   
				   }
  
				   Optin.step.services.provider_args.set( "group", _.extend( {}, Optin.step.services.provider_args.get("group"), {
					   selected: val
				   }) );
			   };
			   
				var unselect_radio_interest = function(e){
					e.preventDefault();
					$("[name='mailchimp_groups_interests']").prop("checked", false);
					Optin.step.services.provider_args.set( "group", _.extend( {}, Optin.step.services.provider_args.get("group"), {
						selected: []
					}) );
				};
                
                /**
				 * Load more lists
				 * @param {*} e 
				 */
				var load_more_lists = function(e){
					var $this = $(e.target),
						$form = $this.closest("form"),
						$box = $(".wpoi-box"),
						data = $form.serialize(),
						$placeholder = $("#optin_new_provider_account_options");


					$("#wpoi-mailchimp-prev-group-args").empty();

					$placeholder.html( $( "#wpoi_loading_indicator" ).html() );

					data += "&action=refresh_provider_account_details&load_more=true";
					data += "&optin=mailchimp";
					$box.find("*").attr("disabled", true);

					/**
					 * Silently clear the args untill they are filled again
					 */
					Optin.step.services.provider_args.clear({silent: true});
					Optin.step.services.model.set( "optin_mail_list", "none" );

					$.post(ajaxurl, data, function( response ){

						$box.find("*").attr("disabled", false);

						if( response.success === true ){

							if( response.data.redirect_to ){
								window.location.href = response.data.redirect_to;
							}else {
								if ( ! response.data ) {
									$placeholder.html( optin_vars.messages.something_went_wrong );
								} else {
									$placeholder.html( response.data );
								}
								$(".mailchimp_optin_email_list").wpmuiSelect();
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

				$(doc).on("change", "#optin_email_list.mailchimp_optin_email_list", update_list_groups );
				$(doc).on("change", "#mailchimp_groups", update_group_interests );
				$(doc).on("change", "[name='mailchimp_groups_interests'], [name='mailchimp_groups_interests[]']", update_selected_group_interests );
				$(doc).on("click", ".wpoi-leave-group-intrests-blank-radios", unselect_radio_interest);
                $(doc).on("click", ".mailchimp_optin_load_more_lists", load_more_lists);
				Optin.Events.on("design:preview:render:finish", $.proxy( this, 'render_in_previewr' ) );
			}
		});
	});
}(jQuery,document));