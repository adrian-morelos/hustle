Hustle.define("Modal", function($){
    "use strict";

    return Backbone.View.extend({
        template: Optin.template("hustle-modal-tpl"),
        $mask: $('<div class="wph-modal--mask"></div>'),
        opts: {

        },
        data:{
            id: "",
            type: "popup",
            style: "",
            title: "",
            subtitle: "",
            content: "Content",
            animation_in: "",
            animation_out: "",
            position: ""
        },
        events:{
            "click .wph-modal--close a": "hide",
            "submit form": "fire_conversion_event",
            "click .wph-modal--cta": "fire_conversion_event",
            "click .wph-modal-never-see-again": "never_see_again"
        },
        initialize: function( options ){
            this.opts = _.extend( {}, this.opts, options );
            if( options.template )
                this.template = options.template;

            this.render();
            return this;
        },
        render: function(){
            var data = _.extend( {}, this.data, this.model.toJSON() );

            this.type_data = data.types[ data.type ];

            this.animation_in  = data.animation_in = data.types[ data.type ].animation_in || data.animation_in;
            this.animation_out = data.animation_out = data.types[ data.type ].animation_out || data.animation_out;

            data.position = data.types[ data.type ].position || data.position;
			
			// check cta_url if preceeds http
			data = this.sanitize_cta_url(data);
			
			// enable fullscreen
			data = this.enable_fullscreen(data);
			
			// handle custom size for custom content
			data = this.handle_custom_size_cc(data);
			
            this.setElement( this.template( data ) );

            this.$mask = this.$mask.clone();
            this.$mask.on("click", _.bind( this.clicked_background, this ) );

            this.$el.find( "form" ).on("submit", _.bind( this.on_form_submit, this ) );
			
			// check if CC and scroll enabled
			this.enable_body_scroll(data);
			
			// hide close button if on admin
			if( window.hasOwnProperty( "optin_vars" ) ) {
				var $close_btn = this.$el.find('a.wph-icon.i-close');
				if ( $close_btn.length ) $close_btn.parent().hide();
			}
			
            return this;
        },
        hide: function(e){
            var self = this;
            if( e )
                e.preventDefault();
			
            if ( self.animation_in !== self.animation_out ) self.$el.removeClass( self.animation_in );
            _.delay(function(){
				if ( self.animation_out && !self.$el.hasClass(self.animation_out) ) {
					self.$el.addClass( self.animation_out );
				}
				
				_.delay( function(){
					self.$el.removeClass("wph-modal-show");
					self.$el.prev(".wph-modal--mask").remove();
					Hustle.Events.trigger("hide_modal", self );
					self.trigger("hidden");
					
					// only for close button
					if( _.isTrue( self.type_data.close_btn_as_never_see ) && e && $(e.target).hasClass('wph-icon i-close') )
						self.never_see_again( e );
                }, 550 );

            }, 350);
			
			// remove any no-scroll class on html
			$('html').removeClass('no-scroll');
        },
		clicked_background: function(e){
			if ( !_.isTrue( this.type_data.not_close_on_background_click ) ) {
				this.hide(e);
			}
		},
        show:function(){
            var self = this;
            if( !window.hasOwnProperty( "optin_vars" ) ){ // don't set cookie in admin
                var show_count_key = Hustle.consts.Module_Show_Count + this.model.get("type") + "-" + this.model.get("id"),
                    current_show_count = Hustle.cookie.get( show_count_key );

                Hustle.cookie.set( show_count_key, current_show_count + 1, 90 );
            }
			
            if ( self.animation_in !== self.animation_out ) self.$el.removeClass( self.animation_out );
            _.delay( function(){
                self.$el.addClass("wph-modal-show");
                self.trigger("shown", self, self.model.get("type"));
                Hustle.Events.trigger("show_modal", self, self.model.get("type") );

                _.delay( function(){
					if ( self.animation_in && !self.$el.hasClass(self.animation_in) ) {
						self.$el.addClass( self.animation_in );
					}
                }, 350 );

            }, 550 );

        },
		sanitize_cta_url: function( data ) {
			if ( data.cta_url ) {
				if (!/^(f|ht)tps?:\/\//i.test(data.cta_url)) {
					data.cta_url = "http://" + data.cta_url;
				}
			}
			return data;
		},
		enable_fullscreen: function( data ) {
			data.fullscreen = '';
			// only for custom content popup
			if ( !data || typeof data.optin_provider === 'undefined' || typeof data.type === 'undefined' ) {
				return data;
			}
			if ( data.optin_provider == 'custom_content' && data.type == 'popup' ) {
				if ( typeof this.type_data.make_fullscreen === 'undefined' ) {
					return data;
				}
				if ( _.isTrue( this.type_data.make_fullscreen ) ) {
					data.fullscreen = 'wph-modal-popup-fullscreen';
				}
			}
			return data;
		},
		handle_custom_size_cc: function( data ){
			data.custom_size_attr = '';
			data.custom_size_class = '';
			// only for custom content
			if ( !data || typeof data.optin_provider === 'undefined' ) {
				return data;
			}
			if ( data.optin_provider == 'custom_content' ) {
				if ( _.isTrue( data.customize_size ) ) {
					data.custom_size_class = 'wph-modal--custom';
					data.custom_size_attr += 'data-custom_width='+ data.custom_width +' data-custom_height='+ data.custom_height +'';
				}
				if ( _.isTrue( data.border ) ) {
					data.custom_size_attr += ' data-border='+ data.border_weight;
				}
			}
			return data;
		},
		enable_body_scroll: function( data ) {
			// only for custom content popup
			if ( !data || typeof data.optin_provider === 'undefined' || typeof data.type === 'undefined' ) {
				return;
			}
			if ( data.optin_provider == 'custom_content' && data.type == 'popup' ) {
				if ( typeof this.type_data.allow_scroll_page === 'undefined' ) {
					return;
				}
				if ( _.isTrue( this.type_data.allow_scroll_page ) ) {
					$('html').addClass('can-scroll');
				} else {
					$('html').addClass('no-scroll');
				}
			}
		},
        fire_conversion_event: function( e ){
            var source = $(e.target).hasClass( "wph-modal--cta" ) ? "cta" : "form";
            Hustle.Events.trigger("cc_modal_converted", this, source);
            this.trigger("converted", this, source);
        },
        never_see_again: function(e){
            if( e )
                e.preventDefault();

            if( !window.hasOwnProperty( "optin_vars" ) ) // don't set cookie in admin
                Hustle.cookie.set( Hustle.consts.Never_See_Aagain_Prefix + this.model.get("type") + "-" + this.model.get("id") , this.model.get("id"), this.type_data.expiration_days );

            // do not hide if close button to avoid infinite loop
			if ( e && !$(e.target).hasClass('wph-icon i-close') ) {
				this.hide();
			}
        },
        on_form_submit: function(e){
            var self = this,
                $form = $(e.target),
                on_submit = this.type_data.on_submit;

            switch ( on_submit ){
                case "close":
                    self.hide();
                    break;
                case "redirect":
                    window.location.replace( $form.attr("action") );
                    break;
                case "default":
                    break;
                default:
                    break;
            }

        }
    });
});