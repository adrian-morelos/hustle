<?php

if( !class_exists("Opt_In_SendinBlue") ) :
    /**
    * Class Opt_In_SendinBlue
    */
    class Opt_In_SendinBlue extends Opt_In_Provider_Abstract  implements  Opt_In_Provider_Interface {

        const ID = "sendinblue";
        const NAME = "SendinBlue";

        const LIST_PAGES = "hustle-sendinblue-list-pages";
        const CURRENT_LISTS = "hustle-sendinblue-current-list";

        static function instance() {
            return new self;
        }

        function is_authorized() {
            return true;
        }

    
        static function api( $api_key ) {
            if ( ! class_exists( 'Opt_In_SendinBlue_Api' ) )
                require_once 'opt-in-sendinblue-api.php';

            $api = new Opt_In_SendinBlue_Api( $api_key );

            return $api;
        }

        /**
        * Updates api option
        *
        * @param $option_key
        * @param $option_value
        * @return bool
        */
        function update_option( $option_key, $option_value) {
            return update_site_option( self::ID . "_" . $option_key, $option_value);
        }

        /**
        * Retrieves api option from db
        *
        * @param $option_key
        * @param $default
        * @return mixed
        */
        function get_option( $option_key, $default ) {
            return get_site_option( self::ID . "_" . $option_key, $default );
        }

        /**
         * Subscribe an email
         * This handles save or update, so no need to check if an email exists
         *
         * @param $optin
         * @param $data
         *
         * @return bool|WP_Error
         */
        function subscribe( Opt_In_Model $optin, array $data ) {
            $err = new WP_Error();

            $err->add( 'something_wrong', __( 'Something went wrong. Please try again', Opt_In::TEXT_DOMAIN ) );

            $email = $data['email'];
            $merge_vals = array();

            if ( isset( $data['first_name'] ) ) {
                $name = $data['first_name'];
                $merge_vals['FIRSTNAME'] = $data['first_name'];
                $merge_vals['NAME'] = $data['first_name'];
            }
            elseif ( isset( $data['f_name'] ) ) {
                $name = $data['f_name'];
                $merge_vals['FIRSTNAME'] = $data['f_name']; // Legacy
                $merge_vals['NAME'] = $data['f_name']; // Legacy
            }
            if ( isset( $data['last_name'] ) ) {
                $surname = $data['last_name'];
                $merge_vals['LASTNAME'] = $data['last_name'];
                $merge_vals['NAME'] .= ' '.$data['last_name'];
            }
            elseif ( isset( $data['l_name'] ) ) {
                $surname = $data['l_name'];
                $merge_vals['LASTNAME'] = $data['l_name']; // Legacy
                $merge_vals['NAME'] .= ' '.$data['last_name']; // Legacy
            }

            // Add extra fields
            $merge_data = array_diff_key( $data, array(
                'email' => '',
                'firstname' => '',
                'lastname' => '',
                'f_name' => '',
                'l_name' => '',
            ) );
            $merge_data = array_filter( $merge_data );

            if ( ! empty( $merge_data ) ) {
                $merge_vals = array_merge( $merge_vals, $merge_data );
            }
            $merge_vals = array_change_key_case($merge_vals, CASE_UPPER);

            $api = self::api( $optin->api_key );

            if ( $api && ! empty( $email ) ) {

                $list_array = array( $optin->optin_mail_list );

                //First get the contact
                //We cannot add to a new list without getting the old list
                //We first get the old list id and merge with the new one
                $contact = $api->get_user( array( 'email' => $email ) );
                if ( !is_wp_error( $contact ) ) {
                    if ( $contact['code'] != 'failure' || ( isset( $contact['data'] ) && isset( $contact['data']['listid'] ) ) ) {
                        if ( in_array( $optin->optin_mail_list, $contact['data']['listid'] ) ) {
                            $err = new WP_Error();
                            $err->add( 'email_exist', __( 'This email address has already subscribed.', Opt_In::TEXT_DOMAIN ) );
                            return $err;
                        } else {
                            $list_array = array_merge( $list_array, $contact['data']['listid'] );
                        }
                    }
                }

                $subscribe_data = array(
                    'email'         => $email,
                    'listid'        => $list_array
                );
                if ( ! empty( $merge_vals ) ) {
                    $subscribe_data['attributes'] = $merge_vals;
                }
                $res = $api->create_update_user( $subscribe_data );

                if ( !is_wp_error( $res ) && isset( $res['code'] ) && $res['code'] == 'success' ) {
                    return true;
                } else {
                    $data['error'] = $res->get_error_message();
                    $optin->log_error( $data );
                }
                
            }

            return $err;
        }

        function get_options( $optin_id ) {
            $lists = array();
            $api = self::api( $this->api_key );
            $first = "";
            $total_lists = 0;
            $total = 0;
            
            if ( $api ) {
                //Load more function
                $load_more  = filter_input( INPUT_POST, 'load_more' );
                $offset = 2;

                if ( $load_more ) {
                    $list_pages = get_site_transient( self::LIST_PAGES );
                    if ( $list_pages ) {
                        $offset = $list_pages;
                    }
                    $lists_api = $api->get_lists( array(
                        "page" => ( 1 * $offset ),
                        "page_limit" => 10
                    ));

                    $offset = $offset + 1; 
                } else {
                    $lists_api = $api->get_lists( array(
                        "page" => 1,
                        "page_limit" => 10
                    ));
                    delete_site_transient( self::LIST_PAGES ); //clear pagination
                    delete_site_transient( self::CURRENT_LISTS ); //clear the lists we have
                }
                
                if( !is_wp_error( $lists_api ) && isset( $lists_api['data'] ) ) {

                    $total = $lists_api['data']['total_list_records'];

                    $api_lists = $lists_api['data']['lists'];

                    if ( is_array( $api_lists) ){
                        foreach ( $api_lists as $list ) {
                            $lists[ $list['id'] ]['value'] = $list['id'];
                            $lists[ $list['id'] ]['label'] = $list['name'];
                        }
                    }

                    if ( count( $lists ) >= $total ) {
                        $offset = 0; //We have reached the end. No more pagination
                    }

                    $old_lists = get_site_transient( self::CURRENT_LISTS );
                    if ( $old_lists && is_array( $old_lists ) ) {
                        $lists = array_merge( $old_lists, $lists );
                    }
                    set_site_transient( self::CURRENT_LISTS , $lists ); //save current list
                    set_site_transient( self::LIST_PAGES , $offset ); //set page offset

                    $total_lists = count( $lists );
                    

                    $first = $total_lists > 0 ? reset( $lists ) : "";
                    if( !empty( $first ) )
                        $first = $first['value'];
                }
            }
            $default_options =  array(
                "label" => array(
                    "id"    => "optin_email_list_label",
                    "for"   => "optin_email_list",
                    "value" => __( "Choose Email List:", Opt_In::TEXT_DOMAIN ),
                    "type"  => "label",
                ),
                "choose_email_list" => array(
                    "type"      => 'select',
                    'name'      => "optin_email_list",
                    'id'        => "optin_email_list",
                    "default"   => "",
                    'options'   => $lists,
                    'value'     => $first,
                    'selected'  => $first,
                    "attributes" => array(
                        'class' => "sendinblue_optin_email_list"
                    )
                ),
                'loadmore' => array(
                    "id"    => "loadmore_sendinblue_lists",
                    "name"  => "loadmore_sendinblue_lists",
                    "type"  => "button",
                    "value" => __( "Load More Lists", Opt_In::TEXT_DOMAIN ),
                    'class' => "wph-button--spaced wph-button wph-button--filled wph-button--gray sendinblue_optin_load_more_lists"
                )
            );


            if ( $total_lists <= 0 ) {
                //If we have no items, no need to show the button
                unset( $default_options['loadmore'] );
            } else if ( $total <= $total_lists ) {
                //If we have reached the end, remove the button
                unset( $default_options['loadmore'] );
            }

            return $default_options;
        }

        function get_account_options( $optin_id ){
            return array(
                "label" => array(
                    "id"    => "optin_api_key_label",
                    "for"   => "optin_api_key",
                    "value" => __("Enter Your API Key:", Opt_In::TEXT_DOMAIN),
                    "type"  => "label",
                ),
                "wrapper" => array(
                    "id"        => "wpoi-get-lists",
                    "class"     => "block-notification",
                    "type"      => "wrapper",
                    "elements"  => array(
                        "api_key" => array(
                            "id"            => "optin_api_key",
                            "name"          => "optin_api_key",
                            "type"          => "text",
                            "default"       => "",
                            "value"         => "",
                            "placeholder"   => "",
                        ),
                        'refresh' => array(
                            "id"    => "refresh_sendinblue_lists",
                            "name"  => "refresh_sendinblue_lists",
                            "type"  => "button",
                            "value" => __("Get Lists"),
                            'class' => "wph-button wph-button--filled wph-button--gray optin_refresh_provider_details"
                        ),
                    )
                ),
                "instructions" => array(
                    "id"    => "optin_api_instructions",
                    "for"   => "",
                    "value" => sprintf( __( "To get your API key, log in to your <a href='%s' target='_blank'>SendinBlue campaigns dashboard</a>, then click on API and Forms in the left menu, then select <strong>Manage your keys</strong>.", Opt_In::TEXT_DOMAIN ), 'https://account.sendinblue.com/advanced/api' ),
                    "type"  => "label",
                ),
            );
        }

        static function add_custom_field( $field, Opt_In_Model $optin ) {
            try{
                $api = self::api( $optin->api_key );
                $api->create_attribute( array( "type" => "normal", "data" => array(
                    strtoupper( $field['label'] ) => strtoupper( $field['type'] )
                ) ) );
                
                // double check if already on our system
                $current_module_fields = $optin->get_design()->__get( 'module_fields' );
                foreach( $current_module_fields as $m_field ) {
                    if ( $m_field['name'] == $field['name'] ) {
                        return array( 'error' => true, 'code' => 'custom', 'message' => __( 'Field already exists.', Opt_In::TEXT_DOMAIN ) );
                    }
                }
                
            }catch (Exception $e){
                return array( 'error' => true, 'code' => 'custom', 'message' => $e->getMessage() );
            }
            return array( 'success' => true, 'field' => $field );
        }
    }
endif;
?>