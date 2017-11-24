Hustle.define("Optin.Preview", function($){
    "use strict";
   return Backbone.View.extend({
       el: ".wph-preview",
       preview_modal: false,
       $preview_yield: false,
       wrapper_class_tpl: Hustle.create_template("wph-preview--optin wph-preview--{{type}}"),
       events: {
           "click .wph-preview--mask": "hide",
           "click .wph-preview--close": "hide",
           "change #wph-preview-type-selector": "change_type"
       },
       initialize: function(){
           this.$preview_yield = this.$("#optin-preview-wrapper");
           this.render();
           this.listenTo( this.preview_modal.model, "change", this.render );
           this.$("#wph-preview-type-selector").val( this.model.get("type") );
       },
       get_tpl: function( layout_id ){
           var templates = ["optin-layout-one", "optin-layout-two", "optin-layout-three", "optin-layout-four"];
           return Hustle.template( templates[ layout_id ] );
        },
       render: function(){
           var Modal = Hustle.get("Modal");
           this.preview_modal = new Modal( { model: this.model, template: this.get_tpl( this.model.get("form_location").toInt() ) } );
           this.$preview_yield.replaceWith( this.preview_modal.$el );
           this.$preview_yield = this.preview_modal.$el;
           this.preview_modal.show();
           this.$("#wph-preview-type-selector").val( this.model.get("type") );
           Hustle.Events.trigger("view.rendered", this);
       },
       show: function(){
           this.$el
               .removeClass("wph-preview--closed")
               .addClass("wph-preview--open");
           this.$(".wph-preview--optin").attr("class", this.wrapper_class_tpl({type: this.model.get("type") }));
           Optin.Events.trigger("design:preview:render:finish", this.preview_modal);
       },
       hide: function(e){
           this.$el
               .removeClass("wph-preview--open")
               .addClass("wph-preview--closed");
       },
       change_type: function(e){
           var type = this.$(e.target).val();

           this.preview_modal.model.set("type",  type);
           this.$(".wph-preview--optin").attr("class", this.wrapper_class_tpl({type: type}));
           Optin.Events.trigger("design:preview:render:finish", this.preview_modal);
           Hustle.Events.trigger("Optin.preview.changed.type", this);
       }
   });
});