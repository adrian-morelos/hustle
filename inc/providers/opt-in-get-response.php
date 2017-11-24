<?php

if( !class_exists("Opt_In_Get_Response") ):

include_once 'opt-in-get-response-api.php';

/**
 * Defines and adds neeed methods for GetResponse email service provider
 *
 * Class Opt_In_Get_Response
 */
class Opt_In_Get_Response extends Opt_In_Provider_Abstract implements  Opt_In_Provider_Interface {

    const ID = "get_response";
    const NAME = "GetResponse";


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
                self::$api = new Opt_In_Get_Response_Api( $api_key, array("debug" => true) );
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

        $email =  $data['email'];

        $geo = new Opt_In_Geo();

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

        $new_data = array(
            'email' => $email,
            "dayOfCycle" => "10",
            'campaign' => array(
                "campaignId" => $optin->optin_mail_list
            ),
            "ipAddress" => $geo->get_user_ip()
        );

        if( count( $name ) )
            $new_data['name'] = implode(" ", $name);

		// Extra fields
		$extra_data = array_diff_key( $data, array(
			'email' => '',
			'first_name' => '',
			'last_name' => '',
			'f_name' => '',
			'l_name' => '',
		) );
		$extra_data = array_filter( $extra_data );

		if ( ! empty( $extra_data ) ) {
			$new_data['customFieldValues'] = array();

			foreach ( $extra_data as $key => $value ) {
				$meta_key = 'gr_field_' . $key;
				$custom_field_id = $optin->get_meta( $meta_key );
				$custom_field = array(
					'name' => $key,
					'type' => 'text', // We only support text for now
					'hidden' => false,
					'values' => array(),
				);

				if ( empty( $custom_field_id ) ) {
					$custom_field_id = self::api( $optin->api_key )->add_custom_field( $custom_field );

					if ( ! empty( $custom_field_id ) ) {
						$optin->add_meta( $meta_key, $custom_field_id );
					}
				}
				$new_data['customFieldValues'][] = array( 'customFieldId' => $custom_field_id, 'value' => array( $value ) );
			}
		}

        $res = self::api( $optin->api_key )->subscribe( $new_data );

		if ( is_wp_error( $res ) ) {
			$error_code = $res->get_error_code();
			$error_message = $res->get_error_message( $error_code );

			if ( preg_match( '%Conflict%', $error_message ) ) {
				$res->add( $error_code, __( 'This email address has already subscribed.', Opt_In::TEXT_DOMAIN ) );
			} else {
				$data['error'] = $error_message;
				$optin->log_error( $data );
			}
		}

		return $res;
    }

    /**
     * Retrieves initial options of the GetResponse account with the given api_key
     *
     * @param $optin_id
     * @return array
     */
    function get_options( $optin_id ){
        $campains = self::api( $this->api_key )->get_campains();

        if( is_wp_error( $campains ) )
            wp_send_json_error(  __("No active campaign is found for the API. Please set up a campaign in GetResponse or check your API.", Opt_In::TEXT_DOMAIN)  );

        $lists = array();
        foreach(  ( array) $campains as $campain ){
            $lists[ $campain->campaignId ]['value'] = $campain->campaignId;
            $lists[ $campain->campaignId ]['label'] = $campain->name;
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
                    "data-nonce" => wp_create_nonce("get_response_choose_campaign"),
                    'class' => "get_response_choose_campaign"
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
                        "id" => "refresh_get_response_lists",
                        "name" => "refresh_get_response_lists",
                        "type" => "button",
                        "value" => __("Get Lists"),
                        'class' => "wph-button wph-button--filled wph-button--gray optin_refresh_provider_details"
                    ),
                )
            ),
            "instructions" => array(
                "id" => "optin_api_instructions",
                "for" => "",
                "value" => __("Log in to your <a href='https://app.getresponse.com/manage_api.html' target='_blank'>GetResponse account</a> to get your API Key.", Opt_In::TEXT_DOMAIN),
                "type" => "label",
            ),
        );
    }

    function is_authorized(){
        return true;
    }

	static function add_custom_field( $field, Opt_In_Model $optin ) {
		$api = self::api( $optin->api_key );
		$type = ! in_array( $field['type'], array( 'text', 'number' ) ) ? 'text' : $field['type'];
		$key = $field['name'];

		$fields = $api->get_custom_fields();
		$exist = false;

		// Check for existing custom fields
		if ( ! is_wp_error( $fields ) && is_array( $fields ) ) {
			foreach ( $fields as $custom_field ) {
				$name = $custom_field->name;
				$custom_field_id = $custom_field->customFieldId;
				$meta_key = "gr_field_{$name}";

				// Update meta
				$optin->add_meta( $meta_key, $custom_field_id );

				if ( $name == $key ) {
					$exist = true;
				}
			}
		}

		// Add custom field if it doesn't exist
		if ( false === $exist ) {
			$custom_field = array(
				'name' => $key,
				'type' => $type,
				'hidden' => false,
				'values' => array(),
			);
			$custom_field_id = $api->add_custom_field( $custom_field );
			$optin->add_meta( "gr_field_{$key}", $custom_field_id );
		}

		return array( 'success' => true, 'field' => $field );
	}
}

endif;