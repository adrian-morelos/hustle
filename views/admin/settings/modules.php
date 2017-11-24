<?php
/**
 * @var $modules Opt_In_Model[]| Hustle_Custom_Content_Model[]
 */
?>
<div class="box-title">
	
	<h3><?php _e('Don\'t show modules to', Opt_In::TEXT_DOMAIN); ?></h3>
	
</div>

<div class="box-content">
	
	<div class="row">
		
		<div class="col-xs-12">
			
			<table class="wph-table wph-table--fixed">
		
				<thead>
					
					<tr>
						
						<th><?php _e('Hustle Module', Opt_In::TEXT_DOMAIN); ?></th>
						
						<th class="wph-module--loginUser"><?php _e('Logged-in User', Opt_In::TEXT_DOMAIN); ?></th>
						
						<th class="wph-module--admin"><?php _e('Admin', Opt_In::TEXT_DOMAIN); ?></th>
						
					</tr>
					
				</thead>
				
				<tbody>
		
				<?php foreach( $modules as $module ) :
					$admin_id = esc_attr( "hustle-module-admin" . $module->id );
					$logged_id = esc_attr( "hustle-module-logged_in" . $module->id ); ?>
					
					<tr>
						
						<td class="wph-module--name">
							
							<?php echo $module->optin_name ?> <small>(<?php echo $module->module_type; ?>)</small>
							
						</td>
						
						<td class="wph-module--loginUser" data-title="<?php _e('Logged-In User', Opt_In::TEXT_DOMAIN); ?>">
							
							<span class="toggle toggle-alt">
								
								<input id="<?php echo $logged_id  ?>" class="toggle-checkbox hustle-for-logged-in-user-toggle" data-user="logged_in" type="checkbox" data-nonce="<?php echo $modules_state_toggle_nonce; ?>" data-id="<?php echo esc_attr( $module->id ); ?>" <?php checked( !$module->is_active_for_logged_in_user, 1 ); ?>>
								
								<label class="toggle-label" for="<?php echo $logged_id  ?>"></label>
								
							</span>
		
						</td>
						
						<td class="wph-module--admin" data-title="<?php _e('Admin', Opt_In::TEXT_DOMAIN); ?>">
		
							<span class="toggle">
		
								<input id="<?php echo $admin_id; ?>" class="toggle-checkbox hustle-for-admin-user-toggle" data-user="admin" type="checkbox" data-nonce="<?php echo $modules_state_toggle_nonce; ?>" data-id="<?php echo esc_attr( $module->id ); ?>" <?php checked( !$module->is_active_for_admin, 1 ); ?> >
		
								<label class="toggle-label" for="<?php echo $admin_id; ?>"></label>
		
							</span>
		
							
						</td>
						
					</tr>
					
				<?php endforeach; ?>
				
				</tbody>
				
			</table>
			
		</div>
		
	</div>
	
</div>