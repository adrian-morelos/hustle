<?php
/**
 * @var $popups WP_Post[]
 */
?>
<ul class="wph-accordions">

	<?php foreach( $popups as $popup ): ?>
		<li class="wph-accordions--item wph-accordion--closed">

		<header>

			<div class="toggle">

				<input data-nonce="<?php echo wp_create_nonce('custom-content-legacy-toggle-activity'); ?>" id="custom-content-legacy-toggle-activity-<?php echo esc_attr( $popup->ID ); ?>" class="toggle-checkbox custom-content-legacy-toggle-activity" type="checkbox" data-id="<?php echo esc_attr( $popup->ID ); ?>" <?php checked( $popup->post_status, "publish" ); ?> >

				<label class="toggle-label" for="custom-content-legacy-toggle-activity-<?php echo esc_attr( $popup->ID ); ?>"></label>

			</div>

			<label class="wph-label--module"><?php echo Hustle_Legacy_Popups::get_title( $popup ); ?></label>

			<div class="wph-accordion--buttons">

				<button class="wph-button wph-button--small wph-button--gray wph-button-legacy-migrate-btn" data-id="<?php echo esc_attr( $popup->ID ); ?>" data-nonce="<?php echo wp_create_nonce('custom-content-legacy-popup-migrate'); ?>" ><?php _e('Re-build as Custom Content', Opt_In::TEXT_DOMAIN); ?></button>

				<button class="wph-button wph-button--small wph-button--gray  wph-button-legacy-quickedit-btn" ><?php _e('Quick Edit', Opt_In::TEXT_DOMAIN); ?></button>

				<button class="wph-button wph-button--small wph-button--red" href=""><?php _e('Delete', Opt_In::TEXT_DOMAIN); ?></button>

			</div>

		</header>

		<section class="wph-accordion--padding wph-accordion-legacy--quickedit">
			<div class="wph-flex">

				<div class="wph-flex--side wph-flex--stats">

					<label class="wph-label--alt"><?php _e('Heading (Optional):', Opt_In::TEXT_DOMAIN); ?></label>

					<input type="text" class="hustle-custom-content-legacy-popup-heading" placeholder="<?php _e('Pop-up heading', Opt_In::TEXT_DOMAIN); ?>" value="<?php echo Hustle_Legacy_Popups::get_heading( $popup ); ?>" >

					<label class="wph-label--alt"><?php _e('Subheading (Optional):', Opt_In::TEXT_DOMAIN); ?></label>

					<input type="text" class="hustle-custom-content-legacy-popup-subheading" placeholder="<?php _e('Option pop-up  subheading', Opt_In::TEXT_DOMAIN); ?>"  value="<?php echo Hustle_Legacy_Popups::get_subheading( $popup ); ?>">

				</div>

				<div class="wph-flex--box">

					<label class="wph-label--alt"><?php _e('Content:', Opt_In::TEXT_DOMAIN); ?></label>


					<textarea class="hustle-custom-content-legacy-popup-content"><?php echo Hustle_Legacy_Popups::get_content( $popup ); ?></textarea>

					<button type="submit" data-nonce="<?php echo wp_create_nonce('custom-content-legacy-popup-quick-edit-save'); ?>" data-id="<?php echo esc_attr( $popup->ID ); ?>" class="wph-button wph-button--small wph-button--gray wph-module--save custom-content-legacy-popup-save-quickedit"><?php _e("Save changes", Opt_In::TEXT_DOMAIN); ?></button>
				</div>

			</div>
		</section>

	</li>
	<?php endforeach; ?>

</ul>