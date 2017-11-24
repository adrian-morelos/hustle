Hustle.define("Optin.Wizard", function($){
    "use strict";

    return Backbone.View.extend({
        el: "#wpoi-wizard",
        events: {
            "click .next-button button.wph-button-save": "save",
            "click .next-button button.wph-button-next": "save",
            "click .next-button button.wph-button-finish": "save",
            "click .wph-toggletabs--title.can-open": "toggle_section",
            "click .js-wph-optin-cancel": "cancel",
            "click .js-wph-optin-back": "back",
        },
        toggle_section: function(e){
            var $this = this.$(e.target),
                $panel = $this.closest(".wph-toggletabs");
			
			$('.wph-toggletabs').not($panel).removeClass('wph-toggletabs--open');
            $panel.toggleClass("wph-toggletabs--closed wph-toggletabs--open");
        },
		validate: function() {
			var errors = 0;

			
			if ( ! this.$('#optin_new_name' ).val() ) {
				errors++;
			}
			if ( ! this.$('#optin_new_provider_name').val()
				&& ( ! this.$('#wpoi-test-mode-setup').is(':checked')
					&& ! this.$('#wpoi-save-to-local').is(':checked') ) ) {
				errors++;
			}

			return errors;
		},
        save: function(e){
            e.preventDefault();
			Hustle.Events.trigger("Optin.save");
 
            var errors = Optin.step.services.errors,
				me = this,
                $this = this.$(e.target).closest("button"),
                nonce = $this.data("nonce"),
                id = Optin.step.services.model.get("optin_id") || -1,
                is_new = id == -1 ? true: false;

			if ( this.validate() > 0 || errors > 0 ) {
				return;
			}

			$this.attr("disabled", true);
			if ( $this.hasClass("wph-button-next") || $this.hasClass("wph-button-finish") ) {
				$this.addClass("wph-button-next--loading");
			} else {
				$this.addClass("wph-button-save--loading");
			}
			$this.siblings().attr("disabled", true);

            $.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: 'inc_opt_save_new',
                    id: id,
                    _ajax_nonce: nonce,
                    optin: Optin.step.services.model.toJSON(),
                    design: Optin.step.design.model.toJSON(),
                    settings: Optin.step.display.model.toJSON(),
                    provider_args: Optin.step.services.provider_args.toJSON()
                },
                complete: function(){
					Optin.hasChanges = false;

                    $this.attr( "disabled", false )
                        .removeClass( "wph-button-next--loading" )
                        .removeClass( "wph-button-save--loading" );
					$this.siblings().attr("disabled", false);
                    if ( $this.hasClass("wph-button-next") ) me.next(e);
                    if ( $this.hasClass("wph-button-finish") ) me.finish_setup(e);
                },
                success: function(res){

                    if( !res.success ) return;

                    Optin.step.services.model.set("optin_id", res.data );
					Optin.hasChanges = false;
                    
                    var currUrl = window.location.pathname + window.location.search;
                    if ( is_new && currUrl.indexOf('&optin=') === -1 ) {
                        currUrl += '&optin=' + res.data;
                        window.history.replaceState( {} , '', currUrl );
                    }
                }
            });
        },
		next: function(e){
			var $this = this.$(e.target),
                $current_panel = $this.closest(".wph-toggletabs"),
                $next_panels = $current_panel.nextAll(".wph-toggletabs")
			;
			if( $next_panels.length ) {
				var $_next = $next_panels.eq(0);

				$current_panel
					.removeClass( "wph-toggletabs--open" )
					.addClass("wph-toggletabs--closed");

				$_next
					.addClass("wph-toggletabs--open");


				$('html, body').animate({
					scrollTop: $_next.offset().top
				}, 700);
				return;
			}
		},
        cancel: function(e){
            e.preventDefault();
            window.onbeforeunload = null;
            window.location.replace( "?page=inc_optin_listing" );
        },
		finish_setup: function(e){
			e.preventDefault();
			var id = Optin.step.services.model.get("optin_id") || -1,
                is_new = id == -1 ? true: false
			;
			
			window.onbeforeunload = null;
			var url = "?page=inc_optin_listing";
			if(is_new) {
				url += "&optin=" + id;
			}else{
				url += "&optin_updated=" + id;
			}
			window.location.replace( url );
		},
        back: function(e){
            e.preventDefault();
            var $this = this.$(e.target),
                $current_panel = $this.closest(".wph-toggletabs"),
                $next_panel = $current_panel.prevAll(".wph-toggletabs"),
                $_prev_panel = $next_panel.first();
				
            $current_panel.removeClass("wph-toggletabs--open");
            $_prev_panel.addClass("wph-toggletabs--open");
            $('html, body').animate({
                scrollTop: $_prev_panel.offset().top
            }, 700);
        }
    });

});