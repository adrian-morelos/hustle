Hustle.define("Settings.E_News", function($){
    "use strict";
    return Backbone.View.extend({
        el: "#enews-sync-box",
        back_tpl: Optin.template("wpoi-e-newsletter-box-back"),
        initial_html: "",
        events: {
            "click .optin-enews-sync-setup" : "setup",
            "click .optin-enews-sync-cancel" : "cancel",
            "click .optin-enews-sync-save" : "save",
            "click .optin-enews-sync-toggle" : "toggle",
            "click .optin-enews-sync-edit" : "setup"
        },
        initialize: function(){
            this.initial_html = this.$el.html();
        },
        setup: function(e){
            e.preventDefault();
            var self = this,
                $this = $(e.target),
                id = $this.data("id"),
                nonce = $this.data("nonce"),
                is_edit = $this.hasClass("optin-enews-sync-edit");

            $.ajax({
                url: ajaxurl,
                type: "GET",
                data: {
                    action: "inc_opt_get_enews_sync_setup",
                    _ajax_nonce: nonce,
                    id: id
                },
                success: function( res ){
                    if( res.success ){
                        self.$el.html( self.back_tpl( res.data ) );
                    }
                },
                error: function(res){

                }
            });
        },
        cancel: function(e){
            e.preventDefault();
            this.$el.html( this.initial_html );
        },
        save: function(e){
            e.preventDefault();
            var self = this,
                $this = $(e.target),
                id = $this.data("id"),
                groups = [],
                nonce = $this.data("nonce");

            this.$(".wpoi-e-newsletter-group").each(function( index, checkbox ){
                if( checkbox.checked )
                    groups.push( checkbox.value );
            });

            $.ajax({
                url: ajaxurl,
                type: "POST",
                data: {
                    action: "inc_opt_save_enews_sync_setup",
                    _ajax_nonce: nonce,
                    id: id,
                    groups: groups
                },
                success: function( res ){
                    if( res.success ){
                        self.$el.html( res.data.html );
                    }
                },
                error: function(res){

                }
            });
        },
        toggle: function(e){
            var self = this,
                $this = $(e.target),
                id = $this.data("id"),
                nonce = $this.data("nonce"),
                state = $this.is(":checked");

            $.ajax({
                url: ajaxurl,
                type: "POST",
                data: {
                    action: "inc_opt_toggle_enews_sync",
                    _ajax_nonce: nonce,
                    id: id,
                    state: state
                },
                success: function( res ){
                    if( res.success ){
                        $this.attr("checked", state);
                        self.initial_html = self.$el.html();
                    }

                }
            });
        }
    });

});
