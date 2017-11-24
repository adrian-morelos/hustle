<?php

/**
 * Abstract class for optin model and stats
 *
 * Class Opt_In_Data
 */
abstract class Hustle_Data
{

    const KEY_DESIGN                = "design";
    const KEY_SETTINGS              = "settings";
    const KEY_VIEW                  = "view";
    const KEY_CONVERSION            = "conversion";
    const KEY_PAGE_SHARES           = "page_shares";
    const TEST_TYPES                = "test_types";
    const TRACK_TYPES               = "track_types";
	const KEY_AFTER_CONTENT = "after_content";
    const KEY_POPUP  = "popup";
    const KEY_SLIDE_IN  = "slide_in";
    const KEY_MAGIC_BAR  = "magic_bar";
    const KEY_SERVICES = "services";
    const KEY_APPEARANCE = "appearance";
    const KEY_FLOATING_SOCIAL = "floating_social";

    const ACTIVE_FOR_ADMIN = "active_for_admin";
    const ACTIVE_FOR_LOGGED_IN = "active_for_logged_in_user";

    /**
     * Optins types
     *
     * @var array
     */
    protected $types = array(
        'popup',
        'slide_in',
        'after_content',
        'shortcode',
        'widget'
    );

    /**
     *
     * @since 1.0.0
     *
     * @var array $_data
     */
    protected $_data;

    /**
     * Reference to $wpdb global var
     *
     * @since 1.0.0
     *
     * @var $wpdb WPDB
     * @access private
     */
    protected $_wpdb;

    /**
     *
     * Opt_In_Data constructor.
     */
    function __construct(){
        global $wpdb;
        $this->_wpdb = $wpdb;
    }


    /**
     * Returns table name
     *
     * @since 1.0.0
     *
     * @return string
     */
    protected function get_table(){
        return $this->_wpdb->base_prefix . Opt_In_Db::TABLE_OPT_IN;
    }

    /**
     * Returns meta table name
     *
     * @since 1.0.0
     *
     * @return string
     */
    protected function get_meta_table(){
        return $this->_wpdb->base_prefix . Opt_In_Db::TABLE_OPT_IN_META;
    }

    /**
     * Returns format for optin table
     *
     *
     * @since 1.0.0
     *
     * @return array
     */
    protected function get_format(){
        return array(
            "blog_id" => "%d",
            "optin_name" => "%s",
            "optin_title" => "%s",
            "optin_message" => "%s",
            "optin_provider" => "%s",
            "optin_mail_list" => "%s",
            "active" => "%d",
            "test_mode" => "%d"
        );
    }

    /**
     * Implements setter magic method
     *
     *
     * @since 1.0.0
     *
     * @param $property
     * @param $val
     */
    function __set($property, $val){
        $this->{$property} = $val;
    }

    /**
     * Implements getter magic method
     *
     *
     * @since 1.0.0
     *
     * @param $field
     * @return mixed
     */
    function __get( $field ){

        if( method_exists( $this, "get_" . $field ) )
            return $this->{"get_". $field}();

        if( !empty( $this->_data ) && isset( $this->_data->{$field} ) )
            return $this->_data->{$field};

    }
}