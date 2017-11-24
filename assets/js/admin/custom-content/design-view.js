Hustle.define("Custom_Content.Design_View", function($, doc, win){
    "use strict";
    return Hustle.View.extend( _.extend({}, Hustle.get("Mixins.Model_Updater"), {
        template: Optin.template("wpoi-custom-content-design-tpl"),
        media_frame: false,
        css_editor: false,
        /* stylables: {
            ".wph-modal.wph-modal-container .wph-modal--content, .wph-cc-shortcode .wph-cc-shortcode--content ": "Container",
            ".wph-modal.wph-modal-container.wph-customize-css h2.wph-modal--title, .wph-cc-shortcode h2.wph-cc-shortcode--title ": "Title",
            ".wph-modal.wph-modal-container.wph-customize-css .wph-modal--content h4.wph-modal--subtitle, .wph-cc-shortcode h4.wph-cc-shortcode--subtitle ": "Subtitle",
            ".wph-modal .wph-modal--content .wph-modal--message , .wph-cc-shortcode .wph-cc-shortcode--content .wph-cc-shortcode--message ": "Content",
            ".wph-modal .wph-modal--content .wph-modal--image, .wph-cc-shortcode .wph-cc-shortcode--content .wph-cc-shortcode--image ": "Image Container",
            ".wph-modal.wph-modal-container.wph-customize-css .wph-modal--content .wph-modal--image img, .wph-cc-shortcode .wph-cc-shortcode--content .wph-cc-shortcode--image img ": "Image",
            ".wph-modal .wph-modal--cta, .wph-cc-shortcode .wph-cc-shortcode--cta ": "CTA Button",
            ".wph-modal .wph-modal-never-see-again ": "Never See Again"
        }, */
        stylables: {
            ".wph-modal.wph-modal-container .wph-modal--content ": "Container",
            ".wph-modal.wph-modal-container.wph-customize-css h2.wph-modal--title ": "Title",
            ".wph-modal.wph-modal-container.wph-customize-css .wph-modal--content h4.wph-modal--subtitle ": "Subtitle",
            ".wph-modal .wph-modal--content .wph-modal--message ": "Content",
            ".wph-modal .wph-modal--content .wph-modal--image ": "Image Container",
            ".wph-modal.wph-modal-container.wph-customize-css .wph-modal--content .wph-modal--image img ": "Image",
            ".wph-modal .wph-modal--cta ": "CTA Button",
            ".wph-modal .wph-modal-never-see-again ": "Never See Again"
        },
        stylable_elements: _({
            main_bg_color: ".wph-modal.wph-modal--cabriolet section, .wph-modal.wph-modal--simple .wph-modal--content, .wph-modal.wph-modal--minimal .wph-modal--content",
            title_color: ".wph-modal.wph-modal--cabriolet .wph-modal--content h2.wph-modal--title, .wph-modal.wph-modal--simple .wph-modal--content header h2.wph-modal--title, .wph-modal.wph-modal--minimal .wph-modal--content h2.wph-modal--title",
            subtitle_color: ".wph-modal.wph-modal--cabriolet .wph-modal--content h4.wph-modal--subtitle, .wph-modal.wph-modal--simple .wph-modal--content header h4.wph-modal--subtitle, .wph-modal.wph-modal--minimal .wph-modal--content header h4.wph-modal--subtitle",
            link_static_color: ".wph-modal .wph-modal--message a, .wph-modal.wph-modal--cabriolet .wph-modal--content .wph-modal--message a:not(.wph-modal--cta), .wph-modal.wph-modal--simple .wph-modal--content .wph-modal--message a:not(.wph-modal--cta), .wph-modal.wph-modal--minimal .wph-modal--content .wph-modal--message a:not(.wph-modal--cta)",
            link_hover_color: ".wph-modal .wph-modal--message a:hover, .wph-modal.wph-modal--cabriolet section .wph-modal--message a:not(.wph-modal--cta):hover, .wph-modal.wph-modal--simple .wph-modal--content .wph-modal--message a:not(.wph-modal--cta):hover, .wph-modal.wph-modal--minimal .wph-modal--content a:not(.wph-modal--cta):hover",
            link_active_color: ".wph-modal .wph-modal--message a:active, .wph-modal.wph-modal--cabriolet section .wph-modal--message a:not(.wph-modal--cta):active, .wph-modal.wph-modal--simple .wph-modal--content .wph-modal--message a:not(.wph-modal--cta):active, .wph-modal.wph-modal--minimal .wph-modal--content a:not(.wph-modal--cta):active",
            cta_static_background: ".wph-modal .wph-modal--cta, .wph-modal .wph-modal--message a.wph-modal--cta",
            cta_hover_background: ".wph-modal .wph-modal--cta:hover, .wph-modal .wph-modal--message a.wph-modal--cta:hover",
            cta_active_background: ".wph-modal .wph-modal--cta:active, .wph-modal .wph-modal--message a.wph-modal--cta:active",
            cta_static_color: ".wph-modal .wph-modal--cta, .wph-modal .wph-modal--message a.wph-modal--cta",
            cta_hover_color: ".wph-modal .wph-modal--cta:hover, .wph-modal .wph-modal--message a.wph-modal--cta:hover",
            cta_active_color: ".wph-modal .wph-modal--cta:active, .wph-modal .wph-modal--message a.wph-modal--cta:active",
            border_static_color: ".wph-modal.wph-modal--cabriolet section, .wph-modal.wph-modal--simple .wph-modal--content, .wph-modal.wph-modal--minimal .wph-modal--content",
            //border_hover_color: ".wph-modal.wph-modal--cabriolet section:hover, .wph-modal.wph-modal--simple .wph-modal--content:hover, .wph-modal.wph-modal--minimal .wph-modal--content:hover",
            //border_active_color: ".wph-modal.wph-modal--cabriolet section:active, .wph-modal.wph-modal--simple .wph-modal--content:active, .wph-modal.wph-modal--minimal .wph-modal--content:active",
            border_radius: ".wph-modal.wph-modal--cabriolet section, .wph-modal.wph-modal--simple .wph-modal--content, .wph-modal.wph-modal--minimal .wph-modal--content",
            border_weight: ".wph-modal.wph-modal--cabriolet section, .wph-modal.wph-modal--simple .wph-modal--content, .wph-modal.wph-modal--minimal .wph-modal--content",
            border_type: ".wph-modal.wph-modal--cabriolet section, .wph-modal.wph-modal--simple .wph-modal--content, .wph-modal.wph-modal--minimal .wph-modal--content",
            drop_shadow_color: ".wph-modal.wph-modal--cabriolet section, .wph-modal.wph-modal--simple .wph-modal--content, .wph-modal.wph-modal--minimal .wph-modal--content",
            drop_shadow_x: ".wph-modal.wph-modal--cabriolet section, .wph-modal.wph-modal--simple .wph-modal--content, .wph-modal.wph-modal--minimal .wph-modal--content",
            drop_shadow_y: ".wph-modal.wph-modal--cabriolet section, .wph-modal.wph-modal--simple .wph-modal--content, .wph-modal.wph-modal--minimal .wph-modal--content",
            drop_shadow_blur: ".wph-modal.wph-modal--cabriolet section, .wph-modal.wph-modal--simple .wph-modal--content, .wph-modal.wph-modal--minimal .wph-modal--content",
            drop_shadow_spread: ".wph-modal.wph-modal--cabriolet section, .wph-modal.wph-modal--simple .wph-modal--content, .wph-modal.wph-modal--minimal .wph-modal--content",
            custom_height: ".wph-modal.wph-modal--popup, .wph-modal.wph-modal--popup .wph-modal--content",
            custom_width: ".wph-modal.wph-modal--popup, .wph-modal.wph-modal--popup .wph-modal--content"
        }),
        events: {
            "click .wph-stylable-element": "insert_stylable_element"
        },
        init: function(){
            this.on("rendered", this.create_color_pickers );
            this.listenTo(this.model, "change:customize_colors", this.render );
            this.listenTo(this.model, "change:customize_css", this.render );
            this.listenTo(this.model, "change:customize_size", this.render );
            this.listenTo(this.model, "change:border", this.render );
            this.listenTo(this.model, "change:drop_shadow", this.render );
            this.listenTo(this.model, "change:style", this.render );

            this.listenTo( this.model, "change", this.apply_styles );

            return this.render();
        },
        render: function(){
            this.$el.html(  this.template( _.extend( {}, this.model.toJSON(), {stylables: this.stylables } ) ) );
            this.apply_styles();
            this.create_css_editor();
            return this;
        },
        create_color_pickers: function(){
            this.$(".wph-color-picker").wpColorPicker({
                change: function(event, ui){
                    var $this = $(this);
                    $this.val( ui.color.toCSS()).trigger("change");
                }
            });
        },
        get_layout_colors: function(){
            if( _.isTrue( this.model.get("customize_colors") ) )
                return _(  this.model.toJSON() ).reduce(function( obj, value, attribute ){

                    if( _.indexOf( ["drop_shadow_color"], attribute ) !== -1 || /^border_/.test( attribute ) || /^drop_/.test(attribute) ) return obj; // excludes

                    if(  /_background$/.test( attribute ) || /_color$/.test( attribute )  || /_background_color$/.test( attribute ) )
                        obj[ attribute ] = value;
                    return obj;
                }, {} );

            return false;
        },
        apply_styles: _.debounce(function(){
            var self = this,
                data = this.model.toJSON(),
                colors = this.get_layout_colors(),
                styles = "",
                $styles_el = $("#hustle-css-preview-styles").length ? $("#hustle-css-preview-styles") : $('<style id="hustle-css-preview-styles">').appendTo("body");


            if( !_.isEmpty( colors ) ){
                _.each(colors, function(color, key){
                    var color_type = /_background$/.test( key ) || /_background_color$/.test( key ) || /_bg_color/.test( key ) ? 'background' : 'color',
                        selector = self.stylable_elements.result( key );

                    if( selector )
                        styles += ( selector + "{ " + color_type + ": " + color +";} " );
                });
            }

            /**
             * Apply border styles
             */
            if( _.isTrue( data.border ) ){
                var border_tpl = Hustle.create_template( " {{el}} {border:{{weight}}px {{type}} {{color}}; }" ),
                    border_radius_tpl = Hustle.create_template( " {{el}} {border-radius:{{radius}}px; }" ) ;
                _(['border_static_color']).each(function(key, i){
                    styles += border_tpl({
                        el: this.stylable_elements.result( key ),
                        weight: data.border_weight,
                        type: data.border_type,
                        color: data[ key ]
                    });
                }.bind(this) );

                /**
                 * Apply border radius style
                 */
                styles += border_radius_tpl( {
                    el: this.stylable_elements.result( "border_radius" ),
                    radius: data.border_radius
                } );

            }


            /***
             * Apply dropshadow styles
             */
            if( _.isTrue( data.drop_shadow ) ){
                var drop_shadow_tpl = Hustle.create_template( " {{el}} {box-shadow:{{x}}px {{y}}px {{blur}}px {{spread}}px {{color}}; }" );

                styles += drop_shadow_tpl( {
                    el: this.stylable_elements.result( "drop_shadow_color" ),
                    x: data.drop_shadow_x,
                    y: data.drop_shadow_y,
                    blur: data.drop_shadow_blur,
                    spread: data.drop_shadow_spread,
                    color: data.drop_shadow_color
                } );
            }

            /**
             * Apply custom size is being applied now on "custom_content/view.js"
             */
            /* if( _.isTrue( data.customize_size ) ){
                var custom_size_tpl = Hustle.create_template( " {{el}} {width: {{width}}px; height: {{height}}px; }" );

                styles += custom_size_tpl({
                   el: this.stylable_elements.result( "custom_height" ),
                   height: data.custom_height,
                   width: data.custom_width
                });
            } */

            if( _.isTrue( data.customize_css ) )
                styles += data.custom_css;

            $styles_el.html( styles );
        }, 10),
        create_css_editor: _.debounce(function(){
            if( _.isFalse( this.model.get("customize_css") ) ) return;

            this.css_editor = ace.edit("hustle_custom_css");

            this.css_editor.getSession().setMode("ace/mode/css");
            this.css_editor.setTheme("ace/theme/solarized_light");
            this.css_editor.getSession().setUseWrapMode(true);
            this.css_editor.getSession().setUseWorker(false);
            this.css_editor.setShowPrintMargin(false);
            this.css_editor.renderer.setShowGutter(true);
            this.css_editor.setHighlightActiveLine(true);
            this.css_editor.on("blur", $.proxy(this.update_custom_css, this));

        }, 0),
        update_custom_css: function(){
            if( this.css_editor )
                this.model.set("custom_css", this.css_editor.getValue() );
        },
        insert_stylable_element: function(e){
            e.preventDefault();
            var $el = $(e.target),
                stylable = $el.data("stylable") + "{}";

            this.css_editor.navigateFileEnd();
            this.css_editor.insert(stylable);
            this.css_editor.navigateLeft(1);
            this.css_editor.focus();

        }
    }));

});