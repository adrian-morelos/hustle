var Inc_Opt_Router = Backbone.Router.extend({

    routes: {
        "":         "services",
        "services": "services",
        "design":   "design",
        "display(/:optin_type)":  "display"
    },

    route: function(route, name, callback) {
        var router = this;
        if (!callback) callback = this[name];

        var f = function() {
            if( !Optin.step.model  )
                Optin.step.model = new Optin.Model( optin_vars.current.data );
			
			if ( ! parseInt(optin_vars.is_limited) ) {
				var Email_Services_Tab = Hustle.get("Optin.Email_Services_Tab");
				if( !Optin.step.services  ){
					var Provider_Args = Hustle.get("Models.M");
					Optin.step.services = new Email_Services_Tab({ model: Optin.step.model, provider_args: new Provider_Args( optin_vars.current.provider_args ) });
				}

				var Design_Tab = Hustle.get("Optin.Design_Tab");
				if( !Optin.step.design  )
					Optin.step.design =  new  Design_Tab({ model: new Optin.Models.Design_Model( optin_vars.current.design ), optin: Optin.step.model });

				var Display_Tab = Hustle.get("Optin.Display_Tab");
				if( !Optin.step.display )
					Optin.step.display = new Display_Tab({ model: new Optin.Models.Settings_Model( optin_vars.current.settings ) });

				if( !Optin.step.wizard ){
					var Wizard = Hustle.get("Optin.Wizard");
					Optin.step.wizard = new Wizard();
				}
			}

            callback.apply(router, arguments);
        };


        return Backbone.Router.prototype.route.call(this, route, name, f);
    },
    execute: function(callback, args, name) {
        // Prevent changing tab if current tab does not validate
        var routeIndex = _.keys(this.routes).indexOf(name) - 1;
        if( routeIndex != Optin.step.current ) {
            switch ( Optin.step.current ) {
                case 0:
                    var validate = Optin.step.model.validate_first_step();
                    if ( validate.size() ) {
                        Optin.step.services.validate();
                        // Set the URL back to the original route and dont execute the route callback
                        Optin.router.navigate(_.keys(this.routes)[Optin.step.current +1], false);
                        // Current tab did not validate, don't route
                        return false;
                    }
                    break;
            }
        } else {
            // Set the URL back to the original route and dont execute the route callback
            Optin.router.navigate(_.keys(this.routes)[Optin.step.current +1], false);
            // don't route if same route as before
            return false;
        }

        Optin.Events.trigger("navigate", args, name);
        if (callback) callback.apply(this, args);
    },

    services: function() {
        Optin.step.activate_step( 0 );
    },

    design: function() {


        Optin.step.activate_step( 1 );
    },

    display: function( type ) {

        Optin.step.activate_step( 2 );

        // If optin type set in URL, scroll to it
        type = type || "";
        if( type !== "" && jQuery('#wpoi-listing-wrap-' + type).length ) {

            jQuery('#wpoi-listing-wrap-' + type ).find("i.dev-icon:not(.search-icon)").trigger("click");

            //Wait for the elements to render
            /*
            window.setTimeout(function(){
                jQuery('html, body').animate({
                    scrollTop: jQuery('#wpoi-listing-wrap-' + type ).offset().top - 50
                }, 2000);

            }, 500);
            */

        }    
        
    }

});

/**
 * Init the routing if it's optin creation page
 */
 // have to remove "-pro" that came from the menu which causes template not to work
adminpage = adminpage.replace('hustle-pro', 'hustle');
if( 'hustle_page_inc_optin' == adminpage  ){
    Optin.router = new Inc_Opt_Router();
    Backbone.history.start();
}