<?php

if( !class_exists("Opt_In_Infusion_Soft") ):

    include_once("opt-in-infusionsoft-api.php");
class Opt_In_Infusion_Soft extends Opt_In_Provider_Abstract  implements  Opt_In_Provider_Interface {

    const ID = "infusionsoft";
    const NAME = "Infusionsoft";

    const CLIENT_ID = "inc_opt_infusionsoft_clientid";
    const CLIENT_SECRET = "inc_opt_infusionsoft_clientsecret";
    const API_CODE = "inc_opt_infusionsoft_api_code";
    const API_SCOPE = "inc_opt_infusionsoft_api_scope";
    const ACCESS_TOKEN_RES = "inc_opt_infusionsoft_access_token";
    const CURRENT_PAGE_URL = "inc_opt_infusionsoft_current_page_url";

    /**
     * @var WP_Error $errors
     */
    protected static $errors;

    /**
     * @var Opt_In_Infusionsoft_Api $api
     */
    protected  static $api;

    static function instance()
    {
        return new self;
    }

    /**
     * Returns a cached api
     *
     * @param $api_key
     * @param $app_name
     * @return Opt_In_Infusionsoft_Api
     */
    protected static function api( $api_key, $app_name){

        if( empty( self::$api ) ){
            try {
                self::$errors = array();
                self::$api = new Opt_In_Infusionsoft_Api( $api_key , $app_name);
            } catch (Exception $e) {
                self::$errors = array("api_error" => $e) ;
            }

        }

        return self::$api;
    }

    /**
     * Updates api option
     *
     * @param $option_key
     * @param $option_value
     * @return bool
     */
    function update_option($option_key, $option_value)
    {
        return update_site_option(self::ID . "_" . $option_key, $option_value);
    }

    /**
     * Retrieves api option from db
     *
     * @param $option_key
     * @param $default
     * @return mixed
     */
    function get_option($option_key, $default)
    {
        return get_site_option(self::ID . "_" . $option_key, $default);
    }


    function subscribe(Opt_In_Model $optin, array $contact)
    {

		$api = self::api( $optin->api_key, $optin->provider_args->account_name );

		if ( isset( $contact['email'] ) ) {
			$contact['Email'] = $contact['email'];
		}
		if ( isset( $contact['first_name'] ) ) {
			$contact['FirstName'] = $contact['first_name'];
		}
		elseif ( isset( $contact['f_name'] ) ) {
			$contact['FirstName'] = $contact['f_name']; // Legacy
		}
		if ( isset( $contact['last_name'] ) ) {
			$contact['LastName'] = $contact['last_name'];
		}
		elseif ( isset( $contact['l_name'] ) ) {
			$contact['LastName'] = $contact['l_name'];
		}
		$contact = array_diff_key( $contact, array(
			'email' => '',
			'first_name' => '',
			'last_name' => '',
			'f_name' => '',
			'l_name' => '',
		) );

		$custom_fields = $optin->get_meta( 'is_custom_fields' );

		if ( empty( $custom_fields ) ) {
			$custom_fields = $api->get_custom_fields();
		} else {
			$custom_fields = json_decode( $custom_fields );
		}

		$extra_custom_fields = array_diff_key( $contact, array_fill_keys( $custom_fields, 1 ) );
		$found_extra = array();

		if ( ! empty( $extra_custom_fields ) ) {

			foreach ( $extra_custom_fields as $key => $value ) {
				$field = $optin->get_custom_field( 'name', $key );
				$label = str_replace( ' ', '', ucwords( $field['label'] ) );

				// Attempt to check the label
				if ( in_array( $label, $custom_fields ) ) {
					$contact[ $label ] = $value;
				} else {
					$found_extra[ $key ] = $value;
				}
				unset( $contact[ $key ] );
			}
		}

		if ( ! empty( $found_extra ) ) {
			$data = $contact;
			$data['error'] = __( 'Some fields are not successfully added.', Opt_In::TEXT_DOMAIN );
			$optin->log_error( $data );
		}

        $contact_id = $api->add_contact( $contact );
 
        if( !is_wp_error( $contact_id ) ){
            $contact_id = $api->add_tag_to_contact( $contact_id, $optin->optin_mail_list );
        }

        if( !is_wp_error( $contact_id ) ) {
            return __("Contact successfully added", Opt_In::TEXT_DOMAIN) ;
		} else {
			$error_code = $contact_id->get_error_code();

			if ( 'email_exist' != $error_code ) {
				$contact['error'] = $contact_id->get_error_message( $error_code );
				$optin->log_error( $contact );
			}

            return $contact_id;
		}
    }

    function get_options( $optin_id )
    {
        $lists  = self::api( $this->api_key, $this->account_name )->get_lists();
        if( is_wp_error( $lists ) )
            wp_send_json_error( $lists->get_error_messages() );
        
        $first = reset( $lists );
        return  array(
            "label" => array(
                "id" => "optin_email_list_label",
                "for" => "optin_email_list",
                "value" => __("Choose Tag:", Opt_In::TEXT_DOMAIN),
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
                    "data-nonce" => wp_create_nonce("infusionsoft_choose_tag"),
                    'class' => "infusionsoft_choose_tag"
                )
            )
        );
    }


    function get_account_options( $optin_id )
    {
        $account_name = "";
        if( !empty( $optin_id ) ){
            $provider_args = Opt_In_Model::instance()->get( $optin_id )->get_provider_args();
            $account_name = isset( $provider_args->account_name ) ? $provider_args->account_name : "";
        }

        return array(
            "optin_client_id_label" => array(
                "id" => "optin_api_key_label",
                "for" => "optin_api_key",
                "value" => __("Enter your API (encrypted) key:", Opt_In::TEXT_DOMAIN),
                "type" => "label",
            ),
            "api_wrapper" => array(
                "id" => "optin_client_id",
                "class" => "optin_client_id_wrapper",
                "type" => "wrapper",
                "elements" => array(
                    "api_key" => array(
                        "id" => "optin_api_key",
                        "name" => "optin_api_key",
                        "type" => "text",
                        "default" => "",
                        "placeholder" => "",
                        "value" => ""
                    ),
                )
            ),
            "app_name" => array(
                "id" => "app_name_wrapper_label",
                "for" => "optin_infusion_soft_app_name",
                "value" => __("Enter your account name:", Opt_In::TEXT_DOMAIN),
                "type" => "label",
            ),
            "wrapper" => array(
                "id" => "wpoi-get-lists",
                "class" => "block-notification",
                "type" => "wrapper",
                "elements" => array(
                    "app_name" => array(
                        "id" => "optin_account_name",
                        "name" => "optin_account_name",
                        "type" => "text",
                        "default" => "",
                        "value" => $account_name,
                        "placeholder" => "",
                    ),
                    'refresh' => array(
                        "id" => "refresh_infusion_soft_lists",
                        "name" => "refresh_infusion_soft_lists",
                        "type" => "button",
                        "value" => __("Get Tags"),
                        'class' => "wph-button wph-button--filled wph-button--gray optin_refresh_provider_details"
                    ),
                )
            ),
            "instructions" => array(
                "id" => "optin_api_instructions",
                "for" => "",
                "value" => sprintf(
                    __("Log in to your infusion account to get <a target='_blank' href='%s'>API ( encrypted ) key </a> and <a href='%s' target='_blank' >account name</a>", Opt_In::TEXT_DOMAIN),
                    "http://help.infusionsoft.com/userguides/get-started/tips-and-tricks/api-key",
                    "http://help.mobit.com/infusionsoft-integration/how-to-find-your-infusionsoft-account-name"
                    ),
                "type" => "label",
            ),
        );
    }

    function exclude_args_fields() {
        return array( 'api_key', 'account_name' );
    }


    function is_authorized()
    {
        return true;
    }

     /**
     * @param $optin Opt_In_Model
     * @return bool
     */
    public static function show_selected_list( $val, $optin ){
        if( $optin->optin_provider === Opt_In_Infusion_Soft::ID )
            return false;

        return true;
    }

    public static function render_selected_tag($optin){
        if( $optin->optin_provider !== Opt_In_Infusion_Soft::ID || !$optin->optin_mail_list ) return;
        printf( __("Selected tag: %s (Press the GET TAGS button to update value) ", Opt_In::TEXT_DOMAIN), $optin->optin_mail_list );
    }

	static function add_custom_field( $field, $optin ) {
		$api = self::api( $optin->api_key, $optin->provider_args->account_name );
		$custom_fields = $api->get_custom_fields();

		// Update custom fields meta
		$optin->add_meta( 'is_custom_fields', $custom_fields );

		// Check if custom field name exist on existing custom fields
		if ( in_array( $field['name'], $custom_fields ) ) {
			return array( 'success' => true, 'field' => $field );
		}

		// Check if label can be use as name
		$label = str_replace( ' ', '', ucwords( $field['label'] ) );
		if ( in_array( $label, $custom_fields ) ) {
			// Replace the field name
			$field['name'] = $label;

			return array( 'success' => true, 'field' => $field );
		}

		return array( 'error' => true, 'code' => 'custom_field_not_exist' );
	}
}

    add_filter("wpoi_optin_infusionsoft_show_selected_list", array("Opt_In_Infusion_Soft", "show_selected_list"), 10, 2);
    add_action("wpoi_optin_show_selected_list_after", array("Opt_In_Infusion_Soft", "render_selected_tag"), 10, 2);
endif;