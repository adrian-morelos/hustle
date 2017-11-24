Hustle.define("Social_Sharing.Module", function($){
    "use strict";

    /**
     * Listing Page
     */
    (function(){
        if( "hustle_page_inc_hustle_social_sharing" !== pagenow ) return;

        var Listing = Hustle.get("Social_Sharing.Listing");
        var ss_listing = new Listing();
    }());


    /**
     * Edit or New page
     */
    (function(){

        if( _.indexOf( ['hustle_page_inc_hustle_social_sharing_new', 'hustle_page_inc_hustle_social_sharing_edit'], pagenow )  === -1  ) return;
		
		if ( parseInt(optin_vars.current.is_ss_limited) ) return;
        
        var View = Hustle.get("Social_Sharing.View"),
            Services_View = Hustle.get("Social_Sharing.Services_View"),
            Appearance_View = Hustle.get("Social_Sharing.Appearance_View"),
            Floating_View = Hustle.get( "Social_Sharing.Floating_View" ),
            Conditions_View = Hustle.get("Settings.Conditions_View"),
            Services_Model = Hustle.get("Social_Sharing.Models.Services"),
            Appearance_Model = Hustle.get("Social_Sharing.Models.Appearance"),
            Floating_Social_Model = Hustle.get("Social_Sharing.Models.Floating_Social")
            ;
        
        var services_model = new Services_Model( optin_vars.current.services || {}  );
        var appearance_model = new Appearance_Model( optin_vars.current.appearance || {}  );
        var floating_social_model = new Floating_Social_Model( optin_vars.current.floating_social || {} );

        window.services_model = services_model;
        window.appearance_model = appearance_model;
        window.floating_social_model = floating_social_model;
		
        return new View({
            model: services_model,
            services_view: new Services_View({ model: services_model }),
            appearance_view: new Appearance_View({ model: appearance_model }),
            floating_view: new Floating_View({
				type: 'floating_social',
				model: floating_social_model,
				conditions_view: new Conditions_View({
					model: floating_social_model.get('conditions'),
					type: 'floating_social'
				})
			})
        });

    }());
});

