<?php
/**
 * Mautic Integration
 *
 * @class Opt_In_Mautic
 * @version 1.0.0
 **/
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

if ( ! class_exists( 'Opt_In_Mautic' ) ) :
	include_once 'opt-in-mautic-api.php';

	class Opt_In_Mautic extends Opt_In_Provider_Abstract implements  Opt_In_Provider_Interface {
		const ID = "mautic";
        const NAME = "Mautic";

		static function instance() {
			return new self;
		}

		static function api( $base_url = '', $username = '', $password = '' ) {
			try {
				return new Opt_In_Mautic_Api( $base_url, $username, $password );
			} catch ( Exception $e ) {
				return $e;
			}
		}

		function is_authorized() {
			return true;
		}

        function update_option($option_key, $option_value){
            return update_site_option( self::ID . "_" . $option_key, $option_value);
        }

        function get_option($option_key, $default){
            return get_site_option( self::ID . "_" . $option_key, $default );
        }

		function subscribe( Opt_In_Model $optin, array $data ) {
			if ( isset( $data['first_name'] ) ) {
				$data['firstname'] = $data['first_name'];
				unset( $data['first_name'] );
			}
			if ( isset( $data['last_name'] ) ) {
				$data['lastname'] = $data['last_name'];
				unset( $data['last_name'] );
			}
			if ( isset( $data['f_name'] ) ) {
				$data['firstname'] = $data['f_name'];
				unset( $data['f_name'] );
			}
			if ( isset( $data['l_name'] ) ) {
				$data['lastname'] = $data['l_name'];
				unset( $data['l_name'] );
			}

			$err = new WP_Error();
			$geo = new Opt_In_Geo();
			$data['ipAddress'] = $geo->get_user_ip();
			$provider_args = $optin->get_provider_args();

			$api = self::api( $provider_args->url, $provider_args->username, $provider_args->password );

			$exist = $api->email_exist( $data['email'] );

			if ( $exist && ! is_wp_error( $exist ) ) {
				$err->add( 'email_exist', __( 'This email address has already subscribed.', Opt_In::TEXT_DOMAIN ) );
				return $err;
			}
			$contact_id = $api->add_contact( $data, $optin );

			if ( is_wp_error( $contact_id ) ) {
				// Remove ipAddress
				unset( $data['ipAddress'] );
				$error_code = $contact_id->get_error_code();
				$data['error'] = $contact_id->get_error_message( $error_code );
				$optin->log_error( $data );
			} else {
				$api->add_contact_to_segment( $optin->optin_mail_list, $contact_id );
			}

			return $contact_id;
		}

        function get_options( $optin_id ){
			$api = self::api( $this->url, $this->username, $this->password );
			$segments = array();
			$value = '';
			$list = array();

			if ( $api ) {
				$segments = $api->get_segments();
			}
			if ( (int) $optin_id > 0 ) {
				$value =  ! empty( $optin->optin_email_list ) ? $optin->optin_email_list : '';
			}

			if ( ! empty( $segments ) ) {
				foreach ( $segments as $segment ) {
					$list[ $segment['id'] ] = array( 'value' => $segment['id'], 'label' => $segment['name'] );
				}
			}

			return array(
				array(
					'type' => 'label',
					'for' => 'optin_email_list',
					'value' => __( 'Choose Segment', Opt_In::TEXT_DOMAIN ),
				),
				array(
					'label' => __( 'Choose Segment', Opt_In::TEXT_DOMAIN ),
					'id' => 'optin_email_list',
					'name' => 'optin_email_list',
					'type' => 'select',
					'value' => $value,
					'options' => $list,
					'selected' => $value,
				),
			);
		}

		function get_account_options( $optin_id ) {
			$url = '';
			$username = '';
			$password = '';

			if ( ! empty( $optin_id ) ) {
				$optin = Opt_In_Model::instance()->get( $optin_id );
				$provider_args = $optin->get_provider_args();

				$api_key = $optin->api_key;
				if ( isset( $provider_args->url ) ) {
					$url = $provider_args->url;
				}
				if ( isset( $provider_args->username ) ) {
					$username = $provider_args->username;
				}
				if ( isset( $provider_args->password ) ) {
					$password = $provider_args->password;
				}
			}

			$options = array(
				'opt_base_url_label' => array(
					'id' => 'opt_base_url_label',
					'for' => '',
					'type' => 'label',
					'value' => __( 'Enter your Mautic installation URL', Opt_In::TEXT_DOMAIN ),
				),
				'opt_url' => array(
					'id' => 'optin_url',
					'name' => 'optin_url',
					'value' => $url,
					'placeholder' => 'https://your-name-here.mautic.net',
					'type' => 'text',
				),
				array(
					'id' => 'opt-username-label',
					'for' => 'optin_username',
					'type' => 'label',
					'value' => __( 'Enter your Username', Opt_In::TEXT_DOMAIN ),
				),
				array(
					'id' => 'optin_username',
					'name' => 'optin_username',
					'type' => 'text',
					'value' => $username,
				),
				array(
					'id' => 'opt-pass-label',
					'for' => 'optin_password',
					'type' => 'label',
					'value' => __( 'Enter your Password', Opt_In::TEXT_DOMAIN ),
				),
				'wrapper2' => array(
					'id' => 'wpoi-get-lists',
					'type' => 'wrapper',
					'class' => 'block-notification',
					'elements' => array(
						array(
							'id' => 'optin_password',
							'type' => 'text',
							'name' => 'optin_password',
							'value' => $password,
						),
						'refresh' => array(
							"id" => "refresh_mautic_lists",
							"name" => "refresh_mautic_lists",
							"type" => "button",
							"value" => __("Get List", Opt_In::TEXT_DOMAIN),
							'class' => "wph-button wph-button--filled wph-button--gray optin_refresh_provider_details"
						),
					),
				),
				"instructions" => array(
                    "id"    => "optin_api_instructions",
                    "for"   => "",
                    "value" => __( "Ensure you enable API and HTTP Basic Auth in your Mautic configuration API settings. Your Mautic installation URL must start with either http or https", Opt_In::TEXT_DOMAIN ),
                    "type"  => "label",
                ),
			);

			return $options;
		}

		function exclude_args_fields() {
			return array( 'api_key', 'username', 'url', 'password' );
		}	

		static function add_custom_field( $field, Opt_In_Model $optin ) {
			$provider_args = $optin->get_provider_args();
			$api = self::api( $provider_args->url, $provider_args->username, $provider_args->password );

			$custom_fields = $api->get_custom_fields();
			$label = $field['label'];
			$alias = $field['name'];
			$exist = false;

			if ( is_array( $custom_fields ) ) {
				foreach ( $custom_fields as $custom_field ) {
					if ( $label == $custom_field['label'] ) {
						$exist = true;
						$field['name'] = $custom_field['alias'];
					} elseif ( $custom_field['alias'] == $alias ) {
						$exist = true;
					}
				}
			}

			if ( false === $exist ) {
				$custom_field = array(
					'label' => $label,
					'alias' => $alias,
					'type' => $field['type'],
				);

				$exist = $api->add_custom_field( $custom_field );
			}

			if ( $exist ) {
				return array( 'success' => true, 'field' => $field );
			}

			return array( 'error' => true, 'code' => '' );
		}
	}
endif;
