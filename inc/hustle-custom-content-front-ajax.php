<?php


class Hustle_Custom_Content_Front_Ajax
{
    function __construct()
    {

        // When CC is viewed
        add_action("wp_ajax_hustle_custom_content_viewed", array( $this, "log_view" ) );
        add_action("wp_ajax_nopriv_hustle_custom_content_viewed", array( $this, "log_view" ) );

        // When CC is converted to
        add_action("wp_ajax_hustle_custom_content_converted", array( $this, "log_conversion" ) );
        add_action("wp_ajax_nopriv_hustle_custom_content_converted", array( $this, "log_conversion" ) );
    }

    function log_view(){
		$data = json_decode( file_get_contents( 'php://input' ) );
		$data = get_object_vars( $data );
 
        $id = is_array( $data ) ?  $data['id'] : null;
        $type = is_array( $data ) ?  $data['type'] : null;

        if( empty( $id ) )
            wp_send_json_error( __("Invalid Request: Invalid Custom Content ", Opt_In::TEXT_DOMAIN ) . $id );

        $cc = Hustle_Custom_Content_Model::instance()->get( $id );

        $res = new WP_Error();

        if( $cc->id )
            $res = $cc->log_view( array(
                'page_type' => $data['page_type'],
                'page_id'   => $data['page_id'],
                'module_id' => $id,
                'uri' => $data['uri'],
                "module_type" => "custom_content"
            ), $type );

        if( is_wp_error( $res ) || empty( $data ) )
            wp_send_json_error( __("Error saving stats", Opt_In::TEXT_DOMAIN) );
        else
            wp_send_json_success( __("Stats Successfully saved", Opt_In::TEXT_DOMAIN) );

    }

    function log_conversion(){
		$data = json_decode( file_get_contents( 'php://input' ) );
		$data = get_object_vars( $data );

        $id = is_array( $data ) ?  $data['id'] : null;
        $type = is_array( $data ) ?  $data['type'] : null;

        if( empty( $id ) )
            wp_send_json_error( __("Invalid Request: Invalid Custom Content ", Opt_In::TEXT_DOMAIN ) . $id );

        $cc = Hustle_Custom_Content_Model::instance()->get( $id );
        $res = new WP_Error();
        if( $cc->id )
            $res = $cc->log_conversion( array(
                'page_type' => $data['page_type'],
                'page_id'   => $data['page_id'],
                'module_id' => $cc->id,
                'uri' => $data['uri'],
                "module_type" => "custom_content",
                "source" => $data['source']
            ), $type );

        if( is_wp_error( $res ) || empty( $data ) )
            wp_send_json_error( __("Error saving stats", Opt_In::TEXT_DOMAIN) );
        else
            wp_send_json_success( __("Stats Successfully saved", Opt_In::TEXT_DOMAIN) );
    }

}