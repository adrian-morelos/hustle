<script id="optin-layout-two" type="text/template">
	
	<div class="wpoi-hustle wpoi-layout-two">
		
		<div class="wpoi-success-message">
			
			<?php $this->render("general/layouts/success"); ?>
			
		</div>
		
		<div class="wpoi-optin">
			
			<div class="wpoi-container wpoi-image-{{image_location}}<# if(!optin_title && !optin_message){ #> nocontent<# } #><# if(!image_src){ #> noimage<# } #>">
				
				<# if(elements.indexOf("image") !== -1){ #>
					
					<div class="wpoi-element wpoi-aside wpoi-image wpoi-image-fill" style="background-image: url('{{image_src}}'); background-size:{{image_style}};"></div>
					
				<# } #>
				
				<div class="wpoi-element">
					
					<div class="wpoi-container wpoi-col">
						
						<# if(optin_title || optin_message){ #>
						
							<div class="wpoi-element">
								
								<div class="wpoi-content">
									
									<# if(optin_title){ #>
										
										<h2 class="wpoi-title">{{optin_title}}</h2>
										
									<# } #>
									
									<# if(optin_message){ #>
										
										<div class="wpoi-message">{{{optin_message}}}</div>
										
									<# } #>
									
								</div>
								
							</div>
							
						<# } #>
						
						<div class="wpoi-element wpoi-form">
							
							<form class="wpoi-container<# if( has_args ){ #> wpoi-col<# } #> wpoi-fields-{{fields_style}} wpoi-{{input_icons}}<# if( has_args ){ #> hasmcg<# } #>" method="post">
								
								<# if( has_args ){ #>
									
									<div class="wpoi-element wpoi-mcg-common-fields">
										
										<div class="wpoi-container">
											
											<# _.each(module_fields, function(field, key){ #>
										
												<div class="wpoi-element">
													
													<input type="{{field.type}}"  name="inc_optin_{{field.name}}" data-error="<?php esc_attr_e('Please, provide {{field.label}}', Opt_In::TEXT_DOMAIN); ?>" class="wpoi-subscribe-{{field.name}} {{_.class(_.isTrue(field.required), 'required' )}}">
													
													<label>
														
														<i class="wphi-font <# if ( field.type == 'email' ) { #>wphi-email<# } else if ( field.type == 'text' ) { if ( field.name == 'fname' || field.name == 'lname' || field.name == 'first_name' || field.name == 'last_name' || field.name == 'FNAME' || field.name == 'LNAME' ) { #>wphi-user<# } else if ( field.name == 'address' || field.name == 'ADDRESS' ) { #>wphi-address<# } else { #>wphi-typo<# } } else if ( field.type == 'number' ) { #>wphi-number<# } else if ( field.type == 'url' ) { #>wphi-url<# } #>"></i>
														
														<span>{{field.placeholder}}</span>
														
													</label>
													
												</div>
												
											<# }); #>
											
										</div>
										
									</div>
									
									<div class="wpoi-element wpoi-provider-args" style="margin-bottom: 0;"></div>
								
								<# } else { #>
								
									<# _.each(module_fields, function(field, key){ #>
										
										<div class="wpoi-element">
											
											<input type="{{field.type}}"  name="inc_optin_{{field.name}}" data-error="<?php esc_attr_e('Please, provide {{field.label}}', Opt_In::TEXT_DOMAIN); ?>" class="wpoi-subscribe-{{field.name}} {{_.class(_.isTrue(field.required), 'required' )}}">
											
											<label>
												
												<i class="wphi-font <# if ( field.type == 'email' ) { #>wphi-email<# } else if ( field.type == 'text' ) { if ( field.name == 'fname' || field.name == 'lname' || field.name == 'first_name' || field.name == 'last_name' || field.name == 'FNAME' || field.name == 'LNAME' ) { #>wphi-user<# } else if ( field.name == 'address' || field.name == 'ADDRESS' ) { #>wphi-address<# } else { #>wphi-typo<# } } else if ( field.type == 'number' ) { #>wphi-number<# } else if ( field.type == 'url' ) { #>wphi-url<# } #>"></i>
												
												<span>{{field.placeholder}}</span>
												
											</label>
											
										</div>
										
									<# }); #>

									<div class="wpoi-button">
										
										<button type="submit" class="wpoi-subscribe-send">{{cta_button}}</button>
										
									</div>
								
								<# } #>
								
							</form>
							
						</div>
						
					</div>
					
				</div>
				
			</div>
			
		</div>
		
	</div>
	
</script>
