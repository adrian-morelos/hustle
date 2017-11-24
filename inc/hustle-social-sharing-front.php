<?php

class Hustle_Social_Sharing_Front {
    
    private $_hustle;
    private $_ss_modules = array();
    private $_styles;
    
    const Widget_CSS_CLass = "inc_social_sharing_widget_wrap";
    const Shortcode_CSS_CLass = "inc_social_sharing_shortcode_wrap";
    
    const SHORTCODE = "wd_hustle_ss";
    
    function __construct( Opt_In $hustle ) {
        
        $this->_hustle = $hustle;
        add_shortcode( self::SHORTCODE, array($this, 'shortcode') );
        
        add_filter( 'hustle_front_handler', array( $this, 'has_ss' ) );
        
        if( is_admin() ) return;
        
        add_action( 'template_redirect', array($this, 'create_ss_modules'), 0);
        
        add_action( 'wp_footer', array($this, 'register_styles') );
        
        add_action( 'wp_footer', array($this, 'add_social_template') );
        
        add_filter( 'hustle_register_scripts', array($this, 'register_modules') );
    }
    
    /**
	 * Check if current page has renderable opt-ins.
	 **/
	function has_ss( $return ) {
		$found = ! empty( $this->_ss_modules );

		if ( $found ) {
			$return = $found;
		}

		return $return;
	}
    
    function create_ss_modules() {
        $all_ss = Hustle_Social_Sharing_Collection::instance()->get_all( true );
        
        foreach( $all_ss as $ss ) {
            
            if( !$ss->display ) continue;
            
            $data = $ss->get_data();
            $service_data = $ss->get_services()->to_array();
            $appearance_data = $ss->get_appearance()->to_array();
            $floating_data = $ss->get_floating_social();
                
            $this->_ss_modules[$data['optin_id']] = $data;
            $this->_ss_modules[$data['optin_id']]['settings'] = $ss->settings;
            $this->_ss_modules[$data['optin_id']]['tracking_types'] = $ss->get_tracking_types();
            $this->_ss_modules[$data['optin_id']]['services'] = $service_data;
            $this->_ss_modules[$data['optin_id']]['appearance'] = $appearance_data;
            $this->_ss_modules[$data['optin_id']]['floating_social'] = $floating_data->to_array();
            $this->_ss_modules[$data['optin_id']]['is_floating_social_allowed'] = $ss->is_allowed_to_display( (object) $floating_data->conditions, 'floating_social');
            $this->_styles .= $ss->get_decorated()->get_styles();
            
        }
    }
    
    function add_social_template() {
        if ( empty( $this->_ss_modules ) ) {
            return;
        }
        
        $this->_hustle->render('general/social', array(
            'admin' => false
        ));
    }
    
    function register_modules() {
        wp_localize_script( 'optin_front', 'Hustle_SS_Modules', $this->_ss_modules );
    }
    
    function register_styles() {
        if ( $this->_styles ) {
            ?>
            <style type="text/css" id="hustle-ss-styles"><?php echo $this->_styles; ?></style>
            <?php
        }
    }
    
    function shortcode( $atts, $content, $a ) {
        $atts = shortcode_atts( array(
            'id' => ''
        ), $atts, self::SHORTCODE );

        if( empty( $atts['id'] ) ) return "";
		
		$ss = Hustle_Social_Sharing_Model::instance()->get_by_shortcode( $atts['id'] );

        if( !$ss || !$ss->active ) return "";
		
		return sprintf("<div class='%s' data-id='%s'></div>", self::Shortcode_CSS_CLass . " inc_ss_" . $ss->id, $ss->id);
    }
}