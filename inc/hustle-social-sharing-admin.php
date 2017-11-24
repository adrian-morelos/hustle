<?php

if( !class_exists("Hustle_Social_Sharing_Admin") ):

class Hustle_Social_Sharing_Admin extends Opt_In {
	
	function __construct() {
		add_action( 'admin_menu', array( $this, "register_admin_menu" ) );
        add_action("current_screen", array( $this, "set_proper_current_screen_for_new_page" ) );
        add_filter("hustle_optin_vars", array( $this, "register_current_json" ) );
	}
	
	function register_admin_menu() {
		add_submenu_page( 'inc_optins', __("Social Sharing", Opt_In::TEXT_DOMAIN) , __("Social Sharing", Opt_In::TEXT_DOMAIN) , "manage_options", 'inc_hustle_social_sharing',  array( $this, "render_social_sharing" )  );
	}
	
	function render_social_sharing() {
        $current_user = wp_get_current_user();
		if( isset( $_GET['id'] ) && ( "-1" === $_GET['id'] || 0 !== intval( $_GET['id'] ) ) ){
            $total_ss = count( Hustle_Social_Sharing_Collection::instance()->get_all( null ) );
			if ( Opt_In_Utils::_is_free() && '-1' === $_GET['id'] && $total_ss >= 1 ) {
				$this->render( 'admin/new-free-info', array(
					'page_title' => __( 'Social Sharing', Opt_In::TEXT_DOMAIN ),
				));
			} else {
				$this->render("admin/new-social-sharing", array());
			}
		} else {
			$this->render("admin/social-sharing", array(
                'add_new_url' => admin_url("admin.php?page=inc_hustle_social_sharing&id=-1"),
                'social_groups' => Hustle_Social_Sharing_Collection::instance()->get_all( null ),
                'types' => array(
                    'floating_social' => __( 'Floating Social', Opt_In::TEXT_DOMAIN ),
                    'shortcode' => __('Shortcode', Opt_In::TEXT_DOMAIN),
                    'widget' => __('Widget', Opt_In::TEXT_DOMAIN)
                ),
                'user_name' => ucfirst($current_user->display_name)
            ));
		}
	}
    
    function set_proper_current_screen_for_new_page( $current ){
        global $current_screen;
        
        if ( !Opt_In_Utils::_is_free() ) {
            $current_screen->id = Opt_In_Utils::clean_current_screen($current_screen->id);
        }
        
        if( isset( $current_screen ) && "hustle_page_inc_hustle_social_sharing" === $current_screen->id && isset( $_GET['id'] ) && "-1" === $_GET['id'] )
            $current_screen->id .= "_new";

        if( isset( $current_screen ) && "hustle_page_inc_hustle_social_sharing" === $current_screen->id && isset( $_GET['id'] ) && 0 !== intval( $_GET['id'] ) )
            $current_screen->id .= "_edit";
    }
    
    private function _is_edit(){
        return  (bool) filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT) && isset( $_GET['page'] ) && $_GET['page'] === "inc_hustle_social_sharing";
    }

    function register_current_json( $current_array ){

        if( $this->_is_edit()  ){
            
            $ss = Hustle_Social_Sharing_Model::instance()->get( filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT) );
            $all_ss = Hustle_Social_Sharing_Collection::instance()->get_all( null );
			$total_ss = count($all_ss);
            $current_array['current'] = array(
                "services" => $ss->get_services()->to_array(),
                "appearance" => $ss->get_appearance()->to_array(),
                "floating_social" => $ss->get_floating_social()->to_array(),
                "is_ss_limited" => (int) ( Opt_In_Utils::_is_free() && '-1' === $_GET['id'] && $total_ss >= 1 )
            );
        }
        
        return $current_array;
    }
    
    function add_new( $data ) {
        $ss = new Hustle_Social_Sharing_Model();
        
        $services = $data['services'];
        $appearance = $data['appearance'];
        $floating_social = $data['floating_social'];
        $shortcode_id = $data['shortcode_id'];
        
        $ss->test_mode = 0;
        $ss->blog_id = get_current_blog_id();
        $ss->optin_name = $services['optin_name'];
        $ss->optin_title = $services['optin_name'];
        $ss->optin_provider = $ss->get_optin_provider();
        $ss->active = 1;
        $id = $ss->save();
        
        $ss->add_meta( "services", $services );
        $ss->add_meta( "appearance", $appearance );
        $ss->add_meta( "floating_social", $floating_social );
        $ss->add_meta( "shortcode_id", $shortcode_id );
        $ss->add_meta( "settings", array(
            "shortcode" => array(
                "enabled" => "true"
            ),
            "widget" => array(
                "enabled" => "true"
            )
        ) );
        
        return $id;
    }
    
    function update( $data ) {
        
        if( !isset( $data['id'] ) || '-1' == $data['id'] ) return false;
        
        $ss = Hustle_Social_Sharing_Model::instance()->get( $data['id'] );
        
        $services = $data['services'];
        $appearance = $data['appearance'];
        $floating_social = $data['floating_social'];
        $shortcode_id = $data['shortcode_id'];
        
        $ss->test_mode = $services['test_mode'];
        $ss->blog_id = get_current_blog_id();
        $ss->optin_name = $services['optin_name'];
        $ss->optin_title = $services['optin_name'];
        $ss->optin_provider = $ss->get_optin_provider();
        $ss->active = $services['active'];
        $ss->save();
        
        $ss->update_meta( "services", $services );
        $ss->update_meta( "appearance", $appearance );
        $ss->update_meta( "floating_social", $floating_social );
        $ss->update_meta( "shortcode_id", $shortcode_id );
        
        return $ss->id;
    }
}

endif;