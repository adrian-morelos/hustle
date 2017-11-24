<script id="optin-mailchimp-args" type="text/template">

	<div class="wpoi-container wpoi-col">
	
		<div class="wpoi-element" style="margin-bottom: 0; margin-right: 0;">
			
			<# if( typeof group !== "undefined" ){ #>
				
				<# if(group.type !== "hidden"){ #>
					
					<label class="wpoi-mcg-list-name">{{group.title}}</label>
					
				<# } #>
				
				<input type="hidden" name="inc_optin_mailchimp_group_id" class="inc_optin_mailchimp_group_id" value="{{group.id}}">
				
			<# } #>
			
		</div>
		
		<div class="wpoi-element">
			
			<div class="wpoi-container">
				
				<div class="wpoi-element">
					
					<# if( typeof group !== "undefined" && group.type !== "hidden" ){ #>
						
						<# if(group.type === "dropdown"){ #>
							<div class="wpoi-mcg-options wpoi-mcg-select">
								
								<select name="inc_optin_mailchimp_group_interest" class="inc_optin_mailchimp_group_interest">
									<option value="0"><?php _e("Please select an interest", Opt_In::TEXT_DOMAIN); ?></option>
									<# _.each(group.interests, function(interest, id){ #>
										<option value="{{interest.value}}" {{_.selected( group.selected && group.selected.indexOf( interest.value .toString()  ) !== -1 , true )}}>{{interest.label}}</option>
									<# }); #>
									
								</select>
								
							</div>
						<# } #>
						
						<# if(group.type === "checkboxes"){ #>
							
							<div class="wpoi-mcg-options">
								
								<# _.each(group.interests, function(interest, id){ var unique = _.uniqueId(interest.value); #>
									<div class="wpoi-mcg-option">
										<input name="inc_optin_mailchimp_group_interest[]" type="checkbox" id="wpoi-checkbox-id-{{unique}}" value="{{interest.value}}" {{_.checked( group.selected && group.selected.indexOf( interest.value .toString() ) !== -1 , true )}} />
										<label for="wpoi-checkbox-id-{{unique}}">{{interest.label}}</label>
									</div>
								<# }); #>
								
							</div>
							
						<# } #>
						
						<# if(group.type === "radio"){ #>
							
							<div class="wpoi-mcg-options">
								
								<# _.each(group.interests, function(interest, id){  var unique = _.uniqueId(interest.value); #>
									<div class="wpoi-mcg-option">
										<input name="inc_optin_mailchimp_group_interest" type="radio" id="wpoi-checkbox-id-{{unique}}" value="{{interest.value}}" {{_.checked( group.selected && group.selected.indexOf( interest.value .toString() ) !== -1 , true )}} />
										<label for="wpoi-checkbox-id-{{unique}}">{{interest.label}}</label>
									</div>
								<# }); #>
								
							</div>
							
						<# } #>
						
					<# } #>
					
				</div>
				
				<div class="wpoi-button wpoi-button-big {{ ( typeof group === 'undefined' ) ? 'wpoi-button-relocate' : '' }}">
					
					<button type="submit" class="wpoi-subscribe-send">{{cta_button}}</button>
					
				</div>
				
			</div>
			
		</div>
		
	</div>
	
</script>