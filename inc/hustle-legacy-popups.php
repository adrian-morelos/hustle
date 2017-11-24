<?php

/**
 * Class Hustle_Legacy_Popups
 *
 * @class Hustle_Legacy_Popups
 */
class Hustle_Legacy_Popups
{
    /**
     * @var $_query WP_Query
     */
    private $_query;
	private static $popup_found = 0;

	/**
	 * @var (object) Opt_In class instance
	 **/
	private $_hustle;

    public function __construct( Opt_In $hustle )
    {
		$this->_hustle = $hustle;

		add_action( 'init', array( $this, 'do_migration' ) );
    }

	public function do_migration() {
		$done = get_option( 'hustle_popup_migrated', false );

		if ( false === $done || empty( $done ) ) {
			$popups = $this->get_all();
			array_map( array( __CLASS__, 'migrate' ), $popups );
			
			if ( empty( self::$popup_found ) ) {
				update_option( 'hustle_popup_update_seen', true );
				update_option( 'hustle_legacy_notice_dismissed', true );
			}
		}

		/**
		 * Temp hide until approval
		$base_plugin = basename( $this->_hustle->get_static_var( 'plugin_path' ) );

		if ( 'popover' == $base_plugin ) {
			$pro_done = get_option( 'hustle_popover_pro_migrated', false );

			if ( false === $pro_done || empty( $pro_done ) ) {
				$popups = $this->get_all();
				array_map( array( __CLASS__, 'migrate' ), $popups );

				if ( empty( self::$popup_found ) ) {
					update_option( 'hustle_popover_pro_migrated', true );
				}
			}
		}
		**/
	}

	public static function migrate( $popup ) {

		$cc = new Hustle_Custom_Content_Model();

        $name = self::get_title( $popup );
        $heading = self::get_heading( $popup );
        $subheading = self::get_subheading( $popup );

        $cc->optin_name = $name;
		$cc->optin_title = $heading;
        $cc->optin_message = self::get_content( $popup );
        $cc->active = $popup->post_status === "publish";
        $cc->blog_id = get_current_blog_id();
		$cc->optin_provider = $cc->get_optin_provider();
        $cc->test_mode = 0;

        $cc->save();

        $design = wp_parse_args( self::get_design_data( $popup ) , $cc->get_design()->to_array() );
        $cc->add_meta( "design",  $design);

        $popup_settings = wp_parse_args( self::get_settings_data( $popup ), $cc->get_popup()->to_array() );

        $cc->add_meta( "popup", $popup_settings );
        $cc->add_meta( "slide_in", $cc->get_slide_in()->to_json() );
        $cc->add_meta( "magic_bar", $cc->get_magic_bar()->to_json() );

        $cc->add_meta("po_title", $heading);
        $cc->add_meta("subtitle", $subheading);
        $cc->add_meta("legacy", true);

        update_post_meta( $popup->ID, "hustle_migrated", true );
	}

    /**
     * Returns array of all legacy popups
     *
     * @param int $posts_per_page
     * @return array
     */
    public function get_all( $posts_per_page = -1 ){
        $this->_query = get_posts(array(
            "post_type" => "inc_popup",
            "posts_per_page" => $posts_per_page,
            'meta_query' => array(
                array(
                    'key'     => 'hustle_migrated',
                    'compare' => 'NOT EXISTS',
                ),
            ),
			'suppress_filter' => true,
			'post_status' => 'any',
        ));

		self::$popup_found = count( $this->_query );

		if ( empty( self::$popup_found ) ) {
			update_option( 'hustle_popup_migrated', true );
			update_option( 'hustle_legacy_notice_dismissed', false );
			update_option( 'hustle_popover_pro_migrated', true );
		}

        return $this->_query;
    }

    /**
     * @return WP_Query
     */
    function get_query(){
        return $this->_query;
    }

    /**
     * @param WP_Post $popup
     * @return string
     */
    public static function get_content( WP_Post $popup ){
        return $popup->post_content;
    }

    /**
     * @param WP_Post $popup
     * @return string
     */
    public static function get_title( WP_Post $popup ){
        return $popup->post_title;
    }

    /**
     * @param WP_Post $popup
     * @return string
     */
    public static function get_heading( WP_Post $popup ){
        return get_post_meta( $popup->ID, 'po_title', true );
    }

    /**
     * @param WP_Post $popup
     * @return string
     */
    public static function get_subheading( WP_Post $popup ){
        return get_post_meta( $popup->ID, 'po_subtitle', true );
    }

    /**
     * @param $id
     * @return array|null|WP_Post
     */
    function get( $id ){
        return get_post( $id );
    }

    /**
     * Returns array containing design settings of the popup
     *
     * @param WP_Post $popup
     * @return array
     */
    static function get_design_data( WP_Post $popup  ){
		global $wpdb;

        $popup_id = $popup->ID;
		$data = array();
		$border_radius = get_post_meta( $popup_id, "po_round_corners", true ) ? 5 : 0;
		$cta_target = get_post_meta( $popup_id, 'po_cta_target', true );

		if ( preg_match( '%blank%', $cta_target ) ) {
			$cta_target = '_blank';
		}
		
		$customize_colors = get_post_meta( $popup_id, 'po_custom_colors', true ) ? true : false;
		$color1 = '';
		$color2 = '';

		if ( $customize_colors ) {
			$color = get_post_meta( $popup_id, 'po_color', true );

			if ( ! empty( $color ) ) {
				$color1 = $color['col1'];
				$color2 = $color['col2'];
			}
		}

		$custom_size = get_post_meta( $popup_id, 'po_custom_size', true ) ? true : false;
		$width = 0;
		$height = 0;

		if ( $custom_size ) {
			$size = get_post_meta( $popup_id, 'po_size', true );
			$width = intval( $size['width'] );
			$height = intval( $size['height'] );
		}
		
		$show_image_on_mobile = (bool) get_post_meta( $popup_id, 'po_image_mobile', true );
		$hide_image_on_mobile = ( $show_image_on_mobile ) ? false : true;

		$metas = array(
			'border' => get_post_meta( $popup_id, 'po_round_corners', true ),
			'border_radius' => $border_radius,
			'image' => get_post_meta( $popup_id, 'po_image', true ),
			'image_location' => get_post_meta( $popup_id, 'po_image_pos', true ),
			'image_position' => get_post_meta( $popup_id, 'po_image_pos', true ),
			'hide_image_on_mobile' => $hide_image_on_mobile,
			'cta_label' => get_post_meta( $popup_id, 'po_cta_label', true ),
			'cta_url' => get_post_meta( $popup_id, 'po_cta_link', true ),
			'style' => get_post_meta( $popup_id, 'po_style', true ),
			'customize_colors' => $customize_colors,
			'title_color' => $color1,
			'subtitle_color' => $color1,
			'link_static_color' => $color1,
			'cta_static_background' => $color1,
			'cta_static_color' => $color2,
			'customize_size' => $custom_size,
			'custom_height' => intval( $height ),
			'custom_width' => intval( $width ),
		);
		

		$custom_css = get_post_meta( $popup_id, 'po_custom_css', true );

		if ( ! empty( $custom_css ) ) {
			$custom_css = str_replace( '#popup', '', $custom_css );

			$css1 = explode( '}', $custom_css );
			$css1 = array_filter( $css1 );

			foreach( $css1 as $pos => $css2 ) {
				$css1[ $pos ] = substr( $css2, 0, strrpos( $css2, '{') );
			}

			if ( count( $css1 ) > 0 ) {
				foreach ( $css1 as $css3 ) {
					$css4 = explode( ',', $css3 );
					$css4 = array_filter( $css4 );

					foreach ( $css4 as $css ) {
						$selector = $css;
						$css_1 = $css;
						$css_2 = '';

						if ( preg_match( '|.popup|', $css ) ) {
							$css_1 = str_replace( '.popup', '.wpmu-modal.wpmu-modal-container .wph-modal--content', $css );
							$css_2 = str_replace( '.popup', '.wph-cc-shortcode .wph-cc-shortcode--content', $css );
						}

						if ( preg_match( '|.wdpu-title|', $css_1 ) ) {
							$css_1 = str_replace( '.wdpu-title', 'h2.wph-modal--title', $css_1 );
							$css_2 = str_replace( 'h2.wph-modal--title', 'h2.wph-cc-shortcode--title', empty( $css_2 ) ? $css_1 : $css_2 );
						}

						if ( preg_match( '|.wdpu-subtitle|', $css_1 ) ) {
							$css_1 = str_replace( '.wdpu-subtitle', 'h4.wph-modal--subtitle', $css_1 );
							$css_2 = str_replace( 'h4.wph-modal--subtitle', 'h4.wph-cc-shortcode--subtitle', empty( $css_2 ) ? $css_1 : $css_2 );
						}

						if ( preg_match( '|.wdpu-image|', $css_1 ) ) {
							$css_1 = str_replace( '.wdpu-image', '.wph-modal--message', $css_1 );
							$css_2 = str_replace( '.wph-modal--message', '.wph-cc-shortcode--image', empty( $css_2 ) ? $css_1 : $css_2 );
						}

						if ( preg_match( '|.wdpu-content|', $css_1 ) ) {
							$css_1 = str_replace( '.wdpu-content', '.wph-modal--message', $css_1 );
							$css_2 = str_replace( '.wph-modal--message', '.wph-cc-shortcode--message', empty( $css_2 ) ? $css_1 : $css_2 );
						}

						if ( preg_match( '|.wdpu-buttons|', $css_1 ) ) {
							$css_1 = str_replace( '.wdpu-buttons', '.wph-modal--clear', $css_1 );
						}

						if ( preg_match( '|.wdpu-cta|', $css_1 ) ) {
							$css_1 = str_replace( '.wdpu-cta', '.wph-modal--cta', $css_1 );
							$css_2 = str_replace( '.wph-modal--cta', '.wph-cc-shortcode--cta', empty( $css_2 ) ? $css_1 : $css_2 );
						}

						if ( preg_match( '|.wdpu-hide-forever|', $css_1 ) ) {
							$css_1 = str_replace( '.wdpu-hide-forever', '.wph-modal-never-see-again', $css_1 );
						}

						if ( preg_match( '|.wdpu-close|', $css_1 ) ) {
							$css_1 = str_replace( '.wdph-close', '.wph-modal--close a', $css_1 );
						}

						// Remove old classes
						$old = array( '.wdpu-inner', '.wdpu-head', '.wdpu-text', '.wdpu-msg-inner' );
						$css_1 = str_replace( $old, '', $css_1 );

						if ( ! empty( $css_2 ) ) {
							$css_2 = str_replace( $old, '', $css_2 );
							$css = $css_1 . ',' . $css_2;
						} else {
							$css = $css_1;
						}

						$custom_css = str_replace( $selector, $css, $custom_css );
					}
				}
			}
		}
		$metas['customize_css'] = ! empty( $custom_css );
		$metas['custom_css'] = $custom_css;

		return $metas;
    }

    /**
     * Retuns array containing the display/behaviour/rules/triggers for the popup
     *
     * @param WP_Post $popup
     * @return array
     */
    static function get_settings_data( WP_Post $popup ){
        $popup_id = $popup->ID;

        return array(
            "enabled" =>  1,
            "conditions" =>  self::_get_conditions_settings( $popup ),
            "triggers" =>  self::_get_trigger_settings( $popup ),
            "animation_in" =>  get_post_meta( $popup_id, "po_animation_in", true ),
            "animation_out" =>  get_post_meta( $popup_id, "po_animation_out", true ),
            "add_never_see_link" =>  get_post_meta( $popup_id, "po_can_hide", true ) ? true : false,
            "allow_scroll_page" =>  get_post_meta( $popup_id, "po_scroll_body", true ) ? true : false,
            "close_btn_as_never_see" =>  get_post_meta( $popup_id, "po_close_hides", true ) ? true : false,
            "expiration_days" =>  (int) get_post_meta( $popup_id, "po_hide_expire", true ),
			'not_close_on_background_click' => get_post_meta( $popup_id, 'po_overlay_close', true ) ? false : true,
			'on_submit' => get_post_meta( $popup_id, 'po_form_submit', true ),
        );
    }

    /**
     * Returns popup trigger settings with keys compatible with Hustle  Custom Content triggers
     *
     * @param WP_Post $popup
     * @return array
     */
    private static function _get_trigger_settings( WP_Post $popup ){
        $popup_id = $popup->ID;
        $saved_settings = (array) maybe_unserialize( get_post_meta( $popup_id, "po_display_data", true ) );
		$triggers = Hustle_Custom_Content_Meta::$triggers_default;

		$display = get_post_meta( $popup_id, 'po_display', true );
		$time = 'time';

		if ( 'delay' == $display ) {
			$display = 'time';
			$delay = (int) $saved_settings['delay'];

			if ( 0 == $delay ) {
				$time = 'immediately';
			}
		}

		$triggers['trigger'] = 'anchor' == $display ? 'scrolled' : $display;
		$triggers['on_time'] = $time;
		$triggers['on_time_delay'] = (int) $saved_settings['delay'];
		$triggers['on_time_unit'] = 's' == $saved_settings['delay_type'] ? 'seconds' : 'minutes';

		// Scroll
		$triggers['on_scroll'] = 'anchor' == $display ? 'selector' : 'scrolled';
		$triggers['on_scroll_page_percent'] = (int) $saved_settings['scroll'];
		$triggers['on_scroll_css_selector'] = $saved_settings['anchor'];

        return $triggers;
    }

    private static function _get_conditions_settings( WP_Post $popup ){
		$conditions = array();
        $popup_id = $popup->ID;
        $rules = (array) maybe_unserialize( get_post_meta( $popup_id, "po_rule", true ) );
        $rules_data = (array) maybe_unserialize( get_post_meta( $popup_id, "po_rule_data", true ) );

        $map = array(
            "login" => "visitor_logged_in",
            "no_login" => "visitor_not_logged_in",
            "count" => "shown_less_than",
            "mobile" => "only_on_mobile",
            "no_mobile" => "not_on_mobile",
            "referrer" => "from_specific_ref",
            "no_internal" => "not_from_internal_link",
            "searchengine" => "from_search_engine",
           // "no_prosite" => "no_prosite",
            "url" => "on_specific_url",
            "comment" => "visitor_has_commented",
            "country" => "in_a_country",
            "no_referrer" => "not_from_specific_ref",
            "no_url" => "not_on_specific_url",
            "no_comment" => "visitor_has_never_commented",
            "no_country" => "not_in_a_country"
        );

        foreach( $rules as $rule_name ){
			if ( isset( $map[ $rule_name ] ) ) {
				
				// handling specific urls and referrers
				if ( isset( $rules_data[$rule_name] ) ) {
					if ( $rule_name == "url" || $rule_name == "no_url" ) {
						$url_rules = array(
							"urls" => implode( "\n", $rules_data[$rule_name] )
						);
						$rules_data[$rule_name] = str_replace("\r","",$url_rules);
					}
					if ( $rule_name == "referrer" || $rule_name == "no_referrer" ) {
						$ref_rules = array(
							"refs" => implode( "\n", $rules_data[$rule_name] )
						);
						$rules_data[$rule_name] = str_replace("\r","",$ref_rules);
					}
				}
				
				$conditions[ $map[ $rule_name ] ] = isset( $rules_data[ $rule_name ] ) ? $rules_data[ $rule_name ]  : true;
			}
        }

        return $conditions;
    }
}