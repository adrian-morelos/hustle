<script id="wpoi-custom-content-popup-tpl" type="text/template">

	<div class="switch-head">
		
		<span class="toggle">
			
			<input id="toggle-cc-{{type}}" class="toggle-checkbox" type="checkbox" data-attribute="enabled"  {{_.checked(_.isTrue(enabled), true)}}>
			
			<label class="toggle-label" for="toggle-cc-{{type}}"></label>
			
		</span>
		
		<label>
			
			<span><?php _e('Enable {{type_name}}', Opt_In::TEXT_DOMAIN); ?></span>
			
			<span id="wph-popup-condition-labels">{{{condition_labels}}}</span>
			
		</label>
		
	</div>

	<div class="switch-wrap{{_.class(enabled, ' open', ' closed')}}">
		
		<div class="switch-content">
			
			<div id="wph-ccontent--popup_conditions">
				
				<h4><?php _e('{{type_name}} Display Conditions', Opt_In::TEXT_DOMAIN); ?></h4>
				
				<p><?php _e('By default, your new {{type_name}} will be shown on <strong>every post & page</strong>. Click ( + ) below to set-up more specific conditions.
	You can set up rules for Categories & Tags, or be even more specific & manually choose posts & pages.', Opt_In::TEXT_DOMAIN); ?></p>
				
				<div class="wph-conditions"></div>
				
			</div><!-- Display Conditions -->
			
			<div id="wph-ccontent--popup_triggers">
				
				<h4><?php _e('{{type_name}} Triggers', Opt_In::TEXT_DOMAIN); ?></h4>
				
				<p><?php _e('{{type_name}} can be triggered after a certain amount of <strong>Time</strong>, when user <strong>Scrolls</strong> pass an element, on <strong>Click</strong>, if user tries to <strong>Leave</strong> or if we detect <strong>AdBlock</strong>.', Opt_In::TEXT_DOMAIN); ?></p>
				
				<div class="wph-trigger"></div>
				
			</div><!-- Triggers -->
			
			<div id="wph-ccontent--popup_animation">
				
				<h4><?php _e('Animation', Opt_In::TEXT_DOMAIN); ?></h4>
				
				<div class="row">
					
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						
						<label><?php _e('Show {{type}} animation:', Opt_In::TEXT_DOMAIN); ?></label>
						
						<select id="" name="" data-attribute="animation_in" class="wpmuiSelect">
							
							<# _.each( _.keys( optin_vars.animations.in ), function( group_key ) { #>
								
								<optgroup label="{{group_key}}">
									
									<# _.each( _.keys( optin_vars.animations.in[group_key] ), function( key ) { #>
										
										<option {{_.selected( animation_in, key )}} value="{{key}}">{{optin_vars.animations.in[group_key][key]}}</option>
										
									<# }); #>
									
								</optgroup>
								
							<# }); #>
							
						</select>
						
					</div>
					
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						
						<label><?php _e('Hide {{type}} animation:', Opt_In::TEXT_DOMAIN); ?></label>
						
						<select id="" name="" data-attribute="animation_out" class="wpmuiSelect">
							
							<# _.each( _.keys( optin_vars.animations.out ), function( group_key ) { #>
								
								<optgroup label="{{group_key}}">
									
									<# _.each( _.keys( optin_vars.animations.out [group_key] ), function( key ) { #>
										
										<option {{_.selected( animation_out, key )}} value="{{key}}">{{optin_vars.animations.out [group_key][key]}}</option>
										
									<# }); #>
									
								</optgroup>
								
							<# }); #>
							
						</select>
						
					</div>
					
				</div>
				
			</div><!-- Animation -->
			
			<div id="wph-ccontent-additional-settings" class="wph-ccontent--popup_settings">
	
				<h4><?php _e('Additional Settings', Opt_In::TEXT_DOMAIN); ?></h4>
	
				<div id="wph-ccontent--additional" class="wph-ccontent--additional">
					
					<!--<div class="wph-label--checkbox">
						
						<label class="wph-label--alt" for="{{type}}-make_fullscreen"><?php _e('Make this {{type_name}} a full screen experience', Opt_In::TEXT_DOMAIN); ?></label>
						
						<div class="wph-input--checkbox">
							
							<input type="checkbox" id="{{type}}-make_fullscreen" class="wph-label--alt" data-attribute="make_fullscreen" {{_.checked(make_fullscreen, true)}}>
							
							<label class="wph-icon i-check" for="{{type}}-make_fullscreen"></label>
							
						</div>
						
					</div>-->
	
					<div class="wph-label--checkbox">
	
						<label class="wph-label--alt" for="{{type}}-add_never_see_link"><?php _e('Add \'Never see this message again\' link', Opt_In::TEXT_DOMAIN); ?></label>
	
						<div class="wph-input--checkbox">
	
							<input type="checkbox" id="{{type}}-add_never_see_link" class="wph-label--alt" data-attribute="add_never_see_link" {{_.checked(add_never_see_link, true)}}>
	
							<label class="wph-icon i-check" for="{{type}}-add_never_see_link"></label>
	
						</div>
	
					</div>
	
					<div class="wph-label--checkbox">
	
						<label class="wph-label--alt" for="{{type}}-close_btn_as_never_see"><?php _e('Close button acts as \'Never see this message again\'', Opt_In::TEXT_DOMAIN); ?></label>
	
						<div class="wph-input--checkbox">
	
							<input type="checkbox"   id="{{type}}-close_btn_as_never_see" class="wph-label--alt" data-attribute="close_btn_as_never_see" {{_.checked(close_btn_as_never_see, true)}}>
	
							<label class="wph-icon i-check" for="{{type}}-close_btn_as_never_see"></label>
	
						</div>
	
					</div>
					
					<div class="wph-label--checkbox">
	
						<label class="wph-label--alt" for="{{type}}-page_scroll_on"><?php _e('Allow page to be scrolled while Pop-up is visible', Opt_In::TEXT_DOMAIN); ?></label>
	
						<div class="wph-input--checkbox">
	
							<input type="checkbox"   id="{{type}}-page_scroll_on" class="wph-label--alt" data-attribute="allow_scroll_page" {{_.checked(allow_scroll_page, true)}}>
	
							<label class="wph-icon i-check" for="{{type}}-page_scroll_on"></label>
	
						</div>
	
					</div>
					
					<div class="wph-label--checkbox">
	
						<label class="wph-label--alt" for="{{type}}-overlay_clickable_off"><?php _e('Clicking on the background does not close {{type_name}}', Opt_In::TEXT_DOMAIN); ?></label>
	
						<div class="wph-input--checkbox">
	
							<input type="checkbox"   id="{{type}}-overlay_clickable_off" class="wph-label--alt" data-attribute="not_close_on_background_click" {{_.checked(not_close_on_background_click, true)}}>
	
							<label class="wph-icon i-check" for="{{type}}-overlay_clickable_off"></label>
	
						</div>
	
					</div>
	
				</div><!-- #wph-ccontent--additional -->
	
				<div id="wph-ccontent--expiration" class="wph-ccontent--expiricy">
	
					<div class="wph-label--block">
	
						<label class="wph-label--alt"><?php _e('Expires', Opt_In::TEXT_DOMAIN); ?></label>
	
					</div>
	
					<div class="wph-label--number">
	
						<label class="wph-label--alt" for="{{type}}-expiration_days"><?php _e('days (upon expiry, user will see the {{type_name}} again)', Opt_In::TEXT_DOMAIN); ?></label>
	
						<div class="wph-input--number">
	
							<input type="number" id="{{type}}-expiration_days" min="0" max="500" step="1" value="{{expiration_days}}" data-attribute="expiration_days">
	
						</div>
	
					</div>
	
				</div><!-- #wph-ccontent--expiration -->
	
				<div id="wph-ccontent--form_submit" class="wph-ccontent--formsubmit">
	
					<h4><?php _e('Form Submit', Opt_In::TEXT_DOMAIN); ?></h4>
	
					<div class="wph-label--block">
	
						<label class="wph-label--alt"><?php _e('If your Pop-up contains a form, you can change the form-submit behavior here', Opt_In::TEXT_DOMAIN); ?></label>
	
					</div>
	
					<select class="wpmuiSelect" data-attribute="on_submit">
	
						<option {{_.selected(on_submit, 'refresh_or_close')}}  value="refresh_or_close"><?php _e("Refresh or close (default)", Opt_In::TEXT_DOMAIN) ?></option>
						<option {{_.selected(on_submit, 'close_after_form_submit')}} value="close_after_form_submit"><?php _e("Always close after form submit", Opt_In::TEXT_DOMAIN) ?></option>
						<option {{_.selected(on_submit, 'refresh_or_nothing')}}  value="refresh_or_nothing"><?php _e("Refresh or do nothing (use for Ajax Forms)", Opt_In::TEXT_DOMAIN) ?></option>
						<option {{_.selected(on_submit, 'redirect_to_form_target')}}  value="redirect_to_form_target"><?php _e("Redirect to form target URL", Opt_In::TEXT_DOMAIN) ?></option>
	
					</select>
	
				</div><!-- #wph-ccontent--form_submit -->
	
			</div><!-- Additional Settings -->
			
		</div>
		
	</div>
	
</script>