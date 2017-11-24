<?php

class Hustle_Collection
{

    /**
     * @return Hustle_Collection
     */
    public static function instance(){
        return new self;
    }

    /**
     * Reference to $wpdb global var
     *
     * @since 1.0.0
     *
     * @var $_db WPDB
     * @access private
     */
    protected static $_db;

    function __construct(){
        global $wpdb;
        self::$_db = $wpdb;
    }

    function get_count(){
        return self::$_db->num_rows;
    }

    /**
     * Returns table name
     *
     * @since 1.0.0
     *
     * @return string
     */
    protected function _get_table(){
        return self::$_db->base_prefix . Opt_In_Db::TABLE_OPT_IN;
    }


    /**
     * Returns meta table name
     *
     * @since 1.0.0
     *
     * @return string
     */
    protected function _get_meta_table(){
        return self::$_db->base_prefix . Opt_In_Db::TABLE_OPT_IN_META;
    }

    /**
     * Fetches all modules from db
     *
     * @param bool|true $active
     * @param $args
     * @return array Hustle_Custom_Content_Model[] | Opt_In_Model[]
     */
    function get_all_modules( $active = true, $args = array() ){
        $blog_id = (int) ( isset( $args['blog_id'] ) ? $args['blog_id']  : get_current_blog_id() );

        if( is_null( $active ) )
            $results = self::$_db->get_results( self::$_db->prepare( "SELECT `optin_id`, `optin_provider` FROM " . $this->_get_table() . " WHERE `blog_id`=%d ORDER BY  `optin_provider` ", $blog_id ), ARRAY_A );
        else
            $results = self::$_db->get_results( self::$_db->prepare( "SELECT `optin_id`, `optin_provider` FROM " . $this->_get_table() ." WHERE  `active`= %d AND `blog_id`=%d ORDER BY  `optin_provider` ", (int) $active, $blog_id ), ARRAY_A  );

        return array_map( array( $this, "return_model_from_results" ), (array) $results );
    }

    /**
     * @param $result
     * @return  Hustle_Custom_Content_Model | Opt_In_Model
     */
    function return_model_from_results( $result ){
        if( empty( $result ) || $result === array() ) return array();

        if( $result['optin_provider'] === "custom_content" )
            return Hustle_Custom_Content_Model::instance()->get( $result['optin_id'] );
        
        if( $result['optin_provider'] === "social_sharing" )
            return Hustle_Social_Sharing_Model::instance()->get( $result['optin_id'] );

        return Opt_In_Model::instance()->get( $result['optin_id']  );
    }
}