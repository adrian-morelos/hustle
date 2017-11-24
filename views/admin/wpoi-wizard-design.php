<?php
/**
 * @var Opt_In_Admin $this
 * @var Opt_In_Model $optin
 * @var bool $is_edit if it's in edit mode
 */
?>

<script id="wpoi-wizard-design_template" type="text/template">
	
	<header class="wph-toggletabs--title can-open">
		
		<h4><?php _e('Content & Design', Opt_In::TEXT_DOMAIN); ?></h4>
		
		<span class="open"><i class="wph-icon i-arrow"></i></span>
		
	</header>
	
	<section class="wph-toggletabs--content">
		
		<div id="wph-optin--content" class="row">
			
			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
	
				<h5><?php _e('Content', Opt_In::TEXT_DOMAIN); ?></h5>
				
				<div class="wph-sticky--anchor"></div>
				
				<button class="wph-preview--eye wph-button" title="<?php _e('Preview', Opt_In::TEXT_DOMAIN); ?>"><i class="wph-icon i-eye"></i></button>
	
			</div>
			
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
				
				<label class="wph-label--border"><?php _e('Compose content for your Opt-in', Opt_In::TEXT_DOMAIN); ?></label>
				
				<div class="row">
					
					<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
						
						<label class="wph-label--alt"><?php _e('Heading (Optional):', Opt_In::TEXT_DOMAIN); ?></label>
						
						<input  id="optin_title" value="{{optin_title}}" type="text" placeholder="<?php esc_attr_e("eg. Get 50% Early-bird Special", Opt_In::TEXT_DOMAIN); ?>" data-attribute="optin_title">
						
						<div id="wph-optin--messages">
							
							<div class="wpoi-wysiwyg-wrap">
								
								<input type="radio" id="wpoi-om" class="wysiwyg-tab" name="wysiwyg_editor" checked>
								<label for="wpoi-om"><?php _e('Opt-in content', Opt_In::TEXT_DOMAIN); ?></label>
								
								<input type="radio" id="wpoi-sm" class="wysiwyg-tab" name="wysiwyg_editor" data-attribute="on_submit" value="success_message">
								<# if( on_submit === "success_message" ) {  #>
									<label for="wpoi-sm"><?php _e('Success message', Opt_In::TEXT_DOMAIN); ?></label>
								<# } #>
								<div class="wysiwyg-tab__content">
									
									<?php wp_editor("{{optin_message}}", "optin_message", array(
											'textarea_name' => 'optin_message',
											'textarea_rows' => 9,
											'media_buttons' => false,
											'teeny' => true,
											'tinymce' => array(
												'height' => 160,
											),
									)); ?>
									
								</div>
								<# if( on_submit === "success_message" ) {  #>
									<div class="wysiwyg-tab__content">

										<?php wp_editor("{{success_message}}", "success_message", array(
												'textarea_name' => 'success_message',
												'textarea_rows' => 9,
												'media_buttons' => false,
												'teeny' => true,
												'tinymce' => array(
													'height' => 160,
												),
										)); ?>

										<p class="description"><?php printf( __('You can use %s to add optin name to the success message', Opt_In::TEXT_DOMAIN), '{name}' ); ?></p>

									</div>
								<# } #>
							</div>
							
						</div>
						
					</div>
					
					<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
						
						<label class="wph-label--alt"><?php _e('Opt-in Image:', Opt_In::TEXT_DOMAIN); ?></label>
						
						<div class="wpoi-select-media wph-media--holder"></div>
						
						<div id="optin_image_style">
						
							<div class="tabs">
			
			                    <ul class="wph-triggers--options tabs-header">
				                    
				                    <li {{_.add_class(image_style === 'contain', 'current')}}>
			
			                        <label for="optin-image-style-contain">
			
			                            <?php _e( "Fit image", Opt_In::TEXT_DOMAIN ); ?>
			
			                            <input type="radio" id="optin-image-style-contain" name="optin-image-style" value="contain" data-attribute="image_style" {{_.checked(image_style, "contain")}}>
			
			                        </label>
			
			                        </li>
			
			                        <li {{_.add_class( image_style === 'cover', 'current' )}}>
			
			                        <label for="optin-image-style-cover">
			
			                            <?php _e( "Fill image", Opt_In::TEXT_DOMAIN ); ?>
			
			                            <input type="radio" id="optin-image-style-cover" name="optin-image-style" value="cover" data-attribute="image_style" {{_.checked(image_style, "cover")}}  >
			
			                        </label>
			
			                        </li>
			
			                    </ul>
			
			                </div>
			                
						</div>

					</div>
					
				</div>
                
                <div class="row">
                    
                    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                        
                        <label class="wph-label--alt"><?php _e('Submit button text', Opt_In::TEXT_DOMAIN); ?></label>

                        <input type="text" placeholder="<?php esc_attr_e('Sign Up', Opt_In::TEXT_DOMAIN); ?>" value="{{cta_button}}" data-attribute="cta_button">
                        
                    </div>
                    
                </div>
				
			</div>
			
		</div><!-- #wph-optin--content -->
		
		<# if ( 'success_message' === on_submit ) { #>
			
			<div id="wpoi-success-message-fields" class="row hidden">
				
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
					
					<h5><?php _e('Success Message', Opt_In::TEXT_DOMAIN); ?></h5>
					
				</div>
				
				<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
					
					<label class="wph-label--border"><?php _e( 'Success message closing behavior', Opt_In::TEXT_DOMAIN ); ?></label>
					
					<div class="wph-label--radio">
						
						<label for="wpoi-success-remain"><?php _e( 'Success message remains until user manually closes it', Opt_In::TEXT_DOMAIN ); ?></label>
						
						<div class="wph-input--radio">
							
							<input type="radio" id="wpoi-success-remain" name="on_success" value="remain" {{_.checked(on_success, 'remain')}} />
							
							<label class="wph-icon i-check" for="wpoi-success-remain" />
						
						</div>
					
					</div>
					
					<div class="wph-label--mix">
						
						<label for="wpoi-success-autoclose" class="on_success"><?php _e( 'Auto-close after', Opt_In::TEXT_DOMAIN ); ?></label>
						
						<div class="wph-input--radio">
							
							<input type="radio" id="wpoi-success-autoclose" name="on_success" value="autoclose" {{_.checked(on_success, 'autoclose')}} />
							
							<label class="wph-icon i-check" for="wpoi-success-autoclose"></label>
						
						</div>
						
						<div class="wph-input--number on_success_time">
							
							<input type="number" name="on_success_time" min="0" value="{{on_success_time}}" />
						
						</div>
						
						<select class="wpmuiSelect on_success_unit" name="on_success_unit">
							
							<option value="s" {{_.selected(on_success_unit, 's')}}><?php _e( 'Seconds', Opt_In::TEXT_DOMAIN ); ?></option>
							
							<option value="m" {{_.selected(on_success_unit, 'm')}}><?php _e( 'Minutes', Opt_In::TEXT_DOMAIN ); ?></option>
							
						</select>
					
					</div>
				
				</div>
			
			</div>
			
		<# } #>

		<div id="wph-optin--structure" class="row"></div>
		<div id="wph-optin--module-fields" class="row"></div>

		<div id="wph-optin--colors" class="row">
			
			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
	
				<h5><?php _e('Colors', Opt_In::TEXT_DOMAIN); ?></h5>
	
			</div>
			
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
				
				<label class="wph-label--border"><?php _e('Pick a color palette and customize it to suit your needs', Opt_In::TEXT_DOMAIN); ?></label>
				
				<div id="wph-optin--palette">
					
					<select id="optin_color_palettes" class="wpmuiSelect" name="optin_color_palettes" data-attribute="colors.palette" {{_.disabled(colors.customize, true)}}>
						
						<# _.each( palettes, function( palette ) { #>
							
							<option value="{{palette._id}}" <# if(colors.palette == palette._id){ #> selected="selected" <# } #> >{{palette.label}}</option>
							
						<# }); #>
						
					</select>
					
					<div class="wph-label--checkbox">
						
						<label for="optin_customize_color_palette"><?php _e( "Customize Colors", Opt_In::TEXT_DOMAIN ); ?></label>
						
						<div class="wph-input--checkbox">
							
							<input type="checkbox" id="optin_customize_color_palette" data-attribute="colors.customize" name="optin_customize_color_palette" {{_.checked(colors.customize, true)}} >
							
							<label class="wph-icon i-check" for="optin_customize_color_palette"></label>
							
						</div>
						
					</div>
					
				</div>
				
				<div id="optwiz-custom_color" class="{{_.class( _.isFalse( colors.customize ), 'hidden' )}}"></div>
				
			</div>
			
		</div><!-- #wph-optin--colors -->
		
		<div id="wph-optin--shapes" class="row"></div><!-- #wph-optin--shapes -->
		
		<div id="wph-optin--css" class="row">
			
			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
	
				<h5><?php _e('Custom CSS', Opt_In::TEXT_DOMAIN); ?></h5>
	
			</div>
			
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
				
				<label class="wph-label--border {{_.class( _.isFalse( customize_css ), 'toggle-off' )}}">
					
					<div class="toggle">
						
						<input id="optin-active-css" class="toggle-checkbox" data-attribute="customize_css" value="true" type="checkbox" {{_.checked( customize_css, true )}} data-nonce="">
						
						<label class="toggle-label" for="optin-active-css"></label>
						
					</div>
					
					<?php _e('Use custom CSS for this opt-in', Opt_In::TEXT_DOMAIN); ?>
					
				</label>
				
				<div id="wph-css-holder" class="{{_.class( _.isFalse( customize_css ), 'hidden' )}}">
					
					<label><?php _e( "Available CSS Selectors (click to add):", Opt_In::TEXT_DOMAIN ); ?></label>
					
					<div class="wpoi-css-selectors">
						
						<div class="wpoi-css-selectors-wrap">
							
							<# _.each( stylables, function( name, stylable ) { #>
								<a href="#" class="wpoi-stylable-element" data-stylable="{{stylable}}" >{{name}}</a>
							<# }); #>
							
						</div>
						
					</div><!-- .wpoi-css-selectors -->
					
					<div id="optin_custom_css" name="" data-nonce="<?php echo wp_create_nonce('inc_opt_prepare_custom_css'); ?>">{{css}}</div><!-- Container: Custom CSS -->
					
					<!--<div class="wpoi-css-button">
						
						<button class="wph-button wph-button--filled wph-button--small wph-button--gray" id="optin_apply_custom_css" data-nonce="<?php echo wp_create_nonce('inc_opt_prepare_custom_css'); ?>" ><?php _e( "Apply Custom CSS", Opt_In::TEXT_DOMAIN ); ?></button>
						
					</div>--><!-- Button: Apply Custom CSS -->
					
				</div>
				
			</div>
			
		</div><!-- #wph-optin--css -->
		
	</section>
	
	<footer class="wph-toggletabs--footer">
		
		<div class="row">
			
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 previous">
				
				<a href="#0" class="wph-button wph-button--filled wph-button--gray js-wph-optin-back"><?php _e('Back', Opt_In::TEXT_DOMAIN); ?></a>
				
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

<?php $this->render("admin/wpoi-wizard-design-structure" ); ?>
<?php $this->render("admin/wpoi-wizard-design-module-fields" ); ?>
<?php $this->render("admin/wpoi-wizard-design-shapes"); ?>
<?php $this->render("admin/wpoi-wizard-design-after-submit"); ?>