<?php
/**
 * Class Opt_In_Meta_Settings_After_Content
 *
 *@property bool $show_on_all_posts
 *@property bool $show_on_all_pages
 *@property array $excluded_posts
 *@property array $selected_posts
 *@property array $excluded_pages
 *@property array $selected_pages
 *@property bool $enabled
 *@property bool $animate
 *@property string $animation
 *@property array $conditions
 */
class Opt_In_Meta_Settings_After_Content extends Hustle_Meta {

    var $defaults = array(
        "enabled" => false,

        "show_on_all_posts" => true,
        "excluded_posts" => array(),
        "selected_posts" => array(),
        "show_on_all_pages" => true,
        "excluded_pages" => array(),
        "selected_pages" => array(),

        "show_on_all_cats" => true,
        "show_on_these_cats" => array(),
        "show_on_all_tags" => true,
        "show_on_these_tags" => array(),
		
		"conditions" => array(),

        "animate" => false,
        "animation" => ""
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