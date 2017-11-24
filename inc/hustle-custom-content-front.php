<?php


class Hustle_Custom_Content_Front
{
    private $_hustle;

    private $_module_handles = array();

    private $_styles;

	private $after_content = array();

	const Widget_CSS_CLass = "inc_cc_widget_wrap inc_cc";
    const Shortcode_CSS_CLass = "inc_cc_shortcode_wrap inc_cc";
	
	const SHORTCODE = "wd_hustle_cc";


    function __construct( Opt_In $hustle )
    {

        $this->_hustle = $hustle;
        add_shortcode(self::SHORTCODE, array( $this, "shortcode" ));

		add_filter( 'hustle_front_handler', array( $this, 'has_cc' ) );
        
        if( is_admin() ) return;

        // Enqueue it in the footer to overrider all the css that comes with the popup
        add_action('wp_footer', array($this, "register_styles"));

        add_action('template_redirect', array($this, "create_modules"), 0);

        add_action("wp_footer", array($this, "add_modal_template"));
		
        add_action("wp_footer", array($this, "add_shortcode_template"));

        add_filter("hustle_register_scripts", array( $this, "register_modules" ));
		
		add_filter( "the_content", array( $this, "add_after_content_template" ), 20);
    }

	/**
	 * Check if current page has renderable opt-ins.
	 **/
	function has_cc( $return ) {
		$found = ! empty( $this->_module_handles );

		if ( $found ) {
			$return = $found;
		}

		return $return;
	}

    function register_modules( $modules ){
        wp_localize_script('optin_front', 'Hustle_Custom_Contents', $this->_module_handles);
    }


    function register_styles()
    {
        $this->_inject_styles();
    }

    /**
     * Enqueues popups to be displayed
     *
     *
     */
    function create_modules()
    {

        global $post;
        $categories_array = $this->_get_term_ids($post, "category");
        $tags_array = $this->_get_term_ids($post, "post_tag");
        $enque_adblock_detector  = false;

        /**
         * @var $module Hustle_Custom_Content_Model
         */

        foreach ( Hustle_Custom_Content_Collection::instance()->get_all( true ) as $module) {

            if( !$module->display ) continue;

            $handle = $this->_get_unique_id();

            $this->_module_handles[$handle]["design"] = $module->get_design()->to_array();
            $this->_module_handles[$handle]["content"] = $module->get_data();
            $this->_module_handles[$handle]["tracking_types"] = $module->get_tracking_types();
            $this->_module_handles[$handle]["settings"] = $module->settings;
			$after_content = $this->_module_handles[$handle]["after_content"] = $module->get_after_content()->to_array();
            $popup = $this->_module_handles[$handle]["popup"] = $module->get_popup()->to_array();
            $slide_in = $this->_module_handles[$handle]["slide_in"] = $module->get_slide_in()->to_array();
            $magic_bar = $this->_module_handles[$handle]["magic_bar"] = $module->get_magic_bar()->to_array();
            $should_display = $this->_module_handles[$handle]["should_display"] = $module->get_types_display_conditions();
            $this->_styles .= $module->get_decorated()->get_styles();
			
			// only the enabled and allowed After Content module should be added
			if ( ! empty( $after_content ) && isset( $after_content['enabled'] ) && ( $after_content['enabled'] == 'true' || (int) $after_content['enabled'] > 0 ) && $should_display['after_content'] ) {
				$this->after_content[ $handle ] = $after_content;
			}

            if(
                ( isset( $popup['triggers'], $popup['triggers']['trigger'] ) && $popup['triggers']['trigger'] === "adblock" && in_array( $popup['triggers']['on_adblock'], array(1, "1", "true", true, "on") ) ) ||
                (  isset( $slide_in['triggers'], $slide_in['triggers']['trigger'] ) && $slide_in['triggers']['trigger'] === "adblock" && in_array( $slide_in['triggers']['on_adblock'], array(1, "1", "true", true, "on") ) ) ||
                (  isset( $magic_bar['triggers'], $magic_bar['triggers']['trigger'] ) && $magic_bar['triggers']['trigger'] === "adblock" && in_array( $slide_in['triggers']['on_adblock'], array(1, "1", "true", true, "on") ) )
            )
                $enque_adblock_detector = true;
        }

        if( $enque_adblock_detector )
            wp_enqueue_script('hustle_front_ads', $this->_hustle->get_static_var( 'plugin_url' ) . 'assets/js/ads.js', array(), $this->_hustle->get_const_var( 'VERSION' ), true );
    }

    /**
     * Returns array of terms ids based on $post and $tax
     *
     * @param $post WP_Post|int
     * @param $tax string taxonomy
     * @return array of term ids
     */
    private function _get_term_ids( $post, $tax ){

        $func = create_function('$obj', 'return (string)$obj->term_id;');
        $terms = get_the_terms( $post, $tax );
        return array_map( $func, empty( $terms ) ? array( ) : $terms );
    }


    private function _get_unique_id()
    {
        return uniqid("Hustle_CC");
    }

    private function _inject_styles(){
        ?>
        <style type="text/css" id="hustle-cc-styles"><?php echo $this->_styles; ?></style>
        <?php
    }

    /**
     * Adds needed layouts
     *
     * @since 2.0
     */
    function add_modal_template(){
		if ( empty( $this->_module_handles ) ) {
			return;
		}

        $this->_hustle->render("general/modal" );
    }

	function add_shortcode_template(){
		if ( empty( $this->_module_handles ) ) {
			return;
		}

		$this->_hustle->render("general/layouts/cc_shortcode" );
	}
	
	/**
     * Shortcode for Custom Content
     *
     * @since 2.0
     */
	function shortcode( $atts, $content, $a ) {
		$atts = shortcode_atts( array(
            'id' => '',
            "type" => ""
        ), $atts, self::SHORTCODE );

        $type = trim( $atts['type'] );
        if( empty( $atts['id'] ) ) return "";
		
		$cc = Hustle_Custom_Content_Model::instance()->get_by_shortcode( $atts['id'] );

        if( !$cc || !$cc->active ) return "";
		
		return sprintf("<div class='%s' data-id='%s'></div>", self::Shortcode_CSS_CLass . " inc_cc_" . $cc->id, $cc->id);
	}
	
	/**
     * After Content Module for Custom Content
     * - conditions already handled on create_modules function
     * @since 2.1
     */
	function add_after_content_template( $content ) {

		if ( isset( $_REQUEST['fl_builder'] ) ) {
			return $content;
		}
		
		foreach ( $this->after_content as $uniq_id => $after_content ) {
			$content .= sprintf( '<div id="cc-%s" data-id="%s" class="cc-after-content"></div>', $uniq_id, $uniq_id );
			
		}
		
		remove_filter("the_content", array($this, "add_after_content_template"));

		return $content;
	}
}