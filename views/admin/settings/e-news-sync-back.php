<script id="wpoi-e-newsletter-box-back" type="text/template">
	
	<div class="box-title">
		
		<h3><?php _e('{{optin_name}} - Setup', Opt_In::TEXT_DOMAIN); ?></h3>
		
	</div>
	
	<div class="box-content">
		
		<div class="row">
			
			<div class="col-xs-12">
				
				<h6><?php _e('Add <strong>{{optin_name}}</strong> emails to these E-Newsletter groups:', Opt_In::TEXT_DOMAIN); ?></h6>
				
				<table class="wph-table wph-table--alt"><!-- wph-settings--enewsletter wph-enews--setup -->
					
					<thead>
						
						<tr>
							
							<th colspan="2"><?php _e('E-newsletter Groups', Opt_In::TEXT_DOMAIN); ?></th>
							
						</tr>
						
					</thead>
					
					<tbody>
						
						<# _.each( groups, function( group, index ) { #>
							
							<tr>
								
								<td colspan="2">
									
									<label for="wpoi-e-newsletter-group-{{group.group_id}}">{{group.group_name}} <span class="description">({{group.type}})</span></label>
									
									<div class="wph-input--checkbox">
										
										<input value="{{group.group_id}}" id="wpoi-e-newsletter-group-{{group.group_id}}" class="wpoi-e-newsletter-group" type="checkbox" {{_.checked(group.selected, true)}} >
										
										<label for="wpoi-e-newsletter-group-{{group.group_id}}" class="wph-icon i-check"></label>
										
									</div>
									
								</td>
								
							</tr>
							
						<# }); #>
						
					</tbody>
					
					<tfoot>
						
						<tr>
							
							<td class="wph-enews--cancelsetup">
								
								<a href="#0" class="wph-button wph-button--inline wph-button--gray optin-enews-sync-cancel"><?php _e("Cancel", Opt_In::TEXT_DOMAIN); ?></a>
								
							</td>
							
							<td class="wph-enews--savesetup">
								
								<a href="#0" class="wph-button wph-button--inline wph-button--filled wph-button--blue optin-enews-sync-save" data-id="{{optin_id}}" data-nonce="{{save_nonce}}" ><?php _e("Save Settings", Opt_In::TEXT_DOMAIN); ?></a>
								
							</td>
							
						</tr>
						
					</tfoot>
					
				</table>
				
			</div>
			
		</div>
		
	</div>
	
</script>