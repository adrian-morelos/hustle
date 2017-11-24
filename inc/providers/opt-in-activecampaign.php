<?php

if( !class_exists("Opt_In_Activecampaign") ):

    include_once 'opt-in-activecampaign-api.php';

    class Opt_In_Activecampaign extends Opt_In_Provider_Abstract implements  Opt_In_Provider_Interface
    {
        const ID = "activecampaign";
        const NAME = "ActiveCampaign";


        /**
         * @var $api Activecampaign
         */
        protected  static $api;

        protected  static $errors;


        static function instance(){
            return new self;
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
         * @param $username
         * @param $api_key
         * @return Opt_In_Activecampaign_Api
         */
        protected static function api( $url, $api_key ){

            if( empty( self::$api ) ){
                try {
                    self::$api = new Opt_In_Activecampaign_Api( $url, $api_key );
                    self::$errors = array();
                } catch (Exception $e) {
                    self::$errors = array("api_error" => $e) ;
                }

            }

            return self::$api;
        }

        /**
         * Adds contact to the the campaign
         *
         * @param Opt_In_Model $optin
         * @param array $data
         * @return array|mixed|object|WP_Error
         */
        public function subscribe( Opt_In_Model $optin, array $data ){
			$api = self::api( $optin->provider_args->url, $optin->api_key );

			if ( isset( $data['f_name'] ) ) {
				$data['first_name'] = $data['f_name']; // Legacy
				unset( $data['f_name'] );
			}
			if( isset( $data['l_name'] ) ) {
				$data['last_name'] = $data['l_name']; // Legacy
				unset( $data['l_name'] );
			}
			$custom_fields = array_diff_key( $data, array( 'first_name' => '', 'last_name' => '', 'email' => '' ) );
			$origData = $data;

			if ( ! empty( $custom_fields ) ) {
				foreach ( $custom_fields as $key => $value ) {
					$key = 'field[%' . $key . '%,0]';
					$data[ $key ] = $value;
				}
			}

            return self::api( $optin->provider_args->url, $optin->api_key )->subscribe( $optin->optin_mail_list, $data, $optin, $origData );
        }

        /**
         * Retrieves initial options of the GetResponse account with the given api_key
         *
         * @param $optin_id
         * @return array
         */
        function get_options( $optin_id ){

            $_lists = self::api( $this->url, $this->api_key )->get_lists();

            if( is_wp_error( ( array) $_lists ) )
                return $_lists;

            if( empty( $_lists ) )
                return new WP_Error("no_audionces", __("No audience list defined for this account", Opt_In::TEXT_DOMAIN));

            if( !is_array( $_lists )  )
                $_lists = array( $_lists );

            $lists = array();
            foreach(  ( array) $_lists as $list ){
                $list = (object) (array) $list;

                $lists[ $list->id ] = array('value' => $list->id, 'label' => $list->name);

            }


            $first = count( $lists ) > 0 ? reset( $lists ) : "";
            if( !empty( $first ) )
                $first = $first['value'];

            return  array(
                "label" => array(
                    "id" => "optin_email_list_label",
                    "for" => "optin_email_list",
                    "value" => __("Choose list:", Opt_In::TEXT_DOMAIN),
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
                        "data-nonce" => wp_create_nonce("activecampaign_choose_campaign"),
                        'class' => "activecampaign_choose_campaign"
                    )
                )
            );

        }

        /**
         * Returns initial account options
         *
         * @param $optin_id
         * @return array
         */
        function get_account_options( $optin_id ){

            $ac_url = "";
            if( !empty( $optin_id ) ){
                $provider_args = Opt_In_Model::instance()->get( $optin_id )->get_provider_args();
                $ac_url = isset( $provider_args->url ) ? $provider_args->url : "";
            }

            return array(
                "optin_url_label" => array(
                    "id" => "optin_url_label",
                    "for" => "optin_url",
                    "value" => __("Enter your ActiveCampaign URL:", Opt_In::TEXT_DOMAIN),
                    "type" => "label",
                ),
                "optin_url_field_wrapper" => array(
                    "id" => "optin_url_id",
                    "class" => "optin_url_id_wrapper",
                    "type" => "wrapper",
                    "elements" => array(
                        "optin_url_field" => array(
                            "id" => "optin_url",
                            "name" => "optin_url",
                            "type" => "text",
                            "default" => "",
                            "value" => $ac_url,
                            "placeholder" => "",
                        )
                    )
                ),
                "optin_api_key_label" => array(
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
                            "id" => "refresh_activecampaign_lists",
                            "name" => "refresh_activecampaign_lists",
                            "type" => "button",
                            "value" => __("Get Lists"),
                            'class' => "wph-button wph-button--filled wph-button--gray optin_refresh_provider_details"
                        ),
                    )
                ),
                "instructions" => array(
                    "id" => "optin_api_instructions",
                    "for" => "",
                    "value" => __("Log in to your <a href='http://www.activecampaign.com/login/' target='_blank'>ActiveCampaign account</a> to get your URL and API Key.", Opt_In::TEXT_DOMAIN),
                    "type" => "label",
                ),
            );
        }

        function exclude_args_fields() {
            return array( 'api_key', 'url' );
        }

        function is_authorized(){
            return true;
        }


        public static function add_values_to_previous_optins( $option, $optin  ){
            if( $optin->optin_provider !== "activecampaign" ) return $option;

            if( $option['id'] === "optin_username_id" && isset( $optin->provider_args->username ) ){
                $option['elements']['optin_username_field']['value'] = $optin->provider_args->username;
            }

            return $option;
        }

        /**
         * Prevents default selected list from showing
         *
         * @param $val
         * @param $optin Opt_In_Model
         * @return bool
         */
        public static function show_selected_list(  $val, $optin  ){
            if( $optin->optin_provider !== Opt_In_Activecampaign::ID ) return true;
            return false;
        }

        /**
         * Renders selected list row
         *
         * @param $optin Opt_In_Model
         */
        public static function render_selected_list( $optin ){
            if( $optin->optin_provider !== Opt_In_Activecampaign::ID || !$optin->optin_mail_list ) return;
            printf( __("Selected audience list: %s (Press the GET LISTS button to update value)", Opt_In::TEXT_DOMAIN), $optin->optin_mail_list );
        }

		static function add_custom_field( $field, $optin ) {
			$api = self::api( $optin->provider_args->url, $optin->api_key );
			$available_fields = array( 'first_name', 'last_name', 'email' );

			if ( ! in_array( $field['name'], $available_fields ) ) {
				$custom_field = array( $field['name'] => $field['label'] );
				$api->add_custom_fields( $custom_field, $optin->optin_mail_list, $optin );
			}

			return array( 'success' => true, 'field' => $field );
		}
    }

    add_filter("wpoi_optin_filter_optin_options",  array( "Opt_In_Activecampaign", "add_values_to_previous_optins" ), 10, 2 );
    add_filter("wpoi_optin_activecampaign_show_selected_list",  array( "Opt_In_Activecampaign", "show_selected_list" ), 10, 2 );
    add_action("wpoi_optin_show_selected_list_after",  array( "Opt_In_Activecampaign", "render_selected_list" ) );
endif;