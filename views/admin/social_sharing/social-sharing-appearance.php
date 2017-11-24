
<?php // ICON TEMPLATES for 2,3,4 icon_styles ?>
<script id="wpoi-sshare-facebook-svg" type="text/template">
    <?php $this->render('general/icons/social/wph-facebook'); ?>
</script>
<script id="wpoi-sshare-twitter-svg" type="text/template">
    <?php $this->render('general/icons/social/wph-twitter'); ?>
</script>
<script id="wpoi-sshare-google-svg" type="text/template">
    <?php $this->render('general/icons/social/wph-google'); ?>
</script>
<script id="wpoi-sshare-pinterest-svg" type="text/template">
    <?php $this->render('general/icons/social/wph-pinterest'); ?>
</script>
<script id="wpoi-sshare-reddit-svg" type="text/template">
    <?php $this->render('general/icons/social/wph-reddit'); ?>
</script>
<script id="wpoi-sshare-linkedin-svg" type="text/template">
    <?php $this->render('general/icons/social/wph-linkedin'); ?>
</script>
<script id="wpoi-sshare-vkontakte-svg" type="text/template">
    <?php $this->render('general/icons/social/wph-vkontakte'); ?>
</script>

<?php // ICON TEMPLATES for 1 icon_styles ?>
<script id="wpoi-sshare-facebook-one-svg" type="text/template">
    <?php $this->render('general/icons/social-path/wph-facebook'); ?>
</script>
<script id="wpoi-sshare-twitter-one-svg" type="text/template">
    <?php $this->render('general/icons/social-path/wph-twitter'); ?>
</script>
<script id="wpoi-sshare-google-one-svg" type="text/template">
    <?php $this->render('general/icons/social-path/wph-google'); ?>
</script>
<script id="wpoi-sshare-pinterest-one-svg" type="text/template">
    <?php $this->render('general/icons/social-path/wph-pinterest'); ?>
</script>
<script id="wpoi-sshare-reddit-one-svg" type="text/template">
    <?php $this->render('general/icons/social-path/wph-reddit'); ?>
</script>
<script id="wpoi-sshare-linkedin-one-svg" type="text/template">
    <?php $this->render('general/icons/social-path/wph-linkedin'); ?>
</script>
<script id="wpoi-sshare-vkontakte-one-svg" type="text/template">
    <?php $this->render('general/icons/social-path/wph-vkontakte'); ?>
</script>

<script id="wpoi-social-sharing-appreance-tpl" type="text/template">
	
	<div id="wph-sshare--icons_design" class="row">
			
        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
            
            <h5><?php _e('Icons Design', Opt_In::TEXT_DOMAIN); ?></h5>
            
        </div>
        
        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
            
            <label class="wph-label--border"><?php _e('Choose what kind of design you want for your icons', Opt_In::TEXT_DOMAIN); ?></label>
            
            <label><?php _e('Icons style', Opt_In::TEXT_DOMAIN); ?></label>
            
            <div class="tabs">
	            
	            <ul class="tabs-header wph-share-icon_style">
		            
		            <li {{_.add_class(icon_style === "one", "current" )}}>
		            	
		            	<label for="wph-sshare-icons_design_one">
		            		
		            		<?php $this->render("general/icons/social-path/wph-facebook"); ?>
		            		
		            		<input type="radio" id="wph-sshare-icons_design_one" name="wph-sshare-type_icons_design" data-attribute="icon_style" value="one" {{_.checked(icon_style, "one")}}>
		            		
		            	</label>
		            	
		            </li>
		            
		            <li {{_.add_class(icon_style === "two", "current" )}}>
		            	
		            	<label for="wph-sshare-icons_design_two">
		            		
		            		<?php $this->render("general/icons/social/wph-facebook"); ?>
		            		
		            		<input type="radio" id="wph-sshare-icons_design_two" name="wph-sshare-type_icons_design" data-attribute="icon_style" value="two" {{_.checked(icon_style, "two")}}>
		            		
		            	</label>
		            	
		            </li>
		            
		            <li {{_.add_class(icon_style === "three", "current" )}}>
		            	
		            	<label for="wph-sshare-icons_design_three">
		            		
		            		<?php $this->render("general/icons/social/wph-facebook"); ?>
		            		
		            		<input type="radio" id="wph-sshare-icons_design_three" name="wph-sshare-type_icons_design" data-attribute="icon_style" value="three" {{_.checked(icon_style, "three")}}>
		            		
		            	</label>
		            	
		            </li>
		            
		            <li {{_.add_class(icon_style === "four", "current" )}}>
		            	
		            	<label for="wph-sshare-icons_design_four">
		            		
		            		<?php $this->render("general/icons/social/wph-facebook"); ?>
		            		
		            		<input type="radio" id="wph-sshare-icons_design_four" name="wph-sshare-type_icons_design" data-attribute="icon_style" value="four" {{_.checked(icon_style, "four")}}>
		            		
		            	</label>
		            	
		            </li>
		            
	            </ul>
	            
            </div>
            
            <div id="wph-sshare-icons_reorder">
	            
	            <label><?php _e('Arrange Icons', Opt_In::TEXT_DOMAIN); ?></label>
	            
	            <small><?php _e('Click & Drag to re-order icons', Opt_In::TEXT_DOMAIN); ?></small>
	            
	            <div class="wph-sshare-reorder_box wph-sshare-icons_design_{{icon_style}}">
		            
	            </div>
	            
            </div>
            
        </div>
        
    </div><!-- #wph-sshare--icons_design -->
    
    <div id="wph-sshare--floating_social" class="row">
			
        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
            
            <h5><?php _e('Floating Social', Opt_In::TEXT_DOMAIN); ?></h5>
            
        </div>
        
        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
            
            <div class="row">
	            
	            <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
		            
		            <label class="wph-label--border"><?php _e('BG & Icon Colors', Opt_In::TEXT_DOMAIN); ?></label>
		            
		            <div class="tabs">
			            
			            <ul class="tabs-header wph-share-customize-color">
				            
				            <li {{_.add_class(customize_colors == 0, "current" )}}>
				            	
				            	<label for="">
				            		
				            		<?php _e('Default Colors', Opt_In::TEXT_DOMAIN); ?>
				            		
				            		<input type="radio" id="wph-sshare-default_colors" value="0" name="customize_colors" data-attribute="customize_colors">
				            		
				            	</label>
				            	
				            </li>
				            
				            <li {{_.add_class(customize_colors == 1, "current" )}}>
				            	
				            	<label for="">
				            		
				            		<?php _e('Custom Colors', Opt_In::TEXT_DOMAIN); ?>
				            		
				            		<input type="radio" id="wph-sshare-custom_colors" value="1" name="customize_colors" data-attribute="customize_colors">
				            		
				            	</label>
				            	
				            </li>
				            
			            </ul>
			            
			            <div class="tabs-body">
				            
				            <div class="tabs-content {{ ( customize_colors == 1 ) ? 'current' : '' }}">

								<?php /* WHAT TO DISPLAY
								CHEATSHEET FOR FLOATING SOCIAL CUSTOM COLORS

								NATIVE SHARE:
								ICON STYLE #1: Icon Color + Counter Border
								ICON STYLE #2: Icon Color + Counter Border
								ICON STYLE #3: Icon Color + Icon Background + Counter Border
								ICON STYLE #4: Icon Color + Icon Background + Counter Border

								LINKED ICONS:
								ICON STYLE #1: Icon Color
								ICON STYLE #2: Icon Color + Icon Border
								ICON STYLE #3: Icon Color + Icon Background
								ICON STYLE #4: Icon Color + Icon Background
								*/ ?>
					            
					            <div id="wps-color--custom">
						            
						            <div class="row">

										<# if ( service_type === "native" ) { #>

											<# if ( icon_style === "three" || icon_style === "four" ) { #>

												<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
													
													<div class="wph-pickers wph-pickers--single">
														
														<div class="wph-pickers--color">
															
															<input type="text" class="wph-color-picker" id="sshare_icon_bg" value="{{icon_bg_color}}" data-attribute="icon_bg_color" data-alpha="true">
															
														</div>
														
													</div>
													
													<label><?php _e('Icon BG', Opt_In::TEXT_DOMAIN); ?></label>
													
												</div>

											<# } #>
											
											<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
												
												<div class="wph-pickers wph-pickers--single">
													
													<div class="wph-pickers--color">
														
														<input type="text" class="wph-color-picker" id="sshare_icon_color" value="{{icon_color}}" data-attribute="icon_color" data-alpha="true">
														
													</div>
													
												</div>
												
												<label><?php _e('Icon Color', Opt_In::TEXT_DOMAIN); ?></label>
												
											</div>

											<# if ( icon_style === "one" || icon_style === "two" ){ #>

												<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
													
													<div class="wph-pickers wph-pickers--single">
														
														<div class="wph-pickers--color">
															
															<input type="text" class="wph-color-picker" id="sshare_counter_border" value="{{counter_border}}" data-attribute="counter_border" data-alpha="true">
															
														</div>
														
													</div>
													
													<label><?php _e('Counter Border', Opt_In::TEXT_DOMAIN); ?></label>
													
												</div>

											<# } #>
											
										<# } #>

										<# if ( service_type === "linked" ) { #>

											<# if ( icon_style !== "one" ) { #>

												<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
													
													<div class="wph-pickers wph-pickers--single">
														
														<div class="wph-pickers--color">
															
															<input type="text" class="wph-color-picker" id="sshare_icon_bg" value="{{icon_bg_color}}" data-attribute="icon_bg_color" data-alpha="true">
															
														</div>
														
													</div>
													
													<# if ( icon_style === "two" ) { #>
														
														<label><?php _e('Icon Border', Opt_In::TEXT_DOMAIN); ?></label>

													<# } else { #>

														<label><?php _e('Icon BG', Opt_In::TEXT_DOMAIN); ?></label>

													<# } #>
													
												</div>

											<# } #>

											<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
												
												<div class="wph-pickers wph-pickers--single">
													
													<div class="wph-pickers--color">
														
														<input type="text" class="wph-color-picker" id="sshare_icon_color" value="{{icon_color}}" data-attribute="icon_color" data-alpha="true">
														
													</div>
													
												</div>
												
												<label><?php _e('Icon Color', Opt_In::TEXT_DOMAIN); ?></label>
												
											</div>

										<# } #>
							            
						            </div>

									<# if ( service_type === "native" && ( icon_style === "three" || icon_style === "four" ) ) { #>
										
										<div class="row">
											
											<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
												
												<div class="wph-pickers wph-pickers--single">
													
													<div class="wph-pickers--color">
														
														<input type="text" class="wph-color-picker" id="sshare_counter_border" value="{{counter_border}}" data-attribute="counter_border" data-alpha="true">
														
													</div>
													
												</div>
												
												<label><?php _e('Counter Border', Opt_In::TEXT_DOMAIN); ?></label>
												
											</div>
											
											<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"></div>
											
										</div>

									<# } #>
						            
					            </div>
					            
				            </div>
				            
			            </div>
			            
		            </div>
		            
		            <div id="wph-sshare--container_bg">
			            
			            <div class="row">
				            
				            <div class="col">
					            
					            <div class="wph-pickers wph-pickers--single">
									
									<div class="wph-pickers--color">
										
										<input type="text" class="wph-color-picker" id="sshare_container_bg" value="{{floating_social_bg}}" data-attribute="floating_social_bg" data-alpha="true">
										
									</div>
									
								</div>
								
								<label><?php _e('Floating Social BG', Opt_In::TEXT_DOMAIN); ?></label>
					            
				            </div>
				            
				            <div class="col">
					            
					            <div class="wph-pickers wph-pickers--single">
									
									<div class="wph-pickers--color">
										
										<input type="text" class="wph-color-picker" id="sshare_counter_text" value="{{counter_text}}" data-attribute="counter_text" data-alpha="true">
										
									</div>
									
								</div>
								
								<label><?php _e('Counter Text', Opt_In::TEXT_DOMAIN); ?></label>
					            
				            </div>
				            
			            </div>
			            
		            </div>
		            
		            <div id="wph-sshare--shadow">
			            
			            <div class="wph-label--checkbox">
				            
				            <label for="floating_social_shadow"><?php _e('Drop Shadow', Opt_In::TEXT_DOMAIN); ?></label>
				            
				            <div class="wph-input--checkbox">
					            
					            <input id="floating_social_shadow" type="checkbox" value="{{drop_shadow}}" {{_.checked(drop_shadow, '1')}} data-attribute="drop_shadow">
					            
					            <label for="floating_social_shadow" class="wph-icon i-check"></label>
					            
				            </div>
				            
			            </div>
			            
			            <div id="wph-sshare--shadow_settings" {{_.add_class(drop_shadow == '0', "hidden" )}}>
							
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
											
											<input type="text" class="wph-color-picker" id="sshare_container_bg" value="{{drop_shadow_color}}" data-attribute="drop_shadow_color" data-alpha="true">
											
										</div>
										
									</div>
									
								</div>
								
							</div>
							
						</div>
			            
		            </div>
                    
                    <div id="wph-sshare--floating_inline_count">
                
                        <div class="wph-label--checkbox">
				            
				            <label for="floating_inline_count"><?php _e('Show Count Inline', Opt_In::TEXT_DOMAIN); ?></label>
				            
				            <div class="wph-input--checkbox">
					            
					            <input id="floating_inline_count" type="checkbox" value="{{floating_inline_count}}" {{_.checked(floating_inline_count, '1')}} data-attribute="floating_inline_count">
					            
					            <label for="floating_inline_count" class="wph-icon i-check"></label>
					            
				            </div>
				            
			            </div>
                    
                    </div>
		            
	            </div>
	            
	            <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
		            
		            <label class="wph-label--border"><?php _e('Preview', Opt_In::TEXT_DOMAIN); ?></label>
		            
		            <div class="wph-sshare--preview_box wph-sshare-floating-social--preview_box">
			            
			            <?php $this->render("general/social", array(
                            'admin' => true,
                            'type' => 'column'
                        )); ?>
			            
		            </div>
		            
	            </div>
	            
            </div>
            
        </div>
        
    </div><!-- #wph-sshare--floating_social -->
    
    <div id="wph-sshare--widget_shortcode" class="row">
			
        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
            
            <h5><?php _e('Widget / Shortcode', Opt_In::TEXT_DOMAIN); ?></h5>
            
        </div>
        
        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
	        
	        <div class="wph-sshare--preview_group">
		        
		        <label class="wph-label--border"><?php _e('Preview', Opt_In::TEXT_DOMAIN); ?></label>
		        
		        <div class="wph-sshare--preview_box wph-sshare-widget--preview_box">
			        
			        <?php $this->render("general/social", array(
                        'admin' => true,
                        'type' => 'row'
                    )); ?>
			        
		        </div>
		        
	        </div>
	        
	        <label class="wph-label--border"><?php _e('BG & Icon Colors', Opt_In::TEXT_DOMAIN); ?></label>
	        
	        <div class="tabs">
			    
			    <ul class="tabs-header wph-share-widget-customize-color">
				    
				    <li {{_.add_class(customize_widget_colors == 0, "current" )}}>
				        
				        <label for="">
				            
				            <?php _e('Default Colors', Opt_In::TEXT_DOMAIN); ?>
				            
							<input type="radio" id="wph-sshare-default_colors" value="0" name="customize_widget_colors" data-attribute="customize_widget_colors">
				            
				        </label>
				        
				    </li>
				    
				    <li {{_.add_class(customize_widget_colors == 1, "current" )}}>
				        
				        <label for="">
				            
				            <?php _e('Custom Colors', Opt_In::TEXT_DOMAIN); ?>
				            
				            <input type="radio" id="wph-sshare-custom_colors" value="1" name="customize_widget_colors" data-attribute="customize_widget_colors">
				            
				        </label>
				        
				    </li>
				    
			    </ul>
			    
			    <div class="tabs-body">
				    
				    <div class="tabs-content {{ ( customize_widget_colors == 1 ) ? 'current' : '' }}">
					    
					    <div id="wps-sshare--widget_custom_colors">
						    
						    <div class="row">
							    
							    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
								    
								    <div class="wph-pickers wph-pickers--single">
										
										<div class="wph-pickers--color">
											
											<input type="text" class="wph-color-picker" id="sshare_icon_bg" value="{{widget_icon_bg_color}}" data-attribute="widget_icon_bg_color" data-alpha="true">
											
										</div>
										
									</div>
									
									<label><?php _e('Icon BG', Opt_In::TEXT_DOMAIN); ?></label>
								    
							    </div>
							    
							    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
									
								    <div class="wph-pickers wph-pickers--single">
										
										<div class="wph-pickers--color">
											
											<input type="text" class="wph-color-picker" id="sshare_icon_color" value="{{widget_icon_color}}" data-attribute="widget_icon_color" data-alpha="true">
											
										</div>
										
									</div>
									
									<label><?php _e('Icon Color', Opt_In::TEXT_DOMAIN); ?></label>
								    
							    </div>
							    
						    </div>
						    
					    </div>
					    
				    </div>
				    
			    </div>
			    
		    </div>
		    
		    <div id="wph-sshare--widget_container_bg">
			    
			    <div class="row">
			    
				    <div class="col">
					    
					    <div class="wph-pickers wph-pickers--single">
							
							<div class="wph-pickers--color">
								
								<input type="text" class="wph-color-picker" id="sshare_container_bg" value="{{widget_bg_color}}" data-attribute="widget_bg_color" data-alpha="true">
								
							</div>
							
						</div>
						
						<label><?php _e('Widget BG', Opt_In::TEXT_DOMAIN); ?></label>
						
				    </div>
				    
				    <div class="col">
					    
					    <div class="wph-pickers wph-pickers--single">
							
							<div class="wph-pickers--color">
								
								<input type="text" class="wph-color-picker" id="sshare_widget_counter_text" value="{{widget_counter_text}}" data-attribute="widget_counter_text" data-alpha="true">
								
							</div>
							
						</div>
						
						<label><?php _e('Counter Text', Opt_In::TEXT_DOMAIN); ?></label>
					    
				    </div>
				    
			    </div>
			    
		    </div>
		    
		    <div id="wph-sshare--widget_shadow">
			    
			    <div class="wph-label--checkbox">
				    
				    <label for="widget_social_shadow"><?php _e('Drop Shadow', Opt_In::TEXT_DOMAIN); ?></label>
				    
					<div class="wph-input--checkbox">
					    
                        <input id="widget_social_shadow" type="checkbox" value="{{widget_drop_shadow}}" {{_.checked(widget_drop_shadow, '1')}} data-attribute="widget_drop_shadow">
					    
					    <label for="widget_social_shadow" class="wph-icon i-check"></label>
					    
				    </div>
				    
			    </div>
			    
			    <div {{widget_drop_shadow}} id="wph-sshare--widget_shadow_settings" {{_.add_class(widget_drop_shadow == '0', "hidden" )}}>
					
					<div class="row">
						
						<div class="col-eq">
							
							<label class="wph-label--alt"><?php _e('X-offset', Opt_In::TEXT_DOMAIN); ?></label>
							
							<div class="wph-input--number">
								
								<input type="number" min="0" max="500" step="1" value="{{widget_drop_shadow_x}}" data-attribute="widget_drop_shadow_x">
								
							</div>
							
						</div>
						
						<div class="col-eq">
							
							<label class="wph-label--alt"><?php _e('Y-offset', Opt_In::TEXT_DOMAIN); ?></label>
							
							<div class="wph-input--number">
								
								<input type="number" min="0" max="500" step="1" value="{{widget_drop_shadow_y}}" data-attribute="widget_drop_shadow_y">
								
							</div>
							
						</div>
						
						<div class="col-eq">
							
							<label class="wph-label--alt"><?php _e('Blur', Opt_In::TEXT_DOMAIN); ?></label>
							
							<div class="wph-input--number">
								
								<input type="number" min="0" max="500" step="1" value="{{widget_drop_shadow_blur}}" data-attribute="widget_drop_shadow_blur">
								
							</div>
									
						</div>
						
						<div class="col-eq">
							
							<label class="wph-label--alt"><?php _e('Spread', Opt_In::TEXT_DOMAIN); ?></label>
							
							<div class="wph-input--number">
								
								<input type="number" min="0" max="500" step="1" value="{{widget_drop_shadow_spread}}" data-attribute="widget_drop_shadow_spread">
								
							</div>
							
						</div>
						
						<div class="col-eq">
							
							<label class="wph-label--alt"><?php _e('Color', Opt_In::TEXT_DOMAIN); ?></label>
							
							<div class="wph-pickers wph-pickers--single">
								
								<div class="wph-pickers--color">
									
									<input type="text" class="wph-color-picker" id="sshare_container_bg" value="{{widget_drop_shadow_color}}" data-attribute="widget_drop_shadow_color" data-alpha="true">
									
								</div>
								
							</div>
							
						</div>
						
					</div>
					
				</div>
			    
		    </div>
            
            <div id="wph-sshare--widget_inline_count">
                
                <div class="wph-label--checkbox">
                    
                    <label for="widget_inline_count"><?php _e('Show Count Inline', Opt_In::TEXT_DOMAIN); ?></label>
                    
                    <div class="wph-input--checkbox">
                        
                        <input id="widget_inline_count" type="checkbox" value="{{widget_inline_count}}" {{_.checked(widget_inline_count, '1')}} data-attribute="widget_inline_count">
                        
                        <label for="widget_inline_count" class="wph-icon i-check"></label>
                        
                    </div>
                    
                </div>
            
            </div>
	        
        </div>
        
    </div><!-- #wph-sshare--widget_shortcode -->
	
</script>


<div id="wph-social-sharing--appearance_tab" class="wph-toggletabs <?php echo ( isset( $_GET['tab'] ) && $_GET['tab'] == 'appearance' ) ?  'wph-toggletabs--open' : ''; ?>">
	
	<header class="wph-toggletabs--title can-open">
		
		<h4><?php _e('Appearance', Opt_In::TEXT_DOMAIN); ?></h4>
		
		<span class="open"><i class="wph-icon i-arrow"></i></span>
		
	</header>
	
	<section class="wph-toggletabs--content">

	</section>
	
	<footer class="wph-toggletabs--footer">
		
		<div class="row">
			
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				
				<button class="wph-button ss-back wph-button--filled wph-button--gray "><?php _e('Back', Opt_In::TEXT_DOMAIN); ?></button>
				
			</div>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				
				<button data-id="<?php echo isset(  $_GET['id'] ) ? $_GET['id']: '-1'; ?>" data-nonce="<?php echo wp_create_nonce('hustle_social_sharing_save'); ?>" class="wph-button ss-save-changes wph-button-save wph-button--filled wph-button--blue" >
					
					<span class="off-action"><?php _e('Save Changes', Opt_In::TEXT_DOMAIN); ?></span>
					
					<span class="on-action"><?php _e('Saving...', Opt_In::TEXT_DOMAIN); ?></span>
					
				</button>
				
				<button data-id="<?php echo isset(  $_GET['id'] ) ? $_GET['id']: '-1'; ?>" data-nonce="<?php echo wp_create_nonce('hustle_social_sharing_save'); ?>" class="wph-button ss-next-step wph-button--filled wph-button--gray" >
					
					<span class="off-action"><?php _e('Next Step', Opt_In::TEXT_DOMAIN); ?></span>
					
					<span class="on-action"><?php _e('Saving...', Opt_In::TEXT_DOMAIN); ?></span>
					
				</button>
				
			</div>
			
		</div>
		
	</footer>
	
</div><!-- #wph-social-sharing--appearance_tab -->

<?php $this->render("admin/common/media-holder"); ?>

