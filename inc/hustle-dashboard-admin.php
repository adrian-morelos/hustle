<?php


class Hustle_Dashboard_Admin extends Opt_In
{

    private $_data;

    function __construct()
    {
        add_action( 'admin_menu', array( $this, "register_menus" ), 1 );
        add_filter("hustle_optin_vars", array( $this, "register_dashboard_vars" ));
        if( $this->_is_dashboard() )
            $this->_data = new Hustle_Dashboard_Data();
    }

    function register_menus(){
        
        $parent_menu_title = ( Opt_In_Utils::_is_free() )
            ? __("Hustle", Opt_In::TEXT_DOMAIN)
            : __("Hustle Pro", Opt_In::TEXT_DOMAIN);

        // Parent menu
        add_menu_page( $parent_menu_title , $parent_menu_title , "manage_options", "inc_optins", array( $this, 'render_dashboard' ), self::$plugin_url . 'assets/img/icon.svg');

        // Dashboard
        add_submenu_page( 'inc_optins', __("Dashboard", Opt_In::TEXT_DOMAIN) , __("Dashboard", Opt_In::TEXT_DOMAIN) , "manage_options", 'inc_optins',  array( $this, "render_dashboard" )  );
    }
    /**
     * Renders Hustle Dashboard
     *
     * @since 2.0
     */
    function render_dashboard(){
        $current_user = wp_get_current_user();

        $this->render("admin/new-welcome", array(
            "data" => $this->_data,
            'active_modules' =>  $this->_data->active_modules,
            'active_optin_modules' =>  $this->_data->active_optin_modules,
            'inactive_optin_modules' =>  $this->_data->inactive_optin_modules,
            'active_cc_modules' =>  $this->_data->active_cc_modules,
            'inactive_cc_modules' =>  $this->_data->inactive_cc_modules,
            'types' => $this->_data->types,
            "user_name" => ucfirst($current_user->display_name),
            'data_exists' => $this->_data->data_exists,
            'conversions' => $this->_data->conversions_today,
            'most_conversions' => $this->_data->most_converted_optin,
            'has_optins' => $this->_data->has_optins,
            'has_custom_content' => $this->_data->has_custom_content,
            'has_social_sharing' => $this->_data->has_social_sharing,
            'has_social_rewards' => $this->_data->has_social_rewards,
            'conversion_data' => $this->_data->conversion_data,
            "all_modules" => $this->_data->all_modules,
            "is_free" => Opt_In::is_free()
        ));
    }

    /**
     * Checks if it's optin admin page
     *
     * @return bool
     */
    private function _is_dashboard(){
        return isset( $_GET['page'] ) &&  ( in_array($_GET['page'], array(
            'inc_hustle_dashboard',
            'inc_optins'
           ) ) );
    }
    function register_dashboard_vars( $vars ){
        if( !$this->_is_dashboard() ) return $vars;

        $arr = array();

        foreach ( $this->_data->conversion_data as $module_name => $data ){
            $arr[] = array(
                "module_name" => $module_name,
                "data" => $data["chart_data"],
                "color" => $data["color"]
            );
        }

        $vars['conversion_chart_data'] = $arr;
        $vars['today'] = date("Y-m-d");
        $vars['today_timestamp'] = strtotime(date("Y-m-d")) * 1000;
        $vars['previous_month'] = date( "Y-m-d", strtotime( date("Y-m-d") . " -1 month" ) );
        $vars['previous_month_timestamp'] = strtotime( date("Y-m-d") . " -1 month" ) * 1000;
        return $vars;
    }
}