<?php

if( !class_exists("Opt_In_Mad_Mimi") ):

    include_once 'opt-in-mad-mimi-api.php';

class Opt_In_Mad_Mimi extends Opt_In_Provider_Abstract implements  Opt_In_Provider_Interface
{
    const ID = "mad_mimi";
    const NAME = "Mad Mimi";


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
     * @param $username
     * @param $api_key
     * @return Opt_In_Mad_Mimi_Api
     */
    protected static function api( $username, $api_key ){

        if( empty( self::$api ) ){
            try {
                self::$api = new Opt_In_Mad_Mimi_Api( $username, $api_key );
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

        $d = array();
        $d['email'] =  $data['email'];

		if ( $this->email_exist( $d['email'], $optin ) ) {
			$err = new WP_Error();
			$err->add( 'email_exist', __( 'This email address has already subscribed.', Opt_In::TEXT_DOMAIN ) );
			return $err;
		}

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
            $d['name'] = implode(" ", $name);

		// Add extra fields
		$data = array_diff_key( $data, array(
			'email' => '',
			'first_name' => '',
			'last_name' => '',
			'f_name' => '',
			'l_name' => '',
		) );
		$data = array_filter( $data );

		if ( ! empty( $data ) ) {
			$d = array_merge( $d, $data );
		}

        $res = self::api( $optin->provider_args->username, $optin->api_key )->subscribe( $optin->optin_mail_list, $d );

		if ( is_wp_error( $res ) ) {
			$error_code = $res->get_error_code();
			$data['error'] = $res->get_error_message( $error_code );
			$optin->log_error( $data );
		}

		return $res;
    }

	/**
	 * Validate if email already subscribe
	 *
	 * @param (string) $email			Current guest user email address.
	 * @param (object) $optin			Opt_In_Model class instance.
	 * @return (bool) Returns true if the specified email already subscribe otherwise false.
	 **/
	function email_exist( $email, Opt_In_Model $optin ) {
		$api = self::api( $optin->provider_args->username, $optin->api_key );
		$res = $api->search_by_email( $email );

		if ( is_object( $res ) && ! empty( $res->member ) && $email == $res->member->email ) {
			return true;
		}
		return false;
	}

    /**
     * Retrieves initial options of the GetResponse account with the given api_key
     *
     * @param $optin_id
     * @return array
     */
    function get_options( $optin_id ){

        $_lists = self::api( $this->username, $this->api_key )->get_lists();

        if( is_wp_error( ( array) $_lists ) )
            return $_lists;

        if( empty( $_lists ) )
            return new WP_Error("no_audionces", __("No audience list defined for this account", Opt_In::TEXT_DOMAIN));

        if( !is_array( $_lists )  )
            $_lists = array( $_lists );

        $lists = array();
        foreach(  ( array) $_lists as $list ){
            $list = (object) (array) $list;
            $list = $list->{'@attributes'};
            $lists[ $list['id']]['value'] = $list['id'];
            $lists[ $list['id']]['label'] = $list['name'];
        }


        $first = count( $lists ) > 0 ? reset( $lists ) : "";
        if( !empty( $first ) )
            $first = $first['value'];

        return  array(
            "label" => array(
                "id" => "optin_email_list_label",
                "for" => "optin_email_list",
                "value" => __("Choose campaign:", Opt_In::TEXT_DOMAIN),
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
                    "data-nonce" => wp_create_nonce("mad_mimi_choose_campaign"),
                    'class' => "mad_mimi_choose_campaign"
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
        return array(
            "optin_username_label" => array(
                "id" => "optin_username_label",
                "for" => "optin_username",
                "value" => __("Enter your username (email address):", Opt_In::TEXT_DOMAIN),
                "type" => "label",
            ),
            "optin_username_field_wrapper" => array(
                "id" => "optin_username_id",
                "class" => "optin_username_id_wrapper",
                "type" => "wrapper",
                "elements" => array(
                    "optin_username_field" => array(
                        "id" => "optin_username",
                        "name" => "optin_username",
                        "type" => "text",
                        "default" => "",
                        "value" => "",
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
                        "id" => "refresh_mad_mimi_lists",
                        "name" => "refresh_mad_mimi_lists",
                        "type" => "button",
                        "value" => __("Get Lists"),
                        'class' => "wph-button wph-button--filled wph-button--gray optin_refresh_provider_details"
                    ),
                )
            ),
            "instructions" => array(
                "id" => "optin_api_instructions",
                "for" => "",
                "value" => __("Log in to your <a href='https://madmimi.com' target='_blank'>Mad Mimi account</a> to get your API Key.", Opt_In::TEXT_DOMAIN),
                "type" => "label",
            ),
        );
    }

    function exclude_args_fields() {
        return array( 'api_key', 'username' );
    }

    function is_authorized(){
        return true;
    }


    public static function add_values_to_previous_optins( $option, $optin  ){
        if( $optin->optin_provider !== "mad_mimi" ) return $option;

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
        if( $optin->optin_provider !== Opt_In_Mad_Mimi::ID ) return true;
        return false;
    }

    /**
     * Renders selected list row
     *
     * @param $optin Opt_In_Model
     */
    public static function render_selected_list( $optin ){
        if( $optin->optin_provider !== Opt_In_Mad_Mimi::ID || !$optin->optin_mail_list ) return;
        printf( __("Selected audience list: %s (Press the GET LISTS button to update value)", Opt_In::TEXT_DOMAIN), $optin->optin_mail_list );
    }
}

    add_filter("wpoi_optin_filter_optin_options",  array( "Opt_In_Mad_Mimi", "add_values_to_previous_optins" ), 10, 2 );
    add_filter("wpoi_optin_mad_mimi_show_selected_list",  array( "Opt_In_Mad_Mimi", "show_selected_list" ), 10, 2 );
    add_action("wpoi_optin_show_selected_list_after",  array( "Opt_In_Mad_Mimi", "render_selected_list" ) );
endif;