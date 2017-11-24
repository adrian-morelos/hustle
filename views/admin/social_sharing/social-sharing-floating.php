<script id="wpoi-social-sharing-floating-tpl" type="text/template">

	<div class="switch-head">

		<span class="toggle">
			
			<input id="toggle-cc-{{type}}" class="toggle-checkbox" type="checkbox" data-attribute="enabled"  {{_.checked(_.isTrue(enabled), true)}}>
			
			<label class="toggle-label" for="toggle-cc-{{type}}"></label>
			
		</span>
		
		<label>
			
			<span><?php _e('Enable {{type_name}}', Opt_In::TEXT_DOMAIN); ?></span>
			
			<span id="wph-floating-social-condition-labels">{{{condition_labels}}}</span>
	
		</label>
		
	</div>

	<div class="switch-wrap{{_.class(enabled, ' open', ' closed')}}">
		
		<div class="switch-content">
			
			<div id="wph-social-sharing--floating-social_conditions" class="wph-flex--box wph-flex--border wph-social-sharing--conditions">

				<h4><?php _e('{{type_name}} Display Conditions', Opt_In::TEXT_DOMAIN); ?></h4>
				
				<p><?php _e('By default, your new {{type_name}} will be shown on <strong>every post & page</strong>. Click ( + ) below to set-up more specific conditions.
	You can set up rules for Categories & Tags, or be even more specific & manually choose posts & pages.', Opt_In::TEXT_DOMAIN); ?></p>
				
				<div class="wph-conditions"></div>

			</div><!-- #wph-social-sharing--floating-social_conditions -->
			
			<div id="wph-sshare--screen_location">
				
				<h4><?php _e('Screen Location', Opt_In::TEXT_DOMAIN); ?></h4>
				
				<p><?php _e("Position Floating Social in respect to", Opt_In::TEXT_DOMAIN); ?></p>
				
				<section id="social-sharing-position">
					
                    <div class="tabs">
                    
						<ul class="tabs-header wph-sshare--pick_location_type">
							
							<li {{_.add_class(location_type === "content", "current" )}}>
								
								<label for="wph-sshare--screen_content">
									
									<?php _e('Content Text', Opt_In::TEXT_DOMAIN); ?>
									
									<input type="radio" name="" id="wph-sshare--screen_content" data-attribute="location_type" value="content" {{_.checked(location_type, "content")}}>
									
								</label>
								
							</li>
							
                            <li {{_.add_class(location_type === "screen", "current" )}}>
								
								<label for="wph-sshare--screen_screen">
									
									<?php _e('Screen', Opt_In::TEXT_DOMAIN); ?>
									
									<input type="radio" name="" id="wph-sshare--screen_screen" data-attribute="location_type" value="screen" {{_.checked(location_type, "screen")}}>
									
								</label>
								
							</li>
							
                            <li {{_.add_class(location_type === "selector", "current" )}}>
								
								<label for="wph-sshare--screen_selector">
									
									<?php _e('CSS Selector', Opt_In::TEXT_DOMAIN); ?>
									
									<input type="radio" name="" id="wph-sshare--screen_selector" data-attribute="location_type" value="selector" {{_.checked(location_type, "selector")}}>
									
								</label>
								
							</li>
							
						</ul>
                        
                    </div>
                        
                    <div class="row wph-sshare--selector {{ ( location_type != 'selector' ) ? 'hidden' : '' }}">
                        
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            
                            <label><?php _e('CSS Selector (Class or ID only)', Opt_In::TEXT_DOMAIN); ?></label>
                            
                            <input type="text" id="" value="{{location_target}}" data-attribute="location_target" placeholder="<?php _e('please include . or # characters to identify your selector', Opt_In::TEXT_DOMAIN); ?>">
                            
                        </div>
                        
                    </div>
                        
                    <div class="row row-inner">
                        
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            
                            <div class="tabs">
        
                                <ul class="tabs-header wph-sshare--select_location_align_x">
                                    
                                    <li {{_.add_class(location_align_x === "left", "current" )}}>
                                        
                                        <label for="wph-sshare--location_align_x">
                                            
                                            <?php _e('Left', Opt_In::TEXT_DOMAIN); ?>
                                            
                                            <input type="radio" name="" id="wph-sshare--location_align_x" data-attribute="location_align_x" value="left" {{_.checked(location_align_x, "left")}}>
                                            
                                        </label>
                                        
                                    </li>
                                    
                                    <li {{_.add_class(location_align_x === "right", "current" )}}>
                                        
                                        <label for="wph-sshare--location_align_x">
                                            
                                            <?php _e('Right', Opt_In::TEXT_DOMAIN); ?>
                                            
                                            <input type="radio" name="" id="wph-sshare--location_align_x" data-attribute="location_align_x" value="right" {{_.checked(location_align_x, "right")}}>
                                            
                                        </label>
                                        
                                    </li>
                                    
                                </ul>
                                
                            </div>
                            
                            <div class="wph-sshare--offset_left {{ ( location_align_x != 'left' ) ? 'hidden' : '' }}">
                                    
                                <label><?php _e('Left offset (px)', Opt_In::TEXT_DOMAIN); ?></label>
                                
                                <div class="wph-input--number">
                                
                                    <input type="number" value="{{location_left}}" name="location_left" data-attribute="location_left" >
                                    
                                </div>
                                
                            </div>
                            
                            <div class="wph-sshare--offset_right {{ ( location_align_x != 'right' ) ? 'hidden' : '' }}">
                                    
                                <label><?php _e('Right offset (px)', Opt_In::TEXT_DOMAIN); ?></label>
                                
                                <div class="wph-input--number">
                                
                                    <input type="number" value="{{location_right}}" name="location_right" data-attribute="location_right" >
                                    
                                </div>
                                
                            </div>
                            
                        </div>
                        
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            
                            <div class="tabs">
        
                                <ul class="tabs-header wph-sshare--select_location_align_y">
                                    
                                    <li {{_.add_class(location_align_y === "top", "current" )}}>
                                        
                                        <label for="wph-sshare--location_align_y">
                                            
                                            <?php _e('Top', Opt_In::TEXT_DOMAIN); ?>
                                            
                                            <input type="radio" name="" id="wph-sshare--location_align_y" data-attribute="location_align_y" value="top" {{_.checked(location_align_y, "top")}}>
                                            
                                        </label>
                                        
                                    </li>
                                    
                                    <li {{_.add_class(location_align_y === "bottom", "current" )}}>
                                        
                                        <label for="wph-sshare--location_align_y">
                                            
                                            <?php _e('Bottom', Opt_In::TEXT_DOMAIN); ?>
                                            
                                            <input type="radio" name="" id="wph-sshare--location_align_y" data-attribute="location_align_y" value="bottom" {{_.checked(location_align_y, "bottom")}}>
                                            
                                        </label>
                                        
                                    </li>
                                    
                                </ul>
                                
                            </div>
                            
                            <div class="wph-sshare--offset_top {{ ( location_align_y != 'top' ) ? 'hidden' : '' }}">
                                    
                                <label><?php _e('Top offset (px)', Opt_In::TEXT_DOMAIN); ?></label>
                                
                                <div class="wph-input--number">
                                
                                    <input type="number" value="{{location_top}}" name="location_top" data-attribute="location_top" >
                                    
                                </div>
                                
                            </div>
                            
                            <div class="wph-sshare--offset_bottom {{ ( location_align_y != 'bottom' ) ? 'hidden' : '' }}">
                                    
                                <label><?php _e('Bottom offset (px)', Opt_In::TEXT_DOMAIN); ?></label>
                                
                                <div class="wph-input--number">
                                
                                    <input type="number" value="{{location_bottom}}" name="location_bottom" data-attribute="location_bottom" >
                                    
                                </div>
                                
                            </div>
                            
                        </div>
                        
                    </div>
					
				</section>
				
			</div><!-- #wph-sshare--screen_location -->
			
		</div>
		
	</div>
	
</script>