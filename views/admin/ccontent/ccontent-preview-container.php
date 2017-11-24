<div class="wph-preview wph-preview--closed">
	
	<div class="wph-preview--mask"></div>
	
	<div id="wph-preview-yield"></div><?php // This div will be replaced with the actual modal ?>
	
	<div class="wph-preview--switch">
		
		<div class="wph-flex wph-flex--row">
			
			<div class="wph-flex--side_50 wph-flex--end">
				
				<button class="wph-preview--close wph-button"><i class="wph-icon i-close"></i></button>
				
			</div>
		
			<div class="wph-flex--box">
				
				<p><?php _e('Preview display type', Opt_In::TEXT_DOMAIN); ?></p>
				
				<select id="wph-preview-type-selector" class="wpmuiSelect">
					
                    <option value="popup"><?php _e('Pop-up', Opt_In::TEXT_DOMAIN); ?></option>
					<option value="slide_in"><?php _e('Slide-in', Opt_In::TEXT_DOMAIN); ?></option>
					<option value="after_content"><?php _e('After Content', Opt_In::TEXT_DOMAIN); ?></option>
					
				</select>
				
			</div>
			
		</div>
		
	</div>

</div>