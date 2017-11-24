Hustle.define("Custom_Content.Content_View", function($, doc, win){
    "use strict";
    return Hustle.View.extend(_.extend({}, Hustle.get("Mixins.Model_Updater"), {
        template: Optin.template("wpoi-custom-content-content-tpl"),
        message_editor: false,
        skip_tinyMCE_sync: false,
        init: function( opts ){
            this.design_model = opts.design_model;
            this.sync_message();
            this.listenTo( Hustle.Events, "CC.save_changes", this.sync_model_message );
            this.listenTo( Hustle.Events, "CC.opening_preview", this.sync_model_message );
            return this.render();
        },
        render: function(args){
            this.setElement( this.template( _.extend( {}, this.model.toJSON(), this.design_model.toJSON() ) ) );
            var Media_Holder = Hustle.get("Media_Holder");
            this.media_holder = new Media_Holder({
                model: this.design_model,
                attribute: "image"
            });

            this.$(".wph-media--holder").html( this.media_holder.$el );
            this.listenTo( this.model, "change:optin_message", _.throttle( this.update_content, 50 ) );
            return this;
        },
        /**
         * Keep model editor in sync with tinyMCE message
         */
        sync_message: function() {
            var self = this,
            waitForTinyMCE = setInterval(function () {
                if (typeof tinyMCE !== "object") return;

                clearInterval(waitForTinyMCE);
                tinyMCE.on("AddEditor", function(args){
                    self.message_editor = tinyMCE.get("optin_message");

                    self.message_editor.on("change", function (e) {
                        self.model.set("optin_message", self.message_editor.getContent());
                    });
                });

            });
        },
        sync_model_message: function(){
            if ( this.skip_tinyMCE_sync ) return;
			
            if (typeof tinyMCE !== "object") return;
			
            if( !this.message_editor ) this.message_editor = tinyMCE.get("optin_message");
			
			this.model.set("optin_message", this.message_editor.getContent());
        },
        /**
         * Sents optin_message to server via ajax and sets content from the parsed result
         */
        update_content: function(){
            var self = this;

            $.ajax({
                url: ajaxurl,
                type: "get",
                data: {
                    action: "hustle_CC_parse_content",
                    html: self.model.get("optin_message")
                },
                success: function(res){
                    if( res.success )
                        self.model.set("content", res.data );
                }
            });
        }
    } ) );

});