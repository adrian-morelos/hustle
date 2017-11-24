<?php

class Opt_In_Front
{

    private $_hustle;

    private $_optin_handles = array();
    private $_optin_layouts = array();
    private $_args_layouts = array();

    private $_styles;

    const Widget_CSS_CLass = "inc_opt_widget_wrap inc_optin";
    const Shortcode_CSS_CLass = "inc_opt_shortcode_wrap inc_optin";
    const Shortcode_Trigger_CSS_CLass = "inc_opt_hustle_shortcode_trigger";
    const AfterContent_CSS_CLass = "inc_opt_after_content_wrap wpoi-animation inc_optin";

    const SHORTCODE = "wd_hustle";

    function __construct( Opt_In $hustle )
    {

        $this->_hustle = $hustle;
        add_action( 'widgets_init', array( $this, 'register_widget' ) );
        
        add_shortcode(self::SHORTCODE, array( $this, "shortcode" ));

        if( is_admin() ) return;

        add_action('wp_enqueue_scripts', array($this, "register_scripts"));
        // Enqueue it in the footer to overrider all the css that comes with the popup
        add_action('wp_footer', array($this, "register_styles"));

        add_action('template_redirect', array($this, "create_popups"), 0);

        add_action("wp_footer", array($this, "add_layout_templates"));

        add_filter("the_content", array($this, "show_after_page_post_content"), 20);
        
        // NextGEN Gallery compat
        add_filter('run_ngg_resource_manager', array($this, 'nextgen_compat'));
    }

    function register_widget() {
        register_widget( 'Opt_In_Widget' );
    }

    function register_scripts()
    {
        $is_on_upfront_builder = class_exists('UpfrontThemeExporter') && function_exists('upfront_exporter_is_running') && upfront_exporter_is_running();
        
        if ( !$is_on_upfront_builder ) {
            if( is_customize_preview() || ! $this->has_optins() || isset( $_REQUEST['fl_builder'] ) ) {
                return;
            }
        }
        
        global $wp;
        
        /**
         * Register popup requirements
         */

        wp_register_script('optin_front', $this->_hustle->get_static_var(  "plugin_url" ) . 'assets/js/front.min.js', array('jquery', 'underscore'), '1.1',  $this->_hustle->get_const_var(  "VERSION" ), false);
		wp_register_script( 'optin_front_fitie', $this->_hustle->get_static_var( "plugin_url" ) . 'assets/js/vendor/fitie/fitie.js', array(), $this->_hustle->get_const_var( "VERSION" ), false );

        $modules = apply_filters("hustle_front_modules", $this->_optin_handles);
        wp_localize_script('optin_front', 'Optins', $modules);

        $vars = apply_filters("hustle_front_vars", array(
            "ajaxurl" => admin_url("admin-ajax.php", is_ssl() ? 'https' : 'http'),
            'page_id' => get_queried_object_id(),
            'page_type' => $this->_hustle->current_page_type(),
            'current_url' => esc_url( home_url( $wp->request ) ),
            'is_upfront' => class_exists( "Upfront" ) && isset( $_GET['editmode'] ) && $_GET['editmode'] === "true",
            'is_caldera_active' => class_exists( "Caldera_Forms" ),
            'adblock_detector_js' => $this->_hustle->get_static_var(  "plugin_url" ) . 'assets/js/front/ads.js',
            'l10n' => array(
                "never_see_again" => __("Never see this message again", Opt_In::TEXT_DOMAIN),
                'success' => __("Congratulations! You have been subscribed to {name}", Opt_In::TEXT_DOMAIN),
                'submit_failure' => __("Something went wrong, please try again.", Opt_In::TEXT_DOMAIN),
                'test_cant_submit' => __("Form can't be submitted in test mode.", Opt_In::TEXT_DOMAIN),
            )
        ) );
        wp_localize_script('optin_front', 'inc_opt', $vars );
        wp_localize_script('optin_front', 'hustle_vars', $vars );

        do_action("hustle_register_scripts");
        wp_enqueue_script('optin_front');
        wp_enqueue_script('optin_front_fitie');
		add_filter( 'script_loader_tag', array($this, "handle_specific_script"), 10, 2 );
    }
	
	/**
     * Handling specific scripts for each scenario
     *
     */
	function handle_specific_script( $tag, $handle ) {
		if ( $handle == 'optin_front_fitie' ) {
			$tag = "<!--[if IE]>". $tag ."<![endif]-->";
		}
		return $tag;
	}
	
    function register_styles()
    {
        $is_on_upfront_builder = class_exists('UpfrontThemeExporter') && function_exists('upfront_exporter_is_running') && upfront_exporter_is_running();
        
        if ( !$is_on_upfront_builder ) {
            if ( ! $this->has_optins() || isset( $_REQUEST['fl_builder'] ) ) {
                return;
            }
        }

        wp_register_style('optin_front', $this->_hustle->get_static_var(  "plugin_url" )  . 'assets/css/front.css', array( 'dashicons' ), $this->_hustle->get_const_var(  "VERSION" ) );

        wp_enqueue_style('optin_form_front');
        wp_enqueue_style('optin_front');

        $this->_inject_styles();
    }

    /**
     * Enqueues popups to be displayed
     *
     *
     */
    function create_popups()
    {

        global $post;
        $categories_array = $this->_get_term_ids($post, "category");
        $tags_array = $this->_get_term_ids($post, "post_tag");
        $enque_adblock_detector  = false;

        /**
         * @var $optin Opt_In_Model
         */
        foreach (Opt_In_Collection::instance()->get_all_optins() as $optin) {
            if( ! $optin->display ) {
				continue;
			}

            $handle = $this->_get_unique_id();
            $settings = $optin->get_frontend_settings($post, $categories_array, $tags_array);

			/**
			 * Include only active opt-in to optimize performance. **/
			$included = false;

			if ( ( ! empty( $settings->after_content ) && ! empty( $settings->after_content['enabled'] ) )
				|| ( ! empty( $settings->popup ) && ! empty( $settings->popup['enabled'] ) )
				|| ( ! empty( $settings->slide_in ) && ( ! empty( $settings->slide_in['enabled'] ) || 'false' == $settings->slide_in['enabled'] ) )
				|| ( ! empty( $settings->widget ) && ! empty( $settings->widget['display'] ) )
				|| ( ! empty( $settings->shortcode ) && ! empty( $settings->shortcode['display'] ) ) ) {
				$included = true;
			}

			if ( false === $included ) {
				// Don't bother iterating if none are enabled.
				continue;
			}

            if( $optin->provider_args )
                $this->_args_layouts[ $handle ] = $optin->optin_provider;

            if( ( $settings->popup['appear_after'] === "adblock" && isset( $settings->popup["trigger_on_adblock"] ) &&  $settings->popup["trigger_on_adblock"] === "true" )
                || (   $settings->slide_in['appear_after'] === "adblock" && isset( $settings->slide_in["trigger_on_adblock"] ) &&  $settings->slide_in["trigger_on_adblock"] === "true" ) ) {
                $enque_adblock_detector = true;
			}

			if ( empty( $settings->after_content['enabled'] ) ) {
				unset($settings->after_content);
			}
			if ( empty( $settings->popup['enabled'] ) ) {
				unset( $settings->popup );
			}
			if ( empty( $settings->slide_in['enabled'] ) || 'false' == $settings->slide_in['enabled'] ) {
				unset( $settings->slide_in );
			}

            $provider = Opt_In::get_provider_by_id( $optin->optin_provider );
            $provider = Opt_In::provider_instance( $provider );
            $p_args = $optin->provider_args;
            $provider_args = $p_args;
            $optin_data = $optin->get_data();
			if( isset( $optin_data['api_key'] ) ){
				unset( $optin_data['api_key'] );
			}
            $hide_args = ( method_exists( $provider, 'exclude_args_fields' ) )
                ? $provider->exclude_args_fields()
                : array();

            if( !empty( $hide_args ) ) {
                foreach ( $hide_args as $field ) {
                    unset( $provider_args->$field );
                }
            }

            $this->_optin_handles[$handle]["settings"] = $settings;
            $this->_optin_handles[$handle]["design"] = $optin->get_design()->to_object();
            $this->_optin_handles[$handle]["data"] = $optin_data;
            $this->_optin_handles[$handle]["shortcode"] = $optin->settings->shortcode->to_array();
            $this->_optin_handles[$handle]["widget"] = $optin->settings->widget->to_array();
            $this->_optin_handles[$handle]["provider_args"] = $provider_args;
            $this->_styles .= $optin->decorated->get_optin_styles();
            $this->_optin_layouts[ $handle ] = $this->_optin_handles[$handle]["design"]->form_location;

        }

        if( $enque_adblock_detector )
            wp_enqueue_script('hustle_front_ads', $this->_hustle->get_static_var(  "plugin_url" ) . 'assets/js/ads.js', array(),'1.0', $this->_hustle->get_const_var(  "VERSION" ), false);
    }

	/**
	 * Check if current page has renderable opt-ins.
	 **/
	function has_optins() {
		$has_optins = ! empty( $this->_optin_handles );

		return apply_filters( 'hustle_front_handler', $has_optins );
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

    /**
     * @param $content
     * @return string
     */
    function show_after_page_post_content( $content ){
		/**
		 * Return the content immediately if there are no renderable opt-ins.
		 **/
		if ( empty( $this->_optin_handles ) || isset( $_REQUEST['fl_builder'] ) ) {
			return $content;
		}

        global $post;

        $optins = Opt_In_Collection::instance()->get_all_optins();
        $categories_array = $this->_get_term_ids($post, "category");
        $tags_array = $this->_get_term_ids($post, "post_tag");

        /**
         * @var Opt_In_Model $optin
         */

        foreach( $optins as $optin ){
            $settings = $optin->get_frontend_settings($post, $categories_array, $tags_array);
            if( isset( $settings->after_content, $settings->after_content['display'] ) && $settings->after_content['display']  ) {
                $content .= sprintf("<div class='%s' data-id='%s'></div>", self::AfterContent_CSS_CLass . " inc_optin_" . $optin->id, $optin->id);
            }
        }

        remove_filter("the_content", array($this, "show_after_page_post_content"));

        return $content;
    }
    
    /**
     * By-pass NextGEN Gallery resource manager
     *
     * @return false
     */
    function nextgen_compat() {
        return false;
    }

    private function _get_unique_id()
    {
        return uniqid("IncOpt");
    }

    private function _inject_styles(){
        ?>
        <style type="text/css" id="inc-opt-styles"><?php echo $this->_styles; ?></style>
        <?php
    }

    /**
     * Returns unique registered layout numbers
     *
     * @since 1.0.1
     * @return array
     */
    private function _get_registered_layouts(){
        return array_unique( $this->_optin_layouts );
    }


    /**
     * Returns unique registered arg layout numbers
     *
     * @since 1.0.1
     * @return array
     */
    private function _get_registered_arg_layouts(){
        return array_unique( $this->_args_layouts );
    }

    /**
     * Adds needed layouts
     *
     * @since 1.0
     */
    function add_layout_templates(){
		if ( ! $this->has_optins() ) {
			return;
		}

        foreach( $this->_get_registered_layouts() as $layout_no ){
            $this->_hustle->render("general/layouts/" . $layout_no );
        }

        foreach( $this->_get_registered_arg_layouts() as $provider_name ){
            $this->_hustle->render("general/providers/" . $provider_name );
        }
    }

    function shortcode( $atts, $content ){
        $atts = shortcode_atts( array(
            'id' => '',
            "type" => ""
        ), $atts, self::SHORTCODE );

        $type = trim( $atts['type'] );
        if( empty( $atts['id'] ) ) return "";



        $optin = Opt_In_Model::instance()->get_by_shortcode( $atts['id'] );

        if( !$optin || !$optin->active ) return "";

        /**
         * Maybe add trigger link
         */
        if( !empty( $content ) && !empty( $type ) && in_array( $type, array("popup", "slide_in") ) && $optin->settings->{$type}->enabled && $optin->settings->{$type}->appear_after === "click" )
            return sprintf("<a href='#' class='%s' data-id='%s' data-type='%s'>%s</a>", self::Shortcode_Trigger_CSS_CLass . " inc_optin_" . $optin->id, $optin->id, esc_attr( $type ),  $content );

        if( !$optin->settings->shortcode->show_in_front()  ) return "";



        return sprintf("<div class='%s' data-id='%s'></div>", self::Shortcode_CSS_CLass . " inc_optin_" . $optin->id, $optin->id);
    }
} 