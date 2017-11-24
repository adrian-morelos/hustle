<script id="wpoi-custom-content-message-box-tp" type="text/template">
	
	<label><?php _e('You can configure <strong>After Content</strong>, <strong>Pop-up</strong> and <strong>Slide-in</strong> opt-ins in the section that follows. Widget with your Custom Content can be set-up in <strong>Appearance</strong> » <strong><a href="">Widgets</a></strong>.', Opt_In::TEXT_DOMAIN); ?></label>
	
	<label><?php _e('Use the following shortcode to embed your Custom Content module anywhere:', Opt_In::TEXT_DOMAIN); ?></label>
	
	<div class="wph-shortcode">[wd_hustle_cc id="{{shortcode_id}}"]</div>
	
</script>

<div id="wph-ccontent--settingstab" class="wph-toggletabs <?php echo ( isset( $_GET['tab'] ) && $_GET['tab'] == 'display' ) ?  'wph-toggletabs--open' : ''; ?>">
	
	<header class="wph-toggletabs--title can-open">
		
		<h4><?php _e('Display Settings', Opt_In::TEXT_DOMAIN); ?></h4>
		
		<span class="open"><i class="wph-icon i-arrow"></i></span>
		
	</header>
	
	<section class="wph-toggletabs--content">
		
		<div id="wph-ccontent--information" class="row">
			
			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
				
				<h5><?php _e('Information', Opt_In::TEXT_DOMAIN); ?></h5>
				
			</div>
			
			<div id="wph-ccontent--messagebox" class="col-xs-12 col-sm-9 col-md-9 col-lg-9"></div>
			
		</div><!-- #wph-ccontent--information -->
		
		<?php $this->render("admin/ccontent/ccontent-after-content"); ?>

		<?php $this->render("admin/ccontent/ccontent-popup"); ?>
		
		<?php $this->render("admin/ccontent/ccontent-slidein"); ?>

		<div id="wph-ccontent--after-content" class="row">
			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
				<h5><?php _e('After Content', Opt_In::TEXT_DOMAIN); ?></h5>
			</div>
			<div id="wph-ccontent-after-content-container" class="col-xs-12 col-sm-9 col-md-9 col-lg-9"></div>
		</div><!-- #wph-ccontent--after-content -->

		<div id="wph-ccontent--popup" class="row">
			
			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
				
				<h5><?php _e('Pop-up', Opt_In::TEXT_DOMAIN); ?></h5>
				
			</div>
			
			<div id="wph-ccontent-popup-container" class="col-xs-12 col-sm-9 col-md-9 col-lg-9"></div>

		</div><!-- #wph-ccontent--popup -->
		
		<div id="wph-ccontent--slidein" class="row">
			
			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
				
				<h5><?php _e('Slide-in', Opt_In::TEXT_DOMAIN); ?></h5>
				
			</div>
			
			<div id="wph-ccontent-slide_in-container" class="col-xs-12 col-sm-9 col-md-9 col-lg-9"></div>

		</div><!-- #wph-ccontent--slidein -->
		
<!--		<div id="wph-ccontent--magicbar" class="wph-flex wph-flex--row">-->
<!---->
<!--			<div class="wph-flex--side wph-flex--title">-->
<!---->
<!--				<h5>--><?php //_e('Magic Bar', Opt_In::TEXT_DOMAIN); ?><!--</h5>-->
<!---->
<!--			</div>-->
<!---->
<!--			<div class="wph-flex--box" id="wph-ccontent-magic_bar-container"></div>-->
<!---->
<!--		</div>-->
		
	</section>
	
	<footer class="wph-toggletabs--footer">
		
		<div class="row">
			
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				
				<button class="wph-button wph-button--filled wph-button--gray wph-js-back"><?php _e('Back', Opt_In::TEXT_DOMAIN); ?></button>
				
			</div>
			
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				
				<button class="wph-button wph-button-save wph-button--filled wph-button--blue" data-id="<?php echo isset(  $_GET['id'] ) ? $_GET['id']: '-1'; ?>" data-nonce="<?php echo wp_create_nonce('hustle_custom_content_save'); ?>" id="save-and-finish" >
					
					<span class="off-action"><?php _e('Save Changes', Opt_In::TEXT_DOMAIN); ?></span>
					
					<span class="on-action"><?php _e('Saving...', Opt_In::TEXT_DOMAIN); ?></span>
					
				</button>
				
				<button class="wph-button wph-button-finish wph-button--filled wph-button--gray" data-id="<?php echo isset(  $_GET['id'] ) ? $_GET['id']: '-1'; ?>" data-nonce="<?php echo wp_create_nonce('hustle_custom_content_save'); ?>" id="finish-setup">
					
					<span class="off-action"><?php _e('Finish Setup', Opt_In::TEXT_DOMAIN); ?></span>
					
					<span class="on-action"><?php _e('Saving...', Opt_In::TEXT_DOMAIN); ?></span>
					
				</button>
				
			</div>
			
		</div>
		
	</footer>
	
</div><!-- #wph-ccontent--settingstab -->