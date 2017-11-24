Hustle.define( "Custom_Content.Models",  function(){
    "use strict";
    var Content = Hustle.get("Models.M").extend({
        defaults: {
            optin_name: "",
            optin_title: "",
            subtitle: "",
            optin_message: "Type your content here ...",
            content: "",
            optin_provider: "custom_content",
            api_key: "",
            mail_list: "",
            active: 1,
            test_mode: 0
        }
    });

    var Design = Hustle.get("Models.M").extend({
        defaults: {
            style: "cabriolet",
            customize_colors: 0,
            customize_css: 0,
            custom_css: "",
            main_bg_color: "rgba(255,255,255,1)",
            title_color: "rgba(51,51,51,1)",
            subtitle_color: "rgba(51,51,51,1)",
            link_static_color: "#1FC5B6",
            link_hover_color: "#15A296",
            link_active_color: "#15A296",
            cta_static_background: "#1FC5B6",
            cta_hover_background: "#15A296",
            cta_active_background: "#15A296",
            cta_static_color: "rgba(255,255,255,1)",
            cta_hover_color: "rgba(255,255,255,1)",
            cta_active_color: "rgba(255,255,255,1)",
            border: true,
            border_radius: 5,
            border_weight: 3,
            border_type: "solid",
            border_static_color: "rgba(218,218,218,1)",
            border_hover_color: "rgba(218,218,218,1)",
            border_active_color: "rgba(218,218,218,1)",
            drop_shadow: false,
            drop_shadow_x: 0,
            drop_shadow_y: 0,
            drop_shadow_blur: 0,
            drop_shadow_spread: 0,
            drop_shadow_color: "rgba(0,0,0,0)",
            image: "",
            hide_image_on_mobile: false,
            image_position: "left",
            cta_label: "",
            cta_url: "",
            cta_target: "_blank",
            customize_size: false,
            custom_height: 300,
            custom_width: 600
        }
    });

    var Triggers = Hustle.get("Models.Trigger");
    var TypeBase = Hustle.get("Models.M").extend({
        defaults:{
            enabled: false,
            conditions: "",
            triggers: "",
            animation_in: "",
            animation_out: "",
            make_fullscreen: false,
            add_never_see_link: false,
            close_btn_as_never_see: false,
            allow_scroll_page: false,
            not_close_on_background_click: false,
            expiration_days: 365,
            on_submit: "default" // default|close|ignore|redirect
        },
        initialize: function(data){
            _.extend( this, data );
            if( ! ( this.get('triggers') instanceof Backbone.Model ) ){
                this.set( 'triggers', new Triggers( this.triggers ) );
            }

            if( ! ( this.get('conditions') instanceof Backbone.Model ) ){
                /**
                 * Make sure conditions is not an array
                 */
                if( _.isEmpty( this.get('conditions') ) && _.isArray( this.get('conditions') )  )
                    this.conditions = {};

				var hModel = Hustle.get("Model");
                this.set( 'conditions', new hModel( this.conditions ) );
            }
			this.on( 'change', this.user_has_change, this );

        }
    });

	var AfterContent = TypeBase.extend({
		defaults: {
			enabled: false,
			animate: false,
			animation: '',
			on_submit: ''
		}
	});
    var Popup = TypeBase.extend();
    var Slide_In = TypeBase.extend({
        defaults:{
            enabled: false,
            conditions: "",
            triggers: "",
            animation_in: "",
            animation_out: "",
            make_fullscreen: false,
            add_never_see_link: false,
            close_btn_as_never_see: false,
            expiration_days: 0,
            on_submit: "refresh_or_close",
            hide_after: true,
            hide_after_val: 10,
            hide_after_unit: "seconds",
            position: "bottom_right",
            after_close: "keep_showing"
        }
    });
    var Magic_Bar = TypeBase.extend();

    return {
        Content: Content,
        Design: Design,
        TypeBase: TypeBase,
		AfterContent: AfterContent,
        Popup: Popup,
        Slide_In: Slide_In,
        Magic_Bar: Magic_Bar
    };
});


