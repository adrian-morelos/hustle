<?php

/**
 * Class Opt_In_Meta_Settings_Popup
 *
 *@property string $animation_in
 *@property string $animation_out
 *@property int $appear_after
 *@property int $appear_after_time_val
 *@property string $appear_after_time_unit
 *@property int $appear_after_page_portion_val
 *@property string $appear_after_page_portion_unit
 *@property string $appear_after_element_val
 *@property bool $add_never_see_this_message
 *@property bool $close_button_acts_as_never_see_again
 *@property int $never_see_expiry
 *@property bool $enabled
 *@property array $conditions
 */
class Opt_In_Meta_Settings_Popup extends Hustle_Meta
{
    var $defaults = array(
        "enabled" =>false,
        "animation_in" =>"",
        "animation_out" =>"",
        "appear_after" =>"time", // scrolled | time | click | exit_intent | adblock
        "appear_after_scroll" =>"scrolled", // scrolled | selector
        "appear_after_time_val" =>5,
        "appear_after_time_unit" =>"seconds",
        "appear_after_page_portion_val" =>20,
        "appear_after_page_portion_unit" => "%",
        "appear_after_element_val" => "",
        "add_never_see_this_message" => false,
        "close_button_acts_as_never_see_again" => false,
		"allow_scroll_page" => true,
		"not_close_on_background_click" => true,
        "never_see_expiry" => 2,

        "show_on_all_posts" => true,
        "excluded_posts" => array(),
        "selected_posts" => array(),
        "show_on_all_pages" =>true,
        "excluded_pages" => array(),
        "selected_pages" => array(),

        "show_on_all_cats" =>true,
        "show_on_these_cats" => array(),
        "show_on_all_tags" =>true,
        "show_on_these_tags" => array(),

        "conditions" => array(),

        "trigger_on_time" => "immediately", // immediately|time
        "trigger_on_element_click:" => "",
        "trigger_on_exit" => false,
        "trigger_on_adblock" => false,
        "trigger_on_adblock_timed" => false,
        "trigger_on_adblock_timed_val" => 180,
        "trigger_on_adblock_timed_unit" => "seconds"
    );
    /**
     * Returns conditions object
     *
     * @return object
     */
    function get_conditions(){
        return (object) ( isset(  $this->data['conditions'] ) ? $this->data['conditions'] : new stdClass() );
    }
}