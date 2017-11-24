<?php

/**
 * Class Opt_In_Model
 *
 * @property array $optin_mail_list
 * @property string $api_key
 * @property Opt_In_Meta_Design $design
 * @property Opt_In_Meta_Settings $settings
 * @property Opt_In_Decorator $decorated
 * @property Object $provider_args
 * @property integer $save_to_collection
 * @property array $subscriptions
 * @property array $total_subscriptions
 * @property bool $sync_with_e_newsletter
 * @property string $module_type
 */

class Opt_In_Model extends Hustle_Model
{

    const KEY_API_KEY               = "api_key";
    const PROVIDER_ARGS             = "provider_args";
    const SAVE_TO_LOCAL_COL         = "save_to_local_collection";
    const MIGRATE_OLD_DISPLAY         = "migrate_old_display_condition";
    const SUBSCRIPTION              = "subscription";
    const E_NEWSLETTER_GROUPS       = "e_newsletter_groups";
    const SYNC_WITH_E_NEWSLETTER    = "sync_with_e_newsletter";
    const HAS_LOCAL_SYNCED_WITH_E_NEWSLETTER = "has_local_synced_with_e_newsletter";
	const ERROR_LOG					= 'error_logs';

    /**
     * @var $_provider_details object
     */
    private $_provider_details;

    static function instance(){
        return new self;
    }

    function __get($field)
    {
        $from_parent = parent::__get($field);
        if( !empty( $from_parent ) )
            return $from_parent;

        if( in_array( $field, $this->types ) ){
            if( !isset( $this->_stats[ $field ] ) )
                $this->_stats[ $field ] = new Opt_In_Model_Stats($this, $field);

            return $this->_stats[ $field ];
        }

    }

    function get_api_key(){
        return $this->get_meta( self::KEY_API_KEY );
    }

    /**
     * Decorates current model
     *
     * @return Opt_In_Decorator
     */
    function get_decorated(){

        if( !$this->_decorator )
            $this->_decorator = new Opt_In_Decorator( $this );

        return $this->_decorator;
    }


    /**
     * Returns db data for current optin
     *
     * @return array
     */
    function get_data(){
        return array_merge(
            (array) $this->_data ,
            array(
                "api_key" => $this->api_key,
                'test_types' => $this->get_test_types(),
                'tracking_types' => $this->get_tracking_types(),
                "save_to_local" => $this->get_save_to_collection()
            ),
            array(
                "optin_mail_list" => $this->get_optin_mail_list(),
                "optin_provider" => $this->get_optin_provider()
            )
        );
    }

    /**
     * Returns optin settings
     *
     * @return Opt_In_Meta_Settings
     */
    public function get_settings(){
        $settings_json = $this->get_meta( self::KEY_SETTINGS );
        return new Opt_In_Meta_Settings( json_decode( $settings_json ? $settings_json : "{}", true ), $this );
    }

    /**
     * Returns opt-in design settings
     *
     * @return Opt_In_Meta_Design
     */
    public function get_design(){
        $settings_json = $this->get_meta( self::KEY_DESIGN );
        return new Opt_In_Meta_Design( json_decode( $settings_json ? $settings_json : "{}", true ), $this );
    }

    /**
     * Toggles state of optin or optin type
     *
     * @param null $environment
     * @return false|int|WP_Error
     */
    function toggle_state( $environment = null ){

        if( is_null( $environment ) )
            return parent::toggle_state( $environment );

        if( in_array( $environment, $this->types ) ) { // we are toggling state of a specific environment

            if( !is_object( $this->settings->{$environment} ) )
                return new WP_Error("Invalid_env", "Invalid environment . " . $environment);

            $prev_value = $this->settings->{$environment}->to_array();
            $prev_value['enabled'] = !isset( $prev_value['enabled'] ) || "false" === $prev_value['enabled'] ? "true": "false";
            $new_value = array_merge($this->settings->to_array(), array( $environment => $prev_value ));
            return $this->update_meta( self::KEY_SETTINGS,  json_encode( $new_value ) );
        }

    }

    /**
     * Returns provider name
     *
     * @return string provider name
     */
    function get_optin_provider(){
        if( isset( $this->_data->optin_provider )  && 0 !== intval( $this->_data->optin_provider  ) ){ // we need refrence to provider saved to metas table
            if( empty( $this->_provider_details ) )
                $this->_provider_details = Opt_In::get_email_services()->get( $this->_data->optin_provider  );

            return $this->_provider_details == (new stdClass() ) ? "" : $this->_provider_details->name ;
        }

        return $this->_data->optin_provider;
    }

    /**
     * Returns chosein mail list id
     *
     * @return string
     */
    function get_optin_mail_list(){
        if( isset( $this->_data->optin_provider )  && 0 !== intval( $this->_data->optin_provider  ) ){ // we need refrence to provider saved to metas table
            if( empty( $this->_provider_details ) )
                $this->_provider_details = Opt_In::get_email_services()->get( $this->_data->optin_provider  );

            return $this->_provider_details == ( new stdClass() ) ? "" : $this->_provider_details->list_id ;
        }

        return isset( $this->_data->optin_mail_list ) && "none" != $this->_data->optin_mail_list ? $this->_data->optin_mail_list : "";
    }

    /**
     * Returns provider args
     *
     * @since 1.0.1
     *
     * @return object
     */
    function get_provider_args(){
        $args = $this->get_meta( self::PROVIDER_ARGS );
        return empty( $args ) ? false : json_decode( $args, false );
    }

    /**
     * Checks if subscription should be saved to local collection
     *
     * @since 1.1.0
     * @return integer
     */
    function get_save_to_collection(){
        return in_array( $this->get_meta( self::SAVE_TO_LOCAL_COL ), array("true", true, 1, "1") ) ? 1 : 0;
    }

    /**
     * Adds new subscription to the local collection
     *
     * @since 1.1.0
     * @param array $data
     * @return bool
     */
    function add_local_subscription(array $data ){
        if( !$this->has_subscribed( $data['email'] ) )
            return $this->add_meta( self::SUBSCRIPTION, json_encode( $data ) );

        return new WP_Error("email_already_added", __("This email address has already subscribed.", Opt_In::TEXT_DOMAIN));
    }

    function has_subscribed( $email ){
        $email_like = '%"' . $email .'"%';
        $sql = $this->_wpdb->prepare( "SELECT `meta_id` FROM " . $this->get_meta_table() . " WHERE `optin_id`=%d AND `meta_key`=%s AND `meta_value`  LIKE %s ", $this->id, self::SUBSCRIPTION, $email_like  );
        return $this->_wpdb->get_var( $sql);
    }

    /**
     * Returns locally collected subscriptions saved to the local collection
     *
     * @return array
     */
    function get_local_subscriptions(){

        return array_map( "json_decode", $this->_wpdb->get_col( $this->_wpdb->prepare( "SELECT `meta_value` FROM " . $this->get_meta_table()  . " WHERE `meta_key`=%s AND `optin_id`=%d ",
            self::SUBSCRIPTION,
            $this->id
        )));
    }

    /**
     * Returns total conversion count
     *
     * @return int
     */
    function get_total_subscriptions(){
        return (int) $this->_wpdb->get_var( $this->_wpdb->prepare( "SELECT COUNT(meta_id) FROM " . $this->get_meta_table() . " WHERE `optin_id`=%d AND `meta_key`=%s ", $this->id, self::SUBSCRIPTION )  );
    }

    /**
     * Wheather this optin should sync with e-newsletter
     *
     * @since 1.1.1
     * @return bool|null
     */
    function get_sync_with_e_newsletter(){
        return $this->get_meta( self::SYNC_WITH_E_NEWSLETTER );
    }

    /**
     * Toggles sync with e-newsletter
     *
     * @since 1.1.1
     * @var bool $val
     * @return false|int
     */
    function toggle_sync_with_e_newsletter( $val = null ){
        return $this->update_meta( self::SYNC_WITH_E_NEWSLETTER, is_null( $val ) ? (int) !$this->get_sync_with_e_newsletter() : (int) $val );
    }

    /**
     * Returns e_newsletter groups
     *
     * @since 1.1.1
     * @return array
     */
    function get_e_newsletter_groups(){
        return (array) json_decode( $this->get_meta( self::E_NEWSLETTER_GROUPS ), true );
    }

    /**
     * Sets e-newsletter groups
     *
     *
     * @since 1.1.1
     * @param array $groups
     * @return false|int
     */
    function set_e_newsletter_groups( array $groups = array() ){
        return $this->update_meta( self::E_NEWSLETTER_GROUPS, json_encode( $groups ) );
    }

    /**
     * Checks if this optin has synced it's local-collection with e-newsletter before
     * This kind of sync is usually only done when admin toggles sync on only for the first time
     *
     * @since 1.1.2
     * @return bool
     */
    function get_has_local_collection_synced_with_e_newsletter(){
        return (bool) $this->get_meta( self::HAS_LOCAL_SYNCED_WITH_E_NEWSLETTER );
    }

    /**
     * Sets HAS_LOCAL_SYNCED_WITH_E_NEWSLETTER
     *
     * @since 1.1.2
     *
     * @param bool|true $val
     * @return false|int
     */
    function set_has_local_collection_synced_with_e_newsletter( $val = true ){
        return $this->update_meta( self::HAS_LOCAL_SYNCED_WITH_E_NEWSLETTER, $val );
    }

    function get_module_type(){
        return "optin";
    }

    /**
     * Checkes if module has type
     *
     * @param $type_name
     * @return bool
     */
    function has_type( $type_name ){
        return in_array( $type_name, $this->types );
    }
	
	/**
     * Returns array of active conditions objects
     *
     * @param $type
     * @return array
     */
    function get_type_conditions( $type ){
        $conditions = array();
        if( !in_array( $type, $this->types ) ) $conditions;
		
		// defaults
		$_conditions = array(
			'posts' => array(),
			'pages' => array(),
			'categories' => array(),
			'tags' => array()
		);
		
		$_conditions = wp_parse_args($this->settings->{$type}->conditions, $this->convert_display_condition_data($type, $_conditions));
		
		if ( isset($_conditions['scalar']) ) {
			unset($_conditions['scalar']);
		}
		
        if( !empty( $_conditions ) ){
            foreach( $_conditions as $condition_key => $args ){
				// only cpt have 'post_type' and 'post_type_label' properties
				if ( is_array($args) && isset($args['post_type']) && isset($args['post_type_label']) ) {
					$conditions[$condition_key] = Hustle_Condition_Factory::build( 'cpt', $args );
				} else {
					$conditions[$condition_key] = Hustle_Condition_Factory::build( $condition_key, $args );
				}
                if( $conditions[$condition_key] ) $conditions[$condition_key]->set_type( $type );
            }
        }
		
        return $conditions;
    }
	
	function convert_display_condition_data( $type, $conditions ) {
		// convert v1 data into v2 for posts
		$excluded_posts = $this->settings->{$type}->excluded_posts;
		$selected_posts = $this->settings->{$type}->selected_posts;
		if ( !empty($excluded_posts) && is_array($excluded_posts) ) {
			$conditions['posts']['filter_type'] = "except";
			$conditions['posts']['posts'] = $excluded_posts;
		}
		if ( !empty($selected_posts) && is_array($selected_posts) ) {
			$conditions['posts']['filter_type'] = "only";
			$conditions['posts']['posts'] = $selected_posts;
		}
		
		// convert v1 data into v2 for pages
		$excluded_pages = $this->settings->{$type}->excluded_pages;
		$selected_pages = $this->settings->{$type}->selected_pages;
		if ( !empty($excluded_pages) && is_array($excluded_pages) ) {
			$conditions['pages']['filter_type'] = "except";
			$conditions['pages']['pages'] = $excluded_pages;
		}
		if ( !empty($selected_pages) && is_array($selected_pages) ) {
			$conditions['pages']['filter_type'] = "only";
			$conditions['pages']['pages'] = $selected_pages;
		}
		
		// convert v1 data into v2 for categories
		$show_on_all_cats = (bool) $this->settings->{$type}->show_on_all_cats;
		$show_on_these_cats = $this->settings->{$type}->show_on_these_cats;
		$conditions['categories']['categories'] = ( is_null($show_on_these_cats) ) ? array() : $show_on_these_cats;
		if ( $show_on_all_cats ) {
			$conditions['categories']['filter_type'] = "except";
		} else {
			$conditions['categories']['filter_type'] = "only";
		}
		
		// convert v1 data into v2 for tags
		$show_on_all_tags = (bool) $this->settings->{$type}->show_on_all_tags;
		$show_on_these_tags = $this->settings->{$type}->show_on_these_tags;
		$conditions['tags']['tags'] = ( is_null($show_on_these_tags) ) ? array() : $show_on_these_tags;
		if ( $show_on_all_tags ) {
			$conditions['tags']['filter_type'] = "except";
		} else {
			$conditions['tags']['filter_type'] = "only";
		}
		
		return $conditions;
	}

	function get_field_types() {
		return array(
			'text' => __( 'Text', Opt_In::TEXT_DOMAIN ),
			'email' => __( 'Email', Opt_In::TEXT_DOMAIN ),
			'number' => __( 'Number', Opt_In::TEXT_DOMAIN ),
			'url' => __( 'URL', Opt_In::TEXT_DOMAIN ),
		);
	}

	function get_custom_field( $key, $value ) {
		$custom_fields = $this->get_design()->__get( 'module_fields' );

		foreach ( $custom_fields as $field ) {
			if ( isset( $field[ $key ] ) && $value == $field[ $key ] ) {
				return $field;
			}
		}
	}

	/**
	 * Save log to DB for every failed subscription.
	 *
	 * @param (array) $data			Submitted field data.
	 **/
	function log_error( $data ) {
		$data = wp_parse_args( array( 'date' => date( 'Y-m-d' ) ), $data );
		$this->add_meta( self::ERROR_LOG, json_encode( $data ) );
	}

	/**
     * Returns total error count
     *
     * @return int
     */
    function get_total_log_errors(){
        return (int) $this->_wpdb->get_var( $this->_wpdb->prepare( "SELECT COUNT(meta_id) FROM " . $this->get_meta_table() . " WHERE `optin_id`=%d AND `meta_key`=%s ", $this->id, self::ERROR_LOG )  );
    }

	/**
	 * Retrieve logs
	 **/
	function get_error_log() {
		return array_map( "json_decode", $this->_wpdb->get_col( $this->_wpdb->prepare( "SELECT `meta_value` FROM " . $this->get_meta_table()  . " WHERE `meta_key`=%s AND `optin_id`=%d ",
            self::ERROR_LOG,
            $this->id
        )));
	}

	/**
	 * Clear error logs.
	 **/
	function clear_error_log() {
		$this->_wpdb->query( $this->_wpdb->prepare( "DELETE FROM " . $this->get_meta_table() . " WHERE `meta_key`=%s AND `optin_id`=%d", self::ERROR_LOG, $this->id ) );
	}
}
