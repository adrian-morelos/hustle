<?php
/**
* @var $optin Opt_In_Model
* @var $this Opt_In_Admin
 */
?>

<div class="box-title">
	
	<h3><?php _e('e-Newsletter Integration', Opt_In::TEXT_DOMAIN); ?></h3>
	
</div>

<div class="box-content">
	
	<div class="row">
		
		<div class="col-xs-12">
			
			<h6 class="alt"><?php _e('Set up email list syncing with E-Newsletter plugin.', Opt_In::TEXT_DOMAIN); ?></h6>
			
			<table class="wph-table">
				
				<thead>
					
					<tr>
						
						<th class="wph-enews--list" colspan="2"><?php _e('Opt-in Lists', Opt_In::TEXT_DOMAIN); ?></th>
						
						<th class="wph-enews--sync"><?php _e('Sync', Opt_In::TEXT_DOMAIN); ?></th>
						
					</tr>
					
				</thead>
				
				<tbody>
					
					<?php foreach( $optins as $optin ) : ?>
						
						<?php if( is_null( $optin->get_sync_with_e_newsletter() ) && $this->get_e_newsletter()->get_groups() !== array() ): ?>
							
							<tr>
								
								<td class="wph-enews--list" data-title="Opt-in List" colspan="2"><?php echo $optin->optin_name; ?></td>
								
								<td class="wph-enews--setup" data-title="Sync">
									
									<a href="#0" class="wph-button wph-button--small wph-button--gray optin-enews-sync-setup" data-nonce="<?php echo $enews_sync_setup_nonce; ?>" data-id="<?php echo esc_attr( $optin->id ) ?>" ><?php _e("Setup", Opt_In::TEXT_DOMAIN); ?></a>
									
								</td>
								
							</tr>
							
						<?php else : ?>
							
							<tr class="<?php echo $this->get_e_newsletter()->get_groups() !== array() ? 'wph-enews--editable' : ''; ?>">
								
								<td class="wph-enews--list" data-title="Opt-in List"><?php echo $optin->optin_name; ?></td>
								
								<td class="wph-enews--edit" data-title="Edit">
									
									<?php if( $this->get_e_newsletter()->get_groups() !== array() ) : ?>
										
										<a href=#0"" class="wph-button wph-button--small wph-button--gray optin-enews-sync-edit" data-nonce="<?php echo $enews_sync_setup_nonce; ?>" data-id="<?php echo esc_attr( $optin->id ) ?>" ><?php _e("Edit", Opt_In::TEXT_DOMAIN); ?></a>
										
									<?php endif; ?>
									
								</td>
								
								<td class="wph-enews--sync" data-title="Sync">
									
									<span class="toggle">
										
										<input id="optin-enews-sync-state-<?php echo esc_attr( $optin->id ) ?>" class="toggle-checkbox optin-enews-sync-toggle" type="checkbox" data-nonce="<?php echo $enews_sync_state_toggle_nonce; ?>" data-id="<?php echo esc_attr( $optin->id ) ?>" <?php checked( true, $optin->sync_with_e_newsletter ); ?> >
										
										<label class="toggle-label" for="optin-enews-sync-state-<?php echo esc_attr( $optin->id ) ?>"></label>
										
									</span>
									
								</td>
								
							</tr>
							
						<?php endif; ?>
						
					<?php endforeach; ?>
					
				</tbody>
				
			</table>
			
		</div>
		
	</div>
	
</div>