<script id="wpoi-wizard-design_structure_template" type="text/template">
	
	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
		
		<h5><?php _e('Structure', Opt_In::TEXT_DOMAIN); ?></h5>
		
	</div>
	
	<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">

        <label class="wph-label--border"><?php _e('Select form layout that is most suited for your opt-in', Opt_In::TEXT_DOMAIN); ?></label>

        <div id="optin_form_location">

            <div class="wpoi-form-design-wrap">

                <div class="wpoi-form-design">

                    <label for="wpoi-form_location_one" class="wpoi-form-design-one"></label>

                    <div class="wph-input--radio">

                        <input type="radio" id="wpoi-form_location_one" name="location" value="0" data-attribute="form_location" {{_.checked(form_location, "0")}}>

                        <label for="wpoi-form_location_one" class="wph-icon i-check"></label>

                    </div>

                </div>

                <div class="wpoi-form-design">

                    <label for="wpoi-form_location_two" class="wpoi-form-design-two"></label>

                    <div class="wph-input--radio">

                        <input type="radio" id="wpoi-form_location_two" name="location" value="1" {{_.checked(form_location, "1")}} data-attribute="form_location" >

                        <label for="wpoi-form_location_two" class="wph-icon i-check"></label>

                    </div>

                </div>

                <div class="wpoi-form-design">

                    <label for="wpoi-form_location_three" class="wpoi-form-design-three"></label>

                    <div class="wph-input--radio">

                        <input type="radio" id="wpoi-form_location_three" name="location" value="2" {{_.checked(form_location, "2")}} data-attribute="form_location" >

                        <label for="wpoi-form_location_three" class="wph-icon i-check"></label>

                    </div>

                </div>

                <div class="wpoi-form-design">

                    <label for="wpoi-form_location_four" class="wpoi-form-design-four"></label>

                    <div class="wph-input--radio">

                        <input type="radio" id="wpoi-form_location_four" name="location" value="3" {{_.checked(form_location, "3")}} data-attribute="form_location" >

                        <label for="wpoi-form_location_four" class="wph-icon i-check"></label>

                    </div>

                </div>

            </div>

        </div><!-- Optin Form Location -->

        <label class="wph-label--border"><?php _e('Choose image location', Opt_In::TEXT_DOMAIN); ?></label>

        <div id="optin_image_location">

            <div class="tabs">
	            
                <ul class="tabs-header">
	                
                    <li {{_.add_class(image_location ==  "left", "current")  }}>
                    
                        <label for="optin-image-location-left">

                            <?php _e( "Left", Opt_In::TEXT_DOMAIN ); ?>

                            <input type="radio" id="optin-image-location-left" name="optin-image-location" data-attribute="image_location" value="left" {{_.checked(image_location, "left")}}>

                        </label>
                        
                    </li>

                    <li {{_.add_class(image_location ==  "right", "current")  }}>

                        <label for="optin-image-location-right">

                            <?php _e( "Right", Opt_In::TEXT_DOMAIN ); ?>

                            <input type="radio" id="optin-image-location-right" name="optin-image-location" value="right"  data-attribute="image_location"  {{_.checked(image_location, "right")}}>

                        </label>

                    </li>

                    <# if( form_location == 0 ){ #>

                        <li {{_.add_class(image_location ==  "above", "current")  }}>

                            <label for="optin-image-location-above">

                                <?php _e( "Above content", Opt_In::TEXT_DOMAIN ); ?>

                                <input type="radio" id="optin-image-location-above" name="optin-image-location" data-attribute="image_location" value="above" {{_.checked(image_location, "above")}} >

                            </label>

                        </li>

                    <# } #>
                    
                    <# if( form_location == 0 ){ #>
                    	
                    	<li {{_.add_class(image_location ==  "below", "current")  }}>
                    		
                    		<label for="optin-image-location-bellow">
                    			
                    			<?php _e( "Below content", Opt_In::TEXT_DOMAIN ); ?>
                    				
                    			<input class="<# if( form_location == 1 || form_location == 2 || form_location == 3){ #>wpoi-hidden<# } #>" type="radio" name="optin-image-location" data-attribute="image_location" id="optin-image-location-bellow" value="below" {{_.checked(image_location, "below")}}>
                    			
                    		</label>
                    		
                    	</li>
                    	
                    <# } #>
                    
                </ul>
                
            </div>

        </div><!-- Optin Image Location -->
    </div>

</script>