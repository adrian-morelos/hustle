<?php

if( !class_exists("Hustle_Custom_Content_Admin") ):

class Hustle_Custom_Content_Admin extends Opt_In
{

    /**
     * @var $legacy_popups Hustle_Legacy_Popups
     */
    private static $legacy_popups;

    function __construct( Hustle_Legacy_Popups $legacy_popups )
    {
        self::$legacy_popups = $legacy_popups;

        add_action( 'admin_menu', array( $this, "register_admin_menu" ) );
        add_action( 'admin_head', array( $this, "hide_unwanted_submenus" ) );
        add_action("current_screen", array( $this, "set_proper_current_screen_for_new_page" ) );
        add_filter("hustle_optin_vars", array( $this, "register_current_json" ) );		
		add_action( 'admin_notices', array( $this, "show_legacy_popup_notice" ) );
    }

    function register_admin_menu(){
        add_submenu_page( 'inc_optins', __("Custom Content", Opt_In::TEXT_DOMAIN) , __("Custom Content", Opt_In::TEXT_DOMAIN) , "manage_options", 'inc_hustle_custom_content',  array( $this, "render_custom_content" )  );
        add_submenu_page( 'inc_optins', __("New Custom Content", Opt_In::TEXT_DOMAIN) , __("New Custom Content", Opt_In::TEXT_DOMAIN) , "manage_options", 'inc_hustle_custom_content&amp;id=-1',  array( $this, "render_new_custom_content" )  );
    }

    /**
     * Removes the submenu entries for content creation
     *
     * @since 2.0
     */
    function hide_unwanted_submenus(){
        remove_submenu_page( 'inc_optins', 'inc_hustle_custom_content&amp;id=-1' );
    }
	
	/**
     * Shows admin notice for CC migrated from Wordpress Popup
     *
     * @since 2.0.2
     */
	function show_legacy_popup_notice() {
		$has_legacy_migrated = (bool) get_option( "hustle_popup_migrated", false );
		$is_dismissed = (bool) get_option( "hustle_legacy_notice_dismissed", false );
		if ( Opt_In_Utils::_is_free() && $has_legacy_migrated && !$is_dismissed && isset($_GET['page']) && $_GET['page'] == "inc_hustle_custom_content" ) {
		?>
		<div id="hustle-legacy-popup-notice" class="notice notice-success is-dismissible" data-nonce="<?php echo wp_create_nonce('inc_cc_legacy_popup_notice'); ?>">
			<p><?php _e( 'Hustle features all-new animations and variations! To check out what’s new, start editing your pop-ups.', Opt_In::TEXT_DOMAIN ); ?></p>
		</div>
		<?php
		}
	}

    /**
     * Renders Hustle Custom Content page (listing)
     *
     * @since 2.0
     */
    function render_custom_content(){
        $current_user = wp_get_current_user();
        if( isset( $_GET['id'] ) && ( "-1" === $_GET['id'] || 0 !== intval( $_GET['id'] ) ) ){
			$all_cc = Hustle_Custom_Content_Collection::instance()->get_all( null );
			$total_cc = count($all_cc);
			foreach($all_cc as $existing_cc) {
				if ( $existing_cc->legacy ) $total_cc--; 
			}
			if ( Opt_In_Utils::_is_free() && '-1' === $_GET['id'] && $total_cc >= 1 ) {
				$this->render( 'admin/new-free-info', array(
					'page_title' => __( 'Custom Content', Opt_In::TEXT_DOMAIN ),
				));
			} else {
				$this->render("admin/new-custom-content", array());
			}
        }else{
			
            $this->render("admin/custom-content", array(
                'add_new_url' => admin_url("admin.php?page=inc_hustle_custom_content&id=-1"),
                "custom_contents" => Hustle_Custom_Content_Collection::instance()->get_all( null ),
                "types" => array(
					'after_content' => __( 'After Content', Opt_In::TEXT_DOMAIN ),
                    'popup' => __('Pop-up', Opt_In::TEXT_DOMAIN),
                    'slide_in' => __('Slide-in', Opt_In::TEXT_DOMAIN),
                    'shortcode' => __('Shortcode', Opt_In::TEXT_DOMAIN),
                    'widget' => __('Widget', Opt_In::TEXT_DOMAIN)
                ),
                'user_name' => ucfirst($current_user->display_name)
            ));
        }
    }

    function add_new( $data ){
        $cc = new Hustle_Custom_Content_Model();

        $content = $data['content'];
        $design = $data['design'];
        $popup = $data['popup'];
        $slide_in = $data['slide_in'];
        $magic_bar = $data['magic_bar'];
        $shortcode_id = $data['shortcode_id'];

        $cc->test_mode = 0;
        $cc->blog_id = get_current_blog_id();
        $cc->optin_name = $content['optin_name'];
        $cc->optin_title = $content['optin_title'];
        $cc->optin_message = $content['optin_message'];
        $cc->optin_provider = $cc->get_optin_provider();
        $cc->active = 1;
        $id = $cc->save();

        $cc->add_meta( "design", $design );
        $cc->add_meta( "popup", $popup );
        $cc->add_meta( "slide_in", $slide_in );
        $cc->add_meta( "magic_bar", $magic_bar );
        $cc->add_meta( "subtitle", $content['subtitle'] );
        $cc->add_meta( "shortcode_id", $shortcode_id );
        $cc->add_meta( "settings", array(
            "shortcode" => array(
                "enabled" => "true"
            ),
            "widget" => array(
                "enabled" => "true"
            )
        ) );

        return $id;
    }

    function update( $data ){

        if( !isset( $data['id'] ) || "-1" == $data['id'] ) return false;

        $cc = Hustle_Custom_Content_Model::instance()->get( $data['id'] );

        $content = $data['content'];
        $design = $data['design'];
		$after_content = $data['after_content'];
        $popup = $data['popup'];
        $slide_in = $data['slide_in'];
        $magic_bar = $data['magic_bar'];
		$shortcode_id = $data['shortcode_id'];

        $cc->test_mode = $content['test_mode'];
        $cc->blog_id = get_current_blog_id();
        $cc->optin_name = $content['optin_name'];
        $cc->optin_title = $content['optin_title'];
        $cc->optin_message = $content['optin_message'];
        $cc->optin_provider = $cc->get_optin_provider();
        $cc->active = $content['active'];
        $cc->save();

        $cc->update_meta( "design", $design );
		$cc->update_meta( "after_content", $after_content );
        $cc->update_meta( "popup", $popup );
        $cc->update_meta( "slide_in", $slide_in );
        $cc->update_meta( "magic_bar", $magic_bar );
        $cc->update_meta( "subtitle", $content['subtitle'] );
        $cc->update_meta( "shortcode_id", $shortcode_id );
        return $cc->id;

    }

    function set_proper_current_screen_for_new_page( $current ){
        global $current_screen;
        
        if ( !Opt_In_Utils::_is_free() ) {
            $current_screen->id = Opt_In_Utils::clean_current_screen($current_screen->id);
        }
        
        if( isset( $current_screen ) && "hustle_page_inc_hustle_custom_content" === $current_screen->id && isset( $_GET['id'] ) && "-1" === $_GET['id'] )
            $current_screen->id .= "_new";

        if( isset( $current_screen ) && "hustle_page_inc_hustle_custom_content" === $current_screen->id && isset( $_GET['id'] ) && 0 !== intval( $_GET['id'] ) )
            $current_screen->id .= "_edit";
    }

    private function _is_edit(){
        return  (bool) filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT) && isset( $_GET['page'] ) && $_GET['page'] === "inc_hustle_custom_content";
    }

    function register_current_json( $current_array ){

        if( $this->_is_edit()  ){
            $cc = Hustle_Custom_Content_Model::instance()->get( filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT) );
			$all_cc = Hustle_Custom_Content_Collection::instance()->get_all( null );
			$total_cc = count($all_cc);
			foreach($all_cc as $existing_cc) {
				if ( $existing_cc->legacy ) $total_cc--; 
			}
            $current_array['current'] = array(
                "content" => $cc->get_data(),
                "design" => $cc->get_design()->to_array(),
				"after_content" => $cc->get_after_content()->to_array(),
                "popup" => $cc->get_popup()->to_array(),
                "slide_in" => $cc->get_slide_in()->to_array(),
                "magic_bar" => $cc->get_magic_bar()->to_array(),
                "is_cc_limited" => (int) ( Opt_In_Utils::_is_free() && '-1' === $_GET['id'] && $total_cc >= 1 )
            );
        }

        return $current_array;
    }
}

endif;