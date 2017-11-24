Hustle.define("Social_Sharing.Services_View", function($, doc, win){
    "use strict";
    return Hustle.View.extend(_.extend({}, Hustle.get("Mixins.Model_Updater"), {
        template: Optin.template("wpoi-social-sharing-services-tpl"),
        init: function( opts ){
            return this.render();
        },
        render: function(args){
            this.setElement( this.template( _.extend( {}, this.model.toJSON() ) ) );
            // var Media_Holder = Hustle.get("Media_Holder");
            // this.media_holder = new Media_Holder({
                // model: this.design_model,
                // attribute: "image"
            // });

            // this.$(".wph-media--holder").html( this.media_holder.$el );
            return this;
        }
    } ) );

});