Hustle.define("Custom_Content.Listing", function($, doc, win){
    "use strict";
    var Delete_Confirmation = Hustle.get("Delete_Confirmation");
    return Backbone.View.extend({
        el: "#wph-ccontent--modules",
        events: {
            "click .wph-accordions header" : "toggle_accordion",
            "change .custom-content-toggle-activity": "toggle_activity",
            "change .custom-content-toggle-tracking-activity": "toggle_tracking_activity",
            "change .custom-content-toggle-type-activity": "toggle_type_activity",
            "change .custom-content-toggle-test-activity": "toggle_test_activity",
            "click .custom-content-edit": "edit",
            "click .custom-content-delete": "delete"
        },
        delete_confirmations: {},
        initialize: function(){
			$(doc).on('click', '#hustle-legacy-popup-notice button.notice-dismiss', this.dismiss_legacy_popup_notice);
        },
		dismiss_legacy_popup_notice: function(e){
			var $this = $(e.target).closest("#hustle-legacy-popup-notice"),
                nonce = $this.data("nonce");
			$.ajax({
                url: ajaxurl,
                type: "POST",
                data: {
                    action: "hustle_custom_content_dismiss_legacy_notice",
                    _ajax_nonce: nonce
                }
            });
		},
        toggle_accordion: function(e){
            if( _.indexOf( ['wph-accordion--animate_buttons', 'wph-icon i-arrow'], e.target.className  ) === -1 ) return;

            var $this = $(e.target),
                $icon = $this.find(".dev-icon"),
                $li = $this.closest("li"),
                $section = $li.find("section");

            $icon.toggleClass("dev-icon-caret_down dev-icon-caret_up");
            $li.toggleClass("wph-accordion--closed wph-accordion--open");
			$li.siblings('li.wph-accordion--open').toggleClass("wph-accordion--closed wph-accordion--open");

        },
        toggle_activity: function(e){
            e.stopPropagation();
            var $this = $(e.target),
                id = $this.data("id"),
                nonce = $this.data("nonce"),
                new_state = $this.is(":checked");

            $this.attr("disabled", true);

            $.ajax({
                url: ajaxurl,
                type: "POST",
                data: {
                    action: "hustle_custom_content_toggle_activity",
                    id: id,
                    _ajax_nonce: nonce
                },
                complete: function(){
                    $this.attr("disabled", false);
                },
                success: function( res ){
                    if( !res.success )
                        $this.attr("checked", !new_state);
                },
                error: function(){
                    $this.attr("checked", !new_state);
                }
            });
        },
        toggle_tracking_activity: function(e){
            e.stopPropagation();
            var $this = $(e.target),
                id = $this.data("id"),
                nonce = $this.data("nonce"),
                type = $this.data("type"),
                new_state = $this.is(":checked");

            $this.attr("disabled", true);

            $.ajax({
                url: ajaxurl,
                type: "POST",
                data: {
                    action: "hustle_custom_content_toggle_tracking_activity",
                    id: id,
                    type: type,
                    _ajax_nonce: nonce
                },
                complete: function(){
                    $this.attr("disabled", false);
                },
                success: function( res ){
                    if( !res.success )
                        $this.attr("checked", !new_state);
                },
                error: function(res){
                    if( !res.success )
                        $this.attr("checked", !new_state);
                }
            });
        },
        toggle_type_activity: function(e){
            e.stopPropagation();
            var $this = $(e.target),
                id = $this.data("id"),
                nonce = $this.data("nonce"),
                type = $this.data("type"),
                new_state = $this.is(":checked");

            $this.attr("disabled", true);

            $.ajax({
                url: ajaxurl,
                type: "POST",
                data: {
                    action: "hustle_custom_content_toggle_type_activity",
                    id: id,
                    type: type,
                    _ajax_nonce: nonce
                },
                complete: function(){
                    $this.attr("disabled", false);
                },
                success: function( res ){
                    if( !res.success )
                        $this.attr("checked", !new_state);
                },
                error: function(res){
                    if( !res.success )
                        $this.attr("checked", !new_state);
                }
            });
        },
        toggle_test_activity: function(e){
            e.stopPropagation();
            var $this = $(e.target),
                id = $this.data("id"),
                nonce = $this.data("nonce"),
                type = $this.data("type"),
                new_state = $this.is(":checked");

            $this.attr("disabled", true);

            $.ajax({
                url: ajaxurl,
                type: "POST",
                data: {
                    action: "hustle_custom_content_toggle_test_activity",
                    id: id,
                    type: type,
                    _ajax_nonce: nonce
                },
                complete: function(){
                    $this.attr("disabled", false);
                },
                success: function( res ){
                    if( !res.success )
                        $this.attr("checked", !new_state);
                },
                error: function(res){
                    if( !res.success )
                        $this.attr("checked", !new_state);
                }
            });
        },
        edit: function(e){
            e.stopPropagation();
        },
        delete: function(e){
            e.stopPropagation();
            var $this = this.$( e.target );

            if( $this.prev( ".hustle-delete-module-confirmation" ).length  ) return;

            var $li = $this.closest("li.wph-accordions--item"),
                id = $this.data("id"),
                confirmation =  new Delete_Confirmation({
                    id: $this.data("id"),
                    nonce: $this.data("nonce"),
                    action: "hustle_custom_content_delete",
                    onSuccess: function(res){
                        if( res.success ){
                            confirmation.remove();
                            $li.toggle("highlight");
                        }
                    }
                });

            $this.before( confirmation.$el );
        }

    });

});