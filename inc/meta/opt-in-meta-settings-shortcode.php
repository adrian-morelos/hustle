<?php
/**
 * Class Opt_In_Meta_Settings_Shortcode
 *
 *@property bool $enabled
 */
class Opt_In_Meta_Settings_Shortcode extends Hustle_Meta {

    /**
     * Returns conditions object
     *
     * @return object
     */
    function get_conditions(){
        return new stdClass();
    }

    /**
     * Decides if shortcode can be shown
     *
     * @return bool
     */
    function show_in_front(){
        if( current_user_can( "manage_options" ) ){
            return $this->enabled || $this->model->is_test_type_active( "shortcode" );
        }else{
            return $this->enabled;
        }
    }
} 