<script id="wpoi-custom-content-content-tpl" type="text/template">
	
	<div id="wph-ccontent--name" class="row">

		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">

			<h5><?php _e('Name', Opt_In::TEXT_DOMAIN); ?></h5>

		</div>

		<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">

			<label class="wph-label--border"><?php _e('Choose a name for your Custom Content module.', Opt_In::TEXT_DOMAIN); ?></label>

			<input type="text" class="wph-input" placeholder="<?php esc_attr_e('Enter name...', Opt_In::TEXT_DOMAIN); ?>" value="{{optin_name}}" data-attribute="optin_name">

		</div>

	</div><!-- #wph-ccontent--name -->

	<div id="wph-ccontent--content" class="row">

		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">

			<h5><?php _e('The Content', Opt_In::TEXT_DOMAIN); ?></h5>
			
			<div class="wph-sticky--anchor"></div>
			
			<button class="wph-preview--eye wph-button" title="<?php _e('Preview', Opt_In::TEXT_DOMAIN); ?>"><i class="wph-icon i-eye"></i></button>

		</div>

		<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">

			<label class="wph-label--border"><?php _e('Add your Custom Content below. You may use shortcodes from other modules.', Opt_In::TEXT_DOMAIN); ?></label>
			
			<div class="row">
				
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					
					<input type="text" class="wph-input" placeholder="<?php esc_attr_e('Title (optional)', Opt_In::TEXT_DOMAIN); ?>" value="{{optin_title}}" data-attribute="optin_title">
					
				</div>
				
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					
					<input type="text" class="wph-input" placeholder="<?php esc_attr_e('Subtitle (optional)', Opt_In::TEXT_DOMAIN); ?>" value="{{subtitle}}" data-attribute="subtitle">
					
				</div>
				
			</div>

			<div id="wph-ccontent--msg" class="row">

				<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">

					<div class="wph-ccontent--textarea">

						<?php wp_editor("{{optin_message}}", "optin_message", array(
								'textarea_name' => 'optin_message',
								'textarea_rows' => 9,
								'media_buttons' => true,
								'teeny' => true,
								'tinymce' => array(
									'height' => 167,
								),
						)); ?>

					</div>

				</div>
				
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
					
					<div class="wph-media--holder"></div>

					<div class="tabs">
						<ul class="wph-triggers--options tabs-header">
						
							<li class="{{'left' === image_position?'current':''}}">
								
								<input type="radio" name="image_position" id="image_position_left" data-attribute="image_position" data-model="design_model"  {{_.checked(image_position, "left")}} value="left">
								
								<label for="image_position_left"><i class="wph-icon i-image"></i><i class="wph-icon i-text"></i></label>
								
							</li>
							
							<li class="{{'right' === image_position?'current':''}}">
								
								<input type="radio" name="image_position" id="image_position_right" data-attribute="image_position" data-model="design_model"  value="right" {{_.checked(image_position, "right")}}>
								
								<label for="image_position_right"><i class="wph-icon i-text"></i><i class="wph-icon i-image"></i></label>
								
							</li>
							
						</ul>
						
					</div>
					
					<div class="wph-label--checkbox">
						
						<label for="hide_image_on_mobile"><?php _e('Hide image on mobile', Opt_In::TEXT_DOMAIN); ?></label>
						
						<div class="wph-input--checkbox">
							
							<input type="checkbox" class="wph-label--alt" {{_.checked( hide_image_on_mobile, true )}} value="true" data-attribute="hide_image_on_mobile" data-model="design_model"  id="hide_image_on_mobile" >
							
							<label class="wph-icon i-check" for="hide_image_on_mobile"></label>
							
						</div>
						
					</div><!-- .wph-label--checkbox -->
					
				</div>

			</div>

		</div>

	</div><!-- #wph-ccontent--content -->


</script>

<script id="wpoi-custom-content-design-tpl" type="text/template">
	
	<div id="wph-ccontent--optional" class="row">

		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"></div>

		<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">

			<label class="wph-label--border"><?php _e('Call to action button (optional)', Opt_In::TEXT_DOMAIN); ?></label>

			<div class="row">

				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">

					<label class="wph-label--alt"><?php _e('Label', Opt_In::TEXT_DOMAIN); ?></label>

					<input type="text" placeholder="<?php esc_attr_e('Click Me...', Opt_In::TEXT_DOMAIN); ?>" value="{{cta_label}}" data-attribute="cta_label">

				</div>

				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">

					<label class="wph-label--alt"><?php _e('URL', Opt_In::TEXT_DOMAIN); ?></label>

					<input type="text" placeholder="http://example.net" value="{{cta_url}}" data-attribute="cta_url">

				</div>

				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">

					<label class="wph-label--alt"><?php _e('Link target', Opt_In::TEXT_DOMAIN); ?></label>

					<select id="" name="" data-type="javascript" data-attribute="cta_target" class="wpmuiSelect">

						<option value="_blank" {{_.selected(cta_target, "_blank")}} ><?php _e('Blank', Opt_In::TEXT_DOMAIN); ?></option>
						<option value="_self" {{_.selected(cta_target, "_self")}} ><?php _e('Self', Opt_In::TEXT_DOMAIN); ?></option>
						<option value="_parent" {{_.selected(cta_target, "_parent")}} ><?php _e('Parent', Opt_In::TEXT_DOMAIN); ?></option>
						<option value="_top" {{_.selected(cta_target, "_top")}} ><?php _e('Top', Opt_In::TEXT_DOMAIN); ?></option>

					</select>

				</div>

			</div>

		</div>

	</div><!-- #wph-ccontent--optional -->

	<div id="wph-ccontent--design" class="row">

		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">

			<h5><?php _e('Colors & Design', Opt_In::TEXT_DOMAIN); ?></h5>

		</div>

		<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">

			<label class="wph-label--border"><?php _e('Customize the appearance of your message.', Opt_In::TEXT_DOMAIN); ?></label>
			
			<h4><?php _e('Message Box', Opt_In::TEXT_DOMAIN); ?></h4>
			
			<label><?php _e('Select a style to use:', Opt_In::TEXT_DOMAIN); ?></label>
			
			<div id="wph-ccontent--palette">
				
				<select data-attribute="style" class="wpmuiSelect">
					
					<option value="cabriolet" {{_.selected(style, "cabriolet")}} >Cabriolet</option>
					<option value="simple" {{_.selected(style, "simple")}} >Simple</option>
					<option value="minimal" {{_.selected(style, "minimal")}} >Minimal</option>
					
				</select>
				
				<div class="wph-label--checkbox">
					
					<label class="wph-label--alt" for="customize_colors"><?php _e('Customize Colors', Opt_In::TEXT_DOMAIN); ?></label>
					
					<div class="wph-input--checkbox">
						
						<input type="checkbox" {{_.checked(customize_colors, true)}} data-attribute="customize_colors" id="customize_colors" value="1">
						
						<label class="wph-icon i-check" for="customize_colors"></label>
						
					</div>
					
				</div>
				
			</div>
			
			<div id="wph-ccontent--custom_colors" class="{{_.class(_.isFalse( customize_colors ), 'hidden')}}" >
				
				<h4><?php _e('Basic', Opt_In::TEXT_DOMAIN); ?></h4>
				
				<div class="ocp-basic-content row">
					
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						
						<label class="wph-label--alt"><?php _e('Main background', Opt_In::TEXT_DOMAIN); ?></label>
						
						<div class="wph-pickers wph-pickers--single">
							
							<div class="wph-pickers--color">
								
								<input type="text" class="wph-color-picker" id="main_bg_color" value="{{main_bg_color}}" data-attribute="main_bg_color" data-alpha="true">
								
							</div>
							
						</div>
						
					</div><!-- Main Background -->
					
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						
						<label class="wph-label--alt"><?php _e('Title color', Opt_In::TEXT_DOMAIN); ?></label>
						
						<div class="wph-pickers wph-pickers--single">
							
							<div class="wph-pickers--color">
								
								<input type="text" class="wph-color-picker" id="" value="{{title_color}}" data-attribute="title_color" data-alpha="true">
								
							</div>
							
						</div>
						
					</div><!-- Title Color -->
					
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						
						<label class="wph-label--alt"><?php _e('Subtitle color', Opt_In::TEXT_DOMAIN); ?></label>
						
						<div class="wph-pickers wph-pickers--single">
							
							<div class="wph-pickers--color">
								
								<input type="text" class="wph-color-picker" id="" value="{{subtitle_color}}" data-attribute="subtitle_color" data-alpha="true">
								
							</div>
							
						</div>
						
					</div><!-- Subtitle Color -->
					
				</div>
				
				<div class="ocp-basic-other row">
					
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						
						<label class="wph-label--alt"><?php _e('Link Color', Opt_In::TEXT_DOMAIN); ?></label>
						
						<div class="wph-pickers">
							
							<div class="wph-pickers--color">
								
								<input type="text" class="wph-color-picker" id="" value="{{link_static_color}}" data-attribute="link_static_color">
								
								<span class="wph-pickers--tip" tooltip="<?php esc_attr_e('Static State Color', Opt_In::TEXT_DOMAIN ); ?>"></span>
								
							</div>
							
							<div class="wph-pickers--color">
								
								<input type="text" class="wph-color-picker" id="" value="{{link_hover_color}}" data-attribute="link_hover_color">
								
								<span class="wph-pickers--tip" tooltip="<?php esc_attr_e('Hover State Color', Opt_In::TEXT_DOMAIN ); ?>"></span>
								
							</div>
							
							<div class="wph-pickers--color">
								
								<input type="text" class="wph-color-picker" id="" value="{{link_active_color}}" data-attribute="link_active_color">
								
								<span class="wph-pickers--tip" tooltip="<?php esc_attr_e('Active State Color', Opt_In::TEXT_DOMAIN ); ?>"></span>
								
							</div>
							
						</div>
						
					</div><!-- Link Color -->
					
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						
						<label class="wph-label--alt"><?php _e('CTA Background', Opt_In::TEXT_DOMAIN); ?></label>
						
						<div class="wph-pickers">
							
							<div class="wph-pickers--color">
								
								<input type="text" class="wph-color-picker" id="" value="{{cta_static_background}}" data-attribute="cta_static_background">
								
								<span class="wph-pickers--tip" tooltip="<?php esc_attr_e('Static State Color', Opt_In::TEXT_DOMAIN ); ?>"></span>
								
							</div>
							
							<div class="wph-pickers--color">
								
								<input type="text" class="wph-color-picker" id="" value="{{cta_hover_background}}" data-attribute="cta_hover_background">
								
								<span class="wph-pickers--tip" tooltip="<?php esc_attr_e('Hover State Color', Opt_In::TEXT_DOMAIN ); ?>"></span>
								
							</div>
							
							<div class="wph-pickers--color">
								
								<input type="text" class="wph-color-picker" id="" value="{{cta_active_background}}" data-attribute="cta_active_background">
								
								<span class="wph-pickers--tip" tooltip="<?php esc_attr_e('Active State Color', Opt_In::TEXT_DOMAIN ); ?>"></span>
								
							</div>
							
						</div>
						
					</div><!-- CTA Background -->
					
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						
						<label class="wph-label--alt"><?php _e('CTA Color', Opt_In::TEXT_DOMAIN); ?></label>
						
						<div class="wph-pickers">
							
							<div class="wph-pickers--color">
								
								<input type="text" class="wph-color-picker" id="" value="{{cta_static_color}}" data-attribute="cta_static_color">
								
								<span class="wph-pickers--tip" tooltip="<?php esc_attr_e('Static State Color', Opt_In::TEXT_DOMAIN ); ?>"></span>
								
							</div>
							
							<div class="wph-pickers--color">
								
								<input type="text" class="wph-color-picker" id="" value="{{cta_hover_color}}" data-attribute="cta_hover_color">
								
								<span class="wph-pickers--tip" tooltip="<?php esc_attr_e('Hover State Color', Opt_In::TEXT_DOMAIN ); ?>"></span>
								
							</div>
							
							<div class="wph-pickers--color">
								
								<input type="text" class="wph-color-picker" id="" value="{{cta_active_color}}" data-attribute="cta_active_color">
								
								<span class="wph-pickers--tip" tooltip="<?php esc_attr_e('Active State Color', Opt_In::TEXT_DOMAIN ); ?>"></span>
								
							</div>
							
						</div>
						
					</div><!-- CTA Color -->
					
				</div>
				
			</div><!-- #wph-ccontent--basic -->
			
			<div id="wph-ccontent--border">
				
				<div class="wph-label--checkbox">
					
					<label for="modal_border"><?php _e('Border', Opt_In::TEXT_DOMAIN); ?></label>
					
					<div class="wph-input--checkbox">
						
						<input type="checkbox" id="modal_border" class="wph-label--alt" value="true" {{_.checked(border, true)}} data-attribute="border">
						
						<label for="modal_border" class="wph-icon i-check"></label>
						
					</div>
					
				</div>
				
			</div>
			
			<div id="wph-ccontent--border_settings" class="{{_.class( _.isFalse( border ) , 'hidden')}}">
				
				<div class="row">
				
					<div class="col-eq">
						
						<label class="wph-label--alt"><?php _e('Radius', Opt_In::TEXT_DOMAIN); ?></label>
						
						<div class="wph-input--number">
							
							<input type="number" min="0" max="500" step="1" value="{{border_radius}}" data-attribute="border_radius">
							
						</div>
						
					</div>
					
					<div class="col-eq">
					
						<label class="wph-label--alt"><?php _e('Weight', Opt_In::TEXT_DOMAIN); ?></label>
						
						<div class="wph-input--number">
							
							<input type="number" min="0" max="500" step="1" value="{{border_weight}}" data-attribute="border_weight">
							
						</div>
						
					</div>
					
					<div class="col-eq">
						
						<label class="wph-label--alt"><?php _e('Type', Opt_In::TEXT_DOMAIN); ?></label>
						
						<select id="" name="" data-type="javascript" data-attribute="border_type" class="wpmuiSelect">
							
							<option value="solid" {{_.selected(border_type, 'solid')}} ><?php _e('Solid', Opt_In::TEXT_DOMAIN); ?></option>
							<option value="dotted" {{_.selected(border_type, 'dotted')}} ><?php _e('Dotted', Opt_In::TEXT_DOMAIN); ?></option>
							<option value="dashed" {{_.selected(border_type, 'dashed')}} ><?php _e('Dashed', Opt_In::TEXT_DOMAIN); ?></option>
							<option value="double" {{_.selected(border_type, 'double')}} ><?php _e('Double', Opt_In::TEXT_DOMAIN); ?></option>
							<option value="none" {{_.selected(border_type, 'none')}} ><?php _e('None', Opt_In::TEXT_DOMAIN); ?></option>
							
						</select>
						
					</div>
					
					<div class="col-eq">
						
						<label class="wph-label--alt"><?php _e('Border color', Opt_In::TEXT_DOMAIN); ?></label>
						
						<div class="wph-pickers wph-pickers--single" style="z-index: 10;">
							
							<div class="wph-pickers--color">
								
								<input type="text" class="wph-color-picker" id="border_static_color" value="{{border_static_color}}" data-attribute="border_static_color">
								
							</div>
		
						</div>
		
					</div>
					
				</div>
				
			</div><!-- Border Styles -->
			
			<div id="wph-ccontent--shadow">
				
				<div class="wph-label--checkbox">
					
					<label for="modal_shadow"><?php _e('Drop Shadow', Opt_In::TEXT_DOMAIN); ?></label>
					
					<div class="wph-input--checkbox">
						
						<input id="modal_shadow" type="checkbox" value="true" {{_.checked(drop_shadow, true)}} data-attribute="drop_shadow">
						
						<label class="wph-icon i-check" for="modal_shadow"></label>
						
					</div>
					
				</div>
				
			</div>
			
			<div id="wph-ccontent--shadow_settings" class="{{_.class( _.isFalse( drop_shadow ) , 'hidden')}}">
				
				<div class="row">
					
					<div class="col-eq">
						
						<label class="wph-label--alt"><?php _e('X-offset', Opt_In::TEXT_DOMAIN); ?></label>
						
						<div class="wph-input--number">
							
							<input type="number" min="0" max="500" step="1" value="{{drop_shadow_x}}" data-attribute="drop_shadow_x">
							
						</div>
					
					</div>
					
					<div class="col-eq">
						
						<label class="wph-label--alt"><?php _e('Y-offset', Opt_In::TEXT_DOMAIN); ?></label>
						
						<div class="wph-input--number">
							
							<input type="number" min="0" max="500" step="1" value="{{drop_shadow_y}}" data-attribute="drop_shadow_y">
							
						</div>
						
					</div>
					
					<div class="col-eq">
						
						<label class="wph-label--alt"><?php _e('Blur', Opt_In::TEXT_DOMAIN); ?></label>
						
						<div class="wph-input--number">
							
							<input type="number" min="0" max="500" step="1" value="{{drop_shadow_blur}}" data-attribute="drop_shadow_blur">
							
						</div>
						
					</div>
					
					<div class="col-eq">
						
						<label class="wph-label--alt"><?php _e('Spread', Opt_In::TEXT_DOMAIN); ?></label>
						
						<div class="wph-input--number">
							
							<input type="number" min="0" max="500" step="1" value="{{drop_shadow_spread}}" data-attribute="drop_shadow_spread">
							
						</div>
						
					</div>
					
					<div class="col-eq">
						
						<label class="wph-label--alt"><?php _e('Color', Opt_In::TEXT_DOMAIN); ?></label>
						
						<div class="wph-pickers wph-pickers--single">
							
							<div class="wph-pickers--color">
								
								<input type="text" data-alpha="true" class="wph-color-picker" id="drop_shadow_color" value="{{drop_shadow_color}}" data-attribute="drop_shadow_color">
								
							</div>
							
						</div>
						
					</div>
					
				</div>
				
			</div><!-- #wph-ccontent--shadow -->
			
			<div id="wph-ccontent--customsize">
				
				<div class="wph-label--checkbox">
					
					<label class="wph-label--alt" for="customize_size"><?php _e('Use custom size (if selected, Pop-up won\'t be responsive)', Opt_In::TEXT_DOMAIN); ?></label>
					
					<div class="wph-input--checkbox">
						
						<input type="checkbox" id="customize_size" data-attribute="customize_size" {{_.checked(_.isTrue( customize_size ), true )}}>
						
						<label class="wph-icon i-check" for="customize_size"></label>
						
					</div>
					
				</div>
				
			</div>
			
			<div id="wph-ccontent--customsize_settings" class="{{_.class( _.isFalse( customize_size ) , 'hidden')}}">
				
				<div class="row">
					
					<div class="col-eq">
						
						<label class="wph-label--alt"><?php _e('Width', Opt_In::TEXT_DOMAIN); ?></label>
						
						<div class="wph-input--number">
							
							<input type="number" id="" min="0" max="500" step="1" value="{{custom_width}}" data-attribute="custom_width">
							
						</div>
						
					</div>
					
					<div class="col-eq">
						
						<label class="wph-label--alt"><?php _e('Height', Opt_In::TEXT_DOMAIN); ?></label>
						
						<div class="wph-input--number">
							
							<input type="number" id="" min="0" max="500" step="1" value="{{custom_height}}" data-attribute="custom_height">
							
						</div>
						
					</div>
					
				</div>
				
			</div><!-- #wph-ccontent--customsize -->
			
		</div>
		
	</div><!-- #wph-ccontent--design -->
	
	<div id="wph-ccontent--css" class="row">

		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">

			<h5><?php _e('Custom CSS', Opt_In::TEXT_DOMAIN); ?></h5>

		</div>

		<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
			
			<label class="wph-label--border{{_.class( _.isFalse( customize_css ), ' toggle-off' )}}">
				
				<span class="toggle">
					
					<input id="toggle-cc-css" class="toggle-checkbox" type="checkbox" value="1" data-attribute="customize_css" {{_.checked( _.isTrue( customize_css ), true )}} >
					
					<label class="toggle-label" for="toggle-cc-css"></label>
					
				</span>
				
				<?php _e('Use custom CSS for this Custom Content Module', Opt_In::TEXT_DOMAIN); ?>
				
			</label>
			
			<div id="wph-css-holder" class="{{_.class( _.isFalse( customize_css ), 'hidden' )}}">
				
				<label><?php _e('Available CSS Selectors (click to add):', Opt_In::TEXT_DOMAIN); ?></label>
				
				<div class="wpoi-css-selectors">
					
					<div class="wpoi-css-selectors-wrap">
						
						<# _.each( stylables, function( name, stylable ) { #>
							<a href="#" class="wph-stylable-element" data-stylable="{{stylable}}" >{{name}}</a>
						<# }); #>
						
					</div>
					
				</div>

				<div id="hustle_custom_css" data-nonce="<?php echo wp_create_nonce('hustle_custom_content_prepare_custom_css'); ?>">{{custom_css}}</div>
				
			</div>
			
		</div>
		
	</div><!-- #wph-ccontent--css -->
	
</script>

<div id="wph-ccontent--designtab" class="wph-toggletabs <?php echo ( !isset( $_GET['tab'] ) || $_GET['tab'] != 'display' ) ?  'wph-toggletabs--open' : ''; ?>">
	
	<header class="wph-toggletabs--title can-open">
		
		<h4><?php _e('Content & Design', Opt_In::TEXT_DOMAIN); ?></h4>
		
		<span class="open"><i class="wph-icon i-arrow"></i></span>
		
	</header>
	
	<section class="wph-toggletabs--content">

	</section>
	
	<footer class="wph-toggletabs--footer">
		
		<div class="row">
			
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				
				<button  class="wph-button wph-button--filled wph-button--gray wph-js-cancel-design-changes"><?php _e('Cancel', Opt_In::TEXT_DOMAIN); ?></button>
				
			</div>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				
				<button data-id="<?php echo isset(  $_GET['id'] ) ? $_GET['id']: '-1'; ?>" data-nonce="<?php echo wp_create_nonce('hustle_custom_content_save'); ?>" class="wph-button wph-button-save wph-button--filled wph-button--blue" id="save-and-next">
					
					<span class="off-action"><?php _e('Save Changes', Opt_In::TEXT_DOMAIN); ?></span>
					
					<span class="on-action"><?php _e('Saving...', Opt_In::TEXT_DOMAIN); ?></span>
					
				</button>
				
				<button data-id="<?php echo isset(  $_GET['id'] ) ? $_GET['id']: '-1'; ?>" data-nonce="<?php echo wp_create_nonce('hustle_custom_content_save'); ?>" class="wph-button wph-button--filled wph-button--gray" id="next-step">
					
					<span class="off-action"><?php _e('Next Step', Opt_In::TEXT_DOMAIN); ?></span>
					
					<span class="on-action"><?php _e('Saving...', Opt_In::TEXT_DOMAIN); ?></span>
					
				</button>
				
			</div>
			
		</div>
		
	</footer>
	
</div><!-- #wph-ccontent--designtab -->

<?php $this->render("admin/common/media-holder"); ?>

