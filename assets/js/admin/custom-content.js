Hustle.define("Custom_Content.Module", function($){
    "use strict";

    /**
     * Listing Page
     */
    (function(){
        if( "hustle_page_inc_hustle_custom_content" !== pagenow ) return;

        var Listing = Hustle.get("Custom_Content.Listing");
        var cc_listing = new Listing();

        var Legacy_Listing = Hustle.get("Legacy_Popups.Listing");
        var cc_legacy_listing = new Legacy_Listing();

    }());


    /**
     * Edit or New page
     */
    (function(){

        if( _.indexOf( ['hustle_page_inc_hustle_custom_content_new', 'hustle_page_inc_hustle_custom_content_edit'], pagenow )  === -1  ) return;
		
		if ( parseInt(optin_vars.current.is_cc_limited) ) return;

        var View = Hustle.get("Custom_Content.View"),
            Content_View = Hustle.get("Custom_Content.Content_View"),
            Design_View = Hustle.get("Custom_Content.Design_View"),
			AfterContent_View = Hustle.get( "Custom_Content.After_Content_View" ),
            Popup_View = Hustle.get("Custom_Content.Popup_View"),
            Slide_In_View = Hustle.get("Custom_Content.Slide_In_View"),
            Display_Triggers_View = Hustle.get("Settings.Display_Triggers_View"),
            Conditions_View = Hustle.get("Settings.Conditions_View"),
            Content_Model = Hustle.get("Custom_Content.Models.Content"),
            Design_Model = Hustle.get("Custom_Content.Models.Design"),
			AfterContent_Model = Hustle.get("Custom_Content.Models.AfterContent"),
            Popup_Model = Hustle.get("Custom_Content.Models.Popup"),
            Slide_In_Model = Hustle.get("Custom_Content.Models.Slide_In"),
            Magic_Bar_Model = Hustle.get("Custom_Content.Models.Magic_Bar")
            ;

        var content_model = new Content_Model( optin_vars.current.content || {}  );
		var after_content_model = new AfterContent_Model( optin_vars.current.after_content || {} );
        var design_model = new Design_Model( optin_vars.current.design || {} );
        var popup_model = new Popup_Model( optin_vars.current.popup || {} );
        var slide_in_model = new Slide_In_Model( optin_vars.current.slide_in || {} );
        var magic_bar_model = new Magic_Bar_Model( optin_vars.current.magic_bar || {} );

        window.content_model = content_model;
        window.design_model = design_model;
		window.after_content_model = after_content_model;
        window.popup_model = popup_model;
        window.slide_in_model = slide_in_model;
        window.magic_bar_model = magic_bar_model;
		
        return new View({
            model: content_model,
            content_view: new Content_View({ model: content_model, design_model: design_model }),
            design_view: new Design_View( { model: design_model } ),
			after_content_view: new AfterContent_View({
				type: 'after_content',
				model: after_content_model,
				display_triggers_view: new Display_Triggers_View( {
					model: after_content_model.get('triggers'),
					type: 'after_content'
				}),
				conditions_view: new Conditions_View({
					model: after_content_model.get('conditions'),
					type: 'after_content'
				})
			}),
            popup_view: new Popup_View( {
                    type: "popup",
                    model: popup_model,
                    display_triggers_view: new Display_Triggers_View( {
                        model: popup_model.get("triggers"),
                        type: "popup"
                    }),
                    conditions_view: new Conditions_View({
                        model: popup_model.get("conditions"),
                        type: "popup"
                    })
                }
            ),
            slide_in: new Slide_In_View( {
                    type: "slide_in",
                    model: slide_in_model,
                    display_triggers_view: new Display_Triggers_View( {
                        model: slide_in_model.get("triggers"),
                        type: "slide_in"
                    }),
                    conditions_view: new Conditions_View({
                        model: slide_in_model.get("conditions"),
                        type: "slide_in"
                    })
                }
            ),
            magic_bar: new Backbone.View({model: magic_bar_model})
            //magic_bar: new Popup_View( {
            //        type: "magic_bar",
            //        model: magic_bar_model,
            //        display_triggers_view: new Display_Triggers_View( {
            //            model: magic_bar_model.get("triggers"),
            //            type: "magic_bar"
            //        }),
            //        conditions_view: new Conditions_View({
            //            model: magic_bar_model.get("conditions"),
            //            type: "magic_bar"
            //        })
            //    }
            //)

        });

    }());
});

