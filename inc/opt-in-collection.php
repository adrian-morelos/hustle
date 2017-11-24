<?php

/**
 * Class Opt_In_Collection
 *
 *
 */
class Opt_In_Collection extends Hustle_Collection
{

    /**
     * @return Opt_In_Collection
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
     * @param int $limit
     * @return array Opt_In_Model[]
     */
    public function get_all_optins( $active = true, $args = array(), $limit = -1 ){
        $blog_id = (int) ( isset( $args['blog_id'] ) ? $args['blog_id']  : get_current_blog_id() );

        if( -1 != $limit ){
            $limit = "LIMIT $limit";
        }else{
            $limit = "";
        }

        if( is_null( $active ) )
            $ids = self::$_db->get_col( self::$_db->prepare( "SELECT `optin_id` FROM " . $this->_get_table() . " WHERE ". $this->_exclude_modules() ." AND `blog_id`=%d ORDER BY  `optin_name` $limit", $blog_id ) );
        else
            $ids = self::$_db->get_col( self::$_db->prepare( "SELECT `optin_id` FROM " . $this->_get_table() ." WHERE ". $this->_exclude_modules() ." AND `active`= %d AND `blog_id`=%d ORDER BY  `optin_name` $limit", (int) $active, $blog_id )  );

        return array_map( array( $this, "return_model_from_id" ), $ids );
    }

    function return_model_from_id( $id ){
        if( empty( $id )) return array();
        return Opt_In_Model::instance()->get( $id );
    }

    public function get_all_id_names(){
        return self::$_db->get_results( self::$_db->prepare( "SELECT `optin_id`, `optin_name` FROM " . $this->_get_table() ." WHERE `active`=%d AND `blog_id`=%d", 1, get_current_blog_id() ), OBJECT );
    }
    
    private function _exclude_modules() {
        $exclude = array(
            '`optin_provider` <> "custom_content"',
            '`optin_provider` <> "social_sharing"'
        );
        return implode(' AND ', $exclude);
    }
} 