Hustle.define("Delete_Confirmation", function($){
    "use strict";
   return Backbone.View.extend({
       template: Optin.template("hustle-delete-module-confirmation-tpl"),
       className: "hustle-delete-module-confirmation",
       tagName: "span",
       opts:{
           id: "",
           nonce: "",
           action: "",
           url: ajaxurl
       },
       events: {
           "click .hustle-delete-module-confirm": "confirm",
           "click .hustle-delete-module-cancel": "cancel"
       },
       initialize: function( options ){
           this.opts = _.extend({}, this.opts, options);
           return this.render();
       },
       render: function(){
           this.$el.html( this.template() );
           return this;
       },
       confirm: function(e){
           e.preventDefault();
           e.stopPropagation();

           var self = this,
             $this = this.$( e.target ),
             $spinner = $("<span class='button-spinner'>"),
             button_width = $this.outerWidth();

           $this.append( $spinner )
               .animate( { width: button_width + ( button_width * 0.2 ) })
               .attr("disabled", true);


           $.ajax({
                url: this.opts.url,
                type: "POST",
                data: {
                    action: this.opts.action,
                    _ajax_nonce: this.opts.nonce,
                    id: this.opts.id
                },
                complete: function(){
                    $this.animate({ width: button_width })
                        .attr( "disabled", false )
                        .find( ".button-spinner" ).remove();
                },
                success: function(res){
                    if( self.opts.onSuccess && _.isFunction( self.opts.onSuccess ) )
                        self.opts.onSuccess.call(this, res, self);
                }
            });
       },
       cancel: function(e){
           e.preventDefault();
           e.stopPropagation();
           this.remove();
       }
   });
});