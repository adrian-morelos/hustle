<?php

/**
 * Class Opt_In_Collection
 *
 *
 */
class Hustle_Custom_Content_Collection extends Hustle_Collection
{

    /**
     * @return Hustle_Custom_Content_Collection
     */
    public static function instance(){
        return new self;
    }

    /**
     * Returns array of Opt_In_Model
     *
     *
     * @param bool|true $active
     * @param array $args
     * @return array Opt_In_Model[]
     */
    public function get_all( $active = true, $args = array() ){
        $blog_id = (int) ( isset( $args['blog_id'] ) ? $args['blog_id']  : get_current_blog_id() );

        if( is_null( $active ) )
            $ids = self::$_db->get_col( self::$_db->prepare( "SELECT `optin_id` FROM " . $this->_get_table() . " WHERE `optin_provider`='custom_content' AND `blog_id`=%d ORDER BY  `optin_id` DESC ", $blog_id ) );
        else
            $ids = self::$_db->get_col( self::$_db->prepare( "SELECT `optin_id` FROM " . $this->_get_table() ." WHERE `optin_provider`='custom_content' AND `active`= %d AND `blog_id`=%d ORDER BY  `optin_id` DESC ", (int) $active, $blog_id )  );

        return array_map( array( $this, "return_model_from_id" ), $ids );
    }

    function return_model_from_id( $id ){
        if( empty( $id )) return array();
        return Hustle_Custom_Content_Model::instance()->get( $id );
    }

    public function get_all_id_names(){
        return self::$_db->get_results( self::$_db->prepare( "SELECT `optin_id`, `optin_name` FROM " . $this->_get_table() ." WHERE `optin_provider`='custom_content' AND  `active`=%d AND `blog_id`=%d", 1, get_current_blog_id() ), OBJECT );
    }
} 