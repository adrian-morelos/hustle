<?php
/**
 * @var $custom_contents Hustle_Custom_Content_Model[]
 */
?>

<ul class="wph-accordions">
	
	<?php foreach( $custom_contents as $custom_content ) :
		
		$keep_open = ( count( $custom_contents ) === 1 ) ? true : false;
		
		if ( !$keep_open && $new_cc && $custom_content->id === $new_cc )
			$keep_open = true;
			
		if ( !$keep_open && $updated_cc && $custom_content->id === $updated_cc )
			$keep_open = true; ?>
		
		<li class="wph-accordions--item wph-accordion--<?php echo $keep_open ? 'open' : 'closed' ?>">
			
			<header class="wph-accordion--animate_buttons">
				
				<div class="toggle">
					
					<input id="custom-content-active-toggle-<?php echo esc_attr( $custom_content->id ); ?>" class="toggle-checkbox custom-content-toggle-activity" type="checkbox" data-id="<?php echo esc_attr( $custom_content->id ); ?>" <?php checked( $custom_content->active, 1 ); ?> data-nonce="<?php echo wp_create_nonce('custom-content-toggle-activity') ?>" >
					
					<label class="toggle-label" for="custom-content-active-toggle-<?php echo esc_attr( $custom_content->id ); ?>"></label>
					
				</div>
				
				<label class="wph-label--module"><?php echo $custom_content->optin_name; ?></label>
				
				<div class="wph-accordion--buttons">
					
					<a class="wph-button wph-button--inline wph-button--small wph-button--gray custom-content-edit" href="<?php echo $custom_content->get_decorated()->get_edit_url(); ?>"><?php _e('Edit', Opt_In::TEXT_DOMAIN); ?></a>
					
					<a class="wph-button wph-button--inline wph-button--small wph-button--red custom-content-delete"  data-id="<?php echo esc_attr( $custom_content->id ); ?>" data-nonce="<?php echo wp_create_nonce('custom-content-delete') ?>" ><?php _e('Delete', Opt_In::TEXT_DOMAIN); ?></a>
					
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
                                    
                                        <a class="wph-button wph-button--small wph-button--gray wph-module--edit" href="<?php echo $custom_content->decorated->get_edit_url() . '&tab=display'; ?>"><?php _e('Edit', Opt_In::TEXT_DOMAIN); ?></a>
									
                                    <?php endif; ?>
                                    
                                    <?php if( "shortcode" === $type_key  ) : ?>
                                        <?php  echo '[wd_hustle_cc id="'. $custom_content->shortcode_id .'"]'; ?>
                                    <?php elseif( "widget" !== $type_key  ) : ?>
                                        <?php echo $custom_content->decorated->get_type_condition_labels($type_key, false); ?>
                                    <?php endif; ?>
									
								</td>
								
								<td class="wph-module--views" data-title="<?php _e('Views', Opt_In::TEXT_DOMAIN); ?>"><?php echo $custom_content->get_stats($type_key)->views_count; ?></td>
								
								<td class="wph-module--conversions" data-title="<?php _e('Conversions', Opt_In::TEXT_DOMAIN); ?>"><?php echo $custom_content->get_stats($type_key)->conversions_count; ?></td>
								
								<td class="wph-module--rates" data-title="<?php _e('Conversions Rate', Opt_In::TEXT_DOMAIN); ?>"><?php echo $custom_content->get_stats($type_key)->conversion_rate; ?>%</td>
                                
                                <td class="wph-module--tracking" data-title="<?php _e('Tracking', Opt_In::TEXT_DOMAIN); ?>">
									
									<div class="toggle">
										
										<input  id="custom-content-toggle-tracking-<?php echo $type_key . '-' . esc_attr( $custom_content->id ); ?>" class="toggle-checkbox custom-content-toggle-tracking-activity" type="checkbox" data-id="<?php echo esc_attr( $custom_content->id ) ?>" data-type="<?php echo esc_attr( $type_key ); ?>" <?php checked( $custom_content->is_track_type_active( $type_key ), true); ?> data-nonce="<?php echo wp_create_nonce('custom-content-toggle-tracking-activity') ?>" >
										
										<label class="toggle-label" for="custom-content-toggle-tracking-<?php echo $type_key . '-' . esc_attr( $custom_content->id ); ?>"></label>
										
									</div>
									
								</td>
								
								<td class="wph-module--admin" data-title="<?php _e('Admin Test', Opt_In::TEXT_DOMAIN); ?>">
									
									<div class="toggle">
										
										<input  id="custom-content-toggle-admin-test-<?php echo $type_key . '-' . esc_attr( $custom_content->id ); ?>" class="toggle-checkbox custom-content-toggle-test-activity" type="checkbox" data-id="<?php echo esc_attr( $custom_content->id ) ?>" data-type="<?php echo esc_attr( $type_key ); ?>" <?php checked( $custom_content->is_test_type_active( $type_key ), true); ?> data-nonce="<?php echo wp_create_nonce('custom-content-toggle-test-activity') ?>" >
										
										<label class="toggle-label" for="custom-content-toggle-admin-test-<?php echo $type_key . '-' . esc_attr( $custom_content->id ); ?>"></label>
										
									</div>
									
								</td>
								
								<td class="wph-module--active" data-title="<?php _e('Active', Opt_In::TEXT_DOMAIN); ?>">
									
									<div class="toggle">
                                    <?php
                                        $enabled_check = ( $type_key == 'shortcode' || $type_key == 'widget' ) 
                                            ? $custom_content->get_parent_settings()->{$type_key}->enabled
                                            : $custom_content->{$type_key}->enabled;
                                    ?>
										<input  id="custom-content-toggle-<?php echo $type_key . '-' . esc_attr( $custom_content->id ); ?>" class="toggle-checkbox custom-content-toggle-type-activity" type="checkbox" data-id="<?php echo esc_attr( $custom_content->id ) ?>" data-type="<?php echo esc_attr( $type_key ); ?>" <?php checked( $enabled_check, true); ?> data-nonce="<?php echo wp_create_nonce('custom-content-toggle-type-activity') ?>"  >
										
										<label class="toggle-label" for="custom-content-toggle-<?php echo $type_key . '-' . esc_attr( $custom_content->id ); ?>"></label>
										
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