<?php
/**
 * @var Opt_In_Admin $this
 * @var Opt_In_Model $optin
 * @var bool $is_edit if it's in edit mode
 */
?>
<script id="wpoi-wizard-settings_widget_template" type="text/template">
	
	<div class="row">
		
		<label><?php printf( __('You can configure <strong>After Content</strong>, <strong>Pop-up</strong> and <strong>Slide-in</strong> opt-ins in the sections that follow.<br/>Widget opt-in can be set-up in <strong>Appearance » <a href="%s">Widgets</a></strong>', Opt_In::TEXT_DOMAIN), $widgets_page_url ); ?></label>
		
		<label><?php _e('Use the following shortcode to embed your opt-in anywhere:', Opt_In::TEXT_DOMAIN); ?></label>
		
		<div class="wph-shortcode"><?php printf( __('[%s id="{{shortcode_id}}"]', Opt_In::TEXT_DOMAIN ), Opt_In_Front::SHORTCODE );?></div>
		
	</div>
	
</script>

<script id="wpoi-wizard-settings_template" type="text/template">
	
	<header class="wph-toggletabs--title can-open">
		
		<h4><?php _e('Display Settings', Opt_In::TEXT_DOMAIN); ?></h4>
		
		<span class="open"><i class="wph-icon i-arrow"></i></span>
		
	</header><!-- .wph-toggletabs--header -->
	
	<section class="wph-toggletabs--content">
		
		<div id="wph-optin--information" class="row">
			
			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
	
				<h5><?php _e('Information', Opt_In::TEXT_DOMAIN); ?></h5>
	
			</div>
			
			<div id="wpoi-wizard-settings-widget-message" class="col-xs-12 col-sm-9 col-md-9 col-lg-9"></div>
			
		</div><!-- #wph-optin--information -->
		
		<div id="wph-optin--after_content" class="row">
			
			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
	
				<h5><?php _e('After content', Opt_In::TEXT_DOMAIN); ?></h5>
				
				<!--<span class="tooltip-left wpoi-tooltip" tooltip="<?php _e('Will look for the_content of post/page and place the Opt-in afterwards', Opt_In::TEXT_DOMAIN) ?>"><span class="dashicons dashicons-editor-help  wpoi-icon-info" ></span></span>-->
	
			</div>
			
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
				
				<div class="switch-head">
					
					<span class="toggle">
						
						<input id="wpoi-after-content-state-toggle" class="toggle-checkbox" type="checkbox" name="wpoi-after-content-state-toggle" data-attribute="after_content.enabled" value="true" data-type="after-content" {{_.checked(after_content.enabled, true)}}>
						
						<label class="toggle-label" for="wpoi-after-content-state-toggle"></label>
						
					</span>
					
					<label>
						
						<span><?php _e('Enable after content opt-in', Opt_In::TEXT_DOMAIN); ?></span>
						
						<# if ( _.isTrue( after_content.enabled ) ){ #>
							
							<span id="wph-after-content-condition-labels">{{{after_content.condition_labels}}}</span>
							
						<# } #>
						
					</label>
					
				</div>
				
				<div class="switch-wrap {{_.class( _.isTrue( after_content.enabled ), 'open' )}}">
					
					<div class="switch-content">
					
						<div id="wph-optin--after_content_conditions">
							
							<h4><?php _e('After Content Display Conditions', Opt_In::TEXT_DOMAIN); ?></h4>
							
							<p><?php _e('By default, your new Pop-up will be shown on <strong>every post & page</strong>. Click ( + ) below to set-up more specific conditions.<br />You can set up rules for Categories & Tags, or be even more specific & manually choose posts & pages.', Opt_In::TEXT_DOMAIN); ?></p>
							
							<div class="wph-conditions"></div>
							
						</div><!-- Display Conditions -->
						
						<div id="wph-optin--after_animations" class="wph-flex--box">
							
							<h4><?php _e('Animation', Opt_In::TEXT_DOMAIN); ?></h4>
							
							<div class="wph-label--radio">
								
								<label for="optin-afterc-animation-off"><?php _e('No Animation, Opt-in is always visible', Opt_In::TEXT_DOMAIN); ?></label>
								
								<div class="wph-input--radio">
									
									<input type="radio" id="optin-afterc-animation-off" name="optin-afterc-animation" data-attribute="after_content.animate" {{_.checked( after_content.animate, false )}} value="false" >
									
									<label class="wph-icon i-check" for="optin-afterc-animation-off"></label>
									
								</div>
								
							</div>
							
							<div class="wph-label--radio">
								
								<label for="optin-afterc-animation-on"><?php _e('Play this Animation when user reaches Opt-in area:', Opt_In::TEXT_DOMAIN); ?></label>
								
								<div class="wph-input--radio">
									
									<input type="radio" id="optin-afterc-animation-on" name="optin-afterc-animation" data-attribute="after_content.animate" {{_.checked( after_content.animate, true )}} value="true" >
									
									<label class="wph-icon i-check" for="optin-afterc-animation-on"></label>
									
								</div>
								
							</div>
							
							<div id="optin-afterc-animation-block" {{_.add_class( _.isFalse( after_content.animate ), 'hidden' )}} >
								
								<select name="optin-afterc-animation" id="optin-afterc-animation" data-attribute="after_content.animation" class="wpmuiSelect">
									
									<?php foreach( $animations->in as $key => $group ): ?>
										
										<optgroup label="<?php echo $key ?>">
											
											<?php foreach( $group as $animate_key => $animation ): ?>
												
												<option {{_.selected( after_content.animation, '<?php echo $animate_key; ?>' )}} value="<?php echo $animate_key ?>"><?php echo $animation ?></option>
												
											<?php endforeach; ?>
											
										</optgroup>
										
									<?php endforeach; ?>
									
								</select>
								
							</div>
							
						</div><!-- Display Animation -->
						
					</div>
					
				</div>
				
			</div>
			
		</div><!-- #wph-optin--after_content -->
		
		<div id="wph-optin--popup" class="row">
			
			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
	
				<h5><?php _e('Pop-up', Opt_In::TEXT_DOMAIN); ?></h5>
	
			</div>
			
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
				
				<div class="switch-head">
					
					<span class="toggle">
						
						<input id="wpoi-popup-state-toggle" class="toggle-checkbox" type="checkbox" name="wpoi-popup-state-toggle" data-attribute="popup.enabled" value="true" data-type="popup"  {{_.checked(popup.enabled, true)}} >
						
						<label class="toggle-label" for="wpoi-popup-state-toggle"></label>
						
					</span>
					
					<label>
						
						<span><?php _e('Enable pop-up opt-in', Opt_In::TEXT_DOMAIN); ?></span>
						
						<# if ( _.isTrue( popup.enabled ) ){ #>
							
							<span id="wph-popup-condition-labels">{{{popup.condition_labels}}}</span>
							
						<# } #>
						
					</label>
					
				</div>
				
				<div class="switch-wrap {{_.class( _.isTrue( popup.enabled ) , 'open')}}">
					
					<div class="switch-content">
						
						<div id="wph-optin--popup_conditions" class="wph-flex--box wph-flex--border">
							
							<h4><?php _e('Opt-in Display Conditions', Opt_In::TEXT_DOMAIN); ?></h4>
							
							<p><?php _e('By default, your new Pop-up will be shown on every <strong>post & page</strong>. Click ( + ) below to set-up more specific conditions. 
	You can set up rules for Categories & Tags, or be even more specific & manually choose posts & pages.', Opt_In::TEXT_DOMAIN); ?></p>
							
							<div class="wph-conditions"></div>
	
						</div><!-- Display Conditions -->
						
						<div id="wph-optin--popup_triggers">
							
							<h4><?php _e('Pop-up Triggers', Opt_In::TEXT_DOMAIN); ?></h4>
							
							<p><?php _e("Pop-up can be triggered after a certain amount of <strong>Time</strong>, when user <strong>Scrolls</strong> pass an element, on <strong>Click</strong>, if user tries to <strong>Leave</strong> or if we detect <strong>AdBlock</strong>", Opt_In::TEXT_DOMAIN); ?></p>
							
							<section id="triggers-section-popup"></section>
							
						</div><!-- Triggers -->
						
						<div id="wph-optin--popup_animation" class="wph-flex--box wph-flex--border">
							
							<h4><?php _e('Animation', Opt_In::TEXT_DOMAIN); ?></h4>
							
							<div class="row">
								
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
									
									<label><?php _e("Show pop-up animation:", Opt_In::TEXT_DOMAIN); ?></label>
									
									<select data-attribute="popup.animation_in" class="wpmuiSelect">
										
										<?php foreach( $animations->in as $key => $group ): ?>
											
											<optgroup label="<?php echo $key ?>">
												
												<?php foreach( $group as $animate_key => $animation ): ?>
													
													<option {{_.selected(popup.animation_in, "<?php echo $animate_key; ?>")}} value="<?php echo $animate_key ?>"><?php echo $animation ?></option>
												<?php endforeach; ?>
												
											</optgroup>
											
										<?php endforeach; ?>
										
									</select>
									
								</div>
								
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
									
									<label><?php _e("Hide pop-up animation:", Opt_In::TEXT_DOMAIN); ?></label>
									
									<select data-attribute="popup.animation_out" class="wpmuiSelect" >
										
										<?php foreach( $animations->out as $key => $group ): ?>
											
											<optgroup label="<?php echo $key ?>">
												
												<?php foreach( $group as $animate_key => $animation ): ?>
													
													<option {{_.selected(popup.animation_out, "<?php echo $animate_key; ?>")}} value="<?php echo $animate_key ?>"><?php echo $animation ?></option>
												<?php endforeach; ?>
												
											</optgroup>
											
										<?php endforeach; ?>
										
									</select>
									
								</div>
								
							</div>
								
						</div><!-- Animation -->
						
						<div id="wph-optin--popup_settings" class="wph-flex--box">
							
							<h4><?php _e('Additional Settings', Opt_In::TEXT_DOMAIN); ?></h4>
							
							<div id="wph-optin--additional_settings" class="wph-flex wph-flex--column wph-margin--20b">
								
	<!--							<div class="wph-label--checkbox">-->
	<!--								-->
	<!--								<label>--><?php //_e('Make this Pop-up a full screen experience', Opt_In::TEXT_DOMAIN); ?><!--</label>-->
	<!--								-->
	<!--								<input type="checkbox">-->
	<!--								-->
	<!--							</div>-->
								
								<div class="wph-label--checkbox">
									
									<label for="popup_add_never_see_this_message"><?php _e("Add 'Never see this message again' link", Opt_In::TEXT_DOMAIN); ?></label>
									
									<div class="wph-input--checkbox">
										
										<input type="checkbox" id="popup_add_never_see_this_message" name=""  {{_.checked(popup.add_never_see_this_message, true)}} data-attribute="popup.add_never_see_this_message">
										
										<label class="wph-icon i-check" for="popup_add_never_see_this_message"></label>
										
									</div>
									
								</div>
								
								<div class="wph-label--checkbox">
									
									<label for="popup_close_button_acts_as_never_see_again"><?php _e("Close button acts as 'Never see this message again' link", Opt_In::TEXT_DOMAIN); ?></label>
									
									<div class="wph-input--checkbox">
										
										<input type="checkbox" id="popup_close_button_acts_as_never_see_again" name="" value="true" {{_.checked(popup.close_button_acts_as_never_see_again, true)}} data-attribute="popup.close_button_acts_as_never_see_again">
										
										<label class="wph-icon i-check" for="popup_close_button_acts_as_never_see_again"></label>
										
									</div>
									
								</div>
								
								<div class="wph-label--checkbox">
									<label for="popup_page_scroll_on"><?php _e('Allow page to be scrolled while Pop-up is visible', Opt_In::TEXT_DOMAIN); ?></label>
									
									<div class="wph-input--checkbox">
										<input type="checkbox" id="popup_page_scroll_on" name="" value="1" {{_.checked(popup.allow_scroll_page, true)}} data-attribute="popup.allow_scroll_page" />
										<label class="wph-icon i-check" for="popup_page_scroll_on"></label>
									</div>
								</div>
								
								<div class="wph-label--checkbox">
									<label for="popup_overlay_clickable"><?php _e('Clicking on the background does not close Pop-up', Opt_In::TEXT_DOMAIN); ?></label>
									
									<div class="wph-input--checkbox">
										<input type="checkbox" id="popup_overlay_clickable" name="" value="1" {{_.checked(popup.not_close_on_background_click, true)}} data-attribute="popup.not_close_on_background_click" />
										<label class="wph-icon i-check" for="popup_overlay_clickable"></label>
									</div>
								</div>
							</div><!-- Additional Settings -->
							
							<div id="wph-optin--expiricy" class="wph-flex wph-flex--column">
								
								<div class="wph-label--block">
									
									<label><?php _e('Expires', Opt_In::TEXT_DOMAIN); ?></label>
									
								</div>
								
								<div class="wph-label--number">
									
									<label><?php _e("days (upon expiry, user will see the Pop-up again)", Opt_In::TEXT_DOMAIN); ?></label>
									
									<div class="wph-input--number">
										
										<input type="number" min="0" value="{{popup.never_see_expiry}}" data-attribute="popup.never_see_expiry">
										
									</div>
									
								</div>
								
							</div><!-- Expiricy -->
							
						</div><!-- Additional Settings -->
						
					</div>
					
				</div>
				
			</div>
			
		</div><!-- #wph-optin--popup -->
		
		<div id="wph-optin--slidein" class="row">
			
			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
	
				<h5><?php _e('Slide-in', Opt_In::TEXT_DOMAIN); ?></h5>
	
			</div>
			
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
				
				<div class="switch-head">
					
					<span class="toggle">
						
						<input id="wpoi-slide-in-state-toggle" class="toggle-checkbox" type="checkbox" name="wpoi-slide-in-state-toggle" data-attribute="slide_in.enabled" data-type="slidein" value="true" {{_.checked(slide_in.enabled, true)}}>
						
						<label class="toggle-label" for="wpoi-slide-in-state-toggle"></label>
						
					</span>
					
					<label>
						
						<span><?php _e('Enable slide-in opt-in', Opt_In::TEXT_DOMAIN); ?></span>
						
						<# if ( _.isTrue( slide_in.enabled ) ){ #>
							
							<span id="wph-slide-in-condition-labels">{{{slide_in.condition_labels}}}</span>
							
						<# } #>
						
					</label>
					
				</div>
				
				<div class="switch-wrap {{_.class( _.isTrue( slide_in.enabled ) , 'open')}}">
					
					<div class="switch-content">
						
						<div id="wph-optin--slide_in_conditions" class="wph-flex--box wph-flex--border">
							
							<h4><?php _e('Slide-in Display Conditions', Opt_In::TEXT_DOMAIN); ?></h4>
							
							<p><?php _e('By default, your new Pop-up will be shown on every <strong>post & page</strong>. Click ( + ) below to set-up more specific conditions. 
	You can set up rules for Categories & Tags, or be even more specific & manually choose posts & pages.', Opt_In::TEXT_DOMAIN); ?></p>
							
							<div class="wph-conditions"></div>
							
						</div><!-- Display Conditions -->
						
						<div id="wph-optin--slidein_triggers">
							
							<h4><?php _e('Slide-in Triggers', Opt_In::TEXT_DOMAIN); ?></h4>
							
							<p><?php _e("Slide-in can be triggered after a certain amount of <strong>Time</strong>, when user <strong>Scrolls</strong> pass an element, on <strong>Click</strong>, if user tries to <strong>Leave</strong> or if we detect <strong>AdBlock</strong>", Opt_In::TEXT_DOMAIN); ?></p>
							
							<section class="wph-trigger" id="triggers-section-slide_in"></section>
							
						</div><!-- Triggers -->
						
						<div id="wph-optin--slidein_options">
							
							<h4><?php _e('After user closes Slide-in', Opt_In::TEXT_DOMAIN); ?></h4>
							
							<div id="wph-optin--additional_settings">
								
								<div class="wph-label--radio">
									
									<label for="wpoi-slidein-keep-showing"><?php _e("Keep showing this message to user", Opt_In::TEXT_DOMAIN); ?></label>
									
									<div class="wph-input--radio">
										
										<input type="radio" id="wpoi-slidein-keep-showing" name="wpoi-slidein-close" value="keep_showing" data-attribute="slide_in.after_close" {{ _.checked(slide_in.after_close, 'keep_showing') }} >
										
										<label class="wph-icon i-check" for="wpoi-slidein-keep-showing"></label>
										
									</div>
									
								</div>
								
								<div class="wph-label--radio">
									
									<label for="wpoi-slidein-noshow"><?php _e("No longer show message on this post / page", Opt_In::TEXT_DOMAIN); ?></label>
									
									<div class="wph-input--radio">
										
										<input type="radio" id="wpoi-slidein-noshow" name="wpoi-slidein-close" value="no_show" data-attribute="slide_in.after_close" {{ _.checked(slide_in.after_close, 'no_show') }} >
										
										<label class="wph-icon i-check" for="wpoi-slidein-noshow"></label>
										
									</div>
									
								</div>
								
								<div class="wph-label--radio">
									
									<label for="wpoi-slidein-hide"><?php _e("Hide all slide-in messages for user", Opt_In::TEXT_DOMAIN); ?></label>
									
									<div class="wph-input--radio">
										
										<input type="radio" id="wpoi-slidein-hide" name="wpoi-slidein-close"  value="hide_all"  data-attribute="slide_in.after_close" {{ _.checked(slide_in.after_close, 'hide_all') }} >
										
										<label class="wph-icon i-check" for="wpoi-slidein-hide"></label>
										
									</div>
									
								</div>
								
							</div>
							
						</div><!-- After user closes Slide-in -->
						
						<div id="wph-optin--expiricy">
							
							<h4><?php _e('Message Autohide', Opt_In::TEXT_DOMAIN); ?></h4>
							
							<div class="wph-label--mix">
								
								<label><?php _e("Automatically hide message after", Opt_In::TEXT_DOMAIN); ?></label>
								
								<div class="wph-input--checkbox">
									
									<input id="slide_in-hide_after" type="checkbox" {{ _.checked(slide_in.hide_after, true) }} data-attribute="slide_in.hide_after" value="true">
									
									<label class="wph-icon i-check" for="slide_in-hide_after"></label>
									
								</div>
								
								<div class="wph-input--number">
									
									<input min="0" type="number" value="{{slide_in.hide_after_val}}" data-attribute="slide_in.hide_after_val">
									
								</div>
								
								<select data-attribute="slide_in.hide_after_unit" class="wpmuiSelect">
									
									<option value="seconds" {{ _.selected( slide_in.hide_after_unit, 'seconds' ) }}  ><?php _e("Seconds", Opt_In::TEXT_DOMAIN); ?></option>
									<option value="minutes" {{ _.selected( slide_in.hide_after_unit, 'minutes' ) }} ><?php _e("Minutes", Opt_In::TEXT_DOMAIN) ?></option>
									<option value="hours" {{ _.selected( slide_in.hide_after_unit, 'hours' ) }} ><?php _e("Hours", Opt_In::TEXT_DOMAIN); ?></option>
									
								</select>
								
							</div>
							
						</div><!-- Auto Hide -->
						
						<div id="wph-optin--slidein_position">
							
							<h4><?php _e('Slide-in Position', Opt_In::TEXT_DOMAIN); ?></h4>
							
							<label id="wpoi-slide_in-position-label">{{slide_in.position_label}}</label>
							
							<div class="wpoi-position-block">
								
								<div class="wpoi-position-block-header">
									
									<span class="wpoi-pb-header-button"></span>
									
									<span class="wpoi-pb-header-button"></span>
									
									<span class="wpoi-pb-header-button"></span>
									
								</div>
								
								<div class="wpoi-position-block-section">
									
									<input class="wpoi-pb-top-left" type="radio" name="wpoi-slide_in-position" data-attribute="slide_in.position" value="top_left" {{_.checked( slide_in.position, 'top_left' )}} >
									
									<input class="wpoi-pb-top-center" type="radio" name="wpoi-slide_in-position" data-attribute="slide_in.position" value="top_center" {{_.checked( slide_in.position, 'top_center' )}} >
									
									<input class="wpoi-pb-top-right" type="radio" name="wpoi-slide_in-position" data-attribute="slide_in.position" value="top_right" {{_.checked( slide_in.position, 'top_right' )}} >
									
									<input class="wpoi-pb-center-right" type="radio" name="wpoi-slide_in-position" data-attribute="slide_in.position" value="center_right" {{_.checked( slide_in.position, 'center_right' )}}  >
									
									<input class="wpoi-pb-bottom-right" type="radio" name="wpoi-slide_in-position" data-attribute="slide_in.position" value="bottom_right" {{_.checked( slide_in.position, 'bottom_right' )}} >
									
									<input class="wpoi-pb-bottom-center" type="radio" name="wpoi-slide_in-position" data-attribute="slide_in.position" value="bottom_center" {{_.checked( slide_in.position, 'bottom_center' )}} >
									
									<input class="wpoi-pb-bottom-left" type="radio" name="wpoi-slide_in-position" data-attribute="slide_in.position" value="bottom_left" {{_.checked( slide_in.position, 'bottom_left' )}} >
									
									<input class="wpoi-pb-center-left" type="radio" name="wpoi-slide_in-position" data-attribute="slide_in.position" value="center_left" {{_.checked( slide_in.position, 'center_left' ) }}  >
									
								</div>
								
							</div>
							
						</div><!-- Additional Settings -->
						
					</div>
					
				</div>
				
			</div>
			
		</div><!-- #wph-optin--slidein -->
		
	</section>
		
	<footer class="wph-toggletabs--footer">
		
		<div class="row">
			
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 previous">
				
				<a href="" class="wph-button wph-button--filled wph-button--gray js-wph-optin-back"><?php _e('Back', Opt_In::TEXT_DOMAIN); ?></a>
				
			</div>
			
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 next-button">
				
				<button data-nonce="<?php echo $save_nonce; ?>" class="wph-button wph-button-save wph-button--filled wph-button--blue" >
					
					<span class="off-action"><?php _e('Save Changes', Opt_In::TEXT_DOMAIN); ?></span>
					
					<span class="on-action"><?php _e('Saving...', Opt_In::TEXT_DOMAIN); ?></span>
					
				</button>
				
				<button data-nonce="<?php echo $save_nonce; ?>" class="wph-button wph-button-finish wph-button--filled wph-button--gray" >
					
					<span class="off-action"><?php _e('Finish Setup', Opt_In::TEXT_DOMAIN); ?></span>
					
					<span class="on-action"><?php _e('Saving...', Opt_In::TEXT_DOMAIN); ?></span>
					
				</button>
				
			</div>
			
		</div>
		
	</footer><!-- .wph-toggletabs--footer -->
		
		<!--<li>
				
				<div class="wpoi-listing-wrap" id="wpoi-listing-wrap-slide_in">
					
					<header class="can-open display-settings-icon">
						
						<h2 class="tl icon slidein slide_in"><?php _e('Slide-in', Opt_In::TEXT_DOMAIN); ?></h2>
						
						<div class="wpoi-toggle-mask">
							
							<div class="wpoi-toggle-mask-element">
							
								<div class="wpoi-toggle-block <# if( !_.isTrue(slide_in.enabled) ){ #> inactive <# } #>">
									
									<p><?php _e('Inactive', Opt_In::TEXT_DOMAIN); ?></p>
								
									
									
								</div>
								
							</div>
							
							<div class="wpoi-toggle-mask-element">
								
								<span class="open"><i class="dev-icon dev-icon-caret_down"></i></span>
								
							</div>
							
						</div>
						
					</header>
					
					<section>
						
						<div class="row white w-border">
							
							<div class="col-half">
								
								<div class="accordion-block">
									
									<header>
										
										<h6 class="tl"><?php _e("Slide-in Trigger Conditions", Opt_In::TEXT_DOMAIN); ?></h6>
										
									</header>

									
									
								</div>
								
							</div>
							
							<div class="col-half">
								
								<div class="accordion-block">
									
									<header>
										
										<h6 class="tl"><?php _e("After user closes Slide-in", Opt_In::TEXT_DOMAIN); ?></h6>
										
									</header>
									
									<section>
										
										<div class="wpoi-wrapper">
											
											<div class="wpoi-element-block one-line">
												
												
												
											</div>
											
											<div class="wpoi-element-block one-line">
												
												
												
											</div>
											
											<div class="wpoi-element-block one-line">
												
												
												
											</div>
											
										</div>
										
									</section>
									
								</div>
								
							</div>
							
						</div>
						
						<div class="row white w-border">
							
							<div class="col-half">
								
								<div class="accordion-block">
									
									<header>
										
										<h6 class="tl"><?php _e("Message Position", Opt_In::TEXT_DOMAIN); ?></h6>
										
									</header>
									
									<section id="wpoi-slidein-position">
										
										<div class="wpoi-wrapper">
											
											<div class="wpoi-element-block one-line">
												
												
												
												
												
											</div>
											
										</div>
										
									</section>
									
								</div>
								
							</div>
							
							<div class="col-half">
								
								<div class="accordion-block">
									
									<header>
										
										<h6 class="tl"><?php _e("Message Auto Hide", Opt_In::TEXT_DOMAIN); ?></h6>
										
									</header>
									
									<section>
										
										<div class="wpoi-wrapper">
											
											<div class="wpoi-element-block one-line">
												
												
												
											</div>
											
										</div>
										
									</section>
									
								</div>
								
							</div>
							
						</div>

						<div class="row white w-border">

							<div class="accordion-block">

								<header>

									<h6 class="tl"><?php _e("Displaying Conditions", Opt_In::TEXT_DOMAIN); ?></h6>

								</header>

								<section>

									<div class="wpoi-conditions-wrap" id="wpoi-conditions-wrap-slide_in">

										<div class="wpoi-conditions-block wpoi-conditions-available">

											<label><?php _e("Available Conditions", Opt_In::TEXT_DOMAIN); ?></label>

											<div class="wpoi-conditions-list wpoi-conditions-list-handles"></div>


										</div>

										<div class="wpoi-conditions-block wpoi-conditions-met">

											<label><?php _e("Show this Slide-in if the following conditions are met:", Opt_In::TEXT_DOMAIN); ?></label>

											<div class="wpoi-conditions-list wpoi-condition-items"></div>

										</div>

									</div>

								</section>

							</div>

						</div>
					</section>
					
				</div>
				
		</li><!-- End Slide-in Settings -->

</script>

<script id="wpoi-wizard-settings-triggers-template" type="text/template">
	<section class="tabs">

		<ul class="tabs-header">
			<li class="<# if( appear_after === 'time' ){ #>current<# } #>">
				<label href="#wpoi-triggers-{{type}}-time" for="wpoi-{{type}}-appear_after_time">
					<input type="radio" class="wpoi-display-trigger-radio" name="wpoi-{{type}}-appear_after" id="wpoi-{{type}}-appear_after_time" data-attribute="{{type}}.appear_after" value="time" {{_.checked(appear_after, "time" )}} >
					<?php _e("Time", Opt_In::TEXT_DOMAIN) ?>
				</label>
			</li>
			<li class="<# if( appear_after === 'scrolled' ){ #>current<# } #>" >
				<label href="#wpoi-triggers-{{type}}-scroll" for="wpoi-{{type}}-appear_after_scrolled">
					<input type="radio" name="wpoi-{{type}}-appear_after" class="wpoi-display-trigger-radio" id="wpoi-{{type}}-appear_after_scrolled"  data-attribute="{{type}}.appear_after" value="scrolled" {{_.checked(appear_after, "scrolled" )}} >
					<?php _e("Scroll", Opt_In::TEXT_DOMAIN) ?>
				</label>
			</li>
			<li class="<# if( appear_after === 'click' ){ #>current<# } #>">
				<label href="#wpoi-triggers-{{type}}-click" for="wpoi-{{type}}-appear_after_click">
					<input type="radio" name="wpoi-{{type}}-appear_after" class="wpoi-display-trigger-radio" id="wpoi-{{type}}-appear_after_click" data-attribute="{{type}}.appear_after" value="click" {{_.checked(appear_after, "click" )}} >
					<?php _e("Click", Opt_In::TEXT_DOMAIN) ?>
				</label>
			</li>

			<li class="<# if( appear_after === 'exit_intent' ){ #>current<# } #>">
				<label href="#wpoi-triggers-{{type}}-exit_intent" for="wpoi-{{type}}-appear_after_exit_intent">
					<input type="radio" name="wpoi-{{type}}-appear_after" class="wpoi-display-trigger-radio" data-attribute="{{type}}.appear_after" id="wpoi-{{type}}-appear_after_exit_intent" value="exit_intent" {{_.checked(appear_after, "exit_intent" )}} >
					<?php _e("Exit Intent", Opt_In::TEXT_DOMAIN) ?>
				</label>
			</li>
			<li class="<# if( appear_after === 'adblock' ){ #>current<# } #>">
				<label href="#wpoi-triggers-{{type}}-adblock" for="wpoi-{{type}}-appear_after_adblock">
					<input type="radio" name="wpoi-{{type}}-appear_after" class="wpoi-display-trigger-radio" data-attribute="{{type}}.appear_after" id="wpoi-{{type}}-appear_after_adblock" value="adblock" {{_.checked(appear_after, "adblock" )}} >
					<?php _e("AdBlock Use", Opt_In::TEXT_DOMAIN) ?>
				</label>
			</li>

		</ul>
		<div class="tabs-body">

			<!-- Time -->
			<div id="wpoi-triggers-{{type}}-time" class="tabs-content<# if( appear_after === 'time' ){ #> current<# } #>">
				<div class="wph-label--radio">
					<label for="wpoi-{{type}}-trigger_on_time_immediately"><?php _e("Trigger immediately", Opt_In::TEXT_DOMAIN); ?></label>
					<div class="wph-input--radio">
						<input type="radio" id="wpoi-{{type}}-trigger_on_time_immediately" value="immediately" name="wpoi-{{type}}-trigger_on_time" data-attribute="{{type}}.trigger_on_time" {{_.checked(trigger_on_time, "immediately" )}}>
						<label class="wph-icon i-check" for="wpoi-{{type}}-trigger_on_time_immediately"></label>
					</div>
				</div>

				<div class="wph-label--mix">
					<label for="wpoi-{{type}}-trigger_on_time_time"><?php _e("Trigger after", Opt_In::TEXT_DOMAIN); ?></label>
					<div class="wph-input--radio">
						<input type="radio" id="wpoi-{{type}}-trigger_on_time_time" value="time" name="wpoi-{{type}}-trigger_on_time" data-attribute="{{type}}.trigger_on_time" {{_.checked(trigger_on_time, "time" )}}>
						<label class="wph-icon i-check" for="wpoi-{{type}}-trigger_on_time_time"></label>
					</div>
					<div class="wph-input--number">
						<input min="0" type="number" name="" value="{{appear_after_time_val}}"  data-attribute="{{type}}.appear_after_time_val">
					</div>
					<select data-attribute="{{type}}.appear_after_time_unit" class="wpmuiSelect">
						<option {{_.selected(appear_after_time_unit, "seconds")}} value="seconds"><?php _e("Seconds", Opt_In::TEXT_DOMAIN); ?></option>
						<option {{_.selected(appear_after_time_unit, "minutes")}} value="minutes"><?php _e("Minutes", Opt_In::TEXT_DOMAIN) ?></option>
						<option {{_.selected(appear_after_time_unit, "hours")}}  value="hours"><?php _e("Hours", Opt_In::TEXT_DOMAIN); ?></option>
					</select>
				</div>

			</div>

			<!-- Scroll -->
			<div id="wpoi-triggers-{{type}}-scroll" class="tabs-content<# if( appear_after === 'scrolled' ){ #> current<# } #>">
				<div class="wph-label--mix">
					<label for="wpoi-{{type}}-appear-scrolled"><?php _e("Trigger after", Opt_In::TEXT_DOMAIN); ?></label>
					<div class="wph-input--radio">
						<input type="radio" id="wpoi-{{type}}-appear-scrolled" value="scrolled" name="wpoi-{{type}}-appear" data-attribute="{{type}}.appear_after_scroll" {{_.checked(appear_after_scroll, "scrolled")}}>
						<label class="wph-icon i-check" for="wpoi-{{type}}-appear-scrolled"></label>
					</div>
					<div class="wph-input--number">
						<input min="0" type="number" max="100" name="" value="{{appear_after_page_portion_val}}"  data-attribute="{{type}}.appear_after_page_portion_val">
					</div>
					<label for="wpoi-{{type}}-appear-scrolled"><?php _e("% of the page has been scrolled", Opt_In::TEXT_DOMAIN); ?></label>
				</div>
				<div class="wph-label--radio">
					<label for="wpoi-{{type}}-appear-selector"><?php _e("Appear after user scrolled past a CSS selector", Opt_In::TEXT_DOMAIN); ?></label>
					<div class="wph-input--radio">
						<input type="radio" id="wpoi-{{type}}-appear-selector" name="wpoi-{{type}}-appear" value="selector" data-attribute="{{type}}.appear_after_scroll" {{_.checked(appear_after_scroll, "selector")}}>
						<label class="wph-icon i-check" for="wpoi-{{type}}-appear-selector"></label>
					</div>
				</div>
				<input type="text" value="{{appear_after_element_val}}" data-attribute="{{type}}.appear_after_element_val">
			</div>

			<!-- Click -->
			<div id="wpoi-triggers-{{type}}-click" class="tabs-content<# if( appear_after === 'click' ){ #> current<# } #>">
				<label><?php _e("Use shortcode to render clickable button"); ?></label>
				<div class="wph-shortcode">[wd_hustle id={{shortcode_id}} type={{type}}]<?php _e("Click here", Opt_In::TEXT_DOMAIN) ?>[/wd_hustle]</div>
				<label for="wpoi-{{type}}-click-selector"><?php _e("Trigger after user clicks on existing element with this ID or Class", Opt_In::TEXT_DOMAIN); ?></label>
				<input type="text" id="wpoi-{{type}}-click-selector" value="{{trigger_on_element_click}}" data-attribute="{{type}}.trigger_on_element_click" placeholder="<?php esc_attr_e('only use .class or #ID selector', Opt_In::TEXT_DOMAIN); ?>">
			</div>

			<!-- Exit -->
			<div id="wpoi-triggers-{{type}}-exit_intent" class="tabs-content<# if( appear_after === 'exit_intent' ){ #> current<# } #>">
				<div class="wph-label--toggle">
					<label for="wpoi-{{type}}-trigger-exit"><?php _e("Trigger when exit intent is detected", Opt_In::TEXT_DOMAIN); ?></label>
					<span class="toggle">
						<input id="wpoi-{{type}}-trigger-exit" class="toggle-checkbox" type="checkbox" data-attribute="{{type}}.trigger_on_exit"  {{_.checked(trigger_on_exit, true)}}  >
						<label class="toggle-label" for="wpoi-{{type}}-trigger-exit"></label>
					</span>
				</div>

				<div class="wph-label--toggle">
					<label for="wpoi-{{type}}-trigger-exit-once"><?php _e("Trigger once per session only", Opt_In::TEXT_DOMAIN); ?></label>
					<span class="toggle">
						<input id="wpoi-{{type}}-trigger-exit-once" class="toggle-checkbox" type="checkbox" data-attribute="{{type}}.on_exit_trigger_once_per_session"  {{_.checked(on_exit_trigger_once_per_session, true)}}  >
						<label class="toggle-label" for="wpoi-{{type}}-trigger-exit-once"></label>
					</span>
				</div>
			</div>

			<!-- AdBlock -->
			<div id="wpoi-triggers-{{type}}-adblock" class="tabs-content<# if( appear_after === 'adblock' ){ #> adblock<# } #>">
				<div class="wph-label--toggle">
					<label for="wpoi-{{type}}-trigger-on-adblock"><?php _e("Trigger when AdBlock is detected", Opt_In::TEXT_DOMAIN); ?></label>
					<span class="toggle">
						<input id="wpoi-{{type}}-trigger-on-adblock" class="toggle-checkbox" type="checkbox" data-attribute="{{type}}.trigger_on_adblock"  {{_.checked(trigger_on_adblock, true)}}  >
						<label class="toggle-label" for="wpoi-{{type}}-trigger-on-adblock"></label>
					</span>
				</div>

				<div class="wpoi-popup-trigger-on-adblock-option wph-label--radio">
					<label for="wpoi-{{type}}-trigger-on-adblock-immediately"><?php _e("Trigger immediately", Opt_In::TEXT_DOMAIN); ?></label>
					<div class="wph-input--radio">
						<input type="radio" id="wpoi-{{type}}-trigger-on-adblock-immediately" value="false" name="wpoi-{{type}}-trigger-on-adblock-timed" data-attribute="{{type}}.trigger_on_adblock_timed" {{_.checked(trigger_on_adblock_timed, false )}}>
						<label for="wpoi-{{type}}-trigger-on-adblock-immediately" class="wph-icon i-check"></label>
					</div>
				</div>

				<div class="wpoi-popup-trigger-on-adblock-option wph-label--mix">
					<label for="wpoi-{{type}}-trigger-on-adblock-timed"><?php _e("Trigger after", Opt_In::TEXT_DOMAIN); ?></label>
					<div class="wph-input--radio">
						<input type="radio" id="wpoi-{{type}}-trigger-on-adblock-timed" value="true" name="wpoi-{{type}}-trigger-on-adblock-timed" data-attribute="{{type}}.trigger_on_adblock_timed" {{_.checked(trigger_on_adblock_timed, true )}}>
						<label class="wph-icon i-check" for="wpoi-{{type}}-trigger-on-adblock-timed"></label>
					</div>
					<div class="wph-input--number">
						<input min="0" type="number" name="" class="wpoi_trigger_on_adblock_timed_val" value="{{trigger_on_adblock_timed_val}}"  data-attribute="{{type}}.trigger_on_adblock_timed_val">
					</div>
					<select data-attribute="{{type}}.trigger_on_adblock_timed_unit" class="wpoi_trigger_on_adblock_timed_unit wpmuiSelect">
						<option {{_.selected(trigger_on_adblock_timed_unit, "seconds")}} value="seconds"><?php _e("Seconds", Opt_In::TEXT_DOMAIN); ?></option>
						<option {{_.selected(trigger_on_adblock_timed_unit, "minutes")}} value="minutes"><?php _e("Minutes", Opt_In::TEXT_DOMAIN) ?></option>
						<option {{_.selected(trigger_on_adblock_timed_unit, "hours")}}  value="hours"><?php _e("Hours", Opt_In::TEXT_DOMAIN); ?></option>
					</select>
				</div>
			</div>
		</div>
	</section>
</script>