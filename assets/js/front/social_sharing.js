(function($, doc, win){
    "use strict";
    
    var Optin = window.Optin || {};
    
    Optin.SS_log_view = Backbone.Model.extend({
		url: inc_opt.ajaxurl + '?action=hustle_social_sharing_viewed',
		defaults: {
			page_type: inc_opt.page_type,
            page_id: inc_opt.page_id,
            type: '',
            uri: encodeURI( window.location.href )
		},
		parse: function( res ) {
			if ( res.success ) {
				console.log('Log success!');
			} else {
				console.log('Log failed!');
			}
		}
	}),
	Optin.SS_log_conversion = Optin.SS_log_view.extend({ url: inc_opt.ajaxurl + '?action=hustle_social_sharing_converted' });
    
    Optin.SS_native_share_enpoints = {
        'facebook': 'https://www.facebook.com/sharer/sharer.php?u=',
        'twitter': 'https://twitter.com/intent/tweet?url=',
        'google': 'https://plus.google.com/share?url=',
        'pinterest': 'https://www.pinterest.com/pin/create/button/?url=',
        'reddit': 'https://www.reddit.com/submit?url=',
        'linkedin': 'https://www.linkedin.com/shareArticle?mini=true&url=',
        'vkontakte': 'https://vk.com/share.php?url=',
    };
    
    Optin.Social_Sharing = Backbone.View.extend({
        template: Optin.template("hustle-social-tpl"),
        events: {
            'click a.native-social-share': 'click_social_native',
            'click a.linked-social-share': 'click_social_linked'
        },
        initialize: function( opts ) {
            this.opts = opts;
            this.optin_id = opts.optin_id;
            this.services = opts.services;
            this.appearance = opts.appearance;
            this.floating_social = opts.floating_social;
            this.is_compat = ( typeof opts.is_compat !== 'undefined' ) 
                ? true
                : false;
            
            if ( typeof opts.parent !== 'undefined' ) {
                this.parent = opts.parent;
            }
            
            this.model_json = _.extend(
                {
                    id: this.optin_id,
                    display_type: this.display_type
                },
                this.services,
                this.appearance,
                this.floating_social
            );
            
            this.render();
        },

        render: function(args){
            var parent_container = this.parent,
                location_align_x = this.model_json.location_align_x,
                location_align_y = this.model_json.location_align_y,
                current_tpl_settings = _.templateSettings;
                
            // if needs compatibility e.g. upfront which uses another _.templateSettings
            if ( this.is_compat ) {
                Optin.global_mixin();
                // force our _.templateSettings setup
                _.templateSettings = {
                    evaluate:    /<#([\s\S]+?)#>/g,
                    interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
                    escape:      /\{\{([^\}]+?)\}\}(?!\})/g
                };
            }
            
            this.setElement( this.template( _.extend( {}, this.model_json ) ) );
            
            if ( this.module_display_type == 'floating_social' ) {                    
                if ( this.model_json.location_type == 'content' ) {
                    parent_container = $('#content');
                } else if ( this.model_json.location_type == 'selector' ) {
                    parent_container = $( this.model_json.location_target );
                } else {
                    parent_container = $('body');
                }
            }
            
            if ( parent_container.length == 0 ) return;
            this.$el.appendTo(parent_container);
            
            var $widget_ss = $('.inc_social_sharing_widget_wrap .wph-social-sharing, .inc_social_sharing_shortcode_wrap .wph-social-sharing'),
                $main_container = ( this.module_display_type === 'floating_social' )
                ? $(parent_container).find('.wph-social-sharing-' + this.model_json.id ).not($widget_ss)
                : $(parent_container).find('.wph-social-sharing-' + this.model_json.id ),
                $sshare_container = $main_container.find('.wph-sshare--container');
            
            this._handle_icons_order();
            _.each( this.model_json.social_icons, $.proxy(function( data, key ) {
                
                var icon_template = ( this.model_json.icon_style == 'one' )
                    ? Optin.template('wpoi-sshare-'+ key +'-one-svg-front')
                    : Optin.template('wpoi-sshare-'+ key +'-svg-front');
                    
                var link = ( this.model_json.service_type == 'native' ) 
                    ? '#'
                    : this.sanitize_url(data.link);
                    
                var target = ( this.model_json.service_type == 'native' ) 
                    ? ''
                    : 'target="_blank"';
                
                // append social icons
                var native_class = 'linked-social-share',
                    icon_html = icon_template(); 
                
                if ( this.model_json.service_type == 'native' ) {
                    native_class = 'native-social-share';
                    if ( _.isTrue( this.model_json.click_counter ) ) {
                        icon_html += '<div class="wph-sshare_social_counter"><span>'+ data.counter +'</span></div>';
                    }
                }
                
                var social_sharing_html = '<a data-social="'+ key +'" class="'+ native_class +'" href="'+ link +'" '+ target +' >'+ icon_html +'</a>';
                $sshare_container.append(social_sharing_html);
                
            }, this) );
            
            if ( this.module_display_type == 'floating_social' ) {
                $main_container.addClass('wph-social-sharing-float');
                if ( location_align_x == 'left' ) {
                    $main_container.css( 'left', this.model_json.location_left + 'px' );
                } else {
                    $main_container.css( 'right', this.model_json.location_right + 'px' );
                }
                if ( location_align_y == 'top' ) {
                    $main_container.css( 'top', this.model_json.location_top + 'px' );
                } else {
                    $main_container.css( 'bottom', this.model_json.location_bottom + 'px' );
                }
            }
            
            if ( this.model_json.service_type == 'native' ) {
                if ( this.module_display_type == 'floating_social' ) {
                    if ( this.model_json.floating_inline_count == '1' ) {
                        $sshare_container.addClass('wph-sshare--count_inline');
                    } else {
                        $sshare_container.addClass('wph-sshare--count_block');
                    }
                } else {
                    if ( this.model_json.widget_inline_count == '1' ) {
                        $sshare_container.addClass('wph-sshare--count_inline');
                    } else {
                        $sshare_container.addClass('wph-sshare--count_block');
                    }
                }
            }
            
            // after getting the template, revert back to previous _.templateSettings
            if ( this.is_compat ) {
                _.templateSettings = current_tpl_settings;
            }
            
            this.html = this.$el.html();
            this.log_view(this.module_display_type, this.opts);
        },
        _handle_icons_order: function() {
            var reordered = {},
                social_icons = this.model_json.social_icons,
                icons_order = this.model_json.icons_order,
                icons_order_arr = icons_order.split(',');
            
            if ( icons_order && icons_order_arr.length ) {
                _.each(icons_order_arr, function( data, key ) {
                    if ( typeof social_icons[data] !== 'undefined' ) {
                        reordered[data] = social_icons[data];
                        social_icons = _.pick(social_icons, function(val, index){
                            if ( data !== index ) {
                                return index = val;
                            }
                        });
                    }
                });
                
                // if still have some, append those
                if ( Object.keys(social_icons).length ) {
                    reordered = _.extend( reordered, _.pick(social_icons, function(val, index) {
                        if ( typeof val !== 'undefined' ) {
                            return index = val;
                        }
                    }) );
                }
                
                this.model_json.social_icons = reordered;
            }
        },
        sanitize_url: function( url ) {
			if ( url ) {
				if (!/^(f|ht)tps?:\/\//i.test(url)) {
					url = "http://" + url;
				}
			}
			return url;
		},
        click_social_native: function(e) {
            e.preventDefault();
            var me = this,
                $this = this.$(e.target),
                $anchor = $this.closest('a.native-social-share'),
                social = $anchor.data('social');
                
            this._update_social_counter($anchor);
            // update other module with same social icon
            $('a[data-social="'+ social +'"]').not($anchor).each( function(){
                me._update_social_counter($(this));
            } );
                
            // update social counter and log conversion
            this.log_conversion(this.module_display_type, this.opts, social, 'native');
                
            if ( social && typeof Optin.SS_native_share_enpoints[social] != 'undefined' ) {
                window.open(
                    Optin.SS_native_share_enpoints[social]+ hustle_vars.current_url, 
                    'MsgWindow', 
                    'menubar=no,toolbar=no,resizable=yes,scrollbars=yes'
                );
            }
        },
        click_social_linked: function(e) {
            var $this = this.$(e.target),
                $anchor = $this.closest('a.linked-social-share'),
                social = $anchor.data('social');
                
            // log conversion only if allowed
            if ( this.opts.tracking_types != null && _.isTrue( this.opts.tracking_types[this.module_display_type] ) ) {
                this.log_conversion(this.module_display_type, this.opts, social, 'linked');
            }
        },
        _update_social_counter: function($a){
            _.delay(function(){
                var $counter = $a.find('.wph-sshare_social_counter span');
                if ( $counter.length ) {
                    var val = parseInt($counter.text()) + 1;
                    $counter.text(val);
                }
            }, 5000);
        },
        log_view: function( type, ss ){
            if ( ss.tracking_types != null && _.isTrue( ss.tracking_types[type] ) ) {
                if ( typeof Optin.SS_log_view != 'undefined' ) {
                    var logView = new Optin.SS_log_view();
                    logView.set( 'type', type );
                    logView.set( 'id', ss.optin_id );
                    logView.save();
                }
            }
            // set cookies used for "show less than" display condition
            if( !window.hasOwnProperty( "optin_vars" ) ){ // don't set cookie in admin
                var show_count_key = Hustle.consts.SS_Module_Show_Count + type + "-" + ss.optin_id,
                    current_show_count = Hustle.cookie.get( show_count_key );
                Hustle.cookie.set( show_count_key, current_show_count + 1, 90 );
            }
        },
        log_conversion: function( type, ss, source, service_type ) {
            var track_converstion = ( ss.tracking_types != null && _.isTrue( ss.tracking_types[type] ) )
                ? true
                : false;
                
            if ( typeof Optin.SS_log_conversion != 'undefined' ) {
                var logConversion = new Optin.SS_log_conversion();
                logConversion.set( 'type', type );
                logConversion.set( 'id', ss.optin_id );
                logConversion.set( 'source', source + '_icon' );
                logConversion.set( 'track', track_converstion );
                logConversion.set( 'service_type', service_type );
                logConversion.save();
            }
        }
    });
    
    Optin.SS_floating = Optin.Social_Sharing.extend({
        module_display_type: 'floating_social',
        display_type: 'column'
    });
    
    Optin.SS_widget = Optin.Social_Sharing.extend({
        module_display_type: 'widget',
        display_type: 'row'
    });
    
    Optin.SS_shortcode = Optin.Social_Sharing.extend({
        module_display_type: 'shortcode',
        display_type: 'row'
    });

}(jQuery, document, window));