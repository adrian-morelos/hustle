<?php


if( !class_exists("Opt_In_Sendy") ):


class Opt_In_Sendy extends Opt_In_Provider_Abstract implements  Opt_In_Provider_Interface {

    const ID = "sendy";
    const NAME = "Sendy";


    /**
     * @var $api GetResponse
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
     * @param $api_key
     * @return Opt_In_Get_Response_Api
     */
    protected static function api( $api_key ){

        if( empty( self::$api ) ){
            try {
                self::$api = new Opt_In_Sendy_Api( $api_key, array("debug" => true) );
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
        $err = new WP_Error();
        $_data = array(
            "boolian" => false,
            "list" => $optin->optin_mail_list
        );
        $_data['email'] =  $data['email'];

		$name = array();

		if ( ! empty( $data['first_name'] ) ) {
			$name['first_name'] = $data['first_name'];
		}
		elseif ( ! empty( $data['f_name'] ) ) {
			$name['first_name'] = $data['f_name']; // Legacy
		}
		if ( ! empty( $data['last_name'] ) ) {
			$name['last_name'] = $data['last_name'];
		}
		elseif ( ! empty( $data['l_name'] ) ) {
			$name['last_name'] = $data['l_name']; // Legacy
		}

        if( count( $name ) )
            $_data['name'] = implode(" ", $name);

		// Add extra fields
		$extra_fields = array_diff_key( $data, array(
			'email' => '',
			'first_name' => '',
			'last_name' => '',
			'f_name' => '',
			'l_name' => '',
		) );
		$extra_fields = array_filter( $extra_fields );

		if ( ! empty( $extra_fields ) ) {
			$_data = array_merge( $_data, $extra_fields );
		}

        if( $optin->provider_args && !empty( $optin->provider_args->installation_url ) )
            $url = trailingslashit( $optin->provider_args->installation_url ) . "subscribe";
        else
            return $err;

        $res = wp_remote_post( $url, array(
            "header" => 'Content-type: application/x-www-form-urlencoded',
            "body" => $_data
        ));

        if( $res['response']['code'] <= 204 ){
            return true;
        }else{
            $err->add( $res['response']['code'], $res['response']['message']  );
            return $err;
        }
    }

    /**
     * Retrieves initial options of the GetResponse account with the given api_key
     *
     * @param $optin_id
     * @return array
     */
    function get_options( $optin_id ){
        return array();
    }

    /**
     * Returns initial account options
     *
     * @param $optin_id
     * @return array
     */
    function get_account_options( $optin_id ){
        return array(
            "label" => array(
                "id" => "optin_api_key_label",
                "for" => "optin_api_key",
                "value" => __("Enter your API key:", Opt_In::TEXT_DOMAIN),
                "type" => "label",
            ),
            "api_wrapper" => array(
                "id" => "wpoi-sendy-api-text",
                "class" => "wpoi-get-lists",
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
                )
            ),

            "choose_email_list_label" => array(
                "id" => "optin_email_list_label",
                "for" => "wpoi-sendy-get-lists",
                "value" => __("Enter list id:", Opt_In::TEXT_DOMAIN),
                "type" => "label",
            ),
            "list_wrapper" => array(
                "id" => "wpoi-sendy-get-lists",
                "class" => "wpoi-get-lists",
                "type" => "wrapper",
                "elements" => array(
                    "choose_email_list" => array(
                        "type" => 'text',
                        'name' => "optin_email_list",
                        'id' => "optin_email_list",
                        'value' => "",
                        "placeholder" => "",
                    ),
                )
            ),

            "installation_url_label" => array(
                "id" => "optin_installation_url_label",
                "for" => "optin_installation_url",
                "value" => __("Enter Sendy installation URL:", Opt_In::TEXT_DOMAIN),
                "type" => "label",
            ),
            "installation_wrapper" => array(
                "id" => "wpoi-sendy-installation-url",
                "class" => "wpoi-sendy-installation-url",
                "type" => "wrapper",
                "elements" => array(
                    "installation_url" => array(
                        "id" => "optin_sendy_installation_url",
                        "name" => "optin_sendy_installation_url",
                        "type" => "text",
                        "default" => "",
                        "value" => "",
                        "placeholder" => "",
                    ),
                )
            ),

            "instructions" => array(
                "id" => "optin_api_instructions",
                "for" => "",
                "value" => __("Log in to your Sendy installation to get your API Key and list id.", Opt_In::TEXT_DOMAIN),
                "type" => "label",
            ),
        );
    }

    function exclude_args_fields() {
        return array( 'api_key', 'installation_url', 'email_list' );
    }

    function is_authorized(){
        return true;
    }

    /**
     *
     *
     * @param $optin Opt_In_Model
     * @return bool
     */
    public static function show_selected_list( $val, $optin ){
        if( $optin->optin_provider === "sendy" )
            return false;

        return true;
    }

    public static function add_values_to_previous_optins( $option, $optin  ){
        if( $optin->optin_provider !== "sendy" ) return $option;

        if(  $option['id'] === "wpoi-sendy-get-lists" ){
            $option['elements']['choose_email_list']['value'] = $optin->optin_mail_list;
        }

        if( $option['id'] === "wpoi-sendy-installation-url" && isset( $optin->provider_args->installation_url ) ){
            $option['elements']['installation_url']['value'] = $optin->provider_args->installation_url;
        }

        return $option;
    }
}

add_filter("wpoi_optin_sendy_show_selected_list",  array( "Opt_In_Sendy", "show_selected_list" ), 10, 2 );
add_filter("wpoi_optin_filter_optin_options",  array( "Opt_In_Sendy", "add_values_to_previous_optins" ), 10, 2 );

endif;