<script id="wpoi-custom-content-slide_in-tpl" type="text/template">

	<div class="switch-head">
		
		<span class="toggle">
			
			<input id="toggle-cc-{{type}}" class="toggle-checkbox" type="checkbox" data-attribute="enabled"  {{_.checked(_.isTrue(enabled), true)}}>
			
			<label class="toggle-label" for="toggle-cc-{{type}}"></label>
			
		</span>
		
		<label>
		
			<span><?php _e('Enable {{type_name}}', Opt_In::TEXT_DOMAIN); ?></span>
			
			<span id="wph-slide-in-condition-labels">{{{condition_labels}}}</span>
			
		</label>

	</div>

	<div class="switch-wrap{{_.class(enabled, ' open', ' closed')}}">
		
		<div class="switch-content">
			
			<div class="wph-flex--box wph-flex--border wph-ccontent--conditions">
	
				<h4><?php _e('{{type_name}} Display Conditions', Opt_In::TEXT_DOMAIN); ?></h4>
	
				<p><?php _e('By default, your new {{type_name}} will be shown on <strong>every post & page</strong>. Click ( + ) below to set-up more specific conditions.
	You can set up rules for Categories & Tags, or be even more specific & manually choose posts & pages.', Opt_In::TEXT_DOMAIN); ?></p>
	
				<div class="wph-conditions"></div>
	
			</div><!-- Display Conditions -->
	
			<div id="wph-ccontent--triggers" class="wph-ccontent-slidein_triggers">
	
				<h4 class="wph-text--reset"><?php _e('{{type_name}} Triggers', Opt_In::TEXT_DOMAIN); ?></h4>
	
				<p><?php _e('{{type_name}} can be triggered after a certain amount of <strong>Time</strong>, when user <strong>Scrolls</strong> pass an element, on <strong>Click</strong>, if user tries to <strong>Leave</strong> or if we detect <strong>AdBlock</strong>.', Opt_In::TEXT_DOMAIN); ?></p>
	
				<div class="wph-trigger"></div>
	
			</div><!-- Triggers -->
	
			<div id="wph-ccontent--slidein_options">
	
				<h4><?php _e('After user closes Slide-in', Opt_In::TEXT_DOMAIN); ?></h4>
				
				<div id="wph-ccontent--additional_settings">
				
					<div class="wph-label--radio">
						
						<label for="wpoi-slidein-keep-showing"><?php _e("Keep showing this message to user", Opt_In::TEXT_DOMAIN); ?></label>
						
						<div class="wph-input--radio">
							
							<input type="radio" id="wpoi-slidein-keep-showing" name="wpoi-slidein-close" value="keep_showing" data-attribute="after_close" {{ _.checked(after_close, 'keep_showing') }} >
							
							<label class="wph-icon i-check" for="wpoi-slidein-keep-showing"></label>
							
						</div>
						
					</div>
					
					<div class="wph-label--radio">
						
						<label for="wpoi-slidein-noshow"><?php _e("No longer show message on this post / page", Opt_In::TEXT_DOMAIN); ?></label>
						
						<div class="wph-input--radio">
							
							<input type="radio" id="wpoi-slidein-noshow" name="wpoi-slidein-close" value="no_show" data-attribute="after_close" {{ _.checked(after_close, 'no_show') }} >
							
							<label class="wph-icon i-check" for="wpoi-slidein-noshow"></label>
							
						</div>
						
					</div>
					
					<div class="wph-label--radio">
						
						<label for="wpoi-slidein-hide"><?php _e("Hide all slide-in messages for user", Opt_In::TEXT_DOMAIN); ?></label>
						
						<div class="wph-input--radio">
							
							<input type="radio" id="wpoi-slidein-hide" name="wpoi-slidein-close"  value="hide_all"  data-attribute="after_close" {{ _.checked(after_close, 'hide_all') }} >
							
							<label class="wph-icon i-check" for="wpoi-slidein-hide"></label>
							
						</div>
						
					</div>
					
				</div><!-- After user closes Slide-in -->
				
			</div>
			
			<div id="wph-ccontent--slidein_expiricy">
				
				<h4><?php _e('Message Autohide', Opt_In::TEXT_DOMAIN); ?></h4>
				
				<div class="wph-label--mix">
	
					<label class="wph-label--alt"><?php _e("Automatically hide message after", Opt_In::TEXT_DOMAIN); ?></label>
	
					<div class="wph-input--checkbox">
	
						<input id="slide_in-hide_after" type="checkbox" {{ _.checked(hide_after, true) }} data-attribute="hide_after" value="true">
	
						<label class="wph-icon i-check" for="slide_in-hide_after"></label>
	
					</div>
	
					<div class="wph-input--number">
	
						<input min="0" type="number" value="{{hide_after_val}}" data-attribute="hide_after_val">
	
					</div>
	
					<select data-attribute="hide_after_unit" class="wpmuiSelect">
	
						<option value="seconds" {{ _.selected( hide_after_unit, 'seconds' ) }}  ><?php _e("Seconds", Opt_In::TEXT_DOMAIN); ?></option>
						<option value="minutes" {{ _.selected( hide_after_unit, 'minutes' ) }} ><?php _e("Minutes", Opt_In::TEXT_DOMAIN) ?></option>
						<option value="hours" {{ _.selected( hide_after_unit, 'hours' ) }} ><?php _e("Hours", Opt_In::TEXT_DOMAIN); ?></option>
	
					</select>
	
				</div>
				
			</div>
			
			<div id="wph-ccontent--slidein_position">
				
				<h4><?php _e('Slide-in Position', Opt_In::TEXT_DOMAIN); ?></h4>
				
				<label id="wpoi-slide_in-position-label">{{position_label}}</label>
				
				<div class="wpoi-position-block">
					
					<div class="wpoi-position-block-header">
						
						<span class="wpoi-pb-header-button"></span>
						
						<span class="wpoi-pb-header-button"></span>
						
						<span class="wpoi-pb-header-button"></span>
						
					</div>
					
					<div class="wpoi-position-block-section">
						
						<input class="wpoi-pb-top-left" type="radio" name="wpoi-slide_in-position" data-attribute="position" value="top_left" {{_.checked( position, 'top_left' )}} >
						
						<input class="wpoi-pb-top-center" type="radio" name="wpoi-slide_in-position" data-attribute="position" value="top_center" {{_.checked( position, 'top_center' )}} >
						
						<input class="wpoi-pb-top-right" type="radio" name="wpoi-slide_in-position" data-attribute="position" value="top_right" {{_.checked( position, 'top_right' )}} >
						
						<input class="wpoi-pb-center-right" type="radio" name="wpoi-slide_in-position" data-attribute="position" value="center_right" {{_.checked( position, 'center_right' )}}  >
						
						<input class="wpoi-pb-bottom-right" type="radio" name="wpoi-slide_in-position" data-attribute="position" value="bottom_right" {{_.checked( position, 'bottom_right' )}} >
						
						<input class="wpoi-pb-bottom-center" type="radio" name="wpoi-slide_in-position" data-attribute="position" value="bottom_center" {{_.checked( position, 'bottom_center' )}} >
						
						<input class="wpoi-pb-bottom-left" type="radio" name="wpoi-slide_in-position" data-attribute="position" value="bottom_left" {{_.checked( position, 'bottom_left' )}} >
						
						<input class="wpoi-pb-center-left" type="radio" name="wpoi-slide_in-position" data-attribute="position" value="center_left" {{_.checked( position, 'center_left' ) }}  >
						
					</div>
					
				</div>
				
			</div><!-- #wph-ccontent--slidein_position -->
	
			<div id="wph-ccontent-additional-settings" class="wph-flex--box">
	
				<div id="wph-ccontent--form_submit" class="wph-flex wph-flex--column">
	
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