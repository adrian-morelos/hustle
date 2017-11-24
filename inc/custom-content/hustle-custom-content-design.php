<?php

/**
 * Class Hustle_Custom_Content_Design
 *
 * @property string $main_bg_color
 * @property bool $border
 * @property int $border_radius
 * @property int $border_weight
 * @property string $border_type
 * @property string $border_static_color
 * @property string $border_hover_color
 * @property string $border_active_color
 * @property bool $drop_shadow
 * @property int $drop_shadow_x
 * @property int $drop_shadow_y
 * @property int $drop_shadow_blur
 * @property int $drop_shadow_spread
 * @property string $drop_shadow_color
 * @property string $image
 * @property bool $hide_image_on_mobile
 * @property string $image_position
 * @property string $cta_label
 * @property string $cta_url
 * @property string $cta_target
 */
class Hustle_Custom_Content_Design extends Hustle_Meta
{
    var $defaults = array(
        "main_bg_color" => "rgba(255,255,255,1)",
        "border" => true,
        "border_radius" => 5,
        "border_weight" => 3,
        "border_type" => "solid",
        "border_static_color" => "rgba(218,218,218,1)",
        "border_hover_color" => "rgba(218,218,218,1)",
        "border_active_color" => "rgba(218,218,218,1)",
        "drop_shadow" => false,
        "drop_shadow_x" => 0,
        "drop_shadow_y" => 0,
        "drop_shadow_blur" => 0,
        "drop_shadow_spread" => 0,
        "drop_shadow_color" => "rgba(0,0,0,0)",
        "image" => "",
        "hide_image_on_mobile" => false,
        "image_position" => "left",
        "cta_label" => "",
        "cta_url" => "",
        "cta_target" => "_blank"
    );
}