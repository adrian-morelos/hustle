<script id="wpoi-wizard-design_shapes_template" type="text/template">

    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">

        <h5><?php _e('Shapes, borders, icons', Opt_In::TEXT_DOMAIN); ?></h5>

    </div>

    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">

        <label class="wph-label--border"><?php _e('Pick form field style to further customize their appearance', Opt_In::TEXT_DOMAIN); ?></label>

        <div class="tabs">
			
			<ul class="tabs-header">
				
				<li {{_.add_class(borders.fields_style == "separated", "current")}}>
					
					<label for="optin_fields_style_separated">
						
						<?php _e( "Separated", Opt_In::TEXT_DOMAIN ); ?>
						
						<input type="radio" id="optin_fields_style_separated" name="optin_fields_style" data-attribute="borders.fields_style" value="separated"  {{_.checked(borders.fields_style, "separated")}}  >
						
					</label>
					
				</li>
				
				<li {{_.add_class(borders.fields_style == "joined", "current")}} >
					
					<label for="optin_fields_style_joined">
						
						<?php _e( "Joined", Opt_In::TEXT_DOMAIN ); ?>
						
						<input type="radio" id="optin_fields_style_joined" name="optin_fields_style" data-attribute="borders.fields_style" value="joined" {{_.checked(borders.fields_style, "joined")}}   >
						
					</label>
					
				</li>
				
			</ul>
			
		</div>

        <div id="wph-shapes--edit">
	        
	        <h4><?php _e('Rounded Corners', Opt_In::TEXT_DOMAIN); ?></h4>

            <div class="row">

                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
	                
	                <label class="wph-label--alt"><?php _e( "Optin Box:", Opt_In::TEXT_DOMAIN ); ?></label>
	                
	                <div class="wph-label--number">
		                
		                <label class="wph-label--alt"><?php _e('px', Opt_In::TEXT_DOMAIN); ?></label>
		                
		                <div class="wph-input--number">

                            <input min="0" type="number" data-attribute="borders.corners_radius" name="optin_rounded_corners_radious" value="{{borders.corners_radius}}"  id="optin_rounded_corners_radious"/>

                        </div>
                        
                    </div>
                    
                </div>
                
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 {{wph_disabled}}">
	                
	                <label class="wph-label--alt"><?php _e( "Fields:", Opt_In::TEXT_DOMAIN ); ?></label>
	                
	                <div class="wph-label--number">
		                
		                <label class="wph-label--alt"><?php _e('px', Opt_In::TEXT_DOMAIN); ?></label>
		                
		                <div class="wph-input--number">
			                
			                <input {{_.disabled(borders.fields_style, "joined")}} min="0" type="number" data-attribute="borders.fields_corners_radius" name="fields_rounded_corners_radious" value="{{borders.fields_corners_radius}}"  id="fields_rounded_corners_radious"/>
			                
			            </div>
			            
			        </div>
			        
			    </div>
			    
			    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 {{wph_disabled}}">
				    
				    <label class="wph-label--alt"><?php _e( "Button:", Opt_In::TEXT_DOMAIN ); ?></label>
				    
				    <div class="wph-label--number">
					    
					    <label class="wph-label--alt"><?php _e('px', Opt_In::TEXT_DOMAIN); ?></label>
					    
					    <div class="wph-input--number">
						    
						    <input {{_.disabled(borders.fields_style, "joined")}} min="0" type="number" name="button_rounded_corners_radious" data-attribute="borders.button_corners_radius" value="{{borders.button_corners_radius}}"  id="button_rounded_corners_radious"/>
						    
						</div>
						
					</div>
					
				</div>

            </div><!-- Border Radius -->
            
            <h4><?php _e('Drop Shadow', Opt_In::TEXT_DOMAIN); ?></h4>

            <div class="row">

                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
	                
                    <div class="wph-label--number">
	                    
                        <label class="wph-label--alt"><?php _e('px', Opt_In::TEXT_DOMAIN); ?></label>
                        
                        <div class="wph-input--number">
	                        
                            <input min="0" type="number" name="" data-attribute="borders.dropshadow_value" value="{{borders.dropshadow_value}}"  id="optin_dropshadow_value"/>
                            
                        </div>
                        
                    </div>
                    
                </div>
                
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
	                
	                <div class="wph-pickers wph-pickers--single">
		                
                        <div class="wph-pickers--color">
	                        
                            <input type="text" class="optin_color_picker" data-attribute="borders.shadow_color" id="optin_shadow_color" value="{{borders.shadow_color}}" data-alpha="true">
                            
                        </div>
                        
                    </div>
                    
                    <label><?php _e('Color', Opt_In::TEXT_DOMAIN); ?></label>
                    
                </div>

            </div>

        </div>
        
        <label class="wph-label--border"><?php _e('Form field icons', Opt_In::TEXT_DOMAIN); ?></label>
        
        <div class="tabs">
			
			<ul class="wph-triggers--options tabs-header">
				
				<li {{_.add_class(input_icons ==  "no_icon", "current")}} >
					
					<label for="optin_error_icons_input_no_icon">
						
						<?php _e( "No Icons", Opt_In::TEXT_DOMAIN ); ?>
						
						<input type="radio" name="optin_input_icons" id="optin_error_icons_input_no_icon" value="no_icon" data-attribute="input_icons" {{_.checked(input_icons, "no_icon")}} >
						
					</label>
					
				</li><?php // No icons (by default) ?>
				
				<li {{_.add_class(input_icons ==  "none_animated_icon", "current")}} >
					
					<label for="optin_error_icons_input_none_animated_icon">
						
						<?php _e( "Static Icons", Opt_In::TEXT_DOMAIN ); ?>
						
						<input type="radio" name="optin_input_icons" id="optin_error_icons_input_none_animated_icon" value="none_animated_icon" data-attribute="input_icons" {{_.checked(input_icons, "none_animated_icon")}} >
						
					</label>
					
				</li><?php // Static Icons ?>
				
				<li {{_.add_class(input_icons ==  "animated_icon", "current")}} >
					
					<label for="optin_error_icons_input_animated_icon">
						
						<?php _e( "Animated Icons", Opt_In::TEXT_DOMAIN ); ?>
						
						<input type="radio" name="optin_input_icons" id="optin_error_icons_input_animated_icon" value="animated_icon" data-attribute="input_icons" {{_.checked(input_icons, "animated_icon")}} >
						
					</label>
					
				</li><?php // Animated Icons ?>
				
			</ul>
			
		</div><?php // Form field icons ?>
		
    </div>
    
</script>