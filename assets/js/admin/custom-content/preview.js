Hustle.define("Custom_Content.Preview", function($){
    "use strict";
   return Backbone.View.extend({
       el: ".wph-preview",
       preview_modal: false,
       $preview_yield: false,
       events: {
           "click .wph-preview--mask": "hide",
           "click .wph-preview--close": "hide",
           "change #wph-preview-type-selector": "change_type"
       },
       initialize: function(){
           this.$preview_yield = this.$("#wph-preview-yield");
           this.render();
           this.listenTo( this.preview_modal.model, "all", this.render );
       },
       render: function(){
           var Modal = Hustle.get("Modal");
           this.preview_modal = new Modal( { model: this.model } );
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
       },
       hide: function(e){
           this.$el
               .removeClass("wph-preview--open")
               .addClass("wph-preview--closed");
       },
       change_type: function(e){
           this.preview_modal.model.set("type", this.$(e.target).val() );
		   Hustle.Events.trigger("cc.type_changed", this);
       }
   });
});