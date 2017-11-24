(function( $ ) {
    "use strict";
    /**
     * Set optin id from the html template
     */

    Optin.get_tpl = function( layout_id ){
        var templates = ["optin-layout-one", "optin-layout-two", "optin-layout-three", "optin-layout-four"];

        return Optin.template( templates[ layout_id ] );
    };

    Optin.View.Alert = Backbone.View.extend({
        template: Optin.template("optin-alert-modal"),
        //el: ".inc-opt-alert-modal",
        events: {
            "click .inc-opt-alert-modal-close": "close",
            "click .inc-opt-alert-modal": "close",
            "click .inc-opt-alert-modal-close-btn": "close",
            "click .inc-opt-alert-modal-inner-container": "prevent_close"
        },
        initialize: function(options){
            this.options = options;
            return this.render();
        },
        render: function(){
            this.$el.html( this.template(_.extend({
                close_text: optin_vars.messages.ok
            }, this.options) ) );
            this.$el.appendTo("body");
        },
        close: function(e){
            this.$el.hide();
            this.remove();
        },
        prevent_close: function(e){
            e.preventDefault();
            e.stopPropagation();
        }
    });

	/**
	 * Key var to listen user changes before triggering
	 * navigate away message.
	 **/
	Optin.hasChanges = false;
	Optin.user_change = function() {
		Optin.hasChanges = true;
	};

	window.onbeforeunload = function() {
		if ( Optin.hasChanges ) {
			return optin_vars.messages.dont_navigate_away;
		}
	};

    /**
     * Pure object to store each step's template
     * @type {{}|*}
     */
    Optin.step = Optin.step || {};

    Optin.step.activate_step = function(step){

        $(".wpoi-tabs-menu li").removeClass("active");
        $(".wpoi-tabs-menu li").removeClass("before");
        $(".wpoi-tabs-menu li").eq(step).addClass("active");
        $(".wpoi-tabs-menu li").slice(0, step).addClass( "before" );
        //$(".wpoi-flexbox li").eq(step).find("button").addClass("wpoi-current-step");

        $(".wpoi-tabs-wrap > div").hide();
        $(".wpoi-tabs-wrap > div").eq(step).show();

        Optin.step.current = step;
    };

    Optin.step.get_current_step = function(){
        return parseInt( Optin.step.current || 0, 10 );
    };


    Optin.step.get_current = function(){
        return parseInt( Optin.step.current || 0, 10 );
    };

    Optin.step.get_current_step = function(){
        switch ( this.get_current ){
            case 0:
                return Optin.step.services;
                break;
            case 1:
                return Optin.step.design;
                break;
            case 2:
                return Optin.step.display;
                break;

        }
    };

})( jQuery );