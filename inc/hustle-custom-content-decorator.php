<?php

/**
 * Class Hustle_Custom_Content_Decorator
 *
 * @property string $mail_service_label
 */
class Hustle_Custom_Content_Decorator
{
    private $_cc;

    function __construct( Hustle_Custom_Content_Model $cc ){
        $this->_cc = $cc;
    }

    /**
     * Implements getter magic method
     *
     *
     * @since 1.0.0
     *
     * @param $field
     * @return mixed
     */
    function __get( $field ){

        if( method_exists( $this, "get_" . $field ) )
            return $this->{"get_". $field}();

        if( !empty( $this->_cc ) && isset( $this->_cc->{$field} ) )
            return $this->_cc->{$field};

    }

    private function  _get_stylable_elements()
    {
        return array(
            "main_bg_color" => ".wph-modal.wph-modal--cabriolet section, .wph-modal.wph-modal--simple .wph-modal--content, .wph-modal.wph-modal--minimal .wph-modal--content, .wph-cc-shortcode.wph-cc-shortcode--cabriolet section, .wph-cc-shortcode.wph-cc-shortcode--simple .wph-cc-shortcode--content, .wph-cc-shortcode.wph-cc-shortcode--minimal .wph-cc-shortcode--content",
            'title_color' => '.wph-modal.wph-modal--cabriolet .wph-modal--content h2.wph-modal--title, .wph-modal.wph-modal--simple .wph-modal--content header h2.wph-modal--title, .wph-modal.wph-modal--minimal .wph-modal--content h2.wph-modal--title, .wph-cc-shortcode .wph-cc-shortcode--content h2.wph-cc-shortcode--title',
			'subtitle_color' => '.wph-modal.wph-modal--cabriolet .wph-modal--content h4.wph-modal--subtitle, .wph-modal.wph-modal--simple .wph-modal--content header h4.wph-modal--subtitle, .wph-modal.wph-modal--minimal .wph-modal--content header h4.wph-modal--subtitle, .wph-cc-shortcode .wph-cc-shortcode--content h4.wph-cc-shortcode--subtitle',
			//"title_color" => ".wph-modal .wph-modal--content h2.wph-modal--title, .wph-cc-shortcode .wph-cc-shortcode--content h2.wph-cc-shortcode--title",
            //"subtitle_color" => ".wph-modal .wph-modal--content h4.wph-modal--subtitle, .wph-cc-shortcode .wph-cc-shortcode--content h4.wph-cc-shortcode--subtitle",
            "link_static_color" => ".wph-modal .wph-modal--message a, .wph-modal.wph-modal--cabriolet section .wph-modal--message a:not(.wph-modal--cta), .wph-modal.wph-modal--simple .wph-modal--content .wph-modal--message a:not(.wph-modal--cta), .wph-modal.wph-modal--minimal .wph-modal--message a:not(.wph-modal--cta), .wph-cc-shortcode .wph-cc-shortcode--message a, .wph-cc-shortcode.wph-cc-shortcode--cabriolet section .wph-cc-shortcode--clear a:not(.wph-cc-shortcode--cta), .wph-cc-shortcode.wph-cc-shortcode--simple .wph-cc-shortcode--content .wph-cc-shortcode--clear a:not(.wph-cc-shortcode--cta), .wph-cc-shortcode.wph-cc-shortcode--minimal footer a:not(.wph-cc-shortcode--cta)",
            "link_hover_color" => ".wph-modal .wph-modal--message a:hover, .wph-modal.wph-modal--cabriolet section .wph-modal--message a:not(.wph-modal--cta):hover, .wph-modal.wph-modal--simple .wph-modal--content .wph-modal--message a:not(.wph-modal--cta):hover, .wph-modal.wph-modal--minimal .wph-modal--content a:not(.wph-modal--cta):hover, .wph-cc-shortcode .wph-cc-shortcode--message a:hover, .wph-cc-shortcode.wph-cc-shortcode--cabriolet section .wph-cc-shortcode--clear a:not(.wph-cc-shortcode--cta):hover, .wph-cc-shortcode.wph-cc-shortcode--simple .wph-cc-shortcode--content .wph-cc-shortcode--clear a:not(.wph-cc-shortcode--cta):hover, .wph-cc-shortcode.wph-cc-shortcode--minimal footer a:not(.wph-cc-shortcode--cta):hover",
            "link_active_color" => ".wph-modal .wph-modal--message a:active, .wph-modal.wph-modal--cabriolet section .wph-modal--message a:not(.wph-modal--cta):active, .wph-modal.wph-modal--simple .wph-modal--content .wph-modal--message a:not(.wph-modal--cta):active, .wph-modal.wph-modal--minimal .wph-modal--content a:not(.wph-modal--cta):active, .wph-cc-shortcode .wph-cc-shortcode--message a:active, .wph-cc-shortcode.wph-cc-shortcode--cabriolet section .wph-cc-shortcode--clear a:not(.wph-cc-shortcode--cta):active, .wph-cc-shortcode.wph-cc-shortcode--simple .wph-cc-shortcode--content .wph-cc-shortcode--clear a:not(.wph-cc-shortcode--cta):active, .wph-cc-shortcode.wph-cc-shortcode--minimal footer a:not(.wph-cc-shortcode--cta):active",
            "cta_static_background" => ".wph-modal .wph-modal--cta, .wph-modal .wph-modal--message a.wph-modal--cta, .wph-cc-shortcode .wph-cc-shortcode--cta, .wph-cc-shortcode .wph-cc-shortcode--message a.wph-cc-shortcode--cta",
            "cta_hover_background" => ".wph-modal .wph-modal--cta:hover, .wph-modal .wph-modal--message a.wph-modal--cta:hover, .wph-cc-shortcode .wph-cc-shortcode--cta:hover, .wph-cc-shortcode .wph-cc-shortcode--message a.wph-cc-shortcode--cta:hover",
            "cta_active_background" => ".wph-modal .wph-modal--cta:active, .wph-modal .wph-modal--message a.wph-modal--cta:active, .wph-cc-shortcode .wph-cc-shortcode--cta:active, .wph-cc-shortcode .wph-cc-shortcode--message a.wph-cc-shortcode--cta:active",
            "cta_static_color" => ".wph-modal .wph-modal--cta, .wph-modal .wph-modal--message a.wph-modal--cta, .wph-cc-shortcode .wph-cc-shortcode--cta, .wph-cc-shortcode .wph-cc-shortcode--message a.wph-cc-shortcode--cta",
            "cta_hover_color" => ".wph-modal .wph-modal--cta:hover, .wph-modal .wph-modal--message a.wph-modal--cta:hover, .wph-cc-shortcode .wph-cc-shortcode--cta:hover, .wph-cc-shortcode .wph-cc-shortcode--message a.wph-cc-shortcode--cta:hover",
            "cta_active_color" => ".wph-modal .wph-modal--cta:active, .wph-modal .wph-modal--message a.wph-modal--cta:active, .wph-cc-shortcode .wph-cc-shortcode--cta:active, .wph-cc-shortcode .wph-cc-shortcode--message a.wph-cc-shortcode--cta:active",
            "border_static_color" => ".wph-modal.wph-modal--cabriolet section, .wph-modal.wph-modal--simple .wph-modal--content, .wph-modal.wph-modal--minimal .wph-modal--content, .wph-cc-shortcode.wph-cc-shortcode--cabriolet section, .wph-cc-shortcode.wph-cc-shortcode--simple .wph-cc-shortcode--content, .wph-cc-shortcode.wph-cc-shortcode--minimal .wph-cc-shortcode--content",
            //"border_hover_color" => ".wph-modal.wph-modal--cabriolet section:hover, .wph-modal.wph-modal--simple .wph-modal--content:hover, .wph-modal.wph-modal--minimal .wph-modal--content:hover, .wph-cc-shortcode.wph-cc-shortcode--cabriolet section:hover, .wph-cc-shortcode.wph-cc-shortcode--simple .wph-cc-shortcode--content:hover, .wph-cc-shortcode.wph-cc-shortcode--minimal .wph-cc-shortcode--content:hover",
            //"border_active_color" => ".wph-modal.wph-modal--cabriolet section:active, .wph-modal.wph-modal--simple .wph-modal--content:active, .wph-modal.wph-modal--minimal .wph-modal--content:active, .wph-cc-shortcode.wph-cc-shortcode--cabriolet section:active, .wph-cc-shortcode.wph-cc-shortcode--simple .wph-cc-shortcode--content:active, .wph-cc-shortcode.wph-cc-shortcode--minimal .wph-cc-shortcode--content:active",
            "border_radius" => ".wph-modal.wph-modal--cabriolet section, .wph-modal.wph-modal--simple .wph-modal--content, .wph-modal.wph-modal--minimal .wph-modal--content, .wph-cc-shortcode.wph-cc-shortcode--cabriolet section, .wph-cc-shortcode.wph-cc-shortcode--simple .wph-cc-shortcode--content, .wph-cc-shortcode.wph-cc-shortcode--minimal .wph-cc-shortcode--content",
            "border_weight" => ".wph-modal.wph-modal--cabriolet section, .wph-modal.wph-modal--simple .wph-modal--content, .wph-modal.wph-modal--minimal .wph-modal--content, .wph-cc-shortcode.wph-cc-shortcode--cabriolet section, .wph-cc-shortcode.wph-cc-shortcode--simple .wph-cc-shortcode--content, .wph-cc-shortcode.wph-cc-shortcode--minimal .wph-cc-shortcode--content",
            "border_type" => ".wph-modal.wph-modal--cabriolet section, .wph-modal.wph-modal--simple .wph-modal--content, .wph-modal.wph-modal--minimal .wph-modal--content, .wph-cc-shortcode.wph-cc-shortcode--cabriolet section, .wph-cc-shortcode.wph-cc-shortcode--simple .wph-cc-shortcode--content, .wph-cc-shortcode.wph-cc-shortcode--minimal .wph-cc-shortcode--content",
            "drop_shadow_color" => ".wph-modal.wph-modal--cabriolet section, .wph-modal.wph-modal--simple .wph-modal--content, .wph-modal.wph-modal--minimal .wph-modal--content, .wph-cc-shortcode.wph-cc-shortcode--cabriolet section, .wph-cc-shortcode.wph-cc-shortcode--simple .wph-cc-shortcode--content, .wph-cc-shortcode.wph-cc-shortcode--minimal .wph-cc-shortcode--content",
            "drop_shadow_x" => ".wph-modal.wph-modal--cabriolet section, .wph-modal.wph-modal--simple .wph-modal--content, .wph-modal.wph-modal--minimal .wph-modal--content, .wph-cc-shortcode.wph-cc-shortcode--cabriolet section, .wph-cc-shortcode.wph-cc-shortcode--simple .wph-cc-shortcode--content, .wph-cc-shortcode.wph-cc-shortcode--minimal .wph-cc-shortcode--content",
            "drop_shadow_y" => ".wph-modal.wph-modal--cabriolet section, .wph-modal.wph-modal--simple .wph-modal--content, .wph-modal.wph-modal--minimal .wph-modal--content, .wph-cc-shortcode.wph-cc-shortcode--cabriolet section, .wph-cc-shortcode.wph-cc-shortcode--simple .wph-cc-shortcode--content, .wph-cc-shortcode.wph-cc-shortcode--minimal .wph-cc-shortcode--content",
            "drop_shadow_blur" => ".wph-modal.wph-modal--cabriolet section, .wph-modal.wph-modal--simple .wph-modal--content, .wph-modal.wph-modal--minimal .wph-modal--content, .wph-cc-shortcode.wph-cc-shortcode--cabriolet section, .wph-cc-shortcode.wph-cc-shortcode--simple .wph-cc-shortcode--content, .wph-cc-shortcode.wph-cc-shortcode--minimal .wph-cc-shortcode--content",
            "drop_shadow_spread" => ".wph-modal.wph-modal--cabriolet section, .wph-modal.wph-modal--simple .wph-modal--content, .wph-modal.wph-modal--minimal .wph-modal--content, .wph-cc-shortcode.wph-cc-shortcode--cabriolet section, .wph-cc-shortcode.wph-cc-shortcode--simple .wph-cc-shortcode--content, .wph-cc-shortcode.wph-cc-shortcode--minimal .wph-cc-shortcode--content",
            "custom_height" => ".wph-modal.wph-modal--popup, .wph-modal.wph-modal--popup .wph-modal--content, .wph-cc-shortcode, .wph-cc-shortcode .wph-cc-shortcode--content",
            "custom_width" => ".wph-modal.wph-modal--popup, .wph-modal.wph-modal--popup .wph-modal--content, .wph-cc-shortcode, .wph-cc-shortcode .wph-cc-shortcode--content"
        );

    }

    private function _get_layout_colors()
    {

        $colors = array();
        if( $this->_cc->design->customize_colors ){
            foreach( $this->_cc->get_design()->to_object() as $key => $v ){
                if(  preg_match("/_background$/uis", $key) || preg_match("/_color$/uis", $key) || preg_match("/_background_color$/uis", $key)   )
                    $colors[ $key ] = $v;
            }
        }

        return $colors;
    }


    public function get_styles(){

        $styles = "";
        $prefix = ' .wph-modal--' . $this->_cc->id;
        $cc_prefix = ' .inc_cc_shortcode_wrap .wph-cc-shortcode--' . $this->_cc->id;
        $stylable_elements = $this->_get_stylable_elements();
        $colors = $this->_get_layout_colors();

        // Color styles
        if( $colors !== array() ){
            foreach( (array) $stylable_elements as $key => $selector ){
                $color_type =  preg_match("/_background$/uis", $key) || preg_match("/_background_color$/uis", $key) || preg_match("/_bg_color$/uis", $key) ? 'background' : 'color';
                if( isset( $colors[ $key ] ) ){
                    $color = $colors[ $key ];
                    foreach( explode(", ", $selector) as $s ) {
						if ( preg_match("/wph-cc-shortcode/", $s) ) {
							$styles .=  ( $cc_prefix . $s . "{ " . $color_type . ": " . $color .";} " );
						} else {
							$styles .=  ( $prefix . $s . "{ " . $color_type . ": " . $color .";} " );
						}
					}
                }
            }
        }

        /**
         * Apply border styles
         */
        if( $this->_cc->design->border ){
            $border_tpl = " %s%s {border:%dpx %s %s; }";
            $border_radius_tpl = " %s%s {border-radius:%dpx; }";
            foreach( array( 'border_static_color' ) as $i => $key ){
				foreach( explode(", ", $stylable_elements[ $key ]) as $s ){
					if ( preg_match("/wph-cc-shortcode/", $s) ) {
						$styles .= sprintf( $border_tpl, $cc_prefix, $s, $this->_cc->design->border_weight,  $this->_cc->design->border_type, $this->_cc->design->{$key} );
					} else {
						$styles .= sprintf( $border_tpl, $prefix, $s, $this->_cc->design->border_weight,  $this->_cc->design->border_type, $this->_cc->design->{$key} );
					}
				}
            }

            /**
             * Apply border radius style
             */
            foreach( explode(", ", $stylable_elements[ "border_radius" ]) as $s ) {
				if ( preg_match("/wph-cc-shortcode/", $s) ) {
					$styles .= sprintf( $border_radius_tpl, $cc_prefix, $s, $this->_cc->design->border_radius );
				} else {
					$styles .= sprintf( $border_radius_tpl, $prefix, $s, $this->_cc->design->border_radius );
				}
			}

        }

        /***
         * Apply dropshadow styles
         */
        if( $this->_cc->design->drop_shadow  ){
            $drop_shadow_tpl = " %s%s {box-shadow:%dpx %dpx %dpx %dpx %s; }";

            foreach( explode(", ", $stylable_elements[ "drop_shadow_color" ]) as $s ) {
				if ( preg_match("/wph-cc-shortcode/", $s) ) {
					$styles .= sprintf( $drop_shadow_tpl, $cc_prefix, $s,
					$this->_cc->design->drop_shadow_x,
					$this->_cc->design->drop_shadow_y,
					$this->_cc->design->drop_shadow_blur,
					$this->_cc->design->drop_shadow_spread,
					$this->_cc->design->drop_shadow_color
					);
				} else {
					$styles .= sprintf( $drop_shadow_tpl, $prefix, $s,
					$this->_cc->design->drop_shadow_x,
					$this->_cc->design->drop_shadow_y,
					$this->_cc->design->drop_shadow_blur,
					$this->_cc->design->drop_shadow_spread,
					$this->_cc->design->drop_shadow_color
					);
				}
			}

        }

        /**
         * Apply custom size is now applied via js at custom_content/view.js
         */
        /* if( $this->_cc->design->customize_size  ) {
            $custom_size_tpl = "%s%s {height: %dpx; width: %dpx; }";

            foreach( explode(", ", $stylable_elements["custom_height"] ) as $s ) {
				if ( preg_match("/wph-cc-shortcode/", $s) ) {
					$styles .= sprintf( $custom_size_tpl, $cc_prefix, $s, $this->_cc->design->custom_height, $this->_cc->design->custom_width);
				} else {
					$styles .= sprintf( $custom_size_tpl, $prefix, $s, $this->_cc->design->custom_height, $this->_cc->design->custom_width);
				}
			}
        } */

        if( $this->_cc->design->customize_css )
            $styles .= Opt_In::prepare_css( $this->_cc->design->custom_css, $prefix, false, true, 'wph-modal' );
		
		return $styles;
    }

    function _str_replace_last( $search , $replace , $str ) {
        if( ( $pos = strrpos( $str , $search ) ) !== false ) {
            $search_length  = strlen( $search );
            $str    = substr_replace( $str , $replace , $pos , $search_length );
        }
        return $str;
    }

    /**
     * Returns a string representation of the display environments configured for the optin
     *
     * @return string
     */
    public function display_environments( $optin_type ){

    }


    /**
     * Returns link to edit page on specific tab
     *
     * @param $tab
     * @return string
     */
    function get_edit_url( $tab = null ){

        if( is_null( $tab )  )
            $url = admin_url("admin.php?page=inc_hustle_custom_content&id=" . $this->_cc->id );
        else
            $url = admin_url("admin.php?page=inc_hustle_custom_content&id=" . $this->_cc->id . "#" . $tab);

        return esc_url( $url );
    }

    /**
     * Returns conditions labels for given type
     *
     * @param $type
     * @param bool|true $return_array
     * @return array|string
     */
    function get_type_condition_labels( $type, $return_array = true ){
        $conditions = $this->_cc->get_type_conditions( $type );
        $labels = array();

        /**
         * @var $condition Opt_In_Condition_Abstract
         */
        foreach( $conditions as $condition ){
            $label = is_object( $condition ) && method_exists( $condition, 'label' ) ? $condition->label() : '';

            if( !empty( $label ) )
            $labels[] = $label;
            unset( $label );
        }

        $labels = $labels === array() ? array( "everywhere" => __("Show everywhere", Opt_In::TEXT_DOMAIN) ) : $labels;
        return $return_array ? $labels : implode( ", ", $labels );
    }
}