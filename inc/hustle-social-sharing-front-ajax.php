<?php


class Hustle_Social_Sharing_Front_Ajax
{
    function __construct()
    {

        // When SS is viewed
        add_action("wp_ajax_hustle_social_sharing_viewed", array( $this, "log_view" ) );
        add_action("wp_ajax_nopriv_hustle_social_sharing_viewed", array( $this, "log_view" ) );

        // When SS is converted to
        add_action("wp_ajax_hustle_social_sharing_converted", array( $this, "log_conversion" ) );
        add_action("wp_ajax_nopriv_hustle_social_sharing_converted", array( $this, "log_conversion" ) );
    }

    function log_view(){
		$data = json_decode( file_get_contents( 'php://input' ) );
		$data = get_object_vars( $data );
 
        $id = is_array( $data ) ?  $data['id'] : null;
        $type = is_array( $data ) ?  $data['type'] : null;

        if( empty( $id ) )
            wp_send_json_error( __("Invalid Request: Invalid Social Sharing ", Opt_In::TEXT_DOMAIN ) . $id );

        $ss = Hustle_Social_Sharing_Model::instance()->get( $id );
        
        $res = new WP_Error();

        if( $ss->id )
            $res = $ss->log_view( array(
                'page_type' => $data['page_type'],
                'page_id'   => $data['page_id'],
                'module_id' => $id,
                'uri' => $data['uri'],
                "module_type" => "social_sharing"
            ), $type );

        if( is_wp_error( $res ) || empty( $data ) )
            wp_send_json_error( __("Error saving stats", Opt_In::TEXT_DOMAIN) );
        else
            wp_send_json_success( __("Stats Successfully saved", Opt_In::TEXT_DOMAIN) );

    }

    function log_conversion(){
		$data = json_decode( file_get_contents( 'php://input' ) );
		$data = get_object_vars( $data );
        
        $id = is_array( $data ) ? $data['id'] : null;
        $type = is_array( $data ) ? $data['type'] : null;
        $track = is_array( $data ) ? (bool) $data['track'] : false;
        $source = is_array( $data ) ? $data['source'] : '';
        $service_type = is_array( $data ) ? $data['service_type'] : false;

        if( empty( $id ) )
            wp_send_json_error( __("Invalid Request: Invalid Social Sharing ", Opt_In::TEXT_DOMAIN ) . $id );

        $ss = Hustle_Social_Sharing_Model::instance()->get( $id );
        
        // only update the social counter for Native Social Sharing
        if( $service_type && $service_type == 'native' && $source ) {
            $social = str_replace( '_icon', '', $source );
            $services = $ss->get_services()->to_array();
            
            if( isset($services['social_icons']) && isset($services['social_icons'][$social]) ) {
                $social_data = $services['social_icons'][$social];
                $social_data['counter'] = ( (int) $social_data['counter'] ) + 1;
                $services['social_icons'][$social] = $social_data;
                $ss->update_meta( "services", $services );
            }
        }
        
        $res = new WP_Error();
        if( $ss->id && $track )
            $res = $ss->log_conversion( array(
                'page_type' => $data['page_type'],
                'page_id'   => $data['page_id'],
                'module_id' => $ss->id,
                'uri' => $data['uri'],
                "module_type" => "social_sharing",
                "source" => $data['source']
            ), $type );
            
            // update meta for social sharing share stats
            $ss->log_share_stats($data['page_id']);

        if( is_wp_error( $res ) || empty( $data ) )
            wp_send_json_error( __("Error saving stats", Opt_In::TEXT_DOMAIN) );
        else
            wp_send_json_success( __("Stats Successfully saved", Opt_In::TEXT_DOMAIN) );
    }

}