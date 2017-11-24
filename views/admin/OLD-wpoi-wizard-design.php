<?php
/**
 * @var Opt_In_Admin $this
 * @var Opt_In_Model $optin
 * @var bool $is_edit if it's in edit mode
 */
?>
<script id="wpoi-wizard-design_template" type="text/template">

	<div class="row">
		
		<section class="box content-box can-open">
			
			<div class="box-title">
				
				<h3 class="title-alternative"><?php _e('CONTENTS', Opt_In::TEXT_DOMAIN); ?></h3>
				
				<span class="open"><i class="dev-icon dev-icon-caret_down"></i></span>
				
			</div>
			
			<div class="box-content">
				
				<div class="row">
					
					<div class="col-two-third">
						
						<div class="wpoi-box-content-block">
							
							<label><?php _e('Opt-in Title:', Opt_In::TEXT_DOMAIN); ?></label>
							
							<input  id="optin_title" value="{{optin_title}}" type="text" placeholder="<?php esc_attr_e("eg. Receive Newsletter", Opt_In::TEXT_DOMAIN); ?>">
							
						</div>
						
						<div class="wpoi-box-content-block">
							
							<div class="wpoi-wysiwyg-wrap">
								
								<input type="radio" id="wpoi-om" class="wysiwyg-tab" name="wysiwyg_editor" checked>
								<label for="wpoi-om"><?php _e('Opt-in Message', Opt_In::TEXT_DOMAIN); ?></label>
								
								<input type="radio" id="wpoi-sm" class="wysiwyg-tab" name="wysiwyg_editor">
								<label for="wpoi-sm"><?php _e('Success Message', Opt_In::TEXT_DOMAIN); ?></label>
								
								<div class="wysiwyg-tab__content">
									
									<?php wp_editor("{{optin_message}}", "optin_message", array(
											'textarea_name' => 'optin_message',
											'textarea_rows' => 9,
											'media_buttons' => false,
											'teeny' => true
									)); ?>
									
								</div>
								
								<div class="wysiwyg-tab__content">
									
									<?php wp_editor("{{success_message}}", "success_message", array(
											'textarea_name' => 'success_message',
											'textarea_rows' => 9,
											'media_buttons' => false,
											'teeny' => true
									)); ?>
									
									<p class="description"><?php printf( __('You can use %s to add optin name to the success message', Opt_In::TEXT_DOMAIN), '{name}' ); ?></p>
									
								</div>
								
							</div>
							
						</div>

					</div>
					
					<div class="col-third">
						
						<div class="wpoi-box-content-block">
						
							<label><?php _e('Opt-in Image:', Opt_In::TEXT_DOMAIN); ?></label>
							
							<div class="wpoi-select-media">
								
								<button class="button button-ghost"><?php _e("Select Media", Opt_In::TEXT_DOMAIN ); ?></button>
								
								<div class="wpoi-media-options">
									
									<button class="button button-white">
										
										<span class="dot"></span>
										<span class="dot"></span>
										<span class="dot"></span>
										
									</button>
									
									<div class="wpoi-media-options-wrap-list open">
										
										<div class="svg-triangle">
											
											<svg xmlns="http://www.w3.org/2000/svg" version="1.1">
												
												<polygon points="10,10 0,10 5,5 "/>
												
											</svg>
											
										</div>
										
										<ul class="wpoi-media-options-list">
											
											<div class="wpoi-media-options-wrap-title">
												
												<span class="wpoi-media-options-title f-left"><?php _e("OPTIONS", Opt_In::TEXT_DOMAIN) ?></span>
												
												<i class="wph-icon i-close"></i>
												
											</div>
											
											<li><a id="wpoi-swap-image-button" href="#"><span class="dashicons dashicons-format-gallery"></span><?php _e("Swap Image", Opt_In::TEXT_DOMAIN) ?></a></li>
											
											<li><a id="wpoi-delete-image-button" href="#"><span class="dashicons dashicons-trash"></span><?php _e("Delete Image", Opt_In::TEXT_DOMAIN) ?></a></li>
											
										</ul>
										
									</div>
									
								</div>
								
								<div class="wpoi-image-preview" style="background-image: url('');"></div>
								
							</div>
							
						</div>
						
					</div>
					
				</div>
				
			</div>
			
		</section>
		
	</div><!-- End Contents -->
	
	<div class="row">
		
		<section class="box content-box can-open wpoi-preview-container">
			
			<div class="box-title">
				
				<h3 class="title-alternative"><?php _e('OPT-IN TYPE & PREVIEW', Opt_In::TEXT_DOMAIN); ?></h3>
				
				<span class="open"><i class="dev-icon dev-icon-caret_down"></i></span>
				
			</div>
			
			<div class="box-content">
				
				<div class="row">
					
					<div class="col-third">
						
						<div class="wpoi-box-content-block">
							
							<label class="wpoi-label-bold"><?php _e( "OPT-IN LAYOUT:", Opt_In::TEXT_DOMAIN ); ?></label>
							
							<div id="optin_form_location">
								
								<div class="wpoi-wrapper wpoi-form-design-wrap">
									
									<div class="wpoi-form-design">
										
										<label for="wpoi-form_location_one" class="wpoi-form-design-one"></label>
										<input type="radio" id="wpoi-form_location_one" name="location" value="0" <# if(form_location == 0){ #> checked="checked" <# } #>>
										
									</div>
									
									<div class="wpoi-form-design">
										
										<label for="wpoi-form_location_two" class="wpoi-form-design-two"></label>
										<input type="radio" id="wpoi-form_location_two" name="location" value="1" <# if(form_location == 1){ #> checked="checked" <# } #>>
										
									</div>
									
									<div class="wpoi-form-design">
										
										<label for="wpoi-form_location_three" class="wpoi-form-design-three"></label>
										<input type="radio" id="wpoi-form_location_three" name="location" value="2" <# if(form_location == 2){ #> checked="checked" <# } #>>
										
									</div>
									
									<div class="wpoi-form-design">
										
										<label for="wpoi-form_location_four" class="wpoi-form-design-four"></label>
										<input type="radio" id="wpoi-form_location_four" name="location" value="3" <# if(form_location == 3){ #> checked="checked" <# } #>>
										
									</div>
									
								</div>
								
							</div>
							
						</div>
						
						<div class="wpoi-box-content-block">
							
							<label class="wpoi-label-bold"><?php _e( "OPTIONAL OPT-IN ELEMENTS:", Opt_In::TEXT_DOMAIN ); ?></label>
							
							<div id="optin_optional_elements">
								
								<div class="wpoi-wrapper wpoi-form-elements-wrap">
									
									<div class="wpoi-form-elements">
										
										<input type="checkbox" id="optin_fname" name="first_name" value="first_name">
										<label for="optin_fname"><?php _e( "First Name Field", Opt_In::TEXT_DOMAIN ); ?></label>
										
									</div>
									
									<div class="wpoi-form-elements">

										<input type="checkbox" id="optin_lname" name="last_name" value="last_name" >
										<label for="optin_lname"><?php _e( "Last Name Field", Opt_In::TEXT_DOMAIN ); ?></label>
										
									</div>
									
								</div>
								
							</div>
							
						</div>
						
						<div class="wpoi-box-content-block">
							
							<label class="wpoi-label-bold"><?php _e( "IMAGE LOCATION:", Opt_In::TEXT_DOMAIN ); ?></label>
							
							<div id="optin_image_location">
								
								<div class="wpoi-wrapper wpoi-form-elements-wrap">

									<div class="wpoi-form-elements">
										
										<input type="radio" id="optin-image-location-left" name="optin-image-location" value="left" {{_.checked(image_location, "left")}}>
										<label for="optin-image-location-left"><?php _e( "Left", Opt_In::TEXT_DOMAIN ); ?></label>
										
									</div>
									
									<div class="wpoi-form-elements">
										
										<input type="radio" id="optin-image-location-right" name="optin-image-location" value="right" {{_.checked(image_location, "right")}}>
										<label for="optin-image-location-right"><?php _e( "Right", Opt_In::TEXT_DOMAIN ); ?></label>
										
									</div>
									
									<div class="wpoi-form-elements">
										
										<input class="<# if( form_location == 1 || form_location == 2 || form_location == 3){ #>wpoi-hidden<# } #>" type="radio" id="optin-image-location-above" name="optin-image-location" value="above" {{_.checked(image_location, "above")}}>
										<label class="<# if( form_location == 1 || form_location == 2 || form_location == 3){ #>wpoi-hidden<# } #>" for="optin-image-location-above"><?php _e( "Above Content", Opt_In::TEXT_DOMAIN ); ?></label>
										
									</div>
									
									<div class="wpoi-form-elements">
										
										<input class="<# if( form_location == 1 || form_location == 2 || form_location == 3){ #>wpoi-hidden<# } #>" type="radio" name="optin-image-location" id="optin-image-location-bellow" value="below" {{_.checked(image_location, "below")}}>
										<label class="<# if( form_location == 1 || form_location == 2 || form_location == 3){ #>wpoi-hidden<# } #>" for="optin-image-location-bellow"><?php _e( "Below Content", Opt_In::TEXT_DOMAIN ); ?></label>
										
									</div>
									
								</div>
								
							</div>
							
						</div>
						
						<div class="wpoi-box-content-block">
							
							<label class="wpoi-label-bold"><?php _e( "IMAGE STYLE:", Opt_In::TEXT_DOMAIN ); ?></label>
							
							<div id="optin_image_style">
								
								<div class="wpoi-wrapper wpoi-form-elements-wrap">

									<div class="wpoi-form-elements">
										
										<input type="radio" id="optin-image-style-cover" name="optin-image-style" value="cover" {{_.checked(image_style, "cover")}} >
										<label for="optin-image-style-fill"><?php _e( "Fill", Opt_In::TEXT_DOMAIN ); ?></label>
										
									</div>
									
									<div class="wpoi-form-elements">
										
										<input type="radio" id="optin-image-style-contain" name="optin-image-style" value="contain" {{_.checked(image_style, "contain")}}>
										<label for="optin-image-style-fit"><?php _e( "Fit", Opt_In::TEXT_DOMAIN ); ?></label>
										
									</div>
									
								</div>
								
							</div>
							
						</div>
						
					</div>
					
					<div class="col-two-third">
						
						<div class="wpoi-box-content-block">
							
							<div class="wpoi-preview-wrap">
								
								<div id="optin-preview-wrapper"></div>
								
							</div>
							
						</div>
						
					</div>
					
				</div>
				
			</div>
			
		</section>
		
	</div><!-- End Optin Type & Preview -->
	
	<div class="row">
		
		<div class="col-half">
			
			<div class="row">
				
				<section class="box content-box can-open">
					
					<div class="box-title">
						
						<h3 class="title-alternative"><?php _e('COLORS', Opt_In::TEXT_DOMAIN); ?></h3>
						
						<span class="open"><i class="dev-icon dev-icon-caret_down"></i></span>
						
					</div>
					
					<div class="box-content">
						
						<div class="wpoi-box-content-block">
							
							<div class="row">
								
								<div class="col-two-third">
									
									<div class="wpoi-wrapper">
										
										<label><?php _e('Color Palette:', Opt_In::TEXT_DOMAIN); ?></label>
										
										<select id="optin_color_palettes" name="optin_color_palettes" data-type="javascript" style="display: none;">
											
											<# _.each( palettes, function( palette ) { #>
												
												<option value="{{palette._id}}" <# if(colors.palette == palette._id){ #> selected="selected" <# } #> >{{palette.label}}</option>
												
											<# }); #>
											
										</select>
										
									</div>
									
								</div>
								
								<div class="col-third">
									
									<div class="wpoi-wrapper wpoi-customized-colors">
									
										<input type="checkbox" id="optin_customize_color_palette" name="optin_customize_color_palette" {{_.checked(colors.customize, true)}} >
										
										<label for="optin_customize_color_palette"><?php _e( "Customized Colors", Opt_In::TEXT_DOMAIN ); ?></label>
										
									</div>
									
								</div>
								
							</div>
							
						</div>
						
						<div class="wpoi-box-content-block">
							
							<div id="optwiz-custom_color" <# if( !_.isTrue( colors.customize )) { #> style="display: none;" <# } #> ></div>
							
						</div>
						
					</div>
					
				</section><!-- End Colors Section -->
				
			</div>
			
			<div class="row">
				
				<section class="box content-box can-open">
					
					<div class="box-title">
						
						<h3 class="title-alternative"><?php _e('CUSTOM CSS', Opt_In::TEXT_DOMAIN); ?></h3>
						
						<span class="open"><i class="dev-icon dev-icon-caret_down"></i></span>
						
					</div>
					
					<div class="box-content">
						<div class="wpoi-wrap cf">

							<!-- CSS Selectors -->

							<div class="wpoi-css-selectors wpoi-wrap cf">
								
								<label class="wpoi-label-bold"><?php _e("Add Custom CSS to this Opt-in", Opt_In::TEXT_DOMAIN); ?></label>

								<label><?php _e( "Available CSS Selectors (click to add):", Opt_In::TEXT_DOMAIN ); ?></label>
								
								<div class="wpoi-css-selectors-wrap">
									
									<# _.each( stylables, function( name, stylable ) { #>
										<a href="#" class="wpoi-stylable-element" data-stylable="{{stylable}}" >{{name}}</a>
									<# }); #>
									
								</div>
								
							</div>

							<!-- Container: Custom CSS -->

							<div id="optin_custom_css" name="">{{css}}</div>

							<!-- Button: Apply Custom CSS -->

							<div class="wpoi-css-button">

								<button class="button button-small" id="optin_apply_custom_css" data-nonce="<?php echo wp_create_nonce('inc_opt_prepare_custom_css'); ?>" ><?php _e( "Apply Custom CSS", Opt_In::TEXT_DOMAIN ); ?></button>

							</div>

						</div>
						
					</div>
					
				</section><!-- End Custom CSS Section -->
				
			</div>
			
		</div>
		
		<div class="col-half">
			
			<section class="box content-box can-open">
				
				<div class="box-title">
					
					<h3 class="title-alternative"><?php _e('SHAPES & BORDERS', Opt_In::TEXT_DOMAIN); ?></h3>
					
					<span class="open"><i class="dev-icon dev-icon-caret_down"></i></span>
					
				</div>
				
				<div class="box-content">
					
					<div class="wpoi-box-content-block">
						
						<label class="wpoi-label-bold"><?php _e( "Form Fields Style:", Opt_In::TEXT_DOMAIN ); ?></label>
						
						<div class="wpoi-wrapper wpoi-form-elements-wrap">
							
							<div class="wpoi-form-elements">
								
								<input type="radio" id="optin_fields_style_joined" name="optin_fields_style" value="joined" {{_.checked(borders.fields_style, "joined")}}   >
								<label for="optin_fields_style_joined"><?php _e( "Joined Together", Opt_In::TEXT_DOMAIN ); ?></label>
								
							</div>
							
							<div class="wpoi-form-elements">
								
								<input type="radio" id="optin_fields_style_separated" name="optin_fields_style" value="separated"  {{_.checked(borders.fields_style, "separated")}}  >
								<label for="optin_fields_style_separated"><?php _e( "Separated", Opt_In::TEXT_DOMAIN ); ?></label>
								
							</div>
							
						</div>
						
					</div>
					
					<div class="wpoi-box-content-block">
						
						<label class="wpoi-label-bold"><?php _e( "Form Fields Icon Animation:", Opt_In::TEXT_DOMAIN ); ?></label>
						
						<div id="optin_elements_input_icons" class="wpoi-wrapper wpoi-form-elements-wrap">
							
							<div class="wpoi-form-elements">
								
								<input type="radio" name="optin_input_icons" id="optin_error_icons_input_animated_icon" value="animated_icon" data-attribute="input_icons" {{_.checked(input_icons, "animated_icon")}} >
								
								<label for="optin_error_icons_input_animated_icon"><?php _e( "Animated icon", Opt_In::TEXT_DOMAIN ); ?></label>
								
							</div><?php // Animated icon ?>
							
							<div class="wpoi-form-elements">
								
								<input type="radio" name="optin_input_icons" id="optin_error_icons_input_none_animated_icon" value="none_animated_icon" data-attribute="input_icons" {{_.checked(input_icons, "none_animated_icon")}} >
								
								<label for="optin_error_icons_input_none_animated_icon"><?php _e( "Static icon", Opt_In::TEXT_DOMAIN ); ?></label>
								
							</div><?php // Fixed icon ?>
							
							<div class="wpoi-form-elements">
								
								<input type="radio" name="optin_input_icons" id="optin_error_icons_input_no_icon" value="no_icon" data-attribute="input_icons" {{_.checked(input_icons, "no_icon")}} >
								
								<label for="optin_error_icons_input_no_icon"><?php _e( "No icon", Opt_In::TEXT_DOMAIN ); ?></label>
								
							</div><?php // No icon ?>
							
						</div>
						
					</div>
					
					<div class="wpoi-box-content-block">
						
						<label class="wpoi-label-bold"><?php _e( "ROUNDED CORNERS:", Opt_In::TEXT_DOMAIN ); ?></label>
						
						<div class="wpoi-wrapper wpoi-form-elements-wrap">
							
							<div class="wpoi-form-elements">
								
								<label for="optin_rounded_corners"><?php _e( "Opt-in Box:", Opt_In::TEXT_DOMAIN ); ?></label>
								
								<input min="0" type="number" name="optin_rounded_corners_radious" value="{{borders.corners_radius}}"  id="optin_rounded_corners_radious"/>
								
								<label>px</label>
								
							</div>
							
							<div class="wpoi-form-elements-wrap">
								
								<div class="wpoi-form-elements">
									
									<label for=""><?php _e( "Form Fields:", Opt_In::TEXT_DOMAIN ); ?></label>
									
									<input {{_.disabled(borders.fields_style, "joined")}} min="0" type="number" name="fields_rounded_corners_radious" value="{{borders.fields_corners_radius}}"  id="fields_rounded_corners_radious"/>
									
									<label>px</label>
									
								</div>
								
								<div class="wpoi-form-elements">
									
									<label for=""><?php _e( "Form Button:", Opt_In::TEXT_DOMAIN ); ?></label>
									
									<input {{_.disabled(borders.fields_style, "joined")}} min="0" type="number" name="button_rounded_corners_radious" value="{{borders.button_corners_radius}}"  id="button_rounded_corners_radious"/>
									
									<label>px</label>
									
								</div>
								
							</div>
							
						</div>
						
					</div>
					
					<div class="wpoi-box-content-block">
						
						<label class="wpoi-label-bold"><?php _e( "DROP SHADOW:", Opt_In::TEXT_DOMAIN ); ?></label>
						
						<div class="wpoi-wrapper wpoi-form-elements-wrap wpoi-shadow-setttings">
							
							<div class="wpoi-form-elements">
								
								<label for=""><?php _e( "Drop Shadow", Opt_In::TEXT_DOMAIN ); ?></label>
								
								<input min="0" type="number" name="" value="{{borders.dropshadow_value}}"  id="optin_dropshadow_value"/>
								
								<label>px</label>
								
							</div>
							
							<div class="wpoi-form-elements">
								
								<input type="text" id="optin_shadow_color"  value="{{borders.shadow_color}}" class="optin_color_picker"/>
								
								<label><?php _e( "Color", Opt_In::TEXT_DOMAIN ); ?></label>
								
							</div>
							
						</div>
						
					</div>
					
				</div>
				
			</section>
			
		</div>
		
	</div><!-- End Colors + Shapes & Borders -->
	
	<div class="row">
		
		<p class="next-button"><a class="button button-dark-blue previous" href=""><?php _e('PREVIOUS', Opt_In::TEXT_DOMAIN); ?></a> <a class="button button-dark-blue next" href=""><?php _e('NEXT', Opt_In::TEXT_DOMAIN); ?></a></p>
		
	</div>

</script>