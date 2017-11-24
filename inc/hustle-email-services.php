<?php

/**
 *
 * Class Hustle_Email_Services
 *
 */
class Hustle_Email_Services
{

    const SERVICE_PROVIDER_META_KEY = "service_provider";

    /**
     * @var array $_services
     */
    protected $_services = array();

    /**
     * @var int $_count
     */
    protected $_count = 0;

    /**
     * @var $_wpdb WPDB
     */
    protected $_wpdb;

    /**
     *
     * Hustle_Email_Services constructor.
     */
    function __construct()
    {
        global $wpdb;
        $this->_wpdb = $wpdb;

        $this->_populate();
    }

    /**
     * Populates services array
     *
     * @since 2.0
     */
    private function _populate(){
        $table = $this->_wpdb->base_prefix . Opt_In_Db::TABLE_OPT_IN;
        $meta_table = $this->_wpdb->base_prefix . Opt_In_Db::TABLE_OPT_IN_META;

        /**
         * Grab service providers saved alongside optin
         */
        $arr  = $this->_wpdb->get_results( $this->_wpdb->prepare("
        SELECT
            optins.`optin_id` AS `id`,
            optins.`optin_provider` AS `name`,
            optins.`optin_mail_list` AS `list_id`,
            meta.`meta_value` AS `api_key`
        FROM `$table` AS optins LEFT JOIN `$meta_table` AS meta ON optins.optin_id = meta.optin_id
        WHERE optins.`optin_provider`<>''
        AND optins.`optin_provider`<>'custom_content'
        AND meta.`meta_key` = 'api_key'
        AND optins.`blog_id` = %d
        ORDER BY optins.`optin_provider` DESC
        ",
            (int) get_current_blog_id()
        ), ARRAY_A);

        foreach( (array) $arr as $item ){
            $id = $item['id'];
            unset( $item['id'] );
            $item['source'] = "optin";
            $this->_services[ $id ] = (object) $item;
        }

        $this->_count = $this->_wpdb->num_rows;

        /**
         * Now grab service providers from meta table
         */
        $from_meta = $this->_wpdb->get_results( $this->_wpdb->prepare( "SELECT `meta_id`, `meta_value` FROM $meta_table WHERE `meta_key`=%s ", self::SERVICE_PROVIDER_META_KEY  ), ARRAY_A );

        foreach( (array) $from_meta as $item ){
            $this->_services[ $item['meta_id'] ] = json_decode( $item['meta_value'], false );
            $this->_services[ $item['meta_id'] ]->source = "meta";
        }

    }

    /**
     * Returns all unique service->list_id saved services
     *
     * since 2.0
     * @return array optin_id => (object) array( name, list_id, api_key )
     */
    function get_all(){
        return array_unique( $this->_services, SORT_REGULAR );
    }

    /**
     * @return int count of unique service->list_id
     */
    function get_count(){
        return $this->_count;
    }

    /**
     * Returns service provider with $id as id
     *
     * @param $id
     * @return object array( name, list_id, api_key )
     */
    function get( $id ){
        return  isset( $this->_services[ $id ] ) ? $this->_services[ $id ] : new stdClass() ;
    }
}