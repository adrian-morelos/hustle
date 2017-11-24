<script id="wpoi-social-sharing-message-box-tpl" type="text/template">
	
	<label><?php _e('You can configure <strong>Floating Social</strong> in the section that follows. Widget with your Social Sharing can be set-up in <strong>Appearance</strong> » <strong><a href="">Widgets</a></strong>.', Opt_In::TEXT_DOMAIN); ?></label>
	
	<label><?php _e('Use the following shortcode to embed your Social Sharing module anywhere:', Opt_In::TEXT_DOMAIN); ?></label>
	
	<div class="wph-shortcode">[wd_hustle_ss id="{{shortcode_id}}"]</div>
	
</script>

<div id="wph-social-sharing--display_settings_tab" class="wph-toggletabs <?php echo ( isset( $_GET['tab'] ) && $_GET['tab'] == 'display' ) ?  'wph-toggletabs--open' : ''; ?>">
	
	<header class="wph-toggletabs--title can-open">
		
		<h4><?php _e('Display Settings', Opt_In::TEXT_DOMAIN); ?></h4>
		
		<span class="open"><i class="wph-icon i-arrow"></i></span>
		
	</header>
	
	<section class="wph-toggletabs--content">
		
		<div id="wph-social-sharing--information" class="row">
			
			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
				
				<h5><?php _e('Information', Opt_In::TEXT_DOMAIN); ?></h5>
				
			</div>
			
			<div id="wph-social-sharing--messagebox" class="col-xs-12 col-sm-9 col-md-9 col-lg-9"></div>
			
		</div><!-- #wph-social-sharing--information -->
		
		<?php $this->render("admin/social_sharing/social-sharing-floating"); ?>

		<div id="wph-social-sharing--floating-social" class="row">
			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
				<h5><?php _e('Floating Social', Opt_In::TEXT_DOMAIN); ?></h5>
			</div>
			<div id="wph-social-sharing--floating-social-container" class="col-xs-12 col-sm-9 col-md-9 col-lg-9"></div>
		</div><!-- #wph-social-sharing--floating-social -->
		
	</section>
	
	<footer class="wph-toggletabs--footer">
		
		<div class="row">
			
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				
				<button class="wph-button ss-back wph-button--filled wph-button--gray "><?php _e('Back', Opt_In::TEXT_DOMAIN); ?></button>
				
			</div>
			
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				
				<button class="wph-button ss-save-changes wph-button-save wph-button--filled wph-button--blue" data-id="<?php echo isset(  $_GET['id'] ) ? $_GET['id']: '-1'; ?>" data-nonce="<?php echo wp_create_nonce('hustle_social_sharing_save'); ?>" >
					
					<span class="off-action"><?php _e('Save Changes', Opt_In::TEXT_DOMAIN); ?></span>
					
					<span class="on-action"><?php _e('Saving...', Opt_In::TEXT_DOMAIN); ?></span>
					
				</button>
				
				<button class="wph-button ss-finish wph-button-finish wph-button--filled wph-button--gray" data-id="<?php echo isset(  $_GET['id'] ) ? $_GET['id']: '-1'; ?>" data-nonce="<?php echo wp_create_nonce('hustle_social_sharing_save'); ?>" >
					
					<span class="off-action"><?php _e('Finish Setup', Opt_In::TEXT_DOMAIN); ?></span>
					
					<span class="on-action"><?php _e('Saving...', Opt_In::TEXT_DOMAIN); ?></span>
					
				</button>
				
			</div>
			
		</div>
		
	</footer>
	
</div><!-- #wph-ccontent--settingstab -->