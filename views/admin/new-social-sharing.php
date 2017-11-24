<div class="hustle-two wph-sshare-wizard-view">
	
	<div id="container" class="container-980">
		
		<header id="header">
			
			<h1><?php _e('SOCIAL SHARING', Opt_In::TEXT_DOMAIN); ?></h1>
			
		</header>
		
		<section id="wph-sshare-wizard">
			
			<div class="row">
				
				<section class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					
					<div class="box content-box">
					
						<div class="box-title">
							
							<h3><?php _e('Create New Social Sharing Module', Opt_In::TEXT_DOMAIN); ?></h3>
							
						</div>
						
						<div class="box-content">
							
                            <!-- Name & Services -->
							<?php $this->render("admin/social_sharing/social-sharing-services"); ?>
                            
							<!-- Appearance -->
							<?php $this->render("admin/social_sharing/social-sharing-appearance"); ?>
							
							<!-- Display Settings -->
							<?php $this->render("admin/social_sharing/social-sharing-display-settings"); ?>
							
						</div>
						
					</div>
					
				</section>
				
			</div>
			
		</section>
		
	</div>
	
	<?php $this->render("admin/ccontent/ccontent-preview-container"); ?>
	
</div>

<?php $this->render("admin/settings/display-triggers"); ?>

<?php $this->render("admin/settings/conditions"); ?>
<?php $this->render("general/modal"); ?>
