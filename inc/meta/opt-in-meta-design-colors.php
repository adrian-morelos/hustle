<?php
/**
 * Class Opt_In_Meta_Design_Colors
 *
 *
 * @property array $palette
 * @property bool $custom
 * @property string $main_background
 * @property int $dropshadow_value
 * @property string $form_background
 * @property string $button_background
 * @property string $button_label
 * @property string $title_color
 * @property string $content_color
 * @property string $fields_background
 */
class Opt_In_Meta_Design_Colors extends Hustle_Meta{
    var $defaults = array(
        "customize" => false,
        "palette" => '',
        "main_background" => '',
        "form_background" => '',
        "button_background" => '',
        "button_label" => '',
        "title_color" => '',
        "content_color" => '',
        "fields_background" => '',
        "fields_color" => ''
    );
}