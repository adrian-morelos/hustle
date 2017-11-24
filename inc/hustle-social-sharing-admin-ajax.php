<?php

if ( !class_exists('Hustle_Social_Sharing_Admin_Ajax', false) ): 

class Hustle_Social_Sharing_Admin_Ajax {
    
    private static $_hustle;
    private static $_admin;
    
    function __construct( $hustle, $admin ) {
        
        self::$_hustle = $hustle;
        self::$_admin = $admin;
        
        add_action( 'wp_ajax_hustle_social_sharing_save', array( $this, 'save' ) );
        add_action('wp_ajax_hustle_social_sharing_toggle_activity', array( $this, 'toggle_activity' ));
        add_action('wp_ajax_hustle_social_sharing_toggle_tracking_activity', array( $this, 'toggle_tracking_activity' ));
        add_action('wp_ajax_hustle_social_sharing_toggle_type_activity', array( $this, 'toggle_type_activity' ));
        add_action('wp_ajax_hustle_social_sharing_toggle_test_activity', array( $this, 'toggle_test_activity' ));
        add_action('wp_ajax_hustle_social_sharing_delete', array( $this, 'delete' ));
    }
    
    function save() {
        Opt_In_Utils::validate_ajax_call( 'hustle_social_sharing_save' );
        
        $post_data = stripslashes_deep( $_POST );
        
        if ( '-1' === $post_data['id'] ) {
            $res = self::$_admin->add_new( $post_data );
        } else {
            $res = self::$_admin->update( $post_data );
        }
        
        wp_send_json(
            array(
                'success' => ( $res === false ) ? false : true,
                'data' => $res
            )
        );
    }
    
    function toggle_activity(){

        Opt_In_Utils::validate_ajax_call( "social-sharing-toggle-activity" );

        $id = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );

        if( !$id )
            wp_send_json_error(__("Invalid Request", Opt_In::TEXT_DOMAIN));

        $result = Hustle_Social_Sharing_Model::instance()->get($id)->toggle_state();

        if( $result )
            wp_send_json_success( __("Successful") );
        else
            wp_send_json_error( __("Failed") );
    }
    
    function toggle_tracking_activity(){

        Opt_In_Utils::validate_ajax_call( "social-sharing-toggle-tracking-activity" );

        $id = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );
        $type = trim( filter_input( INPUT_POST, 'type', FILTER_SANITIZE_STRING ) );

        if( !$id || !$type )
            wp_send_json_error(__("Invalid Request", Opt_In::TEXT_DOMAIN));

        $ss =  Hustle_Social_Sharing_Model::instance()->get($id);

        if( !in_array( $type, $ss->get_types() ))
            wp_send_json_error(__("Invalid environment: " . $type, Opt_In::TEXT_DOMAIN));

        $result = $ss->toggle_type_track_mode( $type );

        if( $result && !is_wp_error( $result ) )
            wp_send_json_success( __("Successful") );
        else
            wp_send_json_error( $result->get_error_message() );
    }
    
    function toggle_type_activity(){

        Opt_In_Utils::validate_ajax_call( "social-sharing-toggle-type-activity" );

        $id = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );
        $type = trim( filter_input( INPUT_POST, 'type', FILTER_SANITIZE_STRING ) );

        if( !$id || !$type )
            wp_send_json_error(__("Invalid Request", Opt_In::TEXT_DOMAIN));

        $ss =  Hustle_Social_Sharing_Model::instance()->get($id);

        if( !in_array( $type, $ss->get_types() ) )
            wp_send_json_error(__("Invalid environment: " . $type, Opt_In::TEXT_DOMAIN));

        // if shortcode/widget, check it on settings
        $result = ( $type == 'shortcode' || $type == 'widget' )
            ? $ss->toggle_display_type_state( $type, true )
            : $ss->toggle_display_type_state( $type );

        if( $result && !is_wp_error( $result ) ) {
			wp_send_json_success( __("Successful") );
		} else {
			wp_send_json_error( $result->get_error_message() );
		}
    }
    
    function toggle_test_activity(){

        Opt_In_Utils::validate_ajax_call( "social-sharing-toggle-test-activity" );

        $id = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );
        $type = trim( filter_input( INPUT_POST, 'type', FILTER_SANITIZE_STRING ) );

        if( !$id || !$type )
            wp_send_json_error(__("Invalid Request", Opt_In::TEXT_DOMAIN));

        $ss =  Hustle_Social_Sharing_Model::instance()->get($id);

        if( !in_array( $type, $ss->get_types() ))
            wp_send_json_error(__("Invalid environment: " . $type, Opt_In::TEXT_DOMAIN));

        $result = $ss->toggle_type_test_mode( $type );

        if( $result && !is_wp_error( $result ) )
            wp_send_json_success( __("Successful") );
        else
            wp_send_json_error( $result->get_error_message() );
    }
    
    function delete(){
        Opt_In_Utils::validate_ajax_call( "social-sharing-delete" );

        $id = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );

        if( !$id  )
            wp_send_json_error(__("Invalid Request", Opt_In::TEXT_DOMAIN));

        $result = Hustle_Social_Sharing_Model::instance()->get( $id )->delete();

        if( $result )
            wp_send_json_success( __("Successful") );
        else
            wp_send_json_error( __("Error deleting", Opt_In::TEXT_DOMAIN)  );
    }
}

endif;