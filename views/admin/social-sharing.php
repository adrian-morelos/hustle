<div id="hustle-social-sharing-listings" class="hustle-two">
	
	<div id="container"<?php if ( count( $social_groups ) !== 0 ) : echo ' class="container-980"'; endif; ?>>
		
		<header id="header"<?php if ( ( count( $social_groups ) === 0 ) ) : echo ' class="no-margin-btm"'; endif;?>>
			
			<?php if ( count( $social_groups ) === 0 ){ ?>
				
				<h1><?php _e('Social Sharing Dashboard', Opt_In::TEXT_DOMAIN); ?></h1>
				
			<?php } else { ?>
				
				<h1><?php _e('Social Sharing Dashboard', Opt_In::TEXT_DOMAIN); ?><a class="wph-button wph-button--small wph-button--gray wph-button--inline" href="<?php echo esc_url( $add_new_url ); ?>"><?php _e('New Sharing Module', Opt_In::TEXT_DOMAIN); ?></a></h1>
				
			<?php } ?>
			
		</header>
		
		<section>

			<section id="wph-ccontent--modules">
				
				<?php if ( count( $social_groups ) === 0 ){ ?>
					
					<?php $this->render("admin/social_sharing/social-sharing-welcome", array(
                        'new_url' => $add_new_url,
                        'user_name' => $user_name
                    )); ?>
					
				<?php } ?>
				
				<div class="row">
					
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<?php $this->render("admin/social_sharing/social-sharing-listings", array(
							'social_groups' => $social_groups,
                            'types' => $types,
							'new_ss' =>  isset( $_GET['new_id'] ) ? $_GET['new_id'] : null,
							'updated_ss' =>  isset( $_GET['updated_id'] ) ? $_GET['updated_id'] : null
						)); ?>
						
					</div>
					
				</div>
				
			</section>
			
		</section>
		
	</div>
	
</div>