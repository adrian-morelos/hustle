<?php

class Hustle_Social_Sharing_Decorator {
    private $_ss;
    
    function __construct( Hustle_Social_Sharing_Model $ss ) {
        $this->_ss = $ss;
    }
    
    function __get( $field ){

        if( method_exists( $this, "get_" . $field ) )
            return $this->{"get_". $field}();

        if( !empty( $this->_ss ) && isset( $this->_ss->{$field} ) )
            return $this->_ss->{$field};

    }
    
    function get_edit_url( $tab = null ){

        if( is_null( $tab )  )
            $url = admin_url("admin.php?page=inc_hustle_social_sharing&id=" . $this->_ss->id );
        else
            $url = admin_url("admin.php?page=inc_hustle_social_sharing&id=" . $this->_ss->id . "#" . $tab);

        return esc_url( $url );
    }
    
    function get_type_condition_labels( $type, $return_array = true ){
        $conditions = $this->_ss->get_type_conditions( $type );
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
    
    public function get_styles() {
        $styles = '';
        $prefix = '.wph-social-sharing.wph-social-sharing-' . $this->_ss->id . ' ';
        $stylable_elements = $this->_get_stylable_elements();
        
        // floating background
        if ( $this->_ss->appearance->floating_social_bg ) {
            $styles .= sprintf( $prefix . $stylable_elements['floating_container'] . '{ background: %s; }',
                $this->_ss->appearance->floating_social_bg );
        }
        // counter text
        if ( $this->_ss->appearance->counter_text ) {
            $styles .= sprintf( $prefix . $stylable_elements['floating_counter_text'] . '{ color: %s; }',
                    $this->_ss->appearance->counter_text );
        }
        
        // customize color
        if ( $this->_ss->appearance->customize_colors == '1' ) {
            
            switch ( $this->_ss->appearance->icon_style) {
                case "one":
                    $styles .= sprintf( $prefix . $stylable_elements['one_icon_color'] . '{ fill: %s; }',
                        $this->_ss->appearance->icon_color );
                    $styles .= sprintf( $prefix . $stylable_elements['one_icon_bg_color'] . '{ background: %s; }',
                        $this->_ss->appearance->icon_bg_color );
                    break;
                case "two":
                    $styles .= sprintf( $prefix . $stylable_elements['two_icon_bg_color'] . '{ border-color: %s; }',
                        $this->_ss->appearance->icon_bg_color );
                    $styles .= sprintf( $prefix . $stylable_elements['two_icon_color'] . '{ fill: %s; }',
                        $this->_ss->appearance->icon_color );
                    break;
                case "three":
                	$styles .= sprintf( $prefix . $stylable_elements['three_icon_bg_color'] . '{ background: %s; }',
                        $this->_ss->appearance->icon_bg_color );
                    $styles .= sprintf( $prefix . $stylable_elements['three_icon_color'] . '{ fill: %s; }',
                        $this->_ss->appearance->icon_color );
                    break;
                default:
                    // default is four
                    $styles .= sprintf( $prefix . $stylable_elements['four_icon_style'] . '{ fill: %s; }',
                        $this->_ss->appearance->icon_color );
                    $styles .= sprintf( $prefix . $stylable_elements['four_icon_bg_color'] . '{ background: %s; }',
                        $this->_ss->appearance->icon_bg_color );
                    break;
            }
            
            if ( $this->_ss->appearance->counter_border ) {
                $styles .= sprintf( $prefix . $stylable_elements['floating_counter_border'] . '{ border: 1px solid %s; }',
                        $this->_ss->appearance->counter_border );
            }
        }
        
        // drop shadow
        if ( $this->_ss->appearance->drop_shadow == '1' ) {
            $box_shadow = '' .
                $this->_ss->appearance->drop_shadow_x . 'px ' .
                $this->_ss->appearance->drop_shadow_y . 'px ' .
                $this->_ss->appearance->drop_shadow_blur . 'px ' .
                $this->_ss->appearance->drop_shadow_spread . 'px ' .
                $this->_ss->appearance->drop_shadow_color;
            
            $styles .= sprintf( $prefix . $stylable_elements['floating_container'] . '{ box-shadow: %s; }',
                $box_shadow );
        }
        
        /* WIDGET STYLES */
        
        // widget background
        if ( $this->_ss->appearance->widget_bg_color ) {
            $styles .= sprintf( $prefix . $stylable_elements['widget_container'] . '{ background: %s; }',
                $this->_ss->appearance->widget_bg_color );
        }
        
        // customize color
        if ( $this->_ss->appearance->customize_widget_colors == '1' ) {
            
            switch ( $this->_ss->appearance->icon_style) {
                case "one":
                    $styles .= sprintf( $prefix . $stylable_elements['widget_one_icon_color'] . '{ fill: %s; }',
                        $this->_ss->appearance->widget_icon_color );
                    $styles .= sprintf( $prefix . $stylable_elements['widget_one_icon_bg_color'] . '{ background: %s; }',
                        $this->_ss->appearance->widget_icon_bg_color );
                    break;
                case "two":
                    $styles .= sprintf( $prefix . $stylable_elements['widget_two_icon_bg_color'] . '{ border-color: %s; }',
                        $this->_ss->appearance->widget_icon_bg_color );
                    $styles .= sprintf( $prefix . $stylable_elements['widget_two_icon_color'] . '{ fill: %s; }',
                        $this->_ss->appearance->widget_icon_color );
                    break;
                case "three":
                	$styles .= sprintf( $prefix . $stylable_elements['widget_three_icon_bg_color'] . '{ background: %s; }',
                        $this->_ss->appearance->widget_icon_bg_color );
                    $styles .= sprintf( $prefix . $stylable_elements['widget_three_icon_color'] . '{ fill: %s; }',
                        $this->_ss->appearance->widget_icon_color );
                    break;
                default:
                    // default is four
                    $styles .= sprintf( $prefix . $stylable_elements['widget_four_icon_style'] . '{ fill: %s; }',
                        $this->_ss->appearance->widget_icon_color );
                    $styles .= sprintf( $prefix . $stylable_elements['widget_four_icon_bg_color'] . '{ background: %s; }',
                        $this->_ss->appearance->widget_icon_bg_color );
                    break;
            }
            
            if ( $this->_ss->appearance->widget_counter_text ) {
                $styles .= sprintf( $prefix . $stylable_elements['widget_counter_text'] . '{ color: %s; }',
                        $this->_ss->appearance->widget_counter_text );
            }
            
        }
        
        // drop shadow
        if ( $this->_ss->appearance->widget_drop_shadow == '1' ) {
            $box_shadow = '' .
                $this->_ss->appearance->widget_drop_shadow_x . 'px ' .
                $this->_ss->appearance->widget_drop_shadow_y . 'px ' .
                $this->_ss->appearance->widget_drop_shadow_blur . 'px ' .
                $this->_ss->appearance->widget_drop_shadow_spread . 'px ' .
                $this->_ss->appearance->widget_drop_shadow_color;
            
            $styles .= sprintf( $prefix . $stylable_elements['widget_container'] . '{ box-shadow: %s; }',
                $box_shadow );
        }
        
        
        return $styles;
    }
    
    private function _get_stylable_elements() {
        return array(
            'floating_container' => '.wph-sshare--container.wph-sshare--column',
            // Icon Type 1
            'one_icon_color' => '.wph-sshare--container.wph-sshare--column.wph-sshare--design_one .wph-social-path .wph-social-icon',
            'one_icon_bg_color' => '.wph-sshare--container.wph-sshare--column.wph-sshare--design_one > a',
            // Icon Type 2
            'two_icon_bg_color' => '.wph-sshare--container.wph-sshare--column.wph-sshare--design_two .wph-social',
            'two_icon_color' => '.wph-sshare--container.wph-sshare--column.wph-sshare--design_two .wph-social .wph-social-icon',
            // Icon Type 3
            'three_icon_color' => '.wph-sshare--container.wph-sshare--column.wph-sshare--design_three .wph-social .wph-social-icon',
            'three_icon_bg_color' => '.wph-sshare--container.wph-sshare--column.wph-sshare--design_three .wph-social',
            // Icon Type 4
            'four_icon_style' => '.wph-sshare--container.wph-sshare--column.wph-sshare--design_four .wph-social .wph-social-icon',
            'four_icon_bg_color' => '.wph-sshare--container.wph-sshare--column.wph-sshare--design_four .wph-social',
            // Other Styles
            'floating_counter_border' => '.wph-sshare--container.wph-sshare--column > a',
            'floating_counter_text' => '.wph-sshare--container.wph-sshare--column > a',
            // Widget styles
            'widget_container' => '.wph-sshare--container.wph-sshare--row',
            // Icon Type 1
            'widget_one_icon_color' => '.wph-sshare--container.wph-sshare--row.wph-sshare--design_one .wph-social-path .wph-social-icon',
            'widget_one_icon_bg_color' => '.wph-sshare--container.wph-sshare--row.wph-sshare--design_one > a',
            // Icon Type 2
            'widget_two_icon_bg_color' => '.wph-sshare--container.wph-sshare--row.wph-sshare--design_two .wph-social',
            'widget_two_icon_color' => '.wph-sshare--container.wph-sshare--row.wph-sshare--design_two .wph-social .wph-social-icon',
            // Icon Type 3
            'widget_three_icon_color' => '.wph-sshare--container.wph-sshare--row.wph-sshare--design_three .wph-social .wph-social-icon',
            'widget_three_icon_bg_color' => '.wph-sshare--container.wph-sshare--row.wph-sshare--design_three .wph-social',
            // Icon Type 4
            'widget_four_icon_style' => '.wph-sshare--container.wph-sshare--row.wph-sshare--design_four .wph-social .wph-social-icon',
            'widget_four_icon_bg_color' => '.wph-sshare--container.wph-sshare--row.wph-sshare--design_four .wph-social',
            // Other Styles
            'widget_counter_text' => '.wph-sshare--container.wph-sshare--row > a',
        );
    }
    
}