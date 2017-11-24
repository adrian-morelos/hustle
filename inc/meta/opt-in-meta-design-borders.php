<?php
/**
 * Class Opt_In_Meta_Design_Borders
 *
 *
 * @property bool $rounded_corners
 * @property int $corners_radius
 * @property bool $drop_shadow
 * @property int $dropshadow_value
 * @property string $shadow_color
 * @property string $fields_style ( joined | separated )
 * @property bool $rounded_form_fields
 * @property bool $rounded_form_button
 */
class Opt_In_Meta_Design_Borders extends Hustle_Meta{
    var $defaults = array(
        "rounded_corners" => true,
        "corners_radius" => 0,
        "fields_corners_radius" => 0,
        "button_corners_radius" => 0,
        "drop_shadow" => false,
        "dropshadow_value" => 0,
        "shadow_color" => '#000',
        "fields_style" => 'joined', // alternative can be separated
        "rounded_form_fields" => true,
        "rounded_form_button" => true
    );
}