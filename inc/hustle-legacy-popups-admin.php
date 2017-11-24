<?php
/**
 * Migrate PopUps
 *
 * @class Hustle_Legacy_Popups_Admin
 **/
class Hustle_Legacy_Popups_Admin {
	private static $_hustle;

	private static $is_seen = false;

	private static $is_free = false;

	private static $popup_pro_update_seen = false;

	public function __construct( Opt_In $hustle ) {
		self::$_hustle = $hustle;

		// Set or check if the message has seen
		add_action( 'admin_init', array( __CLASS__, 'update_seen' ) );

		// Load popup message if first time update
		add_action( 'admin_footer', array( __CLASS__, 'maybe_first_time' ) );
	}

	/**
	 * @note: Development purposes only
	 **/
	private static function reset() {
		delete_option( 'hustle_popup_update_seen' );
	}

	/**
	 * Set or check if update notice is seen
	 **/
	public static function update_seen() {
		self::$is_free = Opt_In_Utils::_is_free();

		self::$is_seen = get_option( 'hustle_popup_update_seen', false );

		if ( isset( $_REQUEST['_wpnonce'] ) && wp_verify_nonce( $_REQUEST['_wpnonce'], 'hustle-popup-update' ) ) {
			self::$is_seen = true;
			update_option( 'hustle_popup_update_seen', true );

			$return_url = add_query_arg( 'page', 'inc_hustle_custom_content', remove_query_arg( '_wpnonce' ) );
			wp_safe_redirect( $return_url );
		}

		self::$popup_pro_update_seen = get_option( 'hustle_popup_pro_seen', false );

		if ( isset( $_REQUEST['_wpnonce'] ) && wp_verify_nonce( $_REQUEST['_wpnonce'], 'hustle-popup-pro-update' ) ) {
			self::$is_seen = true;
			update_option( 'hustle_popup_pro_seen', true );

			$return_url = add_query_arg( 'page', 'inc_hustle_custom_content', remove_query_arg( '_wpnonce' ) );
			wp_safe_redirect( $return_url );
		}
	}

	/**
	 * Show update notice for the first time
	 **/
	public static function maybe_first_time() {
		$show = false;

		if ( self::$is_free && false === self::$is_seen ) {
			$gotcha_url = add_query_arg( '_wpnonce', wp_create_nonce( 'hustle-popup-update' ), admin_url( 'admin.php' ) );
			$show = 'admin/ccontent/ccontent-update';
		}

		/**
		 * Temp hide for final approval
		$base_plugin = basename( self::$_hustle->get_static_var( 'plugin_path' ) );

		if ( false === self::$popup_pro_update_seen && 'popover' === $base_plugin ) {
			$gotcha_url = add_query_arg( '_wpnonce', wp_create_nonce( 'hustle-popup-pro-update' ), admin_url( 'admin.php' ) );
			$show = 'admin/ccontent/ccontent-pro-update';
		}
		***/

		if ( $show ) {
			$plugin_url = self::$_hustle->get_static_var( "plugin_url" );
			self::$_hustle->render( $show, array(
				'image_url' => $plugin_url . 'assets/img/hero/wph-icon.png',
				'gotcha_url' => $gotcha_url,
				'custom_content_url' => add_query_arg( 'page', 'inc_hustle_custom_content', admin_url( 'admin.php' ) ),
			) );
			// Load CSS for non hustle pages
			wp_enqueue_style( 'wpoi_admin', $plugin_url . 'assets/css/admin.css', array(), self::$_hustle->get_const_var( "VERSION" ) );
		}
	}
}
