<div id="wpoi-box-dashboard-optins" class="box">

	<div class="box-title">

		<h3><?php _e('Create a Pop-up, Slide-in, Widget, etc.', Opt_In::TEXT_DOMAIN); ?></h3>

	</div>

	<div class="box-content">
		
		<div class="row">
			
			<div class="col-xs-12">
				
				<h6><?php _e('Choose below to create a simple email opt-in or a custom content module for something like an ad.', Opt_In::TEXT_DOMAIN); ?></h6>
				
				<table class="wph-table wph-dashboard--steps">
		
					<tbody>
		
						<?php //if( true || !$has_optins ): ?>
		
							<tr>
		
								<td class="wph-dashstep--icon">
		
									<div class="wph-icon i-optin"></div>
		
								</td>
		
								<td class="wph-dashstep--info">
		
									<span class="wph-table--title"><?php _e('Opt-ins', Opt_In::TEXT_DOMAIN); ?></span>
									<span class="wph-table--subtitle"><?php _e('Capture visitors\' email addresses with a pop-up, slide-in, widget, or shortcode.', Opt_In::TEXT_DOMAIN); ?></span>
		
								</td>
		
								<td class="wph-dashstep--create">
		
									<a href="admin.php?page=inc_optin" class="wph-button wph-button--small wph-button--gray wph-dashboard--create"><?php _e('Create', Opt_In::TEXT_DOMAIN); ?></a>
		
								</td>
		
							</tr><!-- Opt Ins -->
		
						<?php //endif; ?>
		
						<?php //if( true || !$has_custom_content ): ?>
		
							<tr>
		
								<td class="wph-dashstep--icon">
		
									<div class="wph-icon i-magic"></div>
		
								</td>
		
								<td class="wph-dashstep--info">
		
									<span class="wph-table--title"><?php _e('Custom Content', Opt_In::TEXT_DOMAIN); ?></span>
									<span class="wph-table--subtitle"><?php _e('Create any sort of pop-up, slide-in, widget, or shortcode. For example: An advertisement or promotion.', Opt_In::TEXT_DOMAIN); ?></span>
		
								</td>
		
								<td class="wph-dashstep--create">
		
									<a href="<?php echo esc_url(add_query_arg( array(
										"page" => "inc_hustle_custom_content",
										"id" => "-1"
									))); ?>" class="wph-button wph-button--small wph-button--gray wph-dashboard--create"><?php _e('Create', Opt_In::TEXT_DOMAIN); ?></a>
		
								</td>
		
							</tr><!-- Custom Content -->
		
						<?php //endif; ?>
		
						<?php //if( !$has_social_sharing ): ?>
		
							<tr>
		
								<td class="wph-dashstep--icon">
		
									<div class="wph-icon i-sharing"></div>
		
								</td>
		
								<td class="wph-dashstep--info">
		
									<span class="wph-table--title"><?php _e('Social Sharing', Opt_In::TEXT_DOMAIN); ?></span>
									<span class="wph-table--subtitle"><?php _e('Set-up a set of Social Sharing icons to display throughout your site.', Opt_In::TEXT_DOMAIN); ?></span>
		
								</td>
		
								<td class="wph-dashstep--create">
		
                                    <a href="<?php echo esc_url(add_query_arg( array(
										"page" => "inc_hustle_social_sharing",
										"id" => "-1"
									))); ?>" class="wph-button wph-button--small wph-button--gray wph-dashboard--create"><?php _e('Create', Opt_In::TEXT_DOMAIN); ?></a>
		
								</td>
		
							</tr><!-- Social Sharing -->
		
						<?php //endif; ?>
		
						<?php if( !$has_social_rewards ): ?>
		
							<tr>
		
								<td class="wph-dashstep--icon">
		
									<div class="wph-icon i-rewards"></div>
		
								</td>
		
								<td class="wph-dashstep--info">
		
									<span class="wph-table--title"><?php _e('Social Rewards', Opt_In::TEXT_DOMAIN); ?></span>
									<span class="wph-table--subtitle"><?php _e('Reward content to be unlocked with a Share or Email Address.', Opt_In::TEXT_DOMAIN); ?></span>
		
								</td>
		
								<td class="wph-dashstep--create">
		
									<a href="" class="wph-button wph-button--small wph-button--gray wph-dashboard--create"><?php _e('Create', Opt_In::TEXT_DOMAIN); ?></a>
		
								</td>
		
							</tr><!-- Social Rewards -->
		
						<?php endif; ?>
						
						<tfoot>
							
							<tr>
								
								<td colspan="3"><?php _e('Choose your display options after selecting one of the above.', Opt_In::TEXT_DOMAIN); ?></td>
								
							</tr>
							
						</tfoot>
		
					</tbody>
		
				</table>
				
			</div>
			
		</div>

	</div>

</div>