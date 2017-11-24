Hustle.define("Model", function() {
	"use strict";

	return Backbone.Model.extend({
		initialize: function() {
			this.on( 'change', this.user_has_change, this );
			Backbone.Model.prototype.initialize.apply( this, arguments );
		},
		user_has_change: function() {
			Optin.hasChanges = true;
		}
	});
});

Hustle.define("Models.M", function(){
    "use strict";
    return Hustle.get("Model").extend({
            toJSON: function(){
                var json = _.clone(this.attributes);
                for(var attr in json) {
                    if((json[attr] instanceof Backbone.Model) || (json[attr] instanceof Backbone.Collection)) {
                        json[attr] = json[attr].toJSON();
                    }
                }
                return json;
            },
            set: function(key, val, options){

                if( typeof key === "string" &&  key.indexOf(".") !== -1 ){
                    var parent = key.split(".")[0],
                        child = key.split(".")[1],
                        parent_model = this.get(parent);

                    if( parent_model && parent_model instanceof Backbone.Model ){
                        parent_model.set(child, val, options);
                        this.trigger("change:" + key, key, val, options);
                        this.trigger("change:" + parent, key, val, options);
                    }

                }else{
                    Backbone.Model.prototype.set.call(this, key, val, options);
                }
            },
            get: function(key){
                if( typeof key === "string" &&  key.indexOf(".") !== -1 ){
                    var parent = key.split(".")[0],
                        child = key.split(".")[1];
                    return this.get(parent).get(child);
                }else{
                    return Backbone.Model.prototype.get.call(this, key);
                }
            }
        });
});

Optin.Model  = Hustle.get("Models.M").extend({
    defaults: {
        optin_name: optin_vars.messages.model.defaults.optin_name,
        optin_title: optin_vars.messages.model.defaults.optin_title,
        optin_message: optin_vars.messages.model.defaults.optin_message,
        optin_provider: "",
        api_key: "",
        mail_list: "",
        active: 1,
        test_mode: 0,
        save_to_local: 0,
        service_source: "existing"
    },

    validate_first_step: function (attrs) {
        var errors = [];

        attrs = attrs || this.attributes;

        if ( !attrs.optin_name || attrs.optin_name.isEmpty() ) {
            errors.push({name: 'name', message: optin_vars.messages.model.errors.name });
        }

        if ( attrs.test_mode != 1 &&  attrs.save_to_local != 1 ) {
            if ( !attrs.optin_provider || attrs.optin_provider.isEmpty() ) {
                errors.push({name: 'provider', message: optin_vars.messages.model.errors.provider });
            }

            if ( !attrs.api_key || attrs.api_key.isEmpty() ) {
                errors.push({name: 'api_key', message: optin_vars.messages.model.errors.api_key  });
            }

            if ( !attrs.optin_mail_list || attrs.optin_mail_list.isEmpty() ) {
                errors.push({name: 'mail_list', message: optin_vars.messages.model.errors.mail_list  });
            }
        }

        return _( errors );
    }
});

Optin.Models.Color_Palette = Hustle.get("Models.M").extend({
    defaults:{
        _id: '',
        label: '',
        main_background: '',
        form_background: '',
        button_background: '',
        button_label_color: '',
        title_color: '',
        content_color: '',
        fields_background: '',
        fields_color: ''
    }
});

Optin.Models.Color_Palette_Collection = Backbone.Collection.extend({
    model: Optin.Models.Color_Palette
});

var Palettes = new Optin.Models.Color_Palette_Collection();

_.each(optin_vars.palettes, function(item, index){
    item._id = index.replace(new RegExp(" ", 'g'), "_").toLowerCase();
    item.label = index;
    var m = new Optin.Models.Color_Palette(item);
    Palettes.add(m);
});

Optin.Models.Colors_Model = Hustle.get("Models.M").extend({
    defaults: _.extend({
        customize: false,
        palette: Palettes.at(0).get("_id"),
        main_background: '',
        form_background: '',
        button_background: '',
        button_label: '',
        title_color: '',
        content_color: '',
        fields_background: '',
        fields_color: ''
    }, Palettes.at(0).toJSON())
});

Optin.Models.Borders_Model = Backbone.Model.extend({
    defaults:{
        rounded_corners: true,
        corners_radius: 0,
        fields_corners_radius: 0,
        button_corners_radius: 0,
        drop_shadow: false,
        dropshadow_value: 0,
        shadow_color: '#000',
        fields_style: 'joined', // alternative can be separated
        rounded_form_fields: true,
        rounded_form_button: true
    }
});

Optin.Models.Design_Model = Hustle.get("Models.M").extend({

    defaults:{
        success_message: optin_vars.messages.model.defaults.success_message,
        form_location: "0",
        elements: ['image'],
        image_location: "left",
        image_style: "cover",
        image_src: optin_vars.preview_image,
        colors: new Optin.Models.Colors_Model(),
        borders: new Optin.Models.Borders_Model(),
        opening_animation: "",
        closing_animation: "",
        css: "",
        on_submit: "success_message", // success_message|page_redirect
        on_submit_page_id: "",
        input_icons: "animated_icon", // possible values no_icon|none_animated_icon|animated_icon,
		on_success: 'remain',
		on_success_time: 0,
		on_success_unit: 's',
		customize_css: false,
		cta_button: optin_vars.messages.model.defaults.cta_button,
		module_fields: optin_vars.module_fields
    },
    initialize: function(data){
        _.extend( this, data );
        if( ! ( this.get('colors') instanceof Backbone.Model ) ){
            this.set( 'colors', new Optin.Models.Colors_Model( this.colors ) );
        }

        if( ! ( this.get('borders') instanceof Backbone.Model ) ){
            this.set( 'borders', new Optin.Models.Borders_Model( this.borders ) );
        }
		this.on( 'change', this.user_has_change, this );
    }
});

var old_conditions = [
    "show_on_all_posts",
    "excluded_posts",
    "selected_posts",
    "show_on_all_pages",
    "excluded_pages",
    "selected_pages",
    "show_on_all_cats",
    "show_on_these_cats",
    "show_on_all_tags",
    "show_on_these_tags"
];

Optin.Models.Settings_After_Content = Hustle.get("Models.M").extend({
    defaults:{
        enabled: false,
        animate: false,
        animation: ""
    },
    initialize: function(data){
		
        if( ! ( this.get('conditions') instanceof Backbone.Model ) ){
            /**
             * Make sure conditions is not an array
             */

			var model = Hustle.get('Model');

            if( _.isEmpty( this.get('conditions') ) && _.isArray( this.get('conditions') )  ) {
				this.set( 'conditions', new model() );
			} else {
				this.set( 'conditions', new model( this.get('conditions') ) );
			}
        }
		this.on( 'change', this.user_has_change, this );
    }
});

Optin.Models.Settings_Popup_Model = Hustle.get("Model").extend({
    defaults:{
        enabled: false,
        animation_in: "",
        animation_out: "",
        appear_after: "time", // scrolled | time | click | exit_intent | adblock
        on_exit_trigger_once_per_session: true,
        appear_after_scroll: "scrolled", // scrolled | selector
        appear_after_time_val: 5,
        appear_after_time_unit: "seconds",
        appear_after_page_portion_val: 20,
        appear_after_page_portion_unit: "%",
        appear_after_element_val:"",
        add_never_see_this_message: false,
        close_button_acts_as_never_see_again: false,
        never_see_expiry: 2,

        show_on_all_posts: true,
        excluded_posts: [],
        selected_posts: [],
        show_on_all_pages: true,
        excluded_pages: [],
        selected_pages: [],

        show_on_all_cats: true,
        show_on_these_cats: [],
        show_on_all_tags: true,
        show_on_these_tags: [],

        conditions: {},

        trigger_on_time: "immediately", // immediately|time
        trigger_on_element_click:"",
        trigger_on_exit: false,
        trigger_on_adblock: false,
        trigger_on_adblock_timed: false,
        trigger_on_adblock_timed_val: 180,
        trigger_on_adblock_timed_unit: "seconds"
    },
    initialize: function(data){
        _.extend( this, data );

        if( ! ( this.get('conditions') instanceof Backbone.Model ) ){
            /**
             * Make sure conditions is not an array
             */
			var model = Hustle.get('Model');

            if( _.isEmpty( this.get('conditions') ) && _.isArray( this.get('conditions') )  ) {
				this.set( 'conditions', new model() );
			} else {
				this.set( 'conditions', new model( this.get('conditions') ) );
			}
        }
		this.on( 'change', this.user_has_change, this );

    }
});

Optin.Models.Settings_Slide_In_Model = Hustle.get("Model").extend({
    defaults:{
        enabled: false,
        appear_after: "time", // scrolled | time | click | exit_intent | adblock
        on_exit_trigger_once_per_session: true,
        appear_after_scroll: "scrolled", // scrolled | selector
        appear_after_time_val: 5,
        appear_after_time_unit: "seconds",
        appear_after_page_portion_val: 30,
        appear_after_page_portion_unit: "%",
        appear_after_element_val:"",
        hide_after: true,
        hide_after_val: 10,
        hide_after_unit: "seconds",
        position: "bottom_right",
        after_close: "keep_showing",

        show_on_all_posts: true,
        excluded_posts: [],
        selected_posts: [],
        show_on_all_pages: true,
        excluded_pages: [],
        selected_pages: [],

        show_on_all_cats: true,
        show_on_these_cats: [],
        show_on_all_tags: true,
        show_on_these_tags: [],

        conditions: {},

        trigger_on_time: "immediately", // immediately|time
        trigger_on_element_click:"",
        trigger_on_exit: false,
        trigger_on_adblock: false,
        trigger_on_adblock_timed: false,
        trigger_on_adblock_timed_val: 180,
        trigger_on_adblock_timed_unit: "seconds"
    },
    initialize: function(data){

        if( ! ( this.get('conditions') instanceof Backbone.Model ) ){
            /**
             * Make sure conditions is not an array
             */
			var model = Hustle.get("Model");

            if( _.isEmpty( this.get('conditions') ) && _.isArray( this.get('conditions') )  ) {
				this.set( 'conditions', new model() );
			} else {
				this.set( 'conditions', new model( this.get('conditions') ) );
			}
        }
		this.on( 'change', this.user_has_change, this);

    }
});

Optin.Models.Settings_Model = Hustle.get("Models.M").extend({
    defaults:{
        shortcode_id: "",

        // This will no longer needed as all individual optin types will have its own display settings
        //show_on_all_cats: true,
        //show_on_these_cats: [],
        //show_on_all_tags: true,
        //show_on_these_tags: [],

        after_content: new Optin.Models.Settings_After_Content(),
        popup: new Optin.Models.Settings_Popup_Model(),
        slide_in: new Optin.Models.Settings_Slide_In_Model()
    },
    initialize: function( data ){
        _.extend( this, data );
		
        if( ! ( this.get('after_content') instanceof Backbone.Model ) ){
            this.set( 'after_content', new Optin.Models.Settings_After_Content( this.get('after_content') ) );
        }

        if( ! ( this.get('popup') instanceof Backbone.Model ) ){
            this.set( 'popup', new Optin.Models.Settings_Popup_Model( this.get('popup')) );
        }

        if( ! ( this.get('slide_in') instanceof Backbone.Model ) ){
            this.set( 'slide_in', new Optin.Models.Settings_Slide_In_Model( this.get('slide_in') ) );
        }
		this.on( 'change', this.user_has_change, this );
    }

});

Hustle.define("Models.Trigger", function(){
    "use strict";
   return  Hustle.get("Model").extend({
       defaults:{
           trigger: "time", // time | scroll | click | exit_intent | adblock
           on_time: "immediately", // immediately|time
           on_time_delay: 5,
           on_time_unit: "seconds",
           on_scroll: "scrolled", // scrolled | selector
           on_scroll_page_percent: "20",
           on_scroll_css_selector: "",
           on_click_element: "",
           on_exit_intent: true,
           on_exit_intent_per_session: true,
           on_adblock: false,
           on_adblock_delayed: false,
           on_adblock_delayed_time: 180,
           on_adblock_delayed_unit: "seconds"
       }
   });
});