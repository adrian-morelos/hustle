<script id="wpoi-custom-content-after-content-tpl" type="text/template">

	<div class="switch-head">

		<span class="toggle">
			
			<input id="toggle-cc-{{type}}" class="toggle-checkbox" type="checkbox" data-attribute="enabled"  {{_.checked(_.isTrue(enabled), true)}}>
			
			<label class="toggle-label" for="toggle-cc-{{type}}"></label>
			
		</span>
		
		<label>
			
			<span><?php _e('Enable {{type_name}}', Opt_In::TEXT_DOMAIN); ?></span>
			
			<span id="wph-after-content-condition-labels">{{{condition_labels}}}</span>
	
		</label>
		
	</div>

	<div class="switch-wrap{{_.class(enabled, ' open', ' closed')}}">
		
		<div class="switch-content">
			
			<div id="wph-ccontent--after-content_conditions" class="wph-flex--box wph-flex--border wph-ccontent--conditions">

				<h4><?php _e('{{type_name}} Display Conditions', Opt_In::TEXT_DOMAIN); ?></h4>
				
				<p><?php _e('By default, your new {{type_name}} will be shown on <strong>every post & page</strong>. Click ( + ) below to set-up more specific conditions.
	You can set up rules for Categories & Tags, or be even more specific & manually choose posts & pages.', Opt_In::TEXT_DOMAIN); ?></p>
				
				<div class="wph-conditions"></div>

			</div> <!-- #wph-ccontent--after-content_conditions -->

			<div id="wph-ccontent--after-content_animation">

				<h4><?php _e('Animation', Opt_In::TEXT_DOMAIN); ?></h4>

				<div class="wph-label--radio">

					<label for="afterc-animation-off"><?php _e('No Animation, Custom Content is always visible', Opt_In::TEXT_DOMAIN); ?></label>

					<div class="wph-input--radio">

						<input type="radio" name="animate" id="afterc-animation-off" data-attribute="animate" {{_.checked( animate, false )}} value="false" >

						<label class="wph-icon i-check" for="afterc-animation-off"></label>

					</div>

				</div>

				<div class="wph-label--radio">

					<label for="optin-afterc-animation-on"><?php _e('Play this Animation when user reaches Custom Content area:', Opt_In::TEXT_DOMAIN); ?></label>

					<div class="wph-input--radio">

						<input type="radio" id="optin-afterc-animation-on" name="animate" data-attribute="animate" {{_.checked( animate, true )}} value="true" >

						<label class="wph-icon i-check" for="optin-afterc-animation-on"></label>
					</div>

				</div>

				<div id="optin-afterc-animation-block" >

					<select name="optin-afterc-animation" id="optin-afterc-animation" data-attribute="animation" class="wpmuiSelect">
						<# _.each( _.keys( optin_vars.animations.in ), function( group_key ) { #>

							<optgroup label="{{group_key}}">
								<# _.each( _.keys( optin_vars.animations.in[group_key] ), function( key ) { #>

										<option {{_.selected( animation, key )}} value="{{key}}">{{optin_vars.animations.in[group_key][key]}}</option>

								<# }); #>

							</optgroup>

						<# }); #>
					</select>
								
				</div>
			</div><!-- #wph-ccontent-after-content_animation -->

				<div id="wph-ccontent--form_submit" class="wph-ccontent--formsubmit">
	
					<h4><?php _e('Form Submit', Opt_In::TEXT_DOMAIN); ?></h4>
	
					<div class="wph-label--block">
	
						<label class="wph-label--alt"><?php _e('If your content contains a form, you can change the form-submit behavior here', Opt_In::TEXT_DOMAIN); ?></label>
	
					</div>
	
					<select class="wpmuiSelect" data-attribute="on_submit">
	
						<option {{_.selected(on_submit, 'refresh_or_close')}}  value="refresh_or_close"><?php _e("Refresh or close (default)", Opt_In::TEXT_DOMAIN) ?></option>
						<option {{_.selected(on_submit, 'close_after_form_submit')}} value="close_after_form_submit"><?php _e("Always close after form submit", Opt_In::TEXT_DOMAIN) ?></option>
						<option {{_.selected(on_submit, 'refresh_or_nothing')}}  value="refresh_or_nothing"><?php _e("Refresh or do nothing (use for Ajax Forms)", Opt_In::TEXT_DOMAIN) ?></option>
						<option {{_.selected(on_submit, 'redirect_to_form_target')}}  value="redirect_to_form_target"><?php _e("Redirect to form target URL", Opt_In::TEXT_DOMAIN) ?></option>
	
					</select>
	
				</div><!-- #wph-ccontent--form_submit -->
		</div>
	</div>
</script>