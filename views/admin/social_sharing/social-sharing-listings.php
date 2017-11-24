<?php
/**
 * @var $social_groups Hustle_Social_Sharing_Model[]
 */
?>

<ul class="wph-accordions">
	
	<?php foreach( $social_groups as $social_group ) :
		
		$keep_open = ( count( $social_groups ) === 1 ) ? true : false;
		
		if ( !$keep_open && $new_ss && $social_group->id === $new_ss )
			$keep_open = true;
			
		if ( !$keep_open && $updated_ss && $social_group->id === $updated_ss )
			$keep_open = true; ?>
		
		<li class="wph-accordions--item wph-accordion--<?php echo $keep_open ? 'open' : 'closed' ?>">
			
			<header class="wph-accordion--animate_buttons">
				
				<div class="toggle">
					
					<input id="social-sharing-active-toggle-<?php echo esc_attr( $social_group->id ); ?>" class="toggle-checkbox social-sharing-toggle-activity" type="checkbox" data-id="<?php echo esc_attr( $social_group->id ); ?>" <?php checked( $social_group->active, 1 ); ?> data-nonce="<?php echo wp_create_nonce('social-sharing-toggle-activity') ?>" >
					
					<label class="toggle-label" for="social-sharing-active-toggle-<?php echo esc_attr( $social_group->id ); ?>"></label>
					
				</div>
				
				<label class="wph-label--module"><?php echo $social_group->optin_name; ?></label>
				
				<div class="wph-accordion--buttons">
					
					<a class="wph-button wph-button--inline wph-button--small wph-button--gray social-sharing-edit" href="<?php echo $social_group->get_decorated()->get_edit_url() . '&tab=appearance'; ?>"><?php _e('Edit', Opt_In::TEXT_DOMAIN); ?></a>
					
					<a class="wph-button wph-button--inline wph-button--small wph-button--red social-sharing-delete"  data-id="<?php echo esc_attr( $social_group->id ); ?>" data-nonce="<?php echo wp_create_nonce('social-sharing-delete') ?>" ><?php _e('Delete', Opt_In::TEXT_DOMAIN); ?></a>
					
				</div>
				
				<span class="accordion-state"><i class="wph-icon i-arrow"></i></span>
				
			</header>
			
			<section>
				
				<table class="wph-table wph-table--listings">
					
					<thead>
						
						<tr>
							
							<th class="wph-module--name"><?php _e('Module Type', Opt_In::TEXT_DOMAIN); ?></th>
							
							<th class="wph-module--display"><?php _e('Display Conditions', Opt_In::TEXT_DOMAIN); ?></th>
							
							<th class="wph-module--views"><?php _e('Views', Opt_In::TEXT_DOMAIN); ?></th>
							
							<th class="wph-module--conversions"><?php _e('Conversions', Opt_In::TEXT_DOMAIN); ?></th>
							
							<th class="wph-module--rates"><?php _e('Conversions rate', Opt_In::TEXT_DOMAIN); ?></th>
							
							<th class="wph-module--tracking"><?php _e('Tracking', Opt_In::TEXT_DOMAIN); ?></th>
                            
							<th class="wph-module--admin"><?php _e('Admin Test', Opt_In::TEXT_DOMAIN); ?></th>
							
							<th class="wph-module--active"><?php _e('Active', Opt_In::TEXT_DOMAIN); ?></th>
							
						</tr>
						
					</thead>
					
					<tbody>
						
						<?php foreach( $types as $type_key => $type ) : ?>
							
							<tr>
								
								<th class="wph-module--name"><span><?php echo $type; ?></span></th>
								
								<td class="wph-module--display ">
                                
                                    <?php if( !( "shortcode" === $type_key || "widget" === $type_key ) ) : ?>
									
                                        <a class="wph-button wph-button--small wph-button--gray wph-module--edit" href="<?php echo $social_group->decorated->get_edit_url() . '&tab=display'; ?>"><?php _e('Edit', Opt_In::TEXT_DOMAIN); ?></a>
									
									<?php endif; ?>
                                    
                                    <?php if( "shortcode" === $type_key  ) : ?>
                                        <?php  echo '[wd_hustle_ss id="'. $social_group->shortcode_id .'"]'; ?>
                                    <?php elseif( "widget" !== $type_key  ) : ?>
                                        <?php echo $social_group->decorated->get_type_condition_labels($type_key, false); ?>
                                    <?php endif; ?>
								</td>
								
								<td class="wph-module--views" data-title="<?php _e('Views', Opt_In::TEXT_DOMAIN); ?>"><?php echo $social_group->get_statistics($type_key)->views_count; ?></td>
								
								<td class="wph-module--conversions" data-title="<?php _e('Conversions', Opt_In::TEXT_DOMAIN); ?>"><?php echo $social_group->get_statistics($type_key)->conversions_count; ?></td>
								
								<td class="wph-module--rates" data-title="<?php _e('Conversions Rate', Opt_In::TEXT_DOMAIN); ?>"><?php echo $social_group->get_statistics($type_key)->conversion_rate; ?>%</td>
                                
                                <td class="wph-module--tracking" data-title="<?php _e('Tracking', Opt_In::TEXT_DOMAIN); ?>">
									
									<div class="toggle">
										
										<input  id="social-sharing-toggle-tracking-<?php echo $type_key . '-' . esc_attr( $social_group->id ); ?>" class="toggle-checkbox social-sharing-toggle-tracking-activity" type="checkbox" data-id="<?php echo esc_attr( $social_group->id ) ?>" data-type="<?php echo esc_attr( $type_key ); ?>" <?php checked( $social_group->is_track_type_active( $type_key ), true); ?> data-nonce="<?php echo wp_create_nonce('social-sharing-toggle-tracking-activity') ?>" >
										
										<label class="toggle-label" for="social-sharing-toggle-tracking-<?php echo $type_key . '-' . esc_attr( $social_group->id ); ?>"></label>
										
									</div>
									
								</td>
								
								<td class="wph-module--admin" data-title="<?php _e('Admin Test', Opt_In::TEXT_DOMAIN); ?>">
									
									<div class="toggle">
										
										<input  id="social-sharing-toggle-admin-test-<?php echo $type_key . '-' . esc_attr( $social_group->id ); ?>" class="toggle-checkbox social-sharing-toggle-test-activity" type="checkbox" data-id="<?php echo esc_attr( $social_group->id ) ?>" data-type="<?php echo esc_attr( $type_key ); ?>" <?php checked( $social_group->is_test_type_active( $type_key ), true); ?> data-nonce="<?php echo wp_create_nonce('social-sharing-toggle-test-activity') ?>" >
										
										<label class="toggle-label" for="social-sharing-toggle-admin-test-<?php echo $type_key . '-' . esc_attr( $social_group->id ); ?>"></label>
										
									</div>
									
								</td>
								
								<td class="wph-module--active" data-title="<?php _e('Active', Opt_In::TEXT_DOMAIN); ?>">
									
									<div class="toggle">
										<?php
                                            $enabled_check = ( $type_key == 'shortcode' || $type_key == 'widget' ) 
                                                ? $social_group->get_parent_settings()->{$type_key}->enabled
                                                : $social_group->{$type_key}->enabled;
                                        ?>
										<input  id="social-sharing-toggle-<?php echo $type_key . '-' . esc_attr( $social_group->id ); ?>" class="toggle-checkbox social-sharing-toggle-type-activity" type="checkbox" data-id="<?php echo esc_attr( $social_group->id ) ?>" data-type="<?php echo esc_attr( $type_key ); ?>" <?php checked( $enabled_check, true); ?> data-nonce="<?php echo wp_create_nonce('social-sharing-toggle-type-activity') ?>"  >
										
										<label class="toggle-label" for="social-sharing-toggle-<?php echo $type_key . '-' . esc_attr( $social_group->id ); ?>"></label>
										
									</div>
									
								</td>
								
							</tr>
							
						<?php endforeach; ?>
						
					</tbody>
					
				</table>
				
			</section>
			
		</li>
		
	<?php endforeach; ?>
	
</ul>

<?php $this->render("admin/common/delete-confirmation"); ?>