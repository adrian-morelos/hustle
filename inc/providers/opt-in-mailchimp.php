<?php

if( !class_exists("Opt_In_Mailchimp") ):

    include_once 'opt-in-mailchimp-api.php';

    class Opt_In_Mailchimp extends Opt_In_Provider_Abstract implements  Opt_In_Provider_Interface {

        const ID = "mailchimp";
        const NAME = "MailChimp";


        /**
         * @var $api Mailchimp
         */
        protected  static $api;
        protected  static $errors;

        const GROUP_TRANSIENT = "hustle-mailchimp-group-transient";
        const LIST_PAGES = "hustle-mailchimp-list-pages";

        static function instance(){
            return new self;
        }

        public static function register_ajax_endpoints(){
            add_action( "wp_ajax_hustle_mailchimp_get_list_groups", array( __CLASS__ , "ajax_get_list_groups" ) );
            add_action( "wp_ajax_hustle_mailchimp_get_group_interests", array( __CLASS__ , "ajax_get_group_interests" ) );
        }

        /**
         * Updates api option
         *
         * @param $option_key
         * @param $option_value
         * @return bool
         */
        function update_option($option_key, $option_value){
            return update_site_option( self::ID . "_" . $option_key, $option_value);
        }

        /**
         * Retrieves api option from db
         *
         * @param $option_key
         * @param $default
         * @return mixed
         */
        function get_option($option_key, $default){
            return get_site_option( self::ID . "_" . $option_key, $default );
        }

        /**
         * @param string $api_key
         * @return Mailchimp
         */
        protected static function api( $api_key ){

			if( empty( self::$api ) ){
				try {
                    $exploded = explode( '-', $api_key );
                    $data_center = end( $exploded );
					self::$api = new Opt_In_Mailchimp_Api( $api_key, $data_center );
					self::$errors = array();
				} catch (Exception $e) {
					self::$errors = array("api_error" => $e) ;
				}

			}
			return self::$api;
		}

        public function subscribe( Opt_In_Model $optin, array $data ){
            $api = self::api( $optin->api_key );

            $email =  $data['email'];
            $merge_vals = array();
            $interests = array();

            if ( isset( $data['first_name'] ) ) {
                $merge_vals['MERGE1'] = $data['first_name'];
                $merge_vals['FNAME'] = $data['first_name'];
            }
            elseif ( isset( $data['f_name'] ) ) {
                $merge_vals['MERGE1'] = $data['f_name']; // Legacy
                $merge_vals['FNAME'] = $data['f_name']; // Legacy
            }
            if ( isset( $data['last_name'] ) ) {
                $merge_vals['MERGE2'] = $data['last_name'];
                $merge_vals['LNAME'] = $data['last_name'];
            }
            elseif ( isset( $data['l_name'] ) ) {
                $merge_vals['MERGE2'] = $data['l_name']; // Legacy
                $merge_vals['LNAME'] = $data['l_name']; // Legacy
            }
            // Add extra fields
            $merge_data = array_diff_key( $data, array(
                'email' => '',
                'first_name' => '',
                'last_name' => '',
                'f_name' => '',
                'l_name' => '',
                'mailchimp_group_id' => '',
                'mailchimp_group_interest' => '',
            ) );
            $merge_data = array_filter( $merge_data );

            if ( ! empty( $merge_data ) ) {
                $merge_vals = array_merge( $merge_vals, $merge_data );
            }
            $merge_vals = array_change_key_case($merge_vals, CASE_UPPER);
            
            /**
             * Add args for interest groups
             */
            if( !empty( $data['mailchimp_group_id'] ) && !empty( $data['mailchimp_group_interest'] ) ){
                $data_interest = (array) $data['mailchimp_group_interest'];
                foreach( $data_interest as $interest ) {
                    $interests[$interest] = true;
                }
            }
            
            try {
                $subscribe_data = array(
                    'email_address' => $email,
                    'status' => 'pending' //confirmation mail
                );
                if ( !empty($merge_vals) ) {
                    $subscribe_data['merge_fields'] = $merge_vals;
                }
                if ( !empty($interests) ) {
                    $subscribe_data['interests'] = $interests;
                }
                $existing_member = $this->get_member( $email, $optin, $data );
                if ( $existing_member ) {
                    $member_interests = (array) $existing_member->interests;
					$can_subscribe = false;
					if ( isset( $subscribe_data['interests'] ) ){
						$local_interest_keys = array_keys( $subscribe_data['interests'] );
						foreach( $member_interests as $member_interest => $subscribed ){
							if( !$subscribed && in_array( $member_interest, $local_interest_keys ) ){
								$can_subscribe = true;
							}
						}
					}
                    if ( isset( $subscribe_data['interests'] ) && $can_subscribe ) {
                        unset( $subscribe_data['email_address'] );
						unset( $subscribe_data['merge_fields'] );
						unset( $subscribe_data['status'] );
						$response = $api->update_subscription( $optin->optin_mail_list, $email, $subscribe_data );
						return array( 'message' => $response, 'existing' => true);
                    } else {
                        $err = new WP_Error();
                        $err->add( 'email_exist', __( 'This email address has already subscribed', Opt_In::TEXT_DOMAIN ) );
                        return $err;
                    }
                } else {
                    $result = $api->subscribe( $optin->optin_mail_list, $subscribe_data );
                    return $result;
                }
            } catch( Exception $e ) {
                $data['error'] = $e->getMessage();
                $optin->log_error( $data );

                $err = new WP_Error();
                $err->add( 'server_failed', __( 'Something went wrong. Please try again.', Opt_In::TEXT_DOMAIN ) );
                return $err;
            }
        }

        /**
         * @param string $email
         * @param Opt_In_Model $optin
         * @param array $data
         *
         * @return Object Returns the member if the email address already exists otherwise false.
         */
        function get_member( $email, Opt_In_Model $optin, $data ) {
            $api = self::api( $optin->api_key );

            try {
                $member_info = $api->check_email($optin->optin_mail_list, $email);
                // Mailchimp returns WP error if can't find member on a list
                if ( is_wp_error($member_info) && $member_info->get_error_code() == 404 ) {
                    return false;
                }
                return $member_info;
            } catch( Exception $e ) {
                $data['error'] = $e->getMessage();
                $optin->log_error($data);

                return false;
            }
        }

        function get_options( $optin_id ) {

            //Load more function
            $load_more = filter_input( INPUT_POST, 'load_more' );

            $lists = array();

            if ( $load_more ) {
                $response = $this->lists_pagination( $this->api_key );
                list( $lists, $total ) =  $response;
            } else {
                $response = self::api( $this->api_key )->get_lists();
                $_lists   = $response->lists;
                $total    = $response->total_items;
                if( count( $_lists ) ) {
                    foreach( $_lists as $list ) {
                        $list = (array) $list;
                        $lists[ $list['id'] ]['value'] = $list['id'];
                        $lists[ $list['id'] ]['label'] = $list['name'];
                    }
                    delete_site_transient( self::LIST_PAGES );
                }
            }

            $total_lists = count( $lists );

            $first = $total_lists > 0 ? reset( $lists ) : "";
            if( !empty( $first ) )
                $first = $first['value'];


            $default_options =  array(
                "label" => array(
                    "id" => "optin_email_list_label",
                    "for" => "optin_email_list",
                    "value" => __("Choose email list:", Opt_In::TEXT_DOMAIN),
                    "type" => "label",
                ),
                "choose_email_list" => array(
                    "type" => 'select',
                    'name' => "optin_email_list",
                    'id' => "optin_email_list",
                    "default" => "",
                    'options' => $lists,
                    'value' => $first,
                    'selected' => $first,
                    "attributes" => array(
                        "data-nonce" => wp_create_nonce("mailchimp_choose_email_list"),
                        'class' => "mailchimp_optin_email_list"
                    )
                ),
                'loadmore' => array(
                    "id"    => "loadmore_mailchimp_lists",
                    "name"  => "loadmore_mailchimp_lists",
                    "type"  => "button",
                    "value" => __("Load More Lists", Opt_In::TEXT_DOMAIN),
                    'class' => "wph-button--spaced wph-button wph-button--filled wph-button--gray mailchimp_optin_load_more_lists"
                )
            );

            if ( $total_lists <= 0 ) {
                //If we have no items, no need to show the button
                unset( $default_options['loadmore'] );
            } else if ( $total <= $total_lists ) {
                //If we have reached the end, remove the button
                unset( $default_options['loadmore'] );
            }

            $list_group_options = self::_get_list_group_options( $this->api_key, $first );

            return array_merge( $default_options,  array(
                "wpoi-list-groups-wrapper" => array(
                    "id" => "wpoi-list-groups",
                    "class" => "wpoi-list-groups",
                    "type" => "wrapper",
                    "elements" =>  is_a( $list_group_options, "Mailchimp_Error" ) ? array() : $list_group_options
                ),
                "wpoi-list-group-interests-wrapper" => array(
                    "id" => "wpoi-list-group-interests-wrap",
                    "class" => "wpoi-list-group-interests-wrap",
                    "type" => "wrapper",
                    "elements" =>  array()
                )
            ));

        }

        /**
         * Lists pagination
         *
         * @return array
         */
        function lists_pagination( $api_key ) {
            
            $lists      = array();
            $list_pages = get_site_transient( self::LIST_PAGES );

            $offset     = 2; //Default limit to first page
            $total      = 0; //Default we have 0

            if ( $list_pages ) {
                $total  = isset( $list_pages['total'] ) ? $list_pages['total'] : 0;
                $offset = isset( $list_pages['offset'] ) ? $list_pages['offset'] : 2;
            } else {
                $list_pages = array();
            }

            if ( $offset > 0 ) {
                $response = self::api( $api_key )->get_lists( $offset );
                $_lists   = $response->lists;
                $total    = $response->total_items;

                if ( count( $_lists ) ) {
                    foreach( $_lists as $list ){
                        $list = (array) $list;
                        $lists[ $list['id'] ]['value'] = $list['id'];
                        $lists[ $list['id'] ]['label'] = $list['name'];
                    }
                    if ( count( $_lists ) >= $total ) {
                        $offset = 0; //We have reached the end. No more pagination
                    } else {
                        $offset = $offset + 1; 
                    }

                    $list_pages['offset'] = $offset;
                    $list_pages['total']  = $total;
                    set_site_transient( self::LIST_PAGES , $list_pages );
                } else {
                    delete_site_transient( self::LIST_PAGES );
                }
            } else {
                delete_site_transient( self::LIST_PAGES );
            }
            
            return array( $lists, $total );
        }

        function get_account_options( $optin_id ){
            return array(
                "label" => array(
                    "id" => "optin_api_key_label",
                    "for" => "optin_api_key",
                    "value" => __("Enter your API key:", Opt_In::TEXT_DOMAIN),
                    "type" => "label",
                ),
                "wrapper" => array(
                    "id" => "wpoi-get-lists",
                    "class" => "block-notification",
                    "type" => "wrapper",
                    "elements" => array(
                        "api_key" => array(
                            "id" => "optin_api_key",
                            "name" => "optin_api_key",
                            "type" => "text",
                            "default" => "",
                            "value" => "",
                            "placeholder" => "",
                        ),
                        'refresh' => array(
                            "id" => "refresh_mailchimp_lists",
                            "name" => "refresh_mailchimp_lists",
                            "type" => "button",
                            "value" => __("Get Lists"),
                            'class' => "wph-button wph-button--filled wph-button--gray optin_refresh_provider_details"
                        ),
                    )
                ),
                "instructions" => array(
                    "id" => "optin_api_instructions",
                    "for" => "",
                    "value" => __("Log in to your <a href='https://admin.mailchimp.com/account/api/' target='_blank'>MailChimp account</a> to get your API Key.", Opt_In::TEXT_DOMAIN),
                    "type" => "label",
                ),
            );
        }

        function is_authorized(){
            return true;
        }

        /**
         * Returns options for the given $list_id
         *
         * @param $api_key
         * @param $list_id
         * @return array|Exception
         */
        private static function _get_list_group_options( $api_key, $list_id ){
            $group_options = array();
            $options = array(
                -1 => array(
                    "value" => -1,
                    "label" => __("No group", Opt_In::TEXT_DOMAIN),
                    "interests" => __("First choose interest group", Opt_In::TEXT_DOMAIN)
                )
            );

            try{
                $groups = (array) self::api( $api_key )->get_interest_categories( $list_id );
            }catch (Exception $e){
                    return $e;
            }

            if( !count( $groups ) ) return $group_options;

            foreach( $groups as $group_key => $group ){
                $group = (array) $group;
                
                // get interests for each group category
                $groups[$group_key]->interests = (array) self::api( $api_key )->get_interests( $list_id, $group['id'] );
                
                $options[ $group['id'] ]['value'] = $group['id'];
                $options[ $group['id'] ]['label'] = $group['title'] . " ( " . ucfirst( $group['type'] ) . " )";
            }
            
            set_site_transient( self::GROUP_TRANSIENT  . $list_id, $groups );

            $first = current( $options );
            return array(
                "mailchimp_groups_label" => array(
                    "id" => "mailchimp_groups_label",
                    "for" => "mailchimp_groups",
                    "value" => __("Choose interest group:", Opt_In::TEXT_DOMAIN),
                    "type" => "label",
                ),
                "mailchimp_groups" => array(
                    "type" => 'select',
                    'name' => "mailchimp_groups",
                    'id' => "mailchimp_groups",
                    "default" => "",
                    'options' => $options,
                    'value' => $first,
                    'selected' => $first,
                    "attributes" => array(
                        "data-nonce" => wp_create_nonce("mailchimp_groups")
                    )
                ),
                "mailchimp_groups_instructions" => array(
                    "id" => "mailchimp_groups_instructions",
                    "for" => "",
                    "value" => __("Leave this option blank if you would like to opt-in users without adding them to a group first", Opt_In::TEXT_DOMAIN),
                    "type" => "label",
                )
            );

        }

        /**
         * Normalizes api response for groups interests
         *
         *
         * @since 1.0.1
         *
         * @param $interest
         * @return mixed
         */
        static function normalize_group_interest( $interest ){
            $interest = (array) $interest;
            $interest_arr = array();
            $interest_arr["label"] = $interest['name'];
            $interest_arr["value"] = $interest['id'];

            return $interest_arr;
        }
        /**
         * Returns interest for given $list_id, $group_id
         *
         * @since 1.0.1
         *
         * @param $list_id
         * @param $group_id
         * @return array
         */
        private static function _get_group_interests( $list_id, $group_id ){

            $interests = array(
                -1 => array(
                    "id" => -1,
                    "label" => __("No default choice", Opt_In::TEXT_DOMAIN)
                )
            );

            $groups = get_site_transient( self::GROUP_TRANSIENT  . $list_id );

            if( !count( $groups ) ) return $interests;

            $the_group = array();

            foreach( $groups as $group ){
                $group = (array) $group;
                if( $group["id"] == $group_id )
                    $the_group = $group;
            }
            
            if( $the_group === array() ) return $interests;

            if( in_array($the_group['type'], array("radio", "checkboxes", "hidden")) )
                $interests = array();

            $interests = array_merge( $interests,  array_map( array(__CLASS__, "normalize_group_interest" ),  $the_group['interests']) );

            if(  "hidden" === $the_group['type'] && isset( $the_group['interests'][0] ) )
                $the_group['selected'] = $the_group['interests'][0]['id'];

            return array(
                'group' => $the_group,
                "interests" => $interests,
                "type" => $the_group['type']
            );
        }

        /**
         * @used by array_map in _get_group_interest_args to map interests to their id/value
         *
         * @since 1.0.1
         * @param $interest
         * @return mixed
         */
        private function _map_interests_to_ids( $interest ){
            return $interest['value'];
        }

        /**
         * Returns interest args for the given $group_id and $list_id
         *
         * @since 1.0.1
         *
         * @param $list_id
         * @param $group_id
         * @return array
         */
        private static function _get_group_interest_args($list_id, $group_id ){
            $interests_config = self::_get_group_interests( $list_id, $group_id );
            $interests = $interests_config['interests'];

            $_type = $interests_config['type'];

            $type = "radio" === $interests_config['type'] ? "radios" : $interests_config['type'];
            $type = "dropdown" === $type || "hidden" === $type ? "select" : $type;

            $first = current( $interests );

            $interests_config['group']['interests'] = array_map( array(__CLASS__, "normalize_group_interest" ), $interests_config['group']['interests'] );

            $name = "mailchimp_groups_interests";

            if( $type === "checkboxes" )
                $name .= "[]";

            $choose_prompt = __("Choose default interest:", Opt_In::TEXT_DOMAIN);

            if( $_type === "checkboxes" )
                $choose_prompt = __("Choose default interest(s):", Opt_In::TEXT_DOMAIN);

            if( $_type === "hidden" )
                $choose_prompt = __("Set default interest:", Opt_In::TEXT_DOMAIN);

            if( $type === "radios" )
                $choose_prompt .= sprintf(" ( <a href='#' data-name='mailchimp_groups_interests' class='wpoi-leave-group-intrests-blank wpoi-leave-group-intrests-blank-radios' >%s</a> )", __("clear selection", Opt_In::TEXT_DOMAIN) );

            return array(
                'group' => $interests_config['group'],
                "fields" => array(
                    "mailchimp_groups_interest_label" => array(
                        "id" => "mailchimp_groups_interest_label",
                        "for" => "mailchimp_groups_interests",
                        "value" => $choose_prompt,
                        "type" => "label",
                    ),
                    "mailchimp_groups_interests" => array(
                        "type" => $type,
                        'name' => $name,
                        'id' => "mailchimp_groups_interests",
                        "default" => "",
                        'options' => $interests,
                        'value' => $first,
                        'selected' => array(),
                        "item_attributes" => array()
                    ),
                    "mailchimp_groups_interest_instructions" => array(
                        "id" => "mailchimp_groups_interest_instructions",
                        "for" => "",
                        "value" =>  __("What you select here will appear pre-selected for users. If this is a hidden group, the interest will be set but not shown to users.", Opt_In::TEXT_DOMAIN),
                        "type" => "label",
                    )
                )
            );
        }

        /**
         * Ajax endpoint to render html for group options based on given $list_id and $api_key
         *
         * @since 1.0.1
         */
        static function ajax_get_list_groups(){
            Opt_In_Utils::validate_ajax_call( 'mailchimp_choose_email_list' );

            $list_id = filter_input( INPUT_GET, 'optin_email_list' );
            $api_key = filter_input( INPUT_GET, 'optin_api_key' );
            $options = self::_get_list_group_options( $api_key, $list_id );

            $html = "";
            if( is_array( $options ) && !is_a($options, "Mailchimp_Error")  ){
                foreach( $options as $option )
                    $html .= Opt_In::static_render("general/option", $option , true);

                wp_send_json_success( $html );
            }

            wp_send_json_error( $options );
        }

        /**
         * Ajax call endpoint to return interest options of give list id and group id
         *
         * @since 1.0.1
         */
        static function ajax_get_group_interests(){
            Opt_In_Utils::validate_ajax_call( 'mailchimp_groups' );

            $list_id = filter_input( INPUT_GET, 'optin_email_list' );
            $group_id = filter_input( INPUT_GET, 'mailchimp_groups' );

            $groups_config = get_site_transient( self::GROUP_TRANSIENT  . $list_id );
            if( !$groups_config || !is_array( $groups_config ) )
                wp_send_json_error( __("Invalid list id: ", Opt_In::TEXT_DOMAIN) . $list_id );

            $args = self::_get_group_interest_args( $list_id, $group_id );
            $fields = $args['fields'];
            $html = "";
            foreach( $fields as $field )
                $html .= Opt_In::static_render("general/option", $field , true);

            wp_send_json_success(  array(
                "html" => $html,
                "group" => $args['group']
            ) );
        }

        static function add_custom_field( $field, Opt_In_Model $optin ) {
            try{
                // Mailchimp does not support "email" field type so let's use text
                // returns either the new MailChimp "merge_field" object or WP error (if already existing)
                self::api( $optin->api_key )->add_custom_field( $optin->optin_mail_list, array(
                    'tag' => strtoupper($field['name']),
                    'name' => $field['label'],
                    'type' => ( $field['type'] == 'email' ) ? 'text' : $field['type']
                ) );
                
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

    Opt_In_Mailchimp::register_ajax_endpoints();
endif;