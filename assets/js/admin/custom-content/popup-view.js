Hustle.define("Custom_Content.Popup_View", function($, doc, win){
    "use strict";
    return Hustle.View.extend(_.extend({}, Hustle.get("Mixins.Model_Updater"), {
        template: Hustle.template("wpoi-custom-content-popup-tpl"),
        message_editor: false,
        init: function( options ){
            this.type = options.type;
            this.display_triggers_view = options.display_triggers_view;
            this.conditions_view = options.conditions_view;
            this.listenTo( this.model, "change:enabled", this.toggle_panel );
            this.conditions_view.on("toggle_condition", this.update_conditions_label);
            this.conditions_view.on("change:update_view_label", this.update_conditions_label);
            return this.render();
        },
        render: function(){
            this.$el.html( this.template( _.extend({}, {
                type: this.type,
                type_name: optin_vars.messages.settings[ this.type ],
                condition_labels: this.conditions_view.get_all_conditions_labels()
            }, this.model.toJSON() ) ) );

            this.$(".wph-trigger").html( this.display_triggers_view.$el );
            this.$(".wph-conditions").replaceWith(  this.conditions_view.$el );
			if ( _.isFalse(this.model.enabled) ) this.$el.find("#wph-popup-condition-labels").hide();
            return this;
        },
        toggle_panel: function( model ){
            this.$(".switch-wrap").toggleClass("open closed");
			this.$el.find("#wph-popup-condition-labels").toggle();
        },
        update_conditions_label: function( conditions_view ){
           $('#wph-popup-condition-labels').html( conditions_view.get_all_conditions_labels() );
        }
    } ) );

});