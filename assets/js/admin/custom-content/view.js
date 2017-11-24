Hustle.define("Custom_Content.View", function($, doc, win){
    "use strict";

    return Hustle.View.extend({
        el: ".wph-custom-content",
        message_box_tpl: Optin.template("wpoi-custom-content-message-box-tp"),
        preview: false,
        preview_model: false,
        initial_data: new Backbone.Model({
            content: "",
            design: "",
            popup: "",
            slide_in: "",
            magic_bar: ""
        }),
        events: {
            "click .wph-toggletabs .can-open": "toggle_accordion",
            "click #save-and-next": "save_and_next",
            "click #next-step": "save_and_next",
            "click #save-and-finish": "save_and_finish",
            "click #finish-setup" : "save_and_finish",
            "click .wph-preview--eye.wph-button": "open_preview",
            "click .wph-js-cancel-design-changes" : "cancel_changes",
            "click .wph-js-back" : "go_back",
            "click .wph-triggers--options label": "handle_triggers",
            "click button#optin_message-tmce": "tinyMCE_toggled",
            "change textarea#optin_message": "text_area_update",
			"keyup [data-attribute='optin_name']": "remove_error"

        },
        init: function( opts ){
            this.content_view = opts.content_view;
            this.design_view = opts.design_view;
            this.after_content_view = opts.after_content_view;
            this.popup_view = opts.popup_view;
            this.slide_in = opts.slide_in;
            this.magic_bar = opts.magic_bar;


            this.update_initial_state();

            this.listenTo(this.model, "change", this.render_message_box );
            this.listenTo(this.content_view.model, "change", this.enable_cancel );
            this.listenTo(this.content_view.model, "change:content", this._set_preview_model );
            this.listenTo(Hustle.Events, "cc.type_changed", this.apply_proper_preview_styles );
            this.listenTo(this.design_view.model, "change", this.enable_cancel );

            this.render_message_box();
            return this.render();
        },
        tinyMCE_toggled: function(e){
            this.content_view.skip_tinyMCE_sync = false;
        },
        text_area_update: function(e){
            this.content_view.model.set('optin_message', $(e.target).val());
            this.content_view.model.set('content', $(e.target).val());
            this.content_view.skip_tinyMCE_sync = true;
        },
        handle_triggers: function(e){
            var $this = $(e.target),
                $selected_li = $this.closest('li'),
                $siblings = $selected_li.siblings()
                ;
            $siblings.removeClass('current');
            $selected_li.addClass('current');
        },
        update_initial_state: function(){
            _.extend( this.initial_data, {
                content: this.content_view.model.toJSON(),
                design: this.design_view.model.toJSON(),
                popup: this.popup_view.model.toJSON(),
                slide_in: this.slide_in.model.toJSON(),
                magic_bar: this.magic_bar.model.toJSON()
            } );

            //this.$(".wph-js-cancel-design-changes").attr("disabled", true);
        },
        enable_cancel: _.throttle(function(){
            //this.$(".wph-js-cancel-design-changes").attr("disabled", false);
        }, 50),
        render: function(){
            $(doc).on('click', '#hustle-legacy-popup-notice button.notice-dismiss', this.dismiss_legacy_popup_notice);

            this.content_view.delegateEvents();
            this.design_view.delegateEvents();
            this.$("#wph-ccontent--designtab .wph-toggletabs--content")
                .append( this.content_view.$el )
                .append( this.design_view.$el );

            var after_content_contaner_classes = this.$('#wph-ccontent-after-content-container').attr('class');
            this.$("#wph-ccontent-after-content-container").replaceWith( this.after_content_view.$el.addClass( after_content_contaner_classes ).attr("id", "wph-ccontent-after-content-container") );

            var popup_contaner_classes = this.$("#wph-ccontent-popup-container").attr("class");
            this.$("#wph-ccontent-popup-container").replaceWith( this.popup_view.$el.addClass( popup_contaner_classes ).attr("id", "wph-ccontent-popup-container") );

            var slide_in_contaner_classes = this.$("#wph-ccontent-slide_in-container").attr("class");
            this.$("#wph-ccontent-slide_in-container").replaceWith( this.slide_in.$el.addClass( slide_in_contaner_classes ).attr("id", "wph-ccontent-slide_in-container") );

            var magic_bar_container_classes = this.$("#wph-ccontent-magic_bar-container").attr("class");
            this.$("#wph-ccontent-magic_bar-container").replaceWith( this.magic_bar.$el.addClass( magic_bar_container_classes ).attr("id", "wph-ccontent-magic_bar-container") );

        },
        render_message_box: function(){
            var shortcode_id = this._get_shortcode_id();
            this.$("#wph-ccontent--messagebox").html( this.message_box_tpl( {shortcode_id: shortcode_id } ) );
        },
        toggle_accordion: function(e){
            e.preventDefault();
            var $this = $(e.target),
                $all = $(".wph-toggletabs"),
                $togglable = $this.closest(".wph-toggletabs"),
                $others = $all.not( $togglable ),
                $caret = $togglable.find(".dev-icon-caret_down, .dev-icon-caret_up");

            $others.removeClass("wph-toggletabs--open");
            $others.find(".dev-icon-caret_up")
                .removeClass("dev-icon-caret_up")
                .addClass("dev-icon-caret_down");

            $togglable.toggleClass("wph-toggletabs--open wph-toggletabs--closed");
            $caret.toggleClass("dev-icon-caret_down dev-icon-caret_up");

        },
        _get_shortcode_id: function(){
            return this.model.get("optin_name").trim().toLowerCase().replace(/\s+/g, "-");
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
        _save: function( $btn ){
            var  button_width = ( $btn.next().hasClass('wph-button-finish') ) ? $btn.outerWidth() + 1 : $btn.outerWidth();
            var id = $btn.data("id");
            return $.ajax({
                url: ajaxurl,
                type: "POST",
                data: {
                    action: "hustle_custom_content_save",
                    _ajax_nonce: $btn.data("nonce"),
                    id: $btn.data("id"),
                    content: this.content_view.model.toJSON(),
                    design: this.design_view.model.toJSON(),
                    after_content: this.after_content_view.model.toJSON(),
                    popup: this.popup_view.model.toJSON(),
                    slide_in: this.slide_in.model.toJSON(),
                    magic_bar: this.magic_bar.model.toJSON(),
                    shortcode_id: this._get_shortcode_id()
                },
                complete: function(d){
                    $btn.attr( "disabled", false )
                        .removeClass( "wph-button-next--loading" )
                        .removeClass( "wph-button-save--loading" );

                    Optin.hasChanges = false;
                    if(id == -1){
                        var currUrl = window.location.pathname + window.location.search;
                        currUrl = currUrl.replace('id=-1', 'id=' + d.responseJSON.data);
                        window.history.replaceState( {} , '', currUrl );
                    }

                }
            });
        },
        save_and_next: function(e){
            e.preventDefault();
            Hustle.Events.trigger("CC.save_changes");

            if ( !this.validate() ) return;

            var self = this,
                $this = this.$(e.target).closest("button");
            // $spinner = $("<span class='spinner-container'><span class='button-spinner'></span></span>"),
            // button_width = $this.outerWidth();

            // $this.append( $spinner )
            // .animate( { width: button_width + ( button_width * 0.2 ) })
            // .attr("disabled", true);

            $this.attr("disabled", true);
            if ( $this.is("#save-and-next") ) {
                $this.addClass("wph-button-save--loading");
            } else {
                $this.addClass("wph-button-next--loading");
            }

            // disable sibling too
            $this.siblings().each(function(){
                $(this).attr("disabled", true);
            });

            this._save( $this ).done( function(res){
                if( res.success ){
                    self.$("#next-step").data("id", res.data );
                    self.$("#save-and-next").data("id", res.data );
                    self.$("#save-and-finish").data("id", res.data );
                    self.$("#finish-setup").data("id", res.data );
                    self.update_initial_state();
                    if ( $this.is("#next-step") ) self.next_step(e);
                    // enable sibling too
                    _.delay(function() {
                        $this.siblings().each(function(){
                            $(this).attr("disabled", false);
                        });
                    }, 300);
                }
                Optin.hasChanges = false;
            });


        },
        next_step: function(e){
            e.preventDefault();
            this.$("#wph-ccontent--settingstab .wph-toggletabs--title.can-open span").click();
        },
        save_and_finish: function(e){
            Hustle.Events.trigger("CC.save_changes");
            e.preventDefault();

            if ( !this.validate() ) return;

            var self = this,
                $this = this.$(e.target).closest("button"),
                is_new = parseInt($this.data("id")) == -1 ? true: false;

            $this.attr("disabled", true);
            if ( $this.is("#save-and-finish") ) {
                $this.addClass("wph-button-save--loading");
            } else {
                $this.addClass("wph-button-next--loading");
            }

            // disable sibling too
            $this.siblings().each(function(){
                $(this).attr("disabled", true);
            });

            this._save( $this ).done( function(res){
                if( res.success ) {
                    self.$("#next-step").data("id", res.data );
                    self.$("#save-and-next").data("id", res.data );
                    self.$("#save-and-finish").data("id", res.data );
                    self.$("#finish-setup").data("id", res.data );
                    if ( $this.is("#finish-setup") ) self.finish_setup($this);
                    // enable sibling too
                    _.delay(function() {
                        $this.siblings().each(function(){
                            $(this).attr("disabled", false);
                        });
                    }, 300);
                }
                Optin.hasChanges = false;
            });
        },
        finish_setup: function($this){
            var self = this,
                is_new = parseInt($this.data("id")) == -1 ? true: false;
                
            window.onbeforeunload = null;
            var url = "?page=inc_hustle_custom_content";
            if( is_new ) {
                url += "&new_id=" + $this.data("id");
            } else{
                url += "&updated_id=" + $this.data("id");
            }
            window.location.replace( url );
        },
		remove_error: function() {
			this.$('.dashicons-warning').remove();
		},
        validate: function() {
            // Validating cta_url
            var success = true,
                cta_url = this.design_view.model.get("cta_url"),
                opt_name = this.$( '[data-attribute="optin_name"]' ),
				$error_icon;

            if ( ! opt_name.val() ){
                $error_icon = $('<span class="dashicons dashicons-warning">').attr('title', optin_vars.messages.custom_content.no_name);
				opt_name.after($error_icon);
                success = false;
            }

            // do not validate url for now
            // if ( cta_url ) {
            // var elm = document.createElement('input'),
            // $icon = $('<span class="dashicons dashicons-warning"></span>'),
            // $cta_url_input = this.design_view.$el.find('[data-attribute="cta_url"]')
            // ;
            // elm.setAttribute('type', 'url');
            // elm.value = cta_url;
            // if ( !elm.validity.valid ) {
            // if ( $cta_url_input.next().length == 0 ) {
            // $icon.attr('title', optin_vars.messages.custom_content.errors.cta_url);
            // $cta_url_input.after($icon);
            // }
            // success = false;
            // }
            // }

            // remove error icons if all good
            if ( success ) {
                $('span.dashicons.dashicons-warning').remove();
            }

            return success;
        },
        _set_preview_model: function(){
            if( this.preview_model ){
                this.preview_model.set( _.extend(
                    {},
                    {
                        type: "popup"
                    },
                    this.design_view.model.toJSON(),
                    this.content_view.model.toJSON(),
                    {
                        optin_message: this.content_view.model.get("content")
                    },
                    {
                        types: {
                            popup: this.popup_view.model.toJSON(),
                            slide_in: this.slide_in.model.toJSON(),
                            after_content: this.after_content_view.model.toJSON()
                        }
                    }
                ));
                return;
            }
            this.preview_model = new Backbone.Model( _.extend(
                {},
                {
                    id: this.content_view.model.get("optin_id"),
                    type: "popup"
                },
                this.design_view.model.toJSON(),
                this.content_view.model.toJSON(),
                {
                    optin_message: this.content_view.model.get("content")
                },
                {
                    types: {
                        popup: this.popup_view.model.toJSON(),
                        slide_in: this.slide_in.model.toJSON(),
                        after_content: this.after_content_view.model.toJSON()
                    }
                }
                )
            );
        },
        open_preview: function(e){
            Hustle.Events.trigger("CC.opening_preview");

            if ( !this.validate() ) return;

            this._set_preview_model();

            if( this.preview ){
                this.preview.render();
                this.preview.show();
            } else {
                var Preview = Hustle.get("Custom_Content.Preview");
                this.preview = new Preview({model: this.preview_model });
                this.preview.show();
            }
            
            this.apply_custom_css();

            // TODO: improve this later by fixing the race issue but for now let's use timeout
            // let's wait for the whole model to be updated
            var me = this;
            setTimeout( function(){
                me.apply_proper_preview_styles();
            }, 500);

        },
        cancel_changes: function(e){
            window.onbeforeunload = null;
            window.location.replace( "?page=inc_hustle_custom_content" );
            return;
            // this.content_view.model.set( this.initial_data.content );
            // this.design_view.model.set( this.initial_data.design );

            // this.content_view.render();
            // this.design_view.render();

            // this.$(e.target).attr("disabled", true);
        },
        go_back: function(e){
            this.$("#wph-ccontent--designtab .wph-toggletabs--title.can-open span").click();
        },
        apply_proper_preview_styles: function () {
            var self = this;
            $(".wph-modal").each(function(){
                var $this = $(this),
                    $content = $this.find(".wph-modal--content"),
                    $section = $this.find(".wph-modal--content > section"),
                    $figure = $content.find("section > figure"),
                    $figtwo = $this.find(".wph-modal--content > figure"),
                    $image = $figure.find("img"),
                    $imgtwo = $figtwo.find("img");

                var $cabriolet = $this.hasClass("wph-modal--cabriolet") && ( $figure.hasClass("wph-modal--image_full") || ( $figure.hasClass("wph-modal--image") && ( $image.height() < $figure.height() ) ) );

                var $simple = $this.hasClass("wph-modal--simple") && ( $figtwo.hasClass("wph-modal--image_full") || ( $figtwo.hasClass("wph-modal--image") && ( $imgtwo.height() < $figtwo.height() ) ) );

                var $minimal = $this.hasClass("wph-modal--minimal") && ( $figure.hasClass("wph-modal--image_full") || ( $figure.hasClass("wph-modal--image") && ( $image.height() < $figure.height() ) ) );

                if ( $cabriolet || $minimal ){
                    $image.css({
                        "height" : $section.height() + 'px',
                        "width" : $section.width() + 'px'
                    });
                }

                if ( $simple ){
                    $imgtwo.css({
                        "height" : $content.height() + 'px',
                        "width" : $content.width() + 'px'
                    });
                }

                // apply styles for custom size
                var design_model_data = self.design_view.model.toJSON(),
                    $header = $this.find(".wph-modal--content header"),
                    $footer = $this.find(".wph-modal--content footer"),
                    $modal_content = $this.find(".wph-modal--content"),
                    $modal_message = $this.find(".wph-modal--content .wph-modal--message"),
                    $modal_message_section = $this.find(".wph-modal--content section"),
                    $modal_image = $this.find(".wph-modal--content .wph-modal--image"),
                    $modal_img = $this.find(".wph-modal--content .wph-modal--image img"),
                    custom_width = parseInt(design_model_data.custom_width),
                    custom_height = parseInt(design_model_data.custom_height),
                    border_weight = ( _.isTrue( design_model_data.border ) )
                        ? parseInt(design_model_data.border_weight) * 2
                        : 0;
                if ( _.isTrue( design_model_data.customize_size ) ) {
                    $this.css('width', custom_width + 'px');
                    $this.css('max-width', 'none');
                    if ( $this.hasClass("wph-modal--cabriolet") ) {
                        $modal_message.outerHeight( custom_height - ( $header.outerHeight(true) ) - border_weight );
                        $modal_image.outerHeight( $modal_message.outerHeight(true) );
                        $modal_img.outerHeight( $modal_message.outerHeight(true) );
                    }
                    if ( $this.hasClass("wph-modal--simple") ) {
                        $modal_content.outerHeight( custom_height );
                        $modal_image.outerHeight( $modal_content.height() );
                        $modal_img.outerHeight( $modal_content.height() );
                    }
                    if ( $this.hasClass("wph-modal--minimal") ) {
                        $modal_message_section.outerHeight( custom_height - ( $header.outerHeight(true) + $footer.outerHeight(true) ) - border_weight );
                        $modal_image.outerHeight( $modal_message_section.outerHeight(true) );
                        $modal_img.outerHeight( $modal_message_section.outerHeight(true) );
                    }
                }
            });
        },
        apply_custom_css: function() {
            if ( !this.design_view.css_editor ) {
                return;
            }
            var $styles_el = $("#hustle-cc-custom-styles").length ? $("#hustle-cc-custom-styles") : $('<style id="hustle-cc-custom-styles">').appendTo("body"),
                css_string = this.design_view.css_editor.getValue();

            $.ajax({
                type: "POST",
                url: ajaxurl,
                dataType: "json",
                data: {
                    action: 'hustle_CC_prepare_custom_css',
                    css: css_string,
                    _ajax_nonce: $("#hustle_custom_css").data("nonce")
                },
                success: function(res){
                    if( res && res.success ){
                        $styles_el.html( res.data  );
                    }
                },
                error: function() {
                    
                }
            });
        }
    });

});