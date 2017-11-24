(function( $ ) {
    "use strict";

    Optin.View.Display_Triggers = Backbone.View.extend($.extend( true, {}, Optin.View.Template_Mixin, {
        template: Optin.template("wpoi-wizard-settings-triggers-template"),
        events: {
            'click .tabs-header label': "change_tab"
        },
        initialize: function( opts ){
            this.el = opts.el;
            this.type = opts.type;

            this.listenTo( this.model, "change:" + this.type + ".trigger_on_adblock",  this.hide_adblock_options_on_toggle);
            this.render();
        },
        render: function(){
            this.$el.html( this.template( this.get_data() ) );
            this.hide_adblock_options_on_toggle();
            return this;
        },
        get_data: function(){
            var data = {};
            data.type = this.type;
            data.shortcode_id = this.model.get("shortcode_id");
            return _.extend( {}, data, this.model.get( this.type).toJSON() );
        },
        change_tab: function(event){
            event.preventDefault();
            var $this = this.$(event.target),
                $this_tab = $this.parent("li"),
                $this_content = this.$( $this.attr("href")),
                $radio = $this.find("input[type='radio']");
            this.$(".tabs-header li").removeClass("current");
            this.$(".tabs-content").removeClass("current");

            $this_tab.addClass("current");
            $this_content.addClass("current");
            $radio.prop("checked", true);

            this.model.set( this.type +".appear_after",  $radio.val() );
        },
        hide_adblock_options_on_toggle: function(){
            if( _.isTrue( this.model.get( this.type + ".trigger_on_adblock" ) ) ){
                this.$(".wpoi-popup-trigger-on-adblock-option").show();
            }else{
                this.$(".wpoi-popup-trigger-on-adblock-option").hide();
            }
        }
    }) );
}(jQuery));