Hustle.define("Optin.Listing", function($){
    "use strict";
    var Delete_Confirmation = Hustle.get("Delete_Confirmation");

    return Backbone.View.extend({
        el: "#hustle-optin-listing",
		logShown: false,
        events: {
	        "click .wph-accordions header" : "toggle_optin_accordion",
            "click .hustle-delete-optin": "delete_optin",
            "click .optin-active-state": "toggle_optin_activity",
            "click .button-view-email-list": "view_email_list",
            "change  .optin-type-active-state": "toggle_type_activity",
            "change  .wpoi-testmode-active-state": "toggle_type_mode_activity",
            "change .optin-toggle-tracking-activity": "toggle_tracking_activity",
			"click .button-view-log-list": "view_error_log_list"
        },
        initialize: function(){
            var self = this;
            // Set visibility for test mode toggles at view load, with no animation
            this.$('.optin-type-active-state').each(function(){
                self.set_testmode_visibiliy( $(this), 0 );
            });
        },
        toggle_optin_accordion: function(e){

            if( _.indexOf( ['wph-accordion--animate_buttons', 'wph-icon i-arrow'], e.target.className  ) === -1 ) return;

            var $this = $(e.target),
                $icon = $this.find(".dev-icon"),
                $li = $this.closest("li"),
                $section = $li.find("section");

            $icon.toggleClass("dev-icon-caret_down dev-icon-caret_up");
			$li.toggleClass("wph-accordion--closed wph-accordion--open");
			$li.siblings('li.wph-accordion--open').toggleClass("wph-accordion--closed wph-accordion--open");

        },
        delete_optin: function(e){
            e.preventDefault();

            e.stopPropagation();
            var $this = this.$( e.target );

            if( $this.prev( ".hustle-delete-module-confirmation" ).length  ) return;

            var $li = $this.closest("li.wph-accordions--item"),
                id = $this.data("id"),
                confirmation =  new Delete_Confirmation({
                    id: $this.data("id"),
                    nonce: $this.data("nonce"),
                    action: "inc_opt_delete_optin",
                    onSuccess: function(res){
                        if( res.success ){
                            $this.closest("li").slideUp(300, function(){
                                $(this).remove();
                            });
                        }

                    }
                });

            $this.before( confirmation.$el );

        },
        toggle_optin_activity: function(e){
            var $this = this.$(e.target),
                data = $this.data() || {},
                $overlay = $this.closest(".wph-accordions--item").find(".wph-accordion--disable"),
                $row = $this.closest("li");

            data.action = "inc_opt_toggle_state";
            data._ajax_nonce = data.nonce;
            $this.prop("disabled", true);
            if( $this.is(":checked") ){
                $overlay.addClass("hidden");
                $row.removeClass("wph-accordion--closed")
                    .addClass("wph-accordion--open");
            }else{
                $overlay.removeClass("hidden");
                $row.addClass("wph-accordion--closed")
                    .removeClass("wph-accordion--open");
            }

            $.post(ajaxurl, data,function(response){
                $this.prop("disabled", false);

            });
        },
        view_email_list: function(e){
            e.preventDefault();
            e.stopPropagation();
            var $this = $(e.target),
                id = $this.data("id"),
                name = $this.data("name"),
                total = $this.data("total"),
                Subscription_List_Modal = Hustle.get("Optin.Subscription_List_Modal");
                

            var subscription_list = new Subscription_List_Modal({
                model: {
                    id: id,
                    total: total,
                    name: name,
					module_fields: []
                }
            });

        },
        set_testmode_visibiliy: function( active_toggle, speed ) {
            if( typeof speed === 'undefined' ) speed = 400;
            var $this = active_toggle,
                data = $this.data() || {};

            var $test_mode_toggle = this.$('.wpoi-testmode-active-state[data-id="' + data.id + '"][data-type="' + data.type + '"]').closest(".test-mode");
            if( $this.is( ":checked" ) ){
                $test_mode_toggle.fadeOut( speed );
            } else {
                $test_mode_toggle.fadeIn( speed );
            }

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
                    action: "inc_optin_toggle_tracking_activity",
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
            var $this = $(e.target),
                data = $this.data() || {};

            // Set visibility for test mode toggles when the active toggle changes, as specified in indesign
            this.set_testmode_visibiliy( $this );

            $('.optin-type-active-state[data-id="' + data.id + '"][data-type="' + data.type + '"]').not(this).prop("checked", $this.is(":checked") ? true : false);

            data.action = "inc_opt_toggle_optin_type_state";
            data._ajax_nonce = data.nonce;

            $this.prop("disabled", true);
            $.post(ajaxurl, data,function(response){
                $this.prop("disabled", false);
            });
        },
        toggle_type_mode_activity: function(e){
            var $this = $(e.target),
                data = $this.data() || {};

            data.action = "inc_opt_toggle_type_test_mode";
            data._ajax_nonce = data.nonce;

            $('.wpoi-testmode-active-state[data-id="' + data.id + '"][data-type="' + data.type + '"]').not(this).prop("checked", $this.is(":checked") ? true : false);

            $this.prop("disabled", true);
            $.post(ajaxurl, data,function(response){
                $this.prop("disabled", false);
            });
        },
		view_error_log_list: function(e){
			var target = $(e.currentTarget),
				data = target.data(),
				optin_id = data.id,
				name = data.name,
				ErrorList = Hustle.get( 'Optin.Error_List_Modal' );

			if ( ! this.logShown ) {
				this.logShown = new ErrorList({
					button: target,
					model: {
						name: name,
						optin_id: optin_id,
						total: data.total
					}
				});
			} else {
				this.logShown.show();
			}

/*
			$.getJSON( window.ajax, {
				_wpnonce: optin_vars.error_log_nonce,
				optin_id: optin_id
			}, function( res ) {
				alert(res);
			});
*/
		}
    });
});