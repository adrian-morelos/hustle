<?php

/**
 * Class Opt_In_HubSpot
 */
class Opt_In_HubSpot extends Opt_In_Provider_Abstract  implements  Opt_In_Provider_Interface {
	const ID = "hubspot";
	const NAME = "Hubspot";

	static function instance() {
		return new self;
	}

	function is_authorized() {
		return true;
	}

	/**
	 * @return bool|Opt_In_HubSpot_Api
	 */
	function api() {
		return self::static_api();
	}

	static function static_api() {
		if ( ! class_exists( 'Opt_In_HubSpot_Api' ) )
			require_once 'opt-in-hubspot-api.php';

		$api = new Opt_In_HubSpot_Api();

		return $api;
	}

	/**
	 * Updates api option
	 *
	 * @param $option_key
	 * @param $option_value
	 * @return bool
	 */
	function update_option($option_key, $option_value) {
		return update_site_option( self::ID . "_" . $option_key, $option_value);
	}

	/**
	 * Retrieves api option from db
	 *
	 * @param $option_key
	 * @param $default
	 * @return mixed
	 */
	function get_option($option_key, $default ) {
		return get_site_option( self::ID . "_" . $option_key, $default );
	}

	function subscribe( Opt_In_Model $optin, array $data ) {
		$err = new WP_Error();
		$err->add( 'something_wrong', __( 'Something went wrong. Please try again', Opt_In::TEXT_DOMAIN ) );

		$api = $this->api();

		if ( $api && ! $api->is_error && ! empty( $data['email'] ) ) {
			$email_exist = $api->email_exists( $data['email'] );

			if ( $email_exist ) {
				$contact_id = $email_exist->vid;
				$list_memberships = 'list-memberships';
				$add_to_list = false;

				if ( empty( $email_exist->{$list_memberships} ) )
					$add_to_list = true;

				if ( $add_to_list ) {
					$res = $api->add_to_contact_list( $contact_id, $data['email'], $optin->optin_mail_list );

					if ( false === $res ) {
						$data['error'] = __( 'Unable to add this contact to contact list.', Opt_In::TEXT_DOMAIN );
						$optin->log_error($data);
					}
				}
				$err->add( 'something_wrong', __( 'This email has already subscribe.', Opt_In::TEXT_DOMAIN ) );
			} else {
				$res = $api->add_contact( $data );

				if ( ! is_object( $res ) && (int) $res > 0 ) {
					$contact_id = $res;
					// Add new contact to contact list
					$res = $api->add_to_contact_list( $contact_id, $data['email'], $optin->optin_mail_list );

					if ( false === $res ) {
						$data['error'] = __( 'Unable to add this contact to contact list.', Opt_In::TEXT_DOMAIN );
						$optin->log_error($data);
					}
					return true;
				} elseif( is_wp_error( $res ) ) {
					$data['error'] = $res->get_error_message();
					$optin->log_error( $data );
				} elseif ( isset( $res->status ) && 'error' == $res->status ) {
					$data['error'] = $res->message;
					$optin->log_error($data);
				}
			}
		}

		return $err;
	}

	function get_options( $optin_id ) {
		return array();
	}

	function get_account_options( $optin_id ) {
		$options = array();
		$email_list = '';
		$api = $this->api();

		if ( $optin_id ) {
			$optin = Opt_In_Model::instance()->get( $optin_id );
			$email_list = $optin->optin_mail_list;
		}
		$is_authorize = $api && ! $api->is_error && $api->is_authorized();

		$url = $api->get_authorization_uri( $optin_id );
		$link = sprintf( '<a href="%1$s" class="hubspot-authorize" data-optin="%2$s">%3$s</a>', $url, $optin_id, __( 'click here', Opt_In::TEXT_DOMAIN ) );

		if ( $api && ! $api->is_error ) {
			if ( ! $is_authorize ) {

				$info = __( 'Please %s to connect to your Hubspot account. You will be asked to give us access to your selected account and will be redirected back to this page.', Opt_In::TEXT_DOMAIN );
				$info = sprintf( $info, $link );
				$options['info'] = array(
					'type' => 'label',
					'value' => $info,
					'for' => '',
				);
			} else {
				$info = __( 'Please %s to reconnect to your Hubspot account. You will be asked to give us access to your selected account and will be redirected back to this page.', Opt_In::TEXT_DOMAIN );
				$info = sprintf( $info, $link );

				$list = $api->get_contact_list();
				$options = array(
					array(
						'type' => 'label',
						'value' => $info,
						'for' => '',
					),
					array(
						'type' => 'label',
						'for' => 'optin_email_list',
						'value' => __( 'Choose Contact List. Only static lists will work with Hustle', Opt_In::TEXT_DOMAIN ),
					),
					array(
						'type' 	=> 'select',
						'id' 	=> 'optin_email_list',
						'name' => 'optin_email_list',
						'options' => $list,
						'selected' => $email_list,
						'class' => 'wpmuiSelect',
					)
				);
			}
		}

		return $options;
	}

	static function add_custom_field( $field, Opt_In_Model $optin ) {
		$api = self::static_api();
		$name = $field['name'];
		$label = $field['label'];
		$exist = false;

		if ( $api && ! $api->is_error ) {
			// Get the existing fields
			$props = $api->get_properties();

			if ( ! empty( $props ) ) {
				// Check for existing property
				foreach ( $props as $property_name => $property_label )
					if ( $name == $property_name || $label == $property_label ) {
						$field['name'] = $property_name;
						$field['label'] = $property_label;
						$exist = true;
						continue;
					}
			}

			if ( ! $exist ) {
				// Add the new field as property
				$property = array(
					'name' => $name,
					'label' => $label,
					'type' => 'string',
					'fieldType' => 'text',
					'groupName' => 'contactinformation',
				);

				if ( $api->add_property( $property ) )
					$exist = true;
			}
		}

		if ( $exist )
			return array( 'success' => true, 'field' => $field );
		else
			return array( 'error' => true, 'code' => 'cannot_create_custom_field' );
	}
}

/**
 * Disable selected list description.
 */
add_filter( 'wpoi_optin_hubspot_show_selected_list', '__return_false' );