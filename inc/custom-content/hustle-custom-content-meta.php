<?php

/**
 * Class Hustle_Custom_Content_Meta
 *
 * @property bool $enabled
 * @property object $conditions
 * @property object $triggers
 * @property string $animation_in
 * @property string $animation_out
 * @property bool $make_fullscreen
 * @property bool $add_never_see_link
 * @property bool $close_btn_as_never_see
 * @property bool $allow_scroll_page
 * @property bool $not_close_on_background_click
 * @property int $expiration_days
 *
 */
class Hustle_Custom_Content_Meta extends Hustle_Meta
{
    var $defaults = array(
        "enabled" =>  false,
        "conditions" =>  array(),
        "triggers" =>  array(),
        "animation_in" =>  "",
        "animation_out" =>  "",
        "make_fullscreen" =>  false,
        "add_never_see_link" =>  false,
        "close_btn_as_never_see" =>  false,
        "allow_scroll_page" =>  false,
        "not_close_on_background_click" =>  false,
        "expiration_days" =>  365
    );

    public static $triggers_default = array(
       "trigger"  => "time", // time | scroll | click | exit_intent | adblock
       "on_time"  => "immediately", // immediately|time
       "on_time_delay"  => 5,
       "on_time_unit"  => "seconds",
       "on_scroll"  => "scrolled", // scrolled | selector
       "on_scroll_page_percent"  => "20",
       "on_scroll_css_selector"  => "",
       "on_click_element"  => "",
       "on_exit_intent"  => "detected", // detected | once_per_session
       "on_adblock"  => false,
       "on_adblock_delayed"  => false,
       "on_adblock_delayed_time"  => 180,
       "on_adblock_delayed_unit"  => "seconds"
    );
    
    /**
     * Returns conditions object
     *
     * @return object
     */
    function get_conditions(){
        return (object) ( isset(  $this->data['conditions'] ) ? $this->data['conditions'] : new stdClass() );
    }

    /**
     * Returns conditions object
     *
     * @return object
     */
    function get_triggers(){
        return (object)  wp_parse_args( isset( $this->data['triggers'] ) ? (array) $this->data['triggers'] : array(), self::$triggers_default  );
    }
}