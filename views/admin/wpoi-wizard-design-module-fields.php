<script type="text/template" id="wpoi-wizard-design_module_fields_template">
	
	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
		
		<h5><?php _e('Module Fields', Opt_In::TEXT_DOMAIN); ?></h5>
		
	</div>
	
	<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
		
		<label class="wph-label--border"><?php _e('Opt-in Module Fields', Opt_In::TEXT_DOMAIN); ?></label>
		
		<div class="wph-table--module_fields">
			
			<table class="wph-table wph-table--fixed">
				
				<thead>
					
					<tr>
						
						<th class="wph-column-label"><?php _e( 'Label', Opt_In::TEXT_DOMAIN ); ?></th>
						
						<th class="wph-column-name"><?php _e( 'Name', Opt_In::TEXT_DOMAIN ); ?></th>
						
						<th class="wph-column-type"><?php _e( 'Type', Opt_In::TEXT_DOMAIN ); ?></th>
						
						<th class="wph-column-required"><?php _e( 'Required?', Opt_In::TEXT_DOMAIN ); ?></th>
						
						<th class="wph-column-placeholder"><?php _e( 'Placeholder', Opt_In::TEXT_DOMAIN ); ?></th>
						
					</tr>
					
				</thead>
				
				<tbody id="wpoi-module-fields"></tbody>
				
				<tfoot id="wpoi-module-field-maker" class="hidden">
					
					<tr>
						
						<td class="wph-column-label"><input type="text" data-name="label" placeholder="<?php _e( 'Type label...', Opt_In::TEXT_DOMAIN ); ?>" /></td>
						
						<td class="wph-column-name"><input type="text" data-name="name" placeholder="<?php _e( 'Type name', Opt_In::TEXT_DOMAIN ); ?>" /></td>
						
						<td class="wph-column-type">
							
							<select data-name="type" class="wpmuiSelect">
								
								<?php foreach ( Opt_In_Model::instance()->get_field_types() as $type => $type_label ) : ?>
									
									<option value="<?php echo $type; ?>"><?php echo $type_label; ?></option>
									
								<?php endforeach; ?>
								
							</select>
							
						</td>
						
						<td class="wph-column-required">
							
							<div class="wph-input--checkbox">
								
								<input type="checkbox" id="wpoi-field-required" data-name="required" checked="checked" />
								
								<label class="wph-icon i-check" for="wpoi-field-required"></label>
								
							</div>
							
						</td>
						
						<td class="wph-column-placeholder"><input type="text" data-name="placeholder" placeholder="<?php _e( 'Type placeholder...', Opt_In::TEXT_DOMAIN ); ?>" /></td>
						
					</tr>
					
					<tr>
						
						<td colspan="2">
							
							<button type="button" class="wph-button wph-button--small wph-button--gray wph-cancel-add-field"><?php _e( 'Cancel', Opt_In::TEXT_DOMAIN ); ?></button>
							
						</td>
						
						<td colspan="3">
							
							<button type="button" class="wph-button wph-button--small wph-button--filled wph-button--blue wph-add-new-field"><?php _e( 'Add Field', Opt_In::TEXT_DOMAIN ); ?></button>
							
						</td>
						
					</tr>
					
				</tfoot>
				
			</table>
			
			<div class="wph-new-module">
				
				<button type="button" class="wph-button wph-button--small wph-button--filled wph-button--gray add-new-module-field"><?php _e( 'Add New Field', Opt_In::TEXT_DOMAIN ); ?></button>
				
			</div>
			
		</div>
		
	</div>

</script>

<script type="text/template" id="wpoi-module-field">
	
	<td class="wph-column-label"><input type="text" name="label" value="{{label}}" /></td>
	
	<td class="wph-column-name"><input type="text" name="name" value="{{name}}" /></td>
	
	<td class="wph-column-type">
		
		{{type}}
		
		<input type="hidden" name="type" value="{{type}}" />
		
	</td>
	
	<td class="wph-column-required">
		
		<div class="wph-input--checkbox<# if ( 'email' === type && 'email' === name ) { #> disabled<# } #>">
			
			<input type="checkbox" name="required" value="1" id="required-{{index}}" {{_.checked(required,true)}} />
			
			<label class="wph-icon i-check" for="required-{{index}}"></label>
			
		</div>
		
	</td>
	
	<td class="wph-column-placeholder<# if ( 'email' !== type && 'email' !== name ) { #> can-trash<# } #>">
		
		<input type="text" name="placeholder" value="{{placeholder}}" />

		<# if ( 'email' !== type && 'email' !== name ) { #>
			
			<span class="wph-column-icon">
				
				<i class="wph-icon i-close"></i>
				
			</span>
			
		<# } #>
	</td>
	
</script>