Hustle.define("Social_Sharing.Appearance_View", function($, doc, win){
    "use strict";
    return Hustle.View.extend(_.extend({}, Hustle.get("Mixins.Model_Updater"), {
        template: Optin.template("wpoi-social-sharing-appreance-tpl"),
        init: function( opts ){
            this.on( 'rendered', this.create_color_pickers );
            // this.on( 'rendered', this.make_icons_sortable );
            
            this.listenTo( Hustle.Events, 'SS.appearance_view_ready', this.ready );
            
            return this.render();
        },
        render: function(args){
            
            this.service_model_json = window.services_model.toJSON();
            this._handle_icons_order();
            
            this.setElement( this.template( _.extend( {}, this.model.toJSON(), this.service_model_json ) ) );
            
            return this;
        },
        create_color_pickers: function() {
            this.$('.wph-color-picker').wpColorPicker({
                change: function( event, ui ) {
                    var $this = $(this);
                    $this.val( ui.color.toCSS() ).trigger('change');
                }
            });
        },
        ready: function() {
            var social_icons = this.service_model_json.social_icons,
                $reorder_box = this.$('.wph-sshare-reorder_box'),
                icon_style = this.model.get('icon_style'),
                $preview_box = this.$('.wph-sshare-floating-social--preview_box'),
                $preview_container = $preview_box.find('.wph-sshare--container'),
                $widget_preview_box = this.$('.wph-sshare-widget--preview_box'),
                $widget_preview_container = $widget_preview_box.find('.wph-sshare--container');
            
            _.each( social_icons, $.proxy(function( data, key ) {
                var icon_template = ( icon_style == 'one' )
                    ? Optin.template('wpoi-sshare-'+ key +'-one-svg')
                    : Optin.template('wpoi-sshare-'+ key +'-svg');
                    
                var icon_template_html = icon_template(); 
                
                // append social icons into Reorder box
                var icon_html = '<div class="wph-sshare-reorder_item" data-id="'+ key +'">'+ icon_template_html +'</div>';
                $reorder_box.append(icon_html);
                
                // append icons on floating social preview
                var preview_icon_html = icon_template_html,
                    native_class = ''; 
                if ( this.service_model_json.service_type == 'native' ) {
                    if ( _.isTrue( this.service_model_json.click_counter ) ) {
                        preview_icon_html += '<div class="wph-sshare_social_counter"><span>'+ data.counter +'</span></div>';
                    }
                    native_class = 'native-social-share';
                }
                var floating_preview_icon_html = '<a data-social="'+ key +'" href="#" class="'+ native_class +'" target="_blank">'+ preview_icon_html +'</a>';
                $preview_container.append(floating_preview_icon_html);
                
                // append icons on widget preview
                var widget_preview_icon_html = '<a data-social="'+ key +'" href="#" class="'+ native_class +'" target="_blank">'+ preview_icon_html +'</a>';
                $widget_preview_container.append(widget_preview_icon_html);
                
            }, this) );
            
            this.make_icons_sortable();
            
            // social counter display
            if ( this.service_model_json.service_type == 'native' ) {
                if ( this.model.get('floating_inline_count') == '1' ) {
                    $preview_container.addClass('wph-sshare--count_inline');
                } else {
                    $preview_container.addClass('wph-sshare--count_block');
                }
                if ( this.model.get('widget_inline_count') == '1' ) {
                    $widget_preview_container.addClass('wph-sshare--count_inline');
                } else {
                    $widget_preview_container.addClass('wph-sshare--count_block');
                }
            }
            
        },
        make_icons_sortable: function() {
            var me = this,
                sortArgs = {
                    items: '.wph-sshare-reorder_item',
                    revert: true,
                    axis: 'x',
                    containment: this.$('#wph-sshare-icons_reorder'),
                    stop: function(e, ui) {
                        me._reorder_icons();
                    }
                };
            
            this.$('.wph-sshare-reorder_box').sortable(sortArgs).disableSelection();
        },
        _handle_icons_order: function() {
            var reordered = {},
                social_icons = this.service_model_json.social_icons,
                icons_order = this.model.get('icons_order'),
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
                
                this.service_model_json.social_icons = reordered;
            }
        },
        _reorder_icons: function() {
            var order = [];
            this.$('.wph-sshare-reorder_box').find('.wph-sshare-reorder_item').each( function() {
                order.push($(this).data('id'));
            } );
            this.model.set( 'icons_order', order.join() );
        }
    } ) );

});