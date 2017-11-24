Hustle.define("Social_Sharing.View", function($, doc, win){
    "use strict";

    return Hustle.View.extend({
        el: '.wph-sshare-wizard-view',
        message_box_tpl: Optin.template('wpoi-social-sharing-message-box-tpl'),
        preview: false,
        preview_model: false,
        initial_data: new Backbone.Model({
            content: '',
        }),
        events: {
            'click .wph-toggletabs .can-open': 'toggle_accordion',
            'click ul.wph-ss-service-type li label': 'toggle_service_type',
            'click .wph-button.ss-save-changes': 'ss_save',
            'click .wph-button.ss-cancel': 'ss_cancel',
            'click .wph-button.ss-next-step': 'ss_next_step',
            'click .wph-button.ss-back': 'ss_back',
            'click .wph-button.ss-finish': 'ss_finish',
            'change .wph-sshare--pick_social_icons input.wph-share-icon-enable': 'toggle_icon',
            'change .wph-sshare--pick_social_icons .wph-input--number input': 'icon_counter_updated',
            'change .wph-sshare--pick_social_icons .wph-sshare--input_wrap input': 'icon_link_updated',
            'click ul.wph-share-icon_style [name="wph-sshare-type_icons_design"]': 'toggle_icon_style',
            'click ul.wph-share-customize-color li > label': 'toggle_floating_custom_color',
            'click ul.wph-share-widget-customize-color li > label': 'toggle_widget_custom_color',
            'click ul.wph-sshare--pick_location_type li > label': 'toggle_location_type',
            'click ul.wph-sshare--select_location_align_x li > label': 'toggle_location_align',
            'click ul.wph-sshare--select_location_align_y li > label': 'toggle_location_align'
        },
        init: function( opts ){
            this.services_view = opts.services_view;
            this.appearance_view = opts.appearance_view;
            this.floating_view = opts.floating_view;
            
            this.listenTo( this.model, 'change', this.render_message_box );
            this.listenTo( this.services_view.model, 'change:service_type', this.services_view_changes );
            this.listenTo( this.services_view.model, 'change:click_counter', this.services_view_changes );
            this.listenTo( this.appearance_view.model, 'change:icons_order', this.icons_order_updated );
            this.listenTo( this.appearance_view.model, 'change:drop_shadow', this.appearance_view_changes );
            this.listenTo( this.appearance_view.model, 'change:customize_colors', this.appearance_view_changes );
            this.listenTo( this.appearance_view.model, 'change:customize_widget_colors', this.appearance_view_changes );
            this.listenTo( this.appearance_view.model, 'change:widget_drop_shadow', this.appearance_view_changes );
            this.listenTo( this.appearance_view.model, 'change:floating_inline_count', this.appearance_view_changes );
            this.listenTo( this.appearance_view.model, 'change:widget_inline_count', this.appearance_view_changes );
            this.listenTo( this.appearance_view.model, 'change', _.debounce( this.render_preview, 100 ) );
            
            this.render_message_box();
            return this.render();
        },
        render: function(){
            
            // Names & Services
            this.render_service_view();
                
            // Appearance
            this.render_appearance_view();
                
            var $floating_container = this.$('#wph-social-sharing--floating-social-container'),
                floating_container_classes = $floating_container.attr('class');
                
            $floating_container.replaceWith( this.floating_view.$el.addClass( floating_container_classes ).attr('id', 'wph-social-sharing--floating-social-container') );
        },
        render_service_view: function() {
            // Names & Services
            this.$('#wph-social-sharing--services_tab .wph-toggletabs--content').html('');
            this.services_view.delegateEvents();
            this.$('#wph-social-sharing--services_tab .wph-toggletabs--content')
                .append( this.services_view.$el );
        },
        render_appearance_view: function() {
            
            // Appearance
            this.$('#wph-social-sharing--appearance_tab .wph-toggletabs--content').html('');
            this.appearance_view.delegateEvents();
            this.$('#wph-social-sharing--appearance_tab .wph-toggletabs--content')
                .append( this.appearance_view.$el );
                
            Hustle.Events.trigger('SS.appearance_view_ready');
            
            // Preview
            this.render_preview();
        },
        services_view_changes: function() {
            Optin.hasChanges = true;
            this.services_view.render();
            this.render_service_view();
            this.appearance_view_changes();
        },
        appearance_view_changes: function() {
            Optin.hasChanges = true;
            this._set_social_icons();
            this.appearance_view.render();
            this.render_appearance_view();
        },
        render_message_box: function(){
            var shortcode_id = this._get_shortcode_id();
            this.$('#wph-social-sharing--messagebox').html( this.message_box_tpl( {shortcode_id: shortcode_id } ) );
        },
        render_preview: function() {
            var $preview_box = this.$('#wph-sshare--floating_social .wph-sshare--preview_box .wph-sshare--container'),
                $widget_preview_box = this.$('#wph-sshare--widget_shortcode .wph-sshare--preview_box .wph-sshare--container'),
                appearance_data = this.appearance_view.model.toJSON();
            
            // floating_social_bg
            $preview_box.css( 'background', appearance_data.floating_social_bg );
            // counter text
            if ( appearance_data.counter_text ) {
                $preview_box.find('.wph-sshare_social_counter span')
                    .css( 'color', appearance_data.counter_text );
            }
            
            // custom icon bg color and icon color for each icon_style
            if ( appearance_data.customize_colors == '1' ) {
                
                if ( appearance_data.icon_style == 'one' ) {
                    $preview_box.find('a').css( 'background', appearance_data.icon_bg_color );
                    $preview_box.find('.wph-social-path .wph-social-icon').css( 'fill', appearance_data.icon_color );
                } 
                
                if ( appearance_data.icon_style == 'two' ) {
                    $preview_box.find('.wph-social').css( 'border-color', appearance_data.icon_bg_color );
                    $preview_box.find('.wph-social .wph-social-icon').css( 'fill', appearance_data.icon_color );
                }
                
                if ( appearance_data.icon_style == 'three' || appearance_data.icon_style == 'four' ) {
                    $preview_box.find('.wph-social').css( 'background', appearance_data.icon_bg_color );
                    $preview_box.find('.wph-social .wph-social-icon').css( 'fill', appearance_data.icon_color );
                }
                
                if ( appearance_data.counter_border ) {
                    $preview_box.find('a')
                        .css( 'border', '1px solid ' + appearance_data.counter_border );
                }
            }
            
            // drop_shadow
            if ( appearance_data.drop_shadow == '1' ) {
                var box_shadow = '' + 
                    appearance_data.drop_shadow_x + 'px ' +
                    appearance_data.drop_shadow_y + 'px ' +
                    appearance_data.drop_shadow_blur + 'px ' +
                    appearance_data.drop_shadow_spread + 'px ' +
                    appearance_data.drop_shadow_color;
                
                $preview_box.css( 'box-shadow', box_shadow );
            }
            
            //widget_bg_color
            $widget_preview_box.css( 'background', appearance_data.widget_bg_color );
            $widget_preview_box
                .find('.wph-sshare_social_counter span')
                .css( 'color', appearance_data.widget_counter_text );
            
            // widget icon bg color and icon color for each icon_style
            if ( appearance_data.customize_widget_colors == '1' ) {
                
                if ( appearance_data.icon_style == 'one' ) {
                    $widget_preview_box.find('a').css( 'background', appearance_data.widget_icon_bg_color );
                    $widget_preview_box.find('.wph-social-path .wph-social-icon').css( 'fill', appearance_data.widget_icon_color );
                } 
                
                if ( appearance_data.icon_style == 'two' ) {
                    $widget_preview_box.find('.wph-social').css( 'border-color', appearance_data.widget_icon_bg_color );
                    $widget_preview_box.find('.wph-social .wph-social-icon').css( 'fill', appearance_data.widget_icon_color );
                }
                
                if ( appearance_data.icon_style == 'three' || appearance_data.icon_style == 'four' ) {
                    $widget_preview_box.find('.wph-social').css( 'background', appearance_data.widget_icon_bg_color );
                    $widget_preview_box.find('.wph-social .wph-social-icon').css( 'fill', appearance_data.widget_icon_color );
                }
                
            }
            
            // widget_drop_shadow
            if ( appearance_data.widget_drop_shadow == '1' ) {
                var widget_box_shadow = '' + 
                    appearance_data.widget_drop_shadow_x + 'px ' +
                    appearance_data.widget_drop_shadow_y + 'px ' +
                    appearance_data.widget_drop_shadow_blur + 'px ' +
                    appearance_data.widget_drop_shadow_spread + 'px ' +
                    appearance_data.widget_drop_shadow_color;
                
                $widget_preview_box.css( 'box-shadow', widget_box_shadow );
            }
        },
        toggle_accordion: function(e) {
            e.preventDefault();
            var $this = $(e.target),
                $all = $('.wph-toggletabs'),
                $togglable = $this.closest('.wph-toggletabs'),
                $others = $all.not( $togglable ),
                $caret = $togglable.find('.dev-icon-caret_down, .dev-icon-caret_up');

            $others.removeClass('wph-toggletabs--open');
            $others.find('.dev-icon-caret_up')
                .removeClass('dev-icon-caret_up')
                .addClass('dev-icon-caret_down');

            $togglable.toggleClass('wph-toggletabs--open wph-toggletabs--closed');
            $caret.toggleClass('dev-icon-caret_down dev-icon-caret_up');

        },
        toggle_service_type: function(e){
            e.preventDefault();
            
            Optin.hasChanges = true;
            
            var $this = this.$(e.target);
            
            if ( $this.closest('li').hasClass('current')  ) return;
            
            this.model.set( 'service_type', $(e.target).find('input').val() );
        },
        toggle_icon: function(e) {
            var $this = this.$(e.target),
                is_checked = $this.is(':checked'),
                service_type = this.services_view.model.get('service_type'),
                $parent_container = $this.parents('.wph-sshare--social_' + service_type );
                
            if( is_checked ) {
                $parent_container.find('.disabled').removeClass('disabled');
            } else {
                $parent_container.find('.wph-sshare--icon').addClass('disabled');
                if ( service_type == 'native' ) {
                    $parent_container.find('.wph-input--number').addClass('disabled');
                } else {
                    $parent_container.find('.wph-sshare--input_wrap').addClass('disabled');
                }
            }
            
            // this._set_social_icons();
            // trigger changes on Appearance view to reflect changes on selected icons
            this.appearance_view_changes();
            
        },
        icons_order_updated: _.debounce(
            function() {
                // this._set_social_icons();
                this.appearance_view_changes();
            }, 
            500
        ),
        icon_counter_updated: _.debounce(
            function() {
                // this._set_social_icons();
                this.appearance_view_changes();
            }, 
            500
        ),
        icon_link_updated: function(e) {
            this._set_social_icons();
        },
        toggle_icon_style: function(e) {
            e.preventDefault();
            var $this = this.$(e.target);
            
            if ( $this.closest('li').hasClass('current')  ) return;
                
            this.appearance_view.model.set('icon_style', $this.val(), {silent:true});
            this.appearance_view.render();
            this.render_appearance_view();
        },
        toggle_floating_custom_color: function(e) {
            e.preventDefault();
            var $this = this.$(e.target),
                $li = $this.closest('li'),
                $input = $li.find('input');
            
            if ( $li.hasClass('current')  ) return;
            
            $li.addClass('current');
            $li.siblings().removeClass('current');
            this.appearance_view.model.set( 'customize_colors', $input.val() );
            
        },
        toggle_widget_custom_color: function(e) {
            e.preventDefault();
            var $this = this.$(e.target),
                $li = $this.closest('li'),
                $input = $li.find('input');
            
            if ( $li.hasClass('current')  ) return;
            
            $li.addClass('current');
            $li.siblings().removeClass('current');
            this.appearance_view.model.set( 'customize_widget_colors', $input.val() );
            
        },
        toggle_location_type: function(e) {
            e.preventDefault();
            var $this = this.$(e.target),
                $li = $this.closest('li'),
                $input = $li.find('input'),
                $selector_info = this.$('.wph-sshare--selector');
            
            if ( $li.hasClass('current')  ) return;
            
            $li.addClass('current');
            $li.siblings().removeClass('current');
            this.floating_view.model.set( 'location_type', $input.val() );
            
            if ( $input.val() == 'selector' ) {
                $selector_info.removeClass('hidden');
            } else {
                if ( !$selector_info.hasClass('hidden') ) $selector_info.addClass('hidden');
            }
            
        },
        toggle_location_align: function(e) {
            e.preventDefault();
            var $this = this.$(e.target),
                $li = $this.closest('li'),
                $input = $li.find('input'),
                $additional_settings = this.$('.wph-sshare--offset_' + $input.val() ),
                data_field = $input.data('attribute');
            
            if ( $li.hasClass('current')  ) return;
            
            $li.addClass('current');
            $li.siblings().removeClass('current');
            this.floating_view.model.set( data_field, $input.val() );
            
            $additional_settings.removeClass('hidden');
            $additional_settings.siblings('[class^="wph-sshare--offset_"]').each( function() {
                if ( !$(this).hasClass('hidden') ) $(this).addClass('hidden');
            });
        },
        ss_save: function(e) {
            e.preventDefault();
            
            if ( !this.validate() ) return;
            
            var me = this,
                $this = this.$(e.target).closest('button'),
                ss_id = $this.data('id'),
                $buttons = $this.parents('.row').find('button.wph-button'),
                services = this.services_view.model.toJSON(),
                appearance = this.appearance_view.model.toJSON(),
                floating_social = this.floating_view.model.toJSON(),
                shortcode_id = this._get_shortcode_id();
            
            $this.addClass('wph-button-save--loading');
            
            // disable all buttons
            $buttons.each( function() {
                $(this).attr('disabled', true);
            } );
            
            services = this._get_social_icons_data(services);
            
            // saving the SS module
            return $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'hustle_social_sharing_save',
                    _ajax_nonce: $this.data('nonce'),
                    id: $this.data('id'),
                    services: services,
                    appearance: appearance,
                    floating_social: floating_social,
                    shortcode_id: shortcode_id
                },
                complete: function(resp) {
                    var response = resp.responseJSON,
                        $save_buttons = me.$('button.wph-button[data-id="'+ ss_id +'"]');
                    
                    $this.removeClass('wph-button-save--loading');
                    // enable back the buttons
                    $buttons.each( function(){
                        $(this).attr('disabled', false);
                    } );
                    
                    Optin.hasChanges = false;
                    
                    if ( ss_id == -1 ) {
                        // update all data-id on buttons
                        $save_buttons.attr( 'data-id', response.data );
                        // update url
                        var currUrl = window.location.pathname + window.location.search;
                        currUrl = currUrl.replace('id=-1', 'id=' + response.data);
                        window.history.replaceState( {} , '', currUrl );
                    }
                }
            });
        },
        ss_cancel: function(e) {
            e.preventDefault();
            window.onbeforeunload = null;
            window.location.replace( '?page=inc_hustle_social_sharing' );
            return;
        },
        ss_next_step: function(e) {
            e.preventDefault();
            if ( !this.validate() ) return;
            
            var me = this,
                $next_tab = this.$('.wph-toggletabs.wph-toggletabs--open ~ .wph-toggletabs').first();
                
            this.ss_save(e).done( function(resp){
                if ( resp.success ) {
                    $next_tab.find('.can-open span').click();
                }
            } );
        },
        ss_back: function(e) {
            e.preventDefault();
            var $prev_tab = this.$('.wph-toggletabs.wph-toggletabs--open').prevAll('.wph-toggletabs').first();
            $prev_tab.find('.can-open span').click();
        },
        ss_finish: function(e) {
            e.preventDefault();
            if ( !this.validate() ) return;
            
            var me = this,
                $this = this.$(e.target),
                is_new = ( parseInt($this.data('id')) ) == -1 ? true : false;
            
            this.ss_save(e).done( function(resp){
                if ( resp.success ) {
                    window.onbeforeunload = null;
                    var url = "?page=inc_hustle_social_sharing";
                    if( is_new ) {
                        url += "&new_id=" + resp.data;
                    } else{
                        url += "&updated_id=" + resp.data;
                    }
                    window.location.replace( url );
                }
            } );
        },
        validate: function() {
            var success = true,
                $opt_name = this.$('[data-attribute="optin_name"]'),
                opt_name_placeholder = $opt_name.attr('placeholder');
            
            // validating opt_name
            if ( !$opt_name.val() ) {
                success = false;
                if ( $opt_name.siblings('span.wph-icon.i-warning').length === 0 ) {
                    var $warning = $('<span class="wph-icon i-warning" title="'+ opt_name_placeholder +'"></span>');
                    $warning.insertBefore($opt_name);
                }
                $opt_name.focus();
            }
            
            if ( success ) {
                $('span.dashicons.dashicons-warning').remove();
            }
            
            return success;
        },
        _set_social_icons: function() {
            Optin.hasChanges = true;
            var services = this.services_view.model.toJSON();
            services = this._get_social_icons_data(services);
            this.services_view.model.set( 'social_icons', services.social_icons, {silent:true} );
            window.services_model = this.services_view.model;
        },
        _get_social_icons_data: function( services ) {
            
            var $social_containers = this.$( '.wph-sshare--social_' + services['service_type'] ),
                social_icons = {};
            
            $social_containers.each( function() {
                var $sc = $(this),
                    $toggle_input = $sc.find('span.toggle input'),
                    icon = $sc.find('.wph-sshare--icon').data('id'),
                    $counter = $sc.find('.wph-input--number input'),
                    $link = $sc.find('.wph-sshare--input_wrap input');
                    
                    // check if counter have negative values
                    var counter_val = parseInt($counter.val());
                    if ( counter_val < 0 ) {
                        $counter.val(0);
                    }
                    
                    if ( $toggle_input.is(':checked') ) {
                        social_icons[icon] = {
                            'enabled': true,
                            'counter': ( $counter.length ) ? $counter.val() : '0',
                            'link': ( $link.length ) ? $link.val() : ''
                        };
                    }
                
            } );
            
            services['social_icons'] = social_icons;
            
            return services;
        },
        _get_shortcode_id: function() {
            return this.model.get('optin_name').trim().toLowerCase().replace(/\s+/g, '-');
        }
    });

});