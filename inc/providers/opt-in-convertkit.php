<?php
/**
 * Convertkit Email Integration
 *
 * @class Opt_In_ConvertKit
 * @version 2.0.3
 **/
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

if ( ! class_exists( 'Opt_In_ConvertKit' ) ) :

	include_once 'opt-in-convertkit-api.php';

	class Opt_In_ConvertKit extends Opt_In_Provider_Abstract implements  Opt_In_Provider_Interface {
		
		const ID = "convertkit";
		const NAME = "ConvertKit";
		
		/**
		* @var $api ConvertKit
		*/
		protected  static $api;
		protected  static $errors;

		static function instance() {
			return new self;
		}
		
		/**
		* @param $api_key
		* @return Opt_In_ConvertKit_Api
		*/
		protected static function api( $api_key, $api_secret = '' ){

			if( empty( self::$api ) ){
				try {
					self::$api = new Opt_In_ConvertKit_Api( $api_key, $api_secret );
					self::$errors = array();
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

		function get_options( $optin_id ) {
			$forms = self::api( $this->api_key )->get_forms();
			if( is_wp_error( $forms ) ) {
				wp_send_json_error(  __("No active form is found for the API. Please set up a form in ConvertKit or check your API.", Opt_In::TEXT_DOMAIN)  );
			}
			
			$lists = array();
			foreach(  ( array) $forms as $form ){
				$lists[ $form->id ]['value'] = $form->id;
				$lists[ $form->id ]['label'] = $form->name;
			}
			
			$first = count( $lists ) > 0 ? reset( $lists ) : "";
			if( !empty( $first ) ) $first = $first['value'];

			return  array(
				"label" => array(
					"id" => "optin_email_list_label",
					"for" => "optin_email_list",
					"value" => __("Choose a form:", Opt_In::TEXT_DOMAIN),
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
						"data-nonce" => wp_create_nonce("convert_kit_choose_form"),
						'class' => "convert_kit_choose_form"
					)
				)
			);
		}

		function get_account_options( $optin_id ) {
			$link = '<a href="https://app.convertkit.com/account/edit" target="_blank">ConvertKit</a>';
			$instruction = sprintf( __( 'Log in to your %s account to get your API Key.', Opt_In::TEXT_DOMAIN ), $link );
			
			$api_secret = "";
            if( !empty( $optin_id ) ){
                $provider_args = Opt_In_Model::instance()->get( $optin_id )->get_provider_args();
                $api_secret = isset( $provider_args->api_secret ) ? $provider_args->api_secret : "";
            }

			$options = array(
				'optin_api_secret_label' => array(
					'id' => 'optin-api-secret-label',
					'for' => 'optin_api_secret',
					'value' => __("Enter your API Secret:", Opt_In::TEXT_DOMAIN),
					'type' => 'label',
				),
				'optin_api_secret_wrapper' => array(
					'id' => 'wpoi-api-secret-wrapper',
					'class' => 'block-notification',
					'type' => 'wrapper',
					'elements' => array(
						'api_secret' => array(
							'id' => 'optin_api_secret',
							'name' => 'optin_api_secret',
							'type' => 'text',
							'default' => '',
							'value' => $api_secret,
							'placeholder' => '',
						),
					)
				),
				'label' => array(
					'id' => 'optin_api_key_label',
					'for' => 'optin_api_key',
					'value' => __("Enter your API Key:", Opt_In::TEXT_DOMAIN),
					'type' => 'label',
				),
				'wrapper' => array(
					'id' => 'wpoi-get-lists',
					'class' => 'block-notification',
					'type' => 'wrapper',
					'elements' => array(
						'api_key' => array(
							'id' => 'optin_api_key',
							'name' => 'optin_api_key',
							'type' => 'text',
							'default' => '',
							'value' => '',
							'placeholder' => '',
						),
						'refresh' => array(
							'id' => 'refresh_get_response_lists',
							'name' => 'refresh_get_response_lists',
							'type' => 'button',
							'value' => __("Get Forms", Opt_In::TEXT_DOMAIN ),
							'class' => "wph-button wph-button--filled wph-button--gray optin_refresh_provider_details"
						),
					)
				),
				'instruction' => array(
					'id' => 'optin_convertkit_instruction',
					'type' => 'label',
					'value' => $instruction,
					'for' => '',
				),
			);

			return $options;
		}

		function is_authorized() {
			return true;
		}

		function exclude_args_fields() {
            return array( 'api_key', 'api_secret' );
        }
		
		/**
         * Prevents default selected list from showing
         *
         * @param $val
         * @param $optin Opt_In_Model
         * @return bool
         */
        public static function show_selected_list(  $val, $optin  ){
            if( $optin->optin_provider !== Opt_In_ConvertKit::ID ) return true;
            return false;
        }
		
		/**
         * Renders selected list row
         *
         * @param $optin Opt_In_Model
         */
        public static function render_selected_form( $optin ){
            if( $optin->optin_provider !== Opt_In_ConvertKit::ID || !$optin->optin_mail_list ) return;
			$selected_form_label = $optin->optin_mail_list;
			$property = maybe_unserialize(self::instance()->get_option('lists', false));
			if ( $property && isset($property['choose_email_list']) ) {
				$options = ( isset($property['choose_email_list']['options']) ) 
					? $property['choose_email_list']['options']
					: false;
				$selected_form_label = ( $options && isset($options[$optin->optin_mail_list]) )
					? $options[$optin->optin_mail_list]['label']
					: $optin->optin_mail_list;
			}
			printf( __("Selected form: <strong>%s</strong> (Press the GET FORMS button to update value)", Opt_In::TEXT_DOMAIN), $selected_form_label );
        }
		
		/**
		* Adds subscribers to the form
		*
		* @param Opt_In_Model $optin
		* @param array $data
		* @return array|mixed|object|WP_Error
		*/
		public function subscribe( Opt_In_Model $optin, array $data ) {
			if ( !isset($data['email']) ) return false;

			// deal with custom fields first
			$custom_fields = array(
				'ip_address' => array(
					'label' => 'IP Address'
				)
			);
			$additional_fields = $optin->get_design()->__get( 'module_fields' );
			$subscribe_data_fields = array();

			if ( $additional_fields && is_array($additional_fields) && count($additional_fields) > 0 ) {
				foreach( $additional_fields as $field ) {
					// skip defaults
					if ( $field['name'] == 'first_name' || $field['name'] == 'email' ) {
						continue;
					}
					$meta_key = 'cv_field_' . $field['name'];
					$meta_value = $optin->get_meta( $meta_key );
					$field_name = $field['name'];

					if ( ! $meta_value || $meta_value != $field['label'] ) {
						$custom_fields[$field_name] = array(
							'label' => $field['label']
						);
					}

					if ( isset($data[$field_name]) ) {
						$subscribe_data_fields[$field_name] = $data[$field_name];
					}
				}
			}

			$err = new WP_Error();

			if ( ! $this->maybe_create_custom_fields( $optin, $custom_fields ) ) {
				$data['error'] = __( 'Unable to add custom field.', Opt_In::TEXT_DOMAIN );
				$optin->log_error( $data );
				$err->add( 'server_error', __( 'Something went wrong. Please try again.', Opt_In::TEXT_DOMAIN ) );
				return $err;
			}

			// subscription
			$geo = new Opt_In_Geo();
			$subscribe_data = array(
				"api_key" => $optin->api_key,
				"name" => ( isset($data['first_name']) ) ? $data['first_name'] : '',
				"email" => $data['email'],
				"fields" => array(
					"ip_address" => $geo->get_user_ip()
				)
			);
			$subscribe_data['fields'] = wp_parse_args( $subscribe_data_fields, $subscribe_data['fields'] );

			if ( $this->email_exist( $data['email'], $optin ) ) {
				$err->add( 'email_exist', __( 'This email address has already subscribed.', Opt_In::TEXT_DOMAIN ) );
				return $err;
			}

			$res = self::api( $optin->api_key )->subscribe( $optin->optin_mail_list, $subscribe_data );

			if ( is_wp_error( $res ) ) {
				$error_code = $res->get_error_code();
				$data['error'] = $res->get_error_message( $error_code );
				$optin->log_error( $data );
			}

			return $res;
		}

		function email_exist( $email, Opt_In_Model $optin ) {
			$api_secret = $optin->get_provider_args()->api_secret;
			$api = self::api( $optin->api_key, $api_secret );
			$subscriber = $api->is_subscriber( $email );
			return $subscriber;
		}

		/**
		* Creates necessary custom fields for the form
		*
		* @param Opt_In_Model $optin
		* @return array|mixed|object|WP_Error
		*/
		public function maybe_create_custom_fields( Opt_In_Model $optin, array $fields ) {
			$provider_args = $optin->get_provider_args();
			$api_secret = isset( $provider_args->api_secret ) ? $provider_args->api_secret : "";
			
			// check if already existing
			$custom_fields = self::api( $optin->api_key, $api_secret )->get_form_custom_fields();
			$proceed = true;
			foreach( $custom_fields as $custom_field ) {
				if ( isset( $fields[$custom_field->key] ) ) {
					unset($fields[$custom_field->key]);
				}
			}
			// create necessary fields
			// Note: we don't delete fields here, let the user do it on ConvertKit app.convertkit.com
			foreach( $fields as $key => $field ) {
				$add_custom_field = self::api( $optin->api_key )->create_custom_fields( array(
					'api_secret' => $api_secret,
					'label' => $field['label'],
				) );
				if ( is_wp_error($add_custom_field) ) {
					$proceed = false;
					break;
				}
			}

			return $proceed;
		}

		static function add_custom_field( $field, Opt_In_Model $optin ) {
			$provider_args = $optin->get_provider_args();
			$api_secret = isset( $provider_args->api_secret ) ? $provider_args->api_secret : "";
			$custom_fields = self::api( $optin->api_key, $api_secret )->get_form_custom_fields();
			$exist = false;

			if ( ! empty( $custom_fields ) ) {
				foreach ( $custom_fields as $custom_field ) {
					if ( $field['name'] == $custom_field->key ) {
						$exist = true;
					}
					// Save the key in meta
					$optin->add_meta( 'cv_field_' . $custom_field->key, $custom_field->label );
				}
			}

			if ( false === $exist ) {
				$add = self::api( $optin->api_key )->create_custom_fields( array(
					'api_secret' => $api_secret,
					'label' => $field['label'],
				) );

				if ( ! is_wp_error( $add ) ) {
					$exist = true;
					$optin->add_meta( 'cv_field_' . $field['name'], $field['label'] );
				}
			}

			if ( $exist ) {
				return array( 'success' => true, 'field' => $field );
			}

			return array( 'error' => true, 'code' => 'cannot_create_custom_field' );
		}
	}

	add_filter("wpoi_optin_convertkit_show_selected_list",  array( "Opt_In_ConvertKit", "show_selected_list" ), 10, 2 );
	add_action("wpoi_optin_show_selected_list_after",  array( "Opt_In_ConvertKit", "render_selected_form" ) );
	
endif;
