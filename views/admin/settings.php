<?php
/**
 * @var Opt_In_Admin $this
 */
?>
<div id="hustle-settings" class="hustle-two">

	<div id="container"<?php if ( count( $modules ) == 0 ) : ''; else : echo ' class="container-980"'; endif; ?>>

		<header id="header">

			<h1><?php _e('Settings', Opt_In::TEXT_DOMAIN); ?></h1>

		</header>

		<section>
			
			<?php if ( count( $modules ) == 0 ) : ?>
				
				<?php $this->render("admin/settings/settings-welcome", array(
                    'user_name' => $user_name
                )); ?>
				
			<?php else : ?> 
				
				<div class="row">
					
					<section class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
						
						<?php if ( $is_e_newsletter_active ){ ?>
							
							<div id="enews-sync-box" class="box content-box">
								
								<?php $this->render( "admin/settings/e-news-sync-front", array(
									"optins" => $optins,
									"enews_sync_state_toggle_nonce" => $enews_sync_state_toggle_nonce,
									"enews_sync_setup_nonce" => $enews_sync_setup_nonce
								) ); ?>
								
							</div>
							
							<?php $this->render("admin/settings/e-news-sync-back"); ?>
							
						<?php } ?>
						
						<div class="box content-box" id="modules-activity">
							
							<?php
								$this->render( "admin/settings/modules", array(
									"modules" => $modules,
									"modules_state_toggle_nonce" => $modules_state_toggle_nonce
								) );
							?>
							
						</div>
						
					</section>
					
				</div>
				
			<?php endif; ?>

		</section>

	</div>

</div>