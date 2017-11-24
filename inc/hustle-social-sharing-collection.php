<?php

class Hustle_Social_Sharing_Collection extends Hustle_Collection {
	
	public static function instance() {
		return new self;
	}
	
	public function get_all( $active = true, $args = array() ) {
		$blog_id = (int) ( isset( $args['blog_id'] ) ? $args['blog_id'] : get_current_blog_id() );
		
		if ( is_null( $active ) ) {
			$ids = self::$_db->get_col( self::$_db->prepare( "SELECT `optin_id` FROM " . $this->_get_table() . " WHERE `optin_provider` = 'social_sharing' AND `blog_id` = %d ORDER BY `optin_id` DESC ", $blog_id ) );
		} else {
			$ids = self::$_db->get_col( self::$_db->prepare(" SELECT `optin_id` FROM " . $this->_get_table() . " WHERE `optin_provider` = 'social_sharing' AND `active` = %d AND `blog_id` = %d ORDER BY `optin_id` DESC ", (int) $active, $blog_id ) );
		}
		
		return array_map( array( $this, "return_model_from_id" ), $ids );
	}
	
	function return_model_from_id( $id ){
		if( empty($id) ) return array();
		return Hustle_Social_Sharing_Model::instance()->get( $id );
	}
    
    public function get_share_stats( $offset, $limit ) {
        $stats = self::$_db->get_results( self::$_db->prepare(" SELECT `meta_key`, `meta_value` FROM " . self::$_db->base_prefix . Opt_In_Db::TABLE_OPT_IN_META . " WHERE `meta_key` LIKE '%s' ORDER BY `meta_value` DESC LIMIT %d, %d ", '%' . Hustle_Data::KEY_PAGE_SHARES, $offset, $limit ) );
        return array_map( array( $this, "return_wp_from_stats" ), $stats );
    }
    
    function return_wp_from_stats($stats){
        if( empty($stats) ) return array();
        $page_id = (int) $stats->meta_key;
        $page = get_post($page_id);
        
        // page_id = 0 assume it as homepage
        if ( is_null($page) ) {
            $page = new stdClass();
            $page->ID = 0;
        }
        $page->page_shares = $stats->meta_value;
        return $page;
    }
    
    public function get_total_share_stats() {
        $stats = self::$_db->get_col( self::$_db->prepare(" SELECT COUNT(`meta_key`) FROM " . self::$_db->base_prefix . Opt_In_Db::TABLE_OPT_IN_META . " WHERE `meta_key` LIKE '%s' ", '%' . Hustle_Data::KEY_PAGE_SHARES) );
        return ( isset($stats[0]) ) 
            ? $stats[0]
            : 0;
    }
    
    public function update_page_share( $page_id ) {
        $meta_key = $page_id . '_' . Hustle_Data::KEY_PAGE_SHARES;
        $shares = self::$_db->get_col( self::$_db->prepare(" SELECT SUM(`meta_value`) AS total FROM " . self::$_db->base_prefix . Opt_In_Db::TABLE_OPT_IN_META . " WHERE `meta_key` = '%s' ", $meta_key) );
        
        if ( isset($shares[0]) ) {
            // update
            $shared = ( (int) $shares[0] ) + 1;
            return self::$_db->update(self::$_db->base_prefix . Opt_In_Db::TABLE_OPT_IN_META, array(
                "meta_value" => $shared
            ), array(
                'optin_id' => $page_id,
                'meta_key' => $meta_key
            ),
                array(
                    "%d",
                ),
                array(
                    "%d",
                    "%s"
                )
            );
        } else {
            // add new
            return self::$_db->insert( self::$_db->base_prefix . Opt_In_Db::TABLE_OPT_IN_META, array(
                "optin_id" => $page_id,
                "meta_key" => $meta_key,
                "meta_value" => 1
            ), array(
                "%d",
                "%s",
                "%d",
            ));
        }
    }
}

