<?php
/**
 * Class Opt_In_Meta_Settings_Widget
 *
 *@property bool $enabled
 */
class Opt_In_Meta_Settings_Widget extends Hustle_Meta {

    /**
     * Returns conditions object
     *
     * @return object
     */
    function get_conditions(){
        return new stdClass();
    }


    /**
     * Decides if widget can be shown
     *
     * @return bool
     */
    function show_in_front(){
        if( current_user_can( "manage_options" ) ){
            return $this->enabled || $this->model->is_test_type_active( "widget" );
        }else{
            return $this->enabled;
        }
    }
} 