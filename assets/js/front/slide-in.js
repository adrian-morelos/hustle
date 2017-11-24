(function( $, doc, win ) {
    "use strict";
    if( inc_opt.is_upfront ) return;

	Optin = window.Optin || {};

	Optin.SlideIn = Optin.View.extend({
		className: 'inc_opt_slidein inc_optin wpoi-slide',
		type: 'slide_in',
		prevent_hide_after: false,
		delay_time: 0,

		should_display: function() {
			var cookie_key = 'popup' === this.type ? Optin.POPUP_COOKIE_PREFIX : Optin.SLIDE_IN_COOKIE_PREFIX;
			cookie_key += this.optin_id;

			var opt_cookie_never_see = Optin.cookie.get( cookie_key );
            
            this.add_mask = _.noop;

			if ( ! opt_cookie_never_see ) {
				// Check cookie prefix
				opt_cookie_never_see = Optin.cookie.get( Optin.SLIDE_IN_COOKIE_PREFIX + this.optin_id );
			}
			if ( ! opt_cookie_never_see ) {
				// Check hide_all
				opt_cookie_never_see = Optin.cookie.get( Optin.SLIDE_IN_COOKIE_HIDE_ALL + this.optin_id );
			}
			

			if ( 'keep_showing' === this.settings.after_close && opt_cookie_never_see ) {
				opt_cookie_never_see = false;
				// Reset all cookies
				Optin.cookie.set( Optin.SLIDE_IN_COOKIE_PREFIX + this.optin_id,  this.optin_id, 0 );
				Optin.cookie.set( Optin.SLIDE_IN_COOKIE_HIDE_ALL + this.optin_id, this.optin_id, 0 );
				Optin.cookie.set( cookie_key, this.optin_id, 0 );
			}

			return _.isTrue( this.settings.display ) && ! _.isTrue( opt_cookie_never_see );
		},

		render: function() {
			var cLass = 'inc_opt_slidein inc_opt_slidein_' + this.settings.position + ' inc_optin wpoi-slide';
			this.delay_time = this.settings.hide_after_unit === "minutes" ? parseInt( this.settings.hide_after_val, 10 ) * 60 * 1000 : parseInt( this.settings.hide_after_val, 10 ) * 1000;

			this.$el.addClass( cLass );

			Optin.View.prototype.render.apply( this, arguments );
		},

		onShow: function() {
            if ( this.mask ) {
                this.mask.removeClass('wpoi-show');
            }

			if( _.isTrue( this.settings.hide_after ) ) {
                var me = this;

                var delay_id = _.delay(function(){
					if ( ! me.prevent_hide_after ) {
						// if hide after is not prevented, then hide it
                        me.$el.removeClass("wpoi-show");
						me.$el.trigger( 'hide' );
					}
                }, this.delay_time );
            }
			Optin.View.prototype.onShow.apply(this, arguments);
		},

		onHide: function() {
			var should_remove = false;

			if ( 'hide_all' === this.settings.after_close ) {
				Optin.cookie.set( Optin.SLIDE_IN_COOKIE_HIDE_ALL, this.optin_id, 30 );
				should_remove = true;
			}
			if( "no_show" === this.settings.after_close ) {
                Optin.cookie.set( Optin.SLIDE_IN_COOKIE_PREFIX + this.optin_id,  this.optin_id, 30 );
				should_remove = true;
            }

			if ( should_remove ) {
				// Remove completely
                if ( this.mask ) {
                    this.mask.remove();
                }
				this.remove();
			}
		},

		click: function() {
			this.prevent_hide_after = true;
		}
	});
}(jQuery, document, window));