(function($,doc,win){
    "use strict";
	if( inc_opt.is_upfront ) return;

	/**
	 * Front View Model
	 *
	 * This model is use to render Opt-In/Custom-Content popup and slide_in.
	 **/
	Optin.View = Backbone.View.extend({
		isCC: false,
		display_id: 'display',
		showClass: 'wpoi-show',
		maskShowClass: 'inc_optin_',
		optin_id: '',
		type: '',
		settings: {},
		data: {},
		add_never_see_again: false,
		appear_after: 'time',
		mask: false,
		should_remove: false,
		parent: 'body',
		anim_in_time: Optin.popup_overlay_delay,
		anim_out_time: 2000,
		viewed: false,
		events: {
			'click': 'click',
			'click .inc-opt-close-btn': 'closed',
			'click .inc_opt_never_see_again': 'closed'
		},
		click: _.noop,

		initialize: function( opts ) {
			this.key = opts.key;
			this.opt = Optins[ this.key ];
			this.settings = this.opt.settings[this.type];
			this.data = this.opt.data;
			this.optin_id = this.data.optin_id;
			this.maskClass = 'inc_optin_' + this.optin_id + ' ' + this.maskClass;
			this.add_never_see_again = _.isTrue(  this.settings.add_never_see_this_message );
			this.appear_after = this.settings.appear_after;
			this.cookie_key =  ( 'popup' === this.type ? Optin.POPUP_COOKIE_PREFIX : Optin.SLIDE_IN_COOKIE_PREFIX ) + this.optin_id;
			this.expiration_days = parseInt( this.settings.never_see_expiry, 10 );

			this.triggers = {
				on_time: this.settings.trigger_on_time,
				on_time_delay: this.settings.appear_after_time_val,
				on_time_unit: this.settings.appear_after_time_unit,
				on_scroll: this.settings.appear_after_scroll,
				on_scroll_page_percent: parseInt( this.settings.appear_after_page_portion_val ),
				on_scroll_css_selector: this.settings.appear_after_element_val,
				on_click_element: this.settings.trigger_on_element_click,
				on_exit_intent: this.settings.trigger_on_exit,
				on_exit_intent_per_session: this.settings.on_exit_trigger_once_per_session,
				on_adblock: this.settings.trigger_on_adblock,
				on_adblock_delayed: this.settings.trigger_on_adblock_timed,
				on_adblock_delayed_time: this.settings.trigger_on_adblock_timed_val,
				on_adblock_delayed_unit: this.settings.trigger_on_adblock_timed_unit
			};

			if ( ! this.should_display() ) {
				return;
			}

			if ( _.contains( ['time', 'scrolled', 'adblock'], this.appear_after )
				|| ( 'exit_intent' === this.appear_after && _.isTrue( this.settings.on_exit_trigger_once_per_session ) ) ) {
				this.should_remove = true;
			}

			this.render();
		},

		/**
		 * Check if popup should display. **/
		should_display: function() {
			return _.isTrue( this.settings.display )
				&& !_.isTrue( Optin.cookie.get( this.cookie_key ) );
		},

		/**
		 * Trigger to completely hide this. **/
		never_see_again: function() {
			Optin.cookie.set( this.cookie_key, this.optin_id, this.expiration_days );
		},

		fit: function() {
			var height = $(win).height(),
				max_height = ( height / 100 ) * 65,
				header_height = this.$('header').outerHeight(),
				containers = this.$('.wph-modal--message, .wph-modal--image'),
				message_height = max_height - header_height,
				el_css = {'max-height': max_height };

			this.$el.css( 'max-height', max_height );
			containers.css('max-height', message_height );

			if ( 'popup' === this.type && 'cabriolet' !== this.settings.style ) {
				var top = (height - max_height)/2;
					top = top - (top * 1.5);

				this.$el.css('margin-top', top + 'px');
			}
		},

		render: function() {
			var html = '<a href="#" aria-label="Close" class="inc-opt-close-btn inc-opt-close-' + this.type + '">&times;</a>';
				html += Optin.render_optin( this.opt );
            var data = {handle: this.key, type: this.type, popup: this.opt};

			if ( this.add_never_see_again ) {
				html += '<div class="wpoi-nsa"><a class="inc_opt_never_see_again">%s</a></div>'.replace("%s", inc_opt.l10n.never_see_again );
			}

			if( this.settings.animation_in ){
				this.$el.addClass( this.settings.animation_in );
			}
			this.$el.addClass( ' inc_optin_' + this.optin_id );
			this.$el.html( html );
            
            var provider = this.$(".wpoi-provider-args");

			if ( provider.length ) {
				// Add provider args
				provider.html( Optin.render_provider_args( this.opt )  );
			}

			this.$el.appendTo(this.parent);
			this.$el.display = $.proxy( this, 'display' );
			this.$el.on( 'show', $.proxy( this, 'onShow' ) );
			this.$el.on( 'hide', $.proxy( this, 'onHide' ) );
			this.$el.data(data);
			this.html = this.$el.html();

			// Trigger display
			this[this.appear_after + '_trigger']();

			return this;
		},

		display: function() {
			var me = this;

			// Marked viewed when display is triggered
			this.viewed = true;

			if( this.$el.is( '.' + this.showClass ) ) {
				// If already shown, return
				return;
			}

			this.$el.html( this.html );
			this.$el.removeClass( this.settings.animation_out );
			this.add_mask();
			this.animation_in();
			this.$el.trigger( 'show', this );
		},

		add_mask: function() {
			var me = this,
                no_scroll = _.isFalse(this.settings.allow_scroll_page),
                no_bg_click = _.isFalse(this.settings.not_close_on_background_click);
            
            _.delay( $.proxy(function() {
                if ( no_scroll ) {
                    $('html').addClass('no-scroll');
                }

                if ( ! this.mask ) {
                    this.mask = $( '<div class="' + this.maskClass + ' wpoi-overlay-mask wpoi-animate fadein">' +
                        '<div class="wpoi-' + this.type + '-overlay"></div></div>' );
                    this.mask.insertBefore(this.$el).addClass('wpoi-show');

                    if ( no_bg_click ) {
                        this.mask.on( 'click', $.proxy( this, 'closed' ) );
                    }
                } else {
                    this.mask.addClass('wpoi-show');
                }
            }, this), Optin.popup_overlay_delay);
		},

		animation_in: function() {
			var me = this,
                not_viewed = _.isFalse( me.viewed );

			if( this.settings.animation_in ) {
				this.$el.addClass( this.settings.animation_in );
			}

			_.delay(function(){

				if ( not_viewed ) {
					// Prevent from running if display is abruptly closed
					return;
				}

				me.$el.addClass( me.showClass );

				// If we have an OUT animation,
				// we should swap the animations right after the IN ends
				if( me.settings.animation_out ){
					if( me.settings.animation_in ){

						_.delay(function(){
							me.$el.removeClass( me.settings.animation_in );
							me.$el.addClass( me.settings.animation_out );
						}, 350 );

					} else {
						me.$el.addClass( me.settings.animation_out );
					}

				} else if( me.settings.animation_in ){
					_.delay(function(){
						me.$el.removeClass( me.settings.animation_in );
					}, 350);
				}
                
			}, Optin.popup_overlay_delay );
		},

		time_trigger: function() {
			if ( 'immediately' == this.triggers.on_time ) {
				this.display();
			} else {
				var delay = parseInt( this.triggers.on_time_delay, 10 ) * 1000;

				if( 'minutes' === this.triggers.on_time_unit ) {
					delay *= 60;
				} else if( 'hours' === this.triggers.on_time_unit ) {
					delay *= ( 60 * 60 );
				}

				_.delay( $.proxy( this, 'display' ), delay );
			}
		},

		click_trigger: function() {
            var me = this,
                selector = '';
            
			if( "" !== (selector = $.trim( this.triggers.on_click_element ) )  ){
				var $clickable = $(selector);

				if( $clickable.length ) {
					$(doc).on( 'click', selector, function(e) {
                        e.preventDefault();
                        me.display();
                    } );
				}
			}
            
            /**
            * Clickable button added with shortcode
            */
            $(doc).on("click", ".inc_opt_hustle_shortcode_trigger", function(e){
                e.preventDefault();
                if( $(this).data("id") == me.data.optin_id && $(this).data("type") == me.type ) {
                    me.display();
                }
            });
		},

		scroll_trigger: function() {
			var me = this, popup_shown = false;

			if( 'scrolled' === this.triggers.on_scroll  ){
				$(win).scroll(_.debounce( function(){
					if ( popup_shown ) {
						return;
					}

					if( (  win.pageYOffset * 100 / $(doc).height() ) >= parseFloat( me.triggers.on_scroll_page_percent ) ) {
						me.display();
					   popup_shown = true;
					}

				}, 50) );
			}

			if( 'selector' === this.triggers.on_scroll  ){
				 var $el = $( this.triggers.on_scroll_css_selector );

				 if( $el.length ){
					 $(win).scroll(_.debounce( function(){
						 if ( popup_shown ) {
							 return;
						 }
						 if( win.pageYOffset >= $el.position().top ) {
							 me.display();
							 popup_shown = true;
						 }

					 }, 50));
				 }
			 }
		},

		scrolled_trigger: function() {
			return this.scroll_trigger();
		},

		exit_intent_trigger: function() {
			if(_.isTrue( this.triggers.on_exit_intent  ) ){
				if ( _.isTrue( this.triggers.on_exit_intent_per_session ) ) {
					Hustle.Events.once( 'exit_intended', $.proxy( this, 'display' ) );
				} else {
					Hustle.Events.on( 'exit_intended', $.proxy( this, 'display' ) );
				}
			}
		},

		adblock_trigger: function() {
			var adblock = ! $('#hustle_optin_adBlock_detector').length;

			if ( adblock && _.isTrue( this.triggers.on_adblock ) ) {
				if( _.isFalse( this.triggers.on_adblock_delayed ) ){ 
					this.display();
				} else {
					var delay = parseInt( this.triggers.on_adblock_delayed_time, 10 ) * 1000;

					if(  'minutes' === this.triggers.on_adblock_delayed_unit ) {
						delay *= 60;
					} else if( 'hours' === this.triggers.on_adblock_delayed_unit ) {
						delay *= ( 60 * 60 );
					}

					_.delay( $.proxy( this, 'display' ), delay );
				}
			}
		},

		closed: function(e) {
			var me = this,
				sender = $(e.currentTarget),
				is_never_see = this.isCC ? _.isTrue( this.settings.close_btn_as_never_see ) : _.isTrue( this.settings.close_button_acts_as_never_see_again );

			this.viewed = false;
			this.$el.removeClass('wpoi-show');

			if ( ( sender.is('.wph-modal--close .wph-icon, .inc-opt-close-' + this.type ) && is_never_see )
				|| sender.is( '.inc_opt_never_see_again,.wph-modal-never-see-again' ) ) {
				this.never_see_again();
			}

			_.delay(function() {
				if ( me.viewed ) {
					// Prevent from being hiding if display is triggered again
					return;
				}
				me.$el.removeClass(me.showClass);
                if ( typeof me.mask !== 'undefined' && me.mask ) {
                    me.mask.removeClass('wpoi-show');
                }
			}, Optin.popup_overlay_delay );

			if ( this.settings.animation_in ) {
				if ( this.settings.animation_out ) {
					_.delay(function() {
						if ( me.viewed ) {
							// Prevent from being hiding if display is triggered again
							return;
						}
						me.$el.removeClass( me.settings.animation_out );
						me.$el.addClass( me.settings.animation_in );
					}, 1000 );
				} else {
					this.$el.addClass( this.settings.animation_in );
				}
			}

			if ( ! this.settings.animation_out ) {
				// Make sure all contents are being hidden if popup doesn't have any animation_out
				this.$el.hide();
				_.defer(function() {
					( me.$el[0].style || {} ).display = '';
				});
			}

			if ( _.isTrue( this.settings.close_button_acts_as_never_see_again )
				&& _.isTrue( this.settings.trigger_on_exit ) ) {
				$(doc).off( 'wpoi:exit_intended' );
			}

			// delay only if has animations
			if ( this.settings.animation_out ) {
				_.delay(function() {
					if ( me.viewed ) {
						// Prevent from being hiding if display is triggered again
						return;
					}
					me.clean();
				}, 1100 );
			} else {
				me.clean();
			}

			if ( _.isFalse( this.settings.allow_scroll_page ) ) {
				$('html').removeClass('no-scroll');
			}

			this.$el.trigger( 'hide', this );

			return false;
		},
		
		clean: function() {
			this.$el.html('');
			if ( this.should_remove ) {
				this.$el.remove();
                if ( typeof this.mask !== 'undefined' && this.mask ) {
                    this.mask.remove();
                }
			}
		},

		onShow: function() {
			$(document).trigger( 'wpoi:' + this.display_id, [this.type, this.$el, this.opt ]);
		},

		onHide: function() {
			$(document).trigger("wpoi:hide", [this.type, this.$el, this.opt ]);
		}
	});
}(jQuery,document,window));