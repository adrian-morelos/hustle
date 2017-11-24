<div id="hustle-cc-listings" class="hustle-two">
	
	<div id="container"<?php if ( count( $custom_contents ) !== 0 ) : echo ' class="container-980"'; endif; ?>>
		
		<header id="header"<?php if ( ( count( $custom_contents ) === 0 ) ) : echo ' class="no-margin-btm"'; endif;?>>
			
			<?php if ( count( $custom_contents ) === 0 ){ ?>
				
				<h1><?php _e('Custom Content Dashboard', Opt_In::TEXT_DOMAIN); ?></h1>
				
			<?php } else { ?>
				
				<h1><?php _e('Custom Content Dashboard', Opt_In::TEXT_DOMAIN); ?><a class="wph-button wph-button--small wph-button--gray wph-button--inline" href="<?php echo esc_url( $add_new_url ); ?>"><?php _e('New Custom Content', Opt_In::TEXT_DOMAIN); ?></a></h1>
				
			<?php } ?>
			
		</header>
		
		<section>

			<section id="wph-ccontent--modules">
				
				<?php if ( count( $custom_contents ) === 0 ){ ?>
					
					<?php $this->render("admin/ccontent/ccontent-welcome", array(
                        'new_url' => $add_new_url,
                        'user_name' => $user_name
                    )); ?>
					
				<?php } ?>

				<?php /*if( $legacy_popups && false ): ?>
					
					<h4><?php _e('Custom Content Modules', Opt_In::TEXT_DOMAIN); ?></h4>
					
				<?php endif;*/ ?>
				
				<div class="row">
					
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						
						<?php $this->render("admin/ccontent/ccontent-listings", array(
							"custom_contents" => $custom_contents,
							'types' => $types,
							'new_cc' =>  isset( $_GET['new_id'] ) ? $_GET['new_id'] : null,
							'updated_cc' =>  isset( $_GET['updated_id'] ) ? $_GET['updated_id'] : null
						)); ?>
						
					</div>
					
				</div>
				
			</section>
			
			<?php /*if( $legacy_popups && false ): ?>
				
				<section id="wph-ccontent--migration">
					
					<h4><?php _e('Legacy Pop-ups', Opt_In::TEXT_DOMAIN); ?></h4>
					
					<?php $this->render("admin/ccontent/ccontent-migration", array("popups" => $legacy_popups)); ?>
					
				</section>
				
			<?php endif;*/ ?>
			
		</section>
		
	</div>
	
</div>
