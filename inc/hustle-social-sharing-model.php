<?php

class Hustle_Social_Sharing_Model extends Hustle_Model {
	
	
	static function instance() {
		return new self;
	}
    
    function get_optin_provider(){
        return "social_sharing";
    }
    
    protected $types = array(
		'floating_social',
        'shortcode',
        'widget',
    );
    
    function __get($field)
    {
        $from_parent = parent::__get($field);
        if( !empty( $from_parent ) )
            return $from_parent;

    }
    
    function get_types(){
        return $this->types;
    }

    function get_type(){
        return $this->get_optin_provider();
    }
    
    function get_module_type(){
        return "social_sharing";
    }
    
    /**
     * Checkes if module has type
     *
     * @param $type_name
     * @return bool
     */
    function has_type( $type_name ){
        return in_array( $type_name, $this->types );
    }
    
    function get_data(){
        return array_merge( (array) $this->_data, array(
            
        ));
    }
    
    function get_decorated(){

        if( !$this->_decorator )
            $this->_decorator = new Hustle_Social_Sharing_Decorator( $this );

        return $this->_decorator;
    }
    
    function get_services() {
        return new Hustle_Social_Sharing_Services( $this->get_settings_meta( self::KEY_SERVICES, "{}", true ), $this );
    }
    
    function get_appearance() {
        return new Hustle_Social_Sharing_Appearance( $this->get_settings_meta( self::KEY_APPEARANCE, "{}", true ), $this );
    }
    
    function get_floating_social() {
        return new Hustle_Social_Sharing_Floating_Social( $this->get_settings_meta( self::KEY_FLOATING_SOCIAL, "{}", true  ), $this );
    }
    
    function log_share_stats( $page_id ) {
        $ss_col_instance = Hustle_Social_Sharing_Collection::instance();
        $ss_col_instance->update_page_share($page_id);
    }
    
    /**
     * Returns optin settings
     *
     * @return Opt_In_Meta_Settings
     */
    public function get_parent_settings(){
        $settings_json = $this->get_meta( self::KEY_SETTINGS );
        return new Opt_In_Meta_Settings( json_decode( $settings_json ? $settings_json : "{}", true ), $this );
    }
    
    function get_type_conditions( $type ) {
        $conditions = array();
        if( !in_array( $type, $this->types ) ) $conditions;
        
        $method = "get_$type";

        if ( $type == 'shortcode' ) {
            $settings = $this->get_parent_settings()->get_shortcode();
        } elseif ( $type == 'widget' ) {
            $settings = $this->get_parent_settings()->get_widget();
        } else {
            $settings = $this->{$method}();
        }
		
		// defaults
		$_conditions = array(
			'posts' => array(),
			'pages' => array(),
			'categories' => array(),
			'tags' => array()
		);
		$_conditions = wp_parse_args($settings->conditions, $_conditions);
        if( !empty( $_conditions ) ){
            foreach( $_conditions as $condition_key => $args ){
				// only cpt have 'post_type' and 'post_type_label' properties
				if ( is_array($args) && isset($args['post_type']) && isset($args['post_type_label']) ) {
					$conditions[$condition_key] = Hustle_Condition_Factory::build( 'cpt', $args );
				} else {
					$conditions[$condition_key] = Hustle_Condition_Factory::build( $condition_key, $args );
				}

				if ( is_object( $conditions[ $condition_key ] ) && method_exists( $conditions[ $condition_key ], 'set_type' ) ) {
					$conditions[$condition_key]->set_type( $type );
				}
                
            }
        }

        return $conditions;
    }
    
}