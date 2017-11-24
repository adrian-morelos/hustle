<?php

/**
 * Class Hustle_Legacy_Popups_Ajax
 *
 * Handles all the ajax requests for legacy popups
 */
class Hustle_Legacy_Popups_Ajax
{
    /**
     * @var $_legacy_popups Hustle_Legacy_Popups
     */
    private $_legacy_popups;

    /**
     * Hustle_Legacy_Popups_Ajax constructor.
     * @param Hustle_Legacy_Popups $legacy_popups
     */
    function __construct( Hustle_Legacy_Popups $legacy_popups )
    {
        $this->_legacy_popups = $legacy_popups;
        add_action("wp_ajax_hustle_legacy_popup_toggle_activity", array( $this, "toggle_activity" ) );
        add_action("wp_ajax_hustle_custom_content_legacy_popup_quick_edit_save", array( $this, "quick_edit_save" ) );
        add_action("wp_ajax_hustle_custom_content_legacy_popup_migrate", array( $this, "migrate" ) );
    }

    /**
     * Toggles popup active state
     *
     * @since 2.0
     */
    function toggle_activity(){

        Opt_In_Utils::validate_ajax_call( "custom-content-legacy-toggle-activity" );

        $id = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );

        if( !$id )
            wp_send_json_error(__("Invalid popup Id ", Opt_In::TEXT_DOMAIN) . $id);

        $popup = $this->_legacy_popups->get( $id );
        if( ! ( $popup instanceof  WP_Post ) )
            wp_send_json_error(__("Issuing fetching correct popup, please try again later", Opt_In::TEXT_DOMAIN));

        $arr = $popup->to_array();
        $arr['post_status'] = $popup->post_status === "publish" ? "draft" : "publish";
        $res = wp_update_post( $arr );

        if( is_wp_error( $res ) || 0 === $res )
            wp_send_json_error( method_exists( $res,  'get_error_messages' ) ? $res->get_error_messages() : __("Issue toggling popup active state", Opt_In::TEXT_DOMAIN ) );

        wp_send_json_success( __("Successfully toggled popup active state", Opt_In::TEXT_DOMAIN) );

    }

    function quick_edit_save(){

        Opt_In_Utils::validate_ajax_call( "custom-content-legacy-popup-quick-edit-save" );

        $id = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );
        $heading = filter_input( INPUT_POST, 'heading', FILTER_SANITIZE_STRING );
        $subheading = filter_input( INPUT_POST, 'subheading', FILTER_SANITIZE_STRING );
        $content = filter_input( INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS );


        if( !$id )
            wp_send_json_error(__("Invalid popup Id ", Opt_In::TEXT_DOMAIN) . $id);

        $popup = $this->_legacy_popups->get( $id );
        if( ! ( $popup instanceof  WP_Post ) )
            wp_send_json_error(__("Issuing fetching correct popup, please try again later", Opt_In::TEXT_DOMAIN));

        $arr = $popup->to_array();
        $arr['post_content'] = $content;

        $post_id = wp_update_post( $arr );

        if( is_wp_error( $post_id ) || 0 === $post_id )
            wp_send_json_error( method_exists( $post_id,  'get_error_messages' ) ? $post_id->get_error_messages() : __("Issue updating popup data", Opt_In::TEXT_DOMAIN ) );

        update_post_meta( $post_id, "po_title", $heading );
        update_post_meta( $post_id, "po_subtitle", $subheading );


        wp_send_json_success( __("Successfully updated popup data", Opt_In::TEXT_DOMAIN) );

    }

    function migrate(){
        Opt_In_Utils::validate_ajax_call( "custom-content-legacy-popup-migrate" );

        $id = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );
        $popup = $this->_legacy_popups->get( $id );

        $cc = new Hustle_Custom_Content_Model();

        $name = Hustle_Legacy_Popups::get_title( $popup );
        $heading = Hustle_Legacy_Popups::get_heading( $popup );
        $subheading = Hustle_Legacy_Popups::get_subheading( $popup );

        if(  !empty( $heading ) )
            $name .= "( $heading )";
        if( !empty( $subheading ) )
            $name .= "( $subheading )";

        $cc->optin_name = $name;
        $cc->optin_message = Hustle_Legacy_Popups::get_content( $popup );
        $cc->active = $popup->post_status === "publish";
        $cc->blog_id = get_current_blog_id();
        $cc->test_mode = 0;

        $cc->save();

        $design = wp_parse_args( Hustle_Legacy_Popups::get_design_data( $popup ) , $cc->get_design()->to_array() );
        $cc->add_meta( "design",  $design);

        $popup_settings = wp_parse_args( Hustle_Legacy_Popups::get_settings_data( $popup ) , $cc->get_popup()->to_array() );

        $cc->add_meta( "popup", $popup_settings );
        $cc->add_meta( "slide_in", $cc->get_slide_in()->to_json() );
        $cc->add_meta( "magic_bar", $cc->get_magic_bar()->to_json() );

        $cc->add_meta("po_title", $heading);
        $cc->add_meta("po_subtitle", $subheading);
        $cc->add_meta("migrated_from_popup", true);

        update_post_meta( $id, "hustle_migrated", true );

    }
}