Hustle.define("Legacy_Popups.Listing", function( $ ){
    "use strict";
   return Backbone.View.extend({
      el: "#wph-ccontent--migration",
       events: {
         "click .custom-content-legacy-toggle-activity": "toggle_activity",
         "click .wph-button-legacy-quickedit-btn": "toggle_quick_edit",
         "click .custom-content-legacy-popup-save-quickedit": "save_quick_edit",
         "click .wph-button-legacy-migrate-btn": "migrate"
       },
       initialize: function(){

       },
       toggle_activity: function(e){
           var $this = this.$( e.target ),
               id = $this.data("id"),
               nonce = $this.data("nonce"),
               target_state = $this.is(":checked");

           $this.prop("disabled", true);
           $.ajax({
               url: ajaxurl,
               data: {
                   action: "hustle_legacy_popup_toggle_activity",
                   id: id,
                   target_state: target_state,
                   _ajax_nonce: nonce
               },
               complete: function(){
                   $this.prop("disabled", false);
               },
               success: function(res){
                   if( !res.success )
                    $this.prop("checked", !target_state);
               },
               error: function(){
                   $this.prop("checked", !target_state);
               }

           });
       },
       toggle_quick_edit: function(e){
           var $this = this.$(e.target),
               $li = $this.closest("li");

           $this.toggleClass("wph-button--open wph-button--closed");
           $li.toggleClass("wph-accordion--open wph-accordion--closed");
       },
       save_quick_edit: function(e){
           var self = this,
               $this = this.$( e.target ),
               $panel = $this.closest("li"),
               data = {
                   action: "hustle_custom_content_legacy_popup_quick_edit_save",
                   content: $panel.find('.hustle-custom-content-legacy-popup-content').val(),
                   heading: $panel.find('.hustle-custom-content-legacy-popup-heading').val(),
                   subheading: $panel.find('.hustle-custom-content-legacy-popup-subheading').val(),
                   id: $this.data("id"),
                   _ajax_nonce: $this.data("nonce")
               },
               $spinner = $("<span class='button-spinner'>"),
               quick_edit_btn = $panel.find(".wph-button-legacy-quickedit-btn")[0],
               button_width = $this.outerWidth();

           $this.append( $spinner )
               .animate( { width: button_width + ( button_width * 0.3 ) })
               .attr("disabled", true);

           $.ajax({
               url: ajaxurl,
               data: data,
               complete: function(){
                   $this.animate({ width: button_width })
                       .attr( "disabled", false )
                       .find( ".button-spinner" ).remove();
               },
               success: function(res){
                    if( res.success )
                        self.toggle_quick_edit({ target: quick_edit_btn });
               }
           });
       },
       migrate: function(e){
           var self = this,
               $this = this.$( e.target ),
               $li = $this.closest("li"),
               id = $this.data("id"),
               nonce = $this.data("nonce"),
               $spinner = $("<span class='button-spinner'>"),
               button_width = $this.outerWidth();

           $this.append( $spinner )
               .animate( { width: button_width + ( button_width * 0.3 ) })
               .attr("disabled", true);

           $.ajax({
               url: ajaxurl,
               data: {
                   action: "hustle_custom_content_legacy_popup_migrate",
                   id: id,
                   _ajax_nonce: nonce
               },
               complete: function(){
                   $this.animate({ width: button_width })
                       .attr( "disabled", false )
                       .find( ".button-spinner" ).remove();
               },
               success: function( res ){
                   $li.slideUp(300, function(){
                       $li.remove();
                   });
               }
           });
       }
   });

});