<?php
/**
 * @var $this Opt_In_Admin
 * @var $optin Opt_In_Model
 * @var $new_optin Opt_In_Model
 */
?>

<div id="hustle-optin-listing" class="hustle-two">

	<div id="container" class="<?php if ( count( $optins ) !== 0 ){ echo 'container-980 '; } ?>wpoi-listing-page">

		<header id="header">
			
			<?php if ( count( $optins ) === 0 ) { ?>
				
				<h1><?php _e("Email Opt-ins Dashboard", Opt_In::TEXT_DOMAIN); ?></h1>
				
			<?php } else { ?>
				
				<h1><?php _e("Email Opt-ins Dashboard", Opt_In::TEXT_DOMAIN); ?><a class="wph-button wph-button--small wph-button--gray wph-button--inline" href="<?php echo esc_url( $add_new_url ); ?>"><?php _e('New Opt-in', Opt_In::TEXT_DOMAIN); ?></a></h1>
				
			<?php } ?>

		</header>

		<section>
			
			<?php if ( count( $optins ) === 0 ){ ?>
				
				<?php $this->render("admin/optins/optins-welcome", array(
                    'new_url' => $add_new_url,
                    'user_name' => $user_name
                )); ?>
				
			<?php } else { ?>
				
				<div class="row">
					
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						
						<ul class="wph-accordions">
			
							<?php wp_nonce_field("wpoi_get_emails_list", "wpoi_get_emails_list_nonce");
			
							foreach( $optins as $key => $optin ) :
							
								$keep_open = ( count( $optins ) === 1 ) ? true : false;
								
								if ( !$keep_open && $new_optin && $optin->id === $new_optin->id )
									$keep_open = true;
			
								if ( !$keep_open && $updated_optin && $optin->id === $updated_optin->id )
									$keep_open = true; ?>
			
								<li class="wph-accordions--item<?php echo $keep_open? ' wph-accordion--open' : ' wph-accordion--closed'; ?>">
			
									<header class="wph-accordion--animate_buttons">
			
										<div class="toggle">
			
											<input data-nonce="<?php echo wp_create_nonce('inc_opt_toggle_state') ?>" id="optin-active-state-<?php echo esc_attr($optin->id); ?>" class="toggle-checkbox optin-active-state" type="checkbox" data-id="<?php echo esc_attr($optin->id); ?>" <?php checked( $optin->active, 1 ); ?>>
			
											<label class="toggle-label" for="optin-active-state-<?php echo esc_attr($optin->id); ?>"></label>
			
										</div>
			
										<label class="wph-label--module"><?php echo esc_html( $optin->optin_name ); ?></label>
			
										<label class="wph-label--provider tablet-hidden<?php echo (int) $optin->test_mode  ? 'wpoi-optin-no-privider' : '' ?>"><?php echo esc_html( $optin->decorated->mail_service_label );  ?></label>
			
										<div class="wph-accordion--buttons">
			
											<a class="wph-button wph-button--inline wph-button--small wph-button--gray" href="<?php echo $optin->decorated->get_edit_url('') . '&tab=design'; ?>"><?php _e('Edit', Opt_In::TEXT_DOMAIN); ?></a>
			
											<a class="wph-button wph-button--inline wph-button--small wph-button--red hustle-delete-optin" data-nonce="<?php echo wp_create_nonce('inc_opt_delete_optin'); ?>" data-id="<?php echo esc_attr( $optin->id ); ?>" ><?php _e('Delete', Opt_In::TEXT_DOMAIN); ?></a>
			
										</div>
			
										<?php if( $optin->get_total_subscriptions() ): ?>
			
											<button class="wph-button wph-button--small wph-button--filled wph-button--gray button-view-email-list" href="#" data-total="<?php echo esc_attr( $optin->get_total_subscriptions() ); ?>" data-id="<?php echo esc_attr( $optin->id ); ?>" data-name="<?php echo esc_attr( $optin->optin_name ); ?>" ><?php _e("View Email List", Opt_In::TEXT_DOMAIN); ?></button>
			
										<?php endif; ?>
			
										<?php if ( ( $log_count = $optin->get_total_log_errors() ) ) : ?>
											<button class="wph-button wph-button--small wph-button--red button-view-log-list" href="#" data-total="<?php echo esc_attr( $log_count ); ?>" data-id="<?php echo esc_attr( $optin->id ); ?>" data-name="<?php echo esc_attr( $optin->optin_name ); ?>" ><?php _e("View Error Log", Opt_In::TEXT_DOMAIN); ?></button>
										<?php endif; ?>

										<span class="accordion-state"><i class="wph-icon i-arrow"></i></span>
			
									</header>
			
									<section>
			
										<div class="wph-accordion--disable<?php echo $optin->active ? ' hidden' : ''; ?>">
			
											<p><?php _e("Please activate this opt-in to configure it's settings.", Opt_In::TEXT_DOMAIN); ?></p>
			
										</div>
			
										<table class="wph-table wph-table--fixed">
			
											<thead>
			
												<tr>
			
													<th class="wph-module--name"><?php _e("Opt-in type", Opt_In::TEXT_DOMAIN); ?></th>
			
													<th class="wph-module--display"><?php _e("Display conditions", Opt_In::TEXT_DOMAIN); ?></th>
			
													<th class="wph-module--views"><?php _e("Views", Opt_In::TEXT_DOMAIN); ?></th>
			
													<th class="wph-module--conversions"><?php _e('Conversions', Opt_In::TEXT_DOMAIN); ?></th>
			
													<th class="wph-module--rates"><?php _e('Conversion rate', Opt_In::TEXT_DOMAIN); ?></th>
                                                    
                                                    <th class="wph-module--tracking"><?php _e('Tracking', Opt_In::TEXT_DOMAIN); ?></th>
			
													<th class="wph-module--admin">
			
														<?php _e('Admin test', Opt_In::TEXT_DOMAIN); ?>
			
														<!--<span class="wpoi-tooltip tooltip-right" tooltip="<?php esc_attr_e('Allows logged-in Admins to test the appearance & functionality of the Opt-in before Activating it.', Opt_In::TEXT_DOMAIN) ?>">
			
															<span class="dashicons dashicons-editor-help wpoi-icon-info"></span>
			
														</span>-->
			
													</th>
			
													<th class="wph-module--active"><?php _e('Active', Opt_In::TEXT_DOMAIN); ?></th>
			
											</thead>
			
											<tbody>
			
												<?php foreach( $types as $type_key => $type ) : ?>
			
												<tr>
			
													<th class="wph-module--name"><span><?php echo $type; ?></span></th>
			
													<td class="wph-module--display">
			
														<?php if( !( "shortcode" === $type_key || "widget" === $type_key ) ) : ?>
			
															<a class="wph-button wph-button--small wph-button--gray wph-module--edit"  href="<?php echo $optin->decorated->get_edit_url('') . '&tab=display' ?>"><?php _e("Edit", Opt_In::TEXT_DOMAIN); ?></a>
			
														<?php endif; ?>
                                                        
                                                        <?php if( "shortcode" === $type_key  ) : ?>
                                                            <?php printf( __('[%s id="'. $optin->shortcode_id .'"]', Opt_In::TEXT_DOMAIN ), Opt_In_Front::SHORTCODE );?>
                                                        <?php elseif( "widget" !== $type_key  ) : ?>
                                                            <?php echo $optin->decorated->get_type_condition_labels($type_key, false); ?>
                                                        <?php endif; ?>
														
			
													</td>
			
													<td class="wph-module--views" data-title="<?php _e('Views', Opt_In::TEXT_DOMAIN); ?>"><?php echo $optin->{$type_key}->views_count; ?></td>
			
													<td class="wph-module--conversions" data-title="<?php _e('Conversions', Opt_In::TEXT_DOMAIN); ?>"><?php echo $optin->{$type_key}->conversions_count; ?></td>
			
													<td class="wph-module--rates" data-title="<?php _e('Conversions rate', Opt_In::TEXT_DOMAIN); ?>"><?php echo $optin->{$type_key}->conversion_rate; ?>%</td>
                                                    
                                                    <td class="wph-module--tracking" data-title="<?php _e('Tracking', Opt_In::TEXT_DOMAIN); ?>">
									
                                                        <div class="toggle">
                                                            
                                                            <input  id="optin-toggle-tracking-<?php echo $type_key . '-' . esc_attr( $optin->id ); ?>" class="toggle-checkbox optin-toggle-tracking-activity" type="checkbox" data-id="<?php echo esc_attr( $optin->id ) ?>" data-type="<?php echo esc_attr( $type_key ); ?>" <?php checked( $optin->is_track_type_active( $type_key ), true); ?> data-nonce="<?php echo wp_create_nonce('optin-toggle-tracking-activity') ?>" >
                                                            
                                                            <label class="toggle-label" for="optin-toggle-tracking-<?php echo $type_key . '-' . esc_attr( $optin->id ); ?>"></label>
                                                            
                                                        </div>
                                                        
                                                    </td>
			
													<td class="wph-module--admin" data-title="<?php _e('Admin Test', Opt_In::TEXT_DOMAIN); ?>">
			
														<span class="toggle toggle-alt test-mode">
			
															<input id="optin-testmode-active-state-<?php echo esc_attr($type_key) ."-". esc_attr( $optin->id );  ?>" data-nonce="<?php echo wp_create_nonce('inc_opt_toggle_type_test_mode'); ?>" class="toggle-checkbox wpoi-testmode-active-state" type="checkbox" data-type="<?php echo esc_attr($type_key); ?>" data-id="<?php echo esc_attr($optin->id);  ?>" <?php checked( (bool) $optin->is_test_type_active( $type_key ), true ); ?>  >
			
															<label class="toggle-label" for="optin-testmode-active-state-<?php echo esc_attr($type_key) ."-". esc_attr( $optin->id );  ?>"></label>
			
														</span>
			
													</td>
			
													<td class="wph-module--active" data-title="<?php _e('Active', Opt_In::TEXT_DOMAIN); ?>">
			
														<span class="toggle">
			
															<input id="optin-<?php echo esc_attr($type_key); ?>-active-state-<?php echo esc_attr($optin->id);  ?>" class="toggle-checkbox wpoi-<?php  echo esc_attr($type_key); ?>-active-state optin-type-active-state" data-nonce="<?php echo wp_create_nonce('inc_opt_toggle_optin_type_state'); ?>"  data-type="<?php echo esc_attr($type_key); ?>" data-id="<?php echo esc_attr($optin->id);?>" type="checkbox"  <?php checked( $optin->settings->{$type_key}->enabled, true ); ?> >
			
															<label class="toggle-label" for="optin-<?php echo $type_key ?>-active-state-<?php echo $optin->id;  ?>"></label>
			
														</span>
			
													</td>
			
												</tr>
			
												<?php endforeach; ?>
			
											</tbody>
			
										</table>
			
									</section>
			
								</li>
			
							<?php endforeach; ?>
			
						</ul>
						
					</div>
					
				</div>
				
			<?php } ?>

		</section>

	</div>

	<?php if( ! is_null( $new_optin ) && count( $optins ) === 1 ) $this->render("admin/new-optin_success", array( 'new_optin' => $new_optin, 'types' => $types )); ?>
</div>

<?php require_once("emails_list.php"); ?>
<?php $this->render("admin/common/delete-confirmation"); ?>
<?php $this->render('admin/error_list' ); ?>
