<?php

if( !class_exists("Hustle_Custom_Content_Admin_Ajax", false) ):


class Hustle_Custom_Content_Admin_Ajax
{
    private static $_hustle;
    /**
     * @var $_admin Hustle_Custom_Content_Admin
     */
    private static $_admin;

    function __construct( $hustle, $admin )
    {
        self::$_hustle = $hustle;
        self::$_admin = $admin;

        add_action("wp_ajax_hustle_custom_content_save", array( $this, "save" ));
        add_action("wp_ajax_hustle_custom_content_toggle_activity", array( $this, "toggle_activity" ));
        add_action("wp_ajax_hustle_custom_content_toggle_tracking_activity", array( $this, "toggle_tracking_activity" ));
        add_action("wp_ajax_hustle_custom_content_toggle_type_activity", array( $this, "toggle_type_activity" ));
        add_action("wp_ajax_hustle_custom_content_toggle_test_activity", array( $this, "toggle_test_activity" ));
        add_action("wp_ajax_hustle_custom_content_delete", array( $this, "delete" ));
        add_action("wp_ajax_hustle_custom_content_dismiss_legacy_notice", array( $this, "dismiss_legacy_notice" ));
        add_action("wp_ajax_hustle_CC_parse_content", array( $this, "parse_content" ));
        add_action("wp_ajax_hustle_CC_prepare_custom_css", array( $this, "prepare_custom_css" ));
    }

    function save(){
        Opt_In_Utils::validate_ajax_call( "hustle_custom_content_save" );

        $_POST = stripslashes_deep( $_POST );

        if( "-1" === $_POST['id'] )
            $res = self::$_admin->add_new( $_POST );
        else
            $res = self::$_admin->update( $_POST );

        wp_send_json( array(
            "success" =>  $res === false ? false: true,
            "data" => $res
        ) );

    }

    function toggle_activity(){

        Opt_In_Utils::validate_ajax_call( "custom-content-toggle-activity" );

        $id = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );

        if( !$id )
            wp_send_json_error(__("Invalid Request", Opt_In::TEXT_DOMAIN));

        $result = Hustle_Custom_Content_Model::instance()->get($id)->toggle_state();

        if( $result )
            wp_send_json_success( __("Successful") );
        else
            wp_send_json_error( __("Failed") );
    }

    function toggle_type_activity(){

        Opt_In_Utils::validate_ajax_call( "custom-content-toggle-type-activity" );

        $id = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );
        $type = trim( filter_input( INPUT_POST, 'type', FILTER_SANITIZE_STRING ) );

        if( !$id || !$type )
            wp_send_json_error(__("Invalid Request", Opt_In::TEXT_DOMAIN));

        $cc =  Hustle_Custom_Content_Model::instance()->get($id);

        if( !in_array( $type, $cc->get_types() ) )
            wp_send_json_error(__("Invalid environment: " . $type, Opt_In::TEXT_DOMAIN));
        
        // if shortcode/widget, check it on settings
        $result = ( $type == 'shortcode' || $type == 'widget' )
            ? $cc->toggle_state( $type, true )
            : $cc->toggle_state( $type );

        if( $result && !is_wp_error( $result ) ) {
			wp_send_json_success( __("Successful") );
		} else {
			wp_send_json_error( $result->get_error_message() );
		}
    }
    
    function toggle_tracking_activity(){

        Opt_In_Utils::validate_ajax_call( "custom-content-toggle-tracking-activity" );

        $id = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );
        $type = trim( filter_input( INPUT_POST, 'type', FILTER_SANITIZE_STRING ) );

        if( !$id || !$type )
            wp_send_json_error(__("Invalid Request", Opt_In::TEXT_DOMAIN));

        $cc =  Hustle_Custom_Content_Model::instance()->get($id);

        if( !in_array( $type, $cc->get_types() ))
            wp_send_json_error(__("Invalid environment: " . $type, Opt_In::TEXT_DOMAIN));

        $result = $cc->toggle_type_track_mode( $type );

        if( $result && !is_wp_error( $result ) )
            wp_send_json_success( __("Successful") );
        else
            wp_send_json_error( $result->get_error_message() );
    }

    /**
     * Toggles optin type test mode
     *
     * @since 1.0
     */
    function toggle_test_activity(){

        Opt_In_Utils::validate_ajax_call( "custom-content-toggle-test-activity" );

        $id = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );
        $type = trim( filter_input( INPUT_POST, 'type', FILTER_SANITIZE_STRING ) );

        if( !$id || !$type )
            wp_send_json_error(__("Invalid Request", Opt_In::TEXT_DOMAIN));

        $cc =  Hustle_Custom_Content_Model::instance()->get($id);

        if( !in_array( $type, $cc->get_types() ))
            wp_send_json_error(__("Invalid environment: " . $type, Opt_In::TEXT_DOMAIN));

        $result = $cc->toggle_type_test_mode( $type );

        if( $result && !is_wp_error( $result ) )
            wp_send_json_success( __("Successful") );
        else
            wp_send_json_error( $result->get_error_message() );
    }

    function delete(){
        Opt_In_Utils::validate_ajax_call( "custom-content-delete" );

        $id = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );

        if( !$id  )
            wp_send_json_error(__("Invalid Request", Opt_In::TEXT_DOMAIN));

        $result = Hustle_Custom_Content_Model::instance()->get( $id )->delete();

        if( $result )
            wp_send_json_success( __("Successful") );
        else
            wp_send_json_error( __("Error deleting", Opt_In::TEXT_DOMAIN)  );
    }
	
	function dismiss_legacy_notice() {
		Opt_In_Utils::validate_ajax_call( "inc_cc_legacy_popup_notice" );
		update_option("hustle_legacy_notice_dismissed", true);
		wp_send_json_success();
	}

    function parse_content(){
        $html = filter_input( INPUT_GET, 'html' );
        wp_send_json_success( apply_filters( "the_content", $html ) );
    }
    
    /**
     * Prepares the custom css string for the live previewer
     *
     * @since 2.1
     */
    function prepare_custom_css(){

        Opt_In_Utils::validate_ajax_call( "hustle_custom_content_prepare_custom_css" );

        $_POST = stripslashes_deep( $_POST );
        if( !isset($_POST['css'] ) ) {
            wp_send_json_error();
        }

        $cssString = $_POST['css'];
        $styles = Opt_In::prepare_css($cssString, ".wph-preview .wph-modal--content");
        wp_send_json_success( $styles );
    }

}

endif;