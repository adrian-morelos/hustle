<?php
/**
 * @var Opt_In_Admin $this
 * @var Opt_In_Model $optin
 * @var bool $is_edit if it's in edit mode
 */
?>
<script id="wpoi-wizard-services_template" type="text/template">
	
	<header class="wph-toggletabs--title can-open">
		
		<h4><?php _e('Basic Setup', Opt_In::TEXT_DOMAIN); ?></h4>
		
		<span class="open"><i class="wph-icon i-arrow"></i></span>
		
	</header>

	<section class="wph-toggletabs--content">
		
		<div id="wph-optin--name" class="row">
			
			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
	
				<h5><?php _e('Name & Service', Opt_In::TEXT_DOMAIN); ?></h5>
	
			</div>
			
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
				
				<label class="wph-label--border"><?php _e('Choose a name for your opt-in.', Opt_In::TEXT_DOMAIN); ?></label>
				
				<input type="text" data-attribute="optin_name" id="optin_new_name" name="optin_new_name" value="{{optin_name}}" placeholder="<?php esc_attr_e("Enter opt-in name.", Opt_In::TEXT_DOMAIN) ?>">
				
			</div>
			
		</div>
		
		<div id="wph-optin--mode" class="row">
			
			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"></div>
			
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
				
				<label class="wph-label--border"><?php _e('Select your Email Service', Opt_In::TEXT_DOMAIN); ?></label>
				
				<div class="row">
					
					<div id="wph-optin--testmode" class="col-xs-12 col-sm-6 col-md-5 col-lg-5">
						
						<label>
							
							<span><?php _e('Setup in <strong>Test Mode</strong>', Opt_In::TEXT_DOMAIN); ?></span>
							
							<small><?php _e('A quick and easy way to test Hustle\'s opt-ins', Opt_In::TEXT_DOMAIN); ?></small>
							
						</label>
						
						<span class="toggle toggle-alt">
							
							<input id="wpoi-test-mode-setup" class="toggle-checkbox" type="checkbox" value="1" name="test_mode" data-attribute="test_mode"  {{_.checked(test_mode, 1)}}>
							
							<label class="toggle-label" for="wpoi-test-mode-setup"></label>
							
						</span>
						
					</div>
					
					<div id="wph-optin--localemails" class="col-xs-12 col-sm-6 col-md-7 col-lg-7">
						
						<label class="wph-label--alt">
							
							<span><?php _e('Save Emails to local list', Opt_In::TEXT_DOMAIN); ?></span>
							
							<small><?php _e('Will save submitted email addresses to an exportable CSV list', Opt_In::TEXT_DOMAIN); ?></small>
							
						</label>
						
						<span class="toggle">
							
							<input id="wpoi-save-to-local" class="toggle-checkbox" type="checkbox" value="1" name="save_to_local" data-attribute="save_to_local"  {{_.checked(save_to_local, 1)}}>
							
							<label class="toggle-label" for="wpoi-save-to-local"></label>
							
						</span>
						
					</div>
					
				</div>
				
			</div>
						
		</div>
		
		<div id="wph-optin--service" class="row">
			
			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"></div>
			
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
				
				<h4><?php _e('Email Service', Opt_In::TEXT_DOMAIN); ?></h4>
				
				<div class="tabs">
					
					<!--<ul class="tabs-header">
						
						<li  {{_.add_class( service_source == "existing", 'current' )}}>
						
							<label href="#wpoi-email-service-saved" for="wpoi-email-service_saved">

								<?php _e('Existing services', Opt_In::TEXT_DOMAIN); ?>
									
								<input type="radio" name="wpoi-email-service" id="wpoi-email-service_saved" data-attribute="service_source" value="existing">
								
							</label>
							
						</li>
						
						<li>
							
							<label href="#wpoi-email-service-new" for="wpoi-email-service_new">
								
								<?php _e('Set-up new service', Opt_In::TEXT_DOMAIN); ?>
								
								<input type="radio" name="wpoi-email-service" id="wpoi-email-service_new" data-attribute="service_source" value="new">
								
							</label>
							
						</li>
						
					</ul>-->
					
					<div class="tabs-body">
						
						<div id="wpoi-email-service-saved" class="tabs-content {{_.class( service_source == 'existing', 'hidden' )}}">
							
							<label class="wph-label--notice {{_.class(_.isFalse(test_mode), 'hidden' )}}">
								
								<span><?php _e('To set-up an Email Service, please first disable Test Mode.', Opt_In::TEXT_DOMAIN); ?></span>
								
							</label>
							
							<table class="wph-table wph-table--fixed">
								
								<tbody class="wph-tbody--reset">
									
									<# _.each(optin_vars.services, function(service, id){ #>
										<tr>

											<td class="wph-list--radio">

												<div class="wph-input--radio">

													<input type="radio" id="{{service.provider}}-{{id}}" value="{{id}}" name="optin-existing-service" {{_.checked(service.name, optin_provider)}} data-attribute="optin_provider" {{_.disabled(test_mode, 1)}} >

													<label class="wph-icon i-check" for="{{service.provider}}-{{id}}"></label>

												</div>

											</td>

											<td class="wph-list--icon">

												<div class="wph-list--{{service.name}}"></div>

											</td>

											<td class="wph-list--info">

												<span class="wph-table--title">{{ _.toUpperCase( service.name ) }}</span>

												<span class="wph-table--subtitle">{{service.api_key}}<# if( service.list_id ){ #> <strong>{{service.list_id}}</strong><# } #></span>
											</td>

										</tr>
									<# }); #>

								</tbody>
								
							</table>
							
						</div><!-- #wpoi-email-service-saved -->
						
						<div id="wpoi-email-service-new" class="tabs-content current">
							
							<div id="wpoi-service-details">
								
								<label class="wph-label--notice {{_.class(_.isFalse(test_mode), 'hidden' )}}">
									
									<span><?php _e('To set-up an Email Service, please first disable Test Mode.', Opt_In::TEXT_DOMAIN); ?></span>
									
								</label>
								
								<form action="" method="post" id="hustle_service_details_form">
									
									<?php wp_nonce_field( "refresh_provider_details" ); ?>
									
									<div class="block wpoi-error-select">
										
										<select data-silent="true"  data-attribute="optin_provider" name="optin_new_provider_name"  id="optin_new_provider_name" {{_.disabled( _.isTrue( test_mode ) , true )}}  class="wpmuiSelect" data-nonce="<?php echo wp_create_nonce('change_provider_name') ?>">
											
											<option value=""><?php _e("Choose email provider", Opt_In::TEXT_DOMAIN); ?></option>
											
											<# _.each( optin_vars.providers, function(provider, key) { #>
												
												<option {{ _.selected( optin_provider,  provider.id)  }} value="{{provider.id}}">{{provider.name}}</option>
												
											<# }); #>
											
										</select>
										
									</div><!-- End Email Provider -->

									<?php if ( $is_edit ) : ?>
										
										<div id="wpoi-email-provider-details-container">
											
											<div id="optin_new_provider_account_details" class="block">
												
												<?php
												$current_provider = empty( $selected_provider ) ? $optin->optin_provider : $selected_provider;
												$provider = Opt_In::get_provider_by_id( $current_provider );

												if( $provider ){

													$provider_instance = Opt_In::provider_instance( $provider );

													$options = $provider_instance->get_account_options( $optin->id );

													foreach( $options as $key =>  $option ){

														if( $option['type'] === 'wrapper'  ){ $option['apikey'] = $optin->api_key; }

														$option = apply_filters("wpoi_optin_filter_optin_options", $option, $optin );

														$this->render("general/option", array_merge( $option, array( "key" => $key ) ));

													}

													do_action("wpoi_optin_show_provider_account_options", $current_provider, $provider_instance );

												} ?>
												
											</div>
											
											<div id="optin_new_provider_account_options">
												
												<?php if( $optin->test_mode != 1 && $optin->optin_mail_list && apply_filters("wpoi_optin_{$optin->optin_provider}_show_selected_list", true, $optin ) ): ?>
													
													<?php echo __('Selected list (campaign):', Opt_In::TEXT_DOMAIN ); ?>  <?php echo $optin->optin_mail_list . __(' (Press the GET LISTS button to update value)', Opt_In::TEXT_DOMAIN ); ?>
													
												<?php endif; ?>
												
												<?php do_action("wpoi_optin_show_selected_list_after", $optin);  ?>
												
											</div>
											
											<?php  if( $optin->provider_args ) : ?>
												
												<div id="optin_provider_args">
													
													<?php $this->render("admin/provider/" . $optin->optin_provider . '/args', array(
														"optin" => $optin,
														"args" => $optin->provider_args,
														"this" => $this
													)); ?>
													
												</div>
												
											<?php endif; ?>
											
										</div><!-- End API Key -->
										
									<?php else: ?>
										
										<div id="optin_new_provider_account_details" class="block">
											
											<?php do_action("wpoi_optin_show_provider_account_options", $selected_provider, null ); ?>
											
										</div>
										
										<div id="optin_new_provider_account_options" class="block"></div>
										
									<?php endif; ?>
									
								</form>
								
							</div>
							
						</div><!-- #wpoi-email-service-new -->
						
					</div>
					
				</div>
				
			</div>
			
		</div><!-- #wph-optin--service -->
		
		<div id="wpoi_loading_indicator" style="display: none;">
			
			<label class="wph-label--loading">
				
				<span><?php _e('Wait a bit, content is being loaded...', Opt_In::TEXT_DOMAIN); ?></span>
				
			</label>
			
		</div>
		
	</section><!-- .wph-toggletabs--content -->
	
	<footer class="wph-toggletabs--footer">
		
		<div class="row">
			
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				
				<a href="#0" class="wph-button wph-button--filled wph-button--gray js-wph-optin-cancel"><?php _e('Cancel', Opt_In::TEXT_DOMAIN); ?></a>
				
			</div>
			
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 next-button">
				
				<button data-nonce="<?php echo $save_nonce; ?>" class="wph-button wph-button-save wph-button--filled wph-button--blue">
					
					<span class="off-action"><?php _e('Save Changes', Opt_In::TEXT_DOMAIN); ?></span>
					
					<span class="on-action"><?php _e('Saving...', Opt_In::TEXT_DOMAIN); ?></span>
					
				</button>
				
				<button data-nonce="<?php echo $save_nonce; ?>" class="wph-button wph-button-next wph-button--filled wph-button--gray">
					
					<span class="off-action"><?php _e('Next Step', Opt_In::TEXT_DOMAIN); ?></span>
					
					<span class="on-action"><?php _e('Saving...', Opt_In::TEXT_DOMAIN); ?></span>
					
				</button>
				
			</div>
			
		</div>
		
	</footer><!-- .wph-toggletabs--footer -->

</script>

