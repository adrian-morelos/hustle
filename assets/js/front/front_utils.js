var Optin = Optin || {};
(function( $, doc ) {
    "use strict";
    $.each(['show', 'hide'], function (i, ev) {
        var el = $.fn[ev];
        $.fn[ev] = function () {
            this.trigger(ev);
            return el.apply(this, arguments);
        };
    });
    
    Optin.popup_overlay_delay = 750;


    /**
     * Set optin id from the html template
     */
    Optin.get_tpl = function( layout_id, is_compat ){
        var templates = ["optin-layout-one", "optin-layout-two", "optin-layout-three", "optin-layout-four"];
        return ( is_compat ) 
            ? Optin.template_compat( templates[ layout_id ] )
            : Optin.template( templates[ layout_id ] );
    };

    Optin.popup = {
        shown:[],
        hidden:[],
        long_hidden: [],
        is_already_shown: function( popup_id ){
            return -1 !== this.shown.indexOf( popup_id );
        },
        is_long_hidden: function(optin_obj){
            return !!Optin.cookie.get( Optin.POPUP_COOKIE_PREFIX + optin_obj.id );
        },
        show: function( optin_obj ){

            if( this.is_long_hidden( optin_obj ) )
                return false;

            if( !this.is_already_shown( optin_obj.id )   )
                return optin_obj.show();

        }
    };

    // posts/pages bounce in animation
    var $animation_elements = $('.inc_opt_inline_wrap');
    var $window = $(window);

    function check_if_in_view() {
        var window_height = $window.height();
        var window_top_position = $window.scrollTop();
        var window_bottom_position = (window_top_position + window_height);

        $.each($animation_elements, function() {
            var $element = $(this);
            var element_height = $element.outerHeight();
            var element_top_position = $element.offset().top;
            var element_bottom_position = (element_top_position + element_height);

            //check to see if this current container is within viewport
            if ((element_bottom_position >= window_top_position) &&
                (element_top_position <= window_bottom_position)) {
                $element.addClass('in-view');
            } else {
                $element.removeClass('in-view');
            }
        });
    }

    function add_proper_classes(e, type, $popup, data){
        
        // relocate mailchimp submit button if no groups
        if ( typeof data !== 'undefined' && typeof data.data !== 'undefined' && data.data.optin_provider === 'mailchimp' ) {
            relocate_mailchimp_button(data);
        }
        
        if( ( e.type === "wpoi:display" || e.type === "wpoi:cc_display" ) && type === "popup" ){
            (function (){
                var $parent = type === "popup" ? $(window) : $(this),
                    $this = $popup.find(".wpoi-hustle");
                if ( $parent.width() <= 405){
                    $this.find(".wpoi-optin").addClass("wpoi-small");
                } else {
                    $this.find(".wpoi-optin").removeClass("wpoi-small");
                }

                if ( ( $parent.width() <= 585) && ($parent.width() > 405) ){
                    $this.find(".wpoi-optin").addClass("wpoi-medium");
                } else {
                    $this.find(".wpoi-optin").removeClass("wpoi-medium");
                }
            }());
        }else{
            $(".wpoi-hustle").each(function(){
                var $parent = type === "popup" ? $(window) : $(this),
                    $this = $(this);
                if ( $parent.width() <= 405){
                    $this.find(".wpoi-optin").addClass("wpoi-small");
                } else {
                    $this.find(".wpoi-optin").removeClass("wpoi-small");
                }

                if ( ( $parent.width() <= 585) && ($parent.width() > 405) ){
                    $this.find(".wpoi-optin").addClass("wpoi-medium");
                } else {
                    $this.find(".wpoi-optin").removeClass("wpoi-medium");
                }
            });
            
            // for CC widget & shortcode
            $(".wph-modal").each(function(){
                var $parent = $(this).parent(),
                    $this = $(this);
                
                if ( $parent.data('type') === 'widget' || $parent.data('type') === 'shortcode' ) {
                    if ( $parent.width() <= 405){
                        $this.addClass("wph-modal--small");
                    } else {
                        $this.removeClass("wph-modal--small");
                    }
                }
            });
        }

        $(".wpoi-mcg-select").each(function(){
	        $(this).parent(".wpoi-provider-args > .wpoi-container > .wpoi-element:nth-child(2) > .wpoi-container > .wpoi-element").css({"padding":"0","background":"transparent"});
        });
        
        // Layout #3
        // Set height of image container same to parent div
        // This to avoid Safari conflicts with [ height: 100% ]
        $(".wpoi-layout-three .wpoi-optin:not(.wpoi-small) .nocontent:not(.noimage)").each(function(){
	        var $this = $(this),
	        	$parent = $this.find(".wpoi-aside-x").prev(".wpoi-element"),
	        	$child = $this.find(".wpoi-aside-x").prev(".wpoi-element").find(".wpoi-container.wpoi-col");
	        $child.css("height", $parent.height());
        });
        
        // Layout #3
        // Vertical align content
        $(".wpoi-layout-three .wpoi-optin:not(.wpoi-small) > .wpoi-container.noimage:not(.nocontent)").each(function(){
	        var $this = $(this),
	        	$aside = $this.find(".wpoi-aside-x"),
	        	$div = $this.find(".wpoi-image").next(".wpoi-element"),
	        	$element = $aside.prev(".wpoi-element"),
	        	$content = $this.find(".wpoi-content"),
	        	$col = $element.find(".wpoi-col"),
	        	$form = $this.find("form");
	        
	        if ( $form.height() > $content.height() ){
		        $col.css("height", $aside.height() + 'px' );
		        $div.addClass("wpoi-align");
		        $content.addClass("wpoi-align-element");
	        }
	        if ( $form.height() < $content.height() ){
		        $aside.css("height", $element.height() + 'px');
		        $aside.addClass("wpoi-align");
		        $form.addClass("wpoi-align-element");
	        }
        });
        $(".wpoi-layout-three .wpoi-optin:not(.wpoi-small) > .wpoi-container:not(.noimage):not(.nocontent)").each(function(){
	        var $this = $(this),
	        	$sidebar = $this.find(".wpoi-aside-x"),
	        	$element = $sidebar.prev(".wpoi-element"),
	        	$form = $this.find("form");
	        
	        if ( $form.height() < $element.height() ){
		        $sidebar.css("height", $element.height());
		        $sidebar.addClass("wpoi-align");
		        $form.addClass("wpoi-align-element");
	        }
        });
        
        // Layout #3
        // Group module fields
        $(".wpoi-layout-three .wpoi-optin:not(.wpoi-small)").each(function(){
	        var $this = $(this),
	        	$elements = $this.find('form > .wpoi-element:not(.wpoi-provider-args,.wpoi-grouped-element)');
            $elements.addClass("wpoi-grouped-element");
            
            //The elements will be grouped a single time, it doesn't matter how many times this function is called
	        for (var i = 0; i < $elements.length; i+=2) {
		        $elements.slice(i, i+2).wrapAll('<div class="wpoi-element wpoi-grouped-element" style="background-color: transparent;"><div class="wpoi-container"></div></div>');
		    }
        });
        
        // Layout #4
        // Group module fields
        $(".wpoi-layout-four .wpoi-optin:not(.wpoi-small)").each(function(){
	        var $this = $(this),
	        	$elements = $this.find('form > .wpoi-element:not(.wpoi-provider-args,.wpoi-grouped-element)');
	        $elements.addClass("wpoi-grouped-element");

            //The elements will be grouped a single time, it doesn't matter how many times this function is called
	        for (var i = 0; i < $elements.length; i+=2) {
		        $elements.slice(i, i+2).wrapAll('<div class="wpoi-element wpoi-grouped-element" style="background-color: transparent;"><div class="wpoi-container"></div></div>');
		    }
        });
        
        // Layout #4
        // Vertical align content
        $(".wpoi-layout-four .wpoi-optin:not(.wpoi-small) > .wpoi-container.noimage:not(.nocontent)").each(function(){
	        var $this = $(this),
	        	$aside = $this.find(".wpoi-aside-xl"),
	        	$col = $this.find(".wpoi-aside-xl > .wpoi-container"),
	        	$parent = $aside.find(".wpoi-form"),
	        	$form = $aside.find("form"),
	        	$element = $aside.next(".wpoi-element"),
	        	$content = $element.find(".wpoi-content");
	        
	        if ( $content.height() > $form.height() ){
		        $col.css("height", $aside.height() + 'px');
		        $parent.addClass("wpoi-align");
		        $form.addClass("wpoi-align-element");
	        }
	        if ( $content.height() < $form.height() ) {
		        $element.css("height", $col.height() + 'px');
		        $element.addClass("wpoi-align");
		        $content.addClass("wpoi-align-element");
	        }
        });
        $(".wpoi-layout-four .wpoi-optin:not(.wpoi-small) > .wpoi-container:not(.noimage):not(.nocontent)").each(function(){
	        var $this = $(this),
	        	$aside = $this.find(".wpoi-aside-xl"),
	        	$col = $this.find(".wpoi-aside-xl > .wpoi-container"),
	        	$image = $this.find(".wpoi-image"),
	        	$parent = $aside.find(".wpoi-form"),
	        	$form = $aside.find("form"),
	        	$element = $aside.next(".wpoi-element"),
	        	$content = $this.find(".wpoi-content");
	        
	        if ( $content.height() > $col.height() ){
		        $col.css("height", $aside.height() + 'px');
		        $parent.css("height", $col.height() - $image.height() );
		        $parent.addClass("wpoi-align");
		        $form.addClass("wpoi-align-element");
	        }
	        if ( $content.height() < $col.height() ) {
		        $element.css("height", $aside.height() + 'px');
		        $element.addClass("wpoi-align");
		        $content.addClass("wpoi-align-element");
	        }
        });
        
        // Custom Content
        // Add proper width and height to img
        // parent div and make object-fit work
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
			var $header = $this.find(".wph-modal--content header"),
				$footer = $this.find(".wph-modal--content footer"),
				$modal_content = $this.find(".wph-modal--content"),
				$modal_message = $this.find(".wph-modal--content .wph-modal--message"),
				$modal_message_section = $this.find(".wph-modal--content section"),
				$modal_image = $this.find(".wph-modal--content .wph-modal--image"),
				$modal_img = $this.find(".wph-modal--content .wph-modal--image img"),
				custom_width = parseInt($this.data("custom_width")),
				custom_height = parseInt($this.data("custom_height")),
				border_weight = parseInt($this.data("border")) * 2
			;
			border_weight = ( isNaN(border_weight) ) 
				? 0
				: border_weight
			;
			if ( custom_width && custom_height ) {
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
		// Custom Content Shortcode
		// Add proper width and height to img
        // parent div and make object-fit work
        $(".wph-cc-shortcode").each(function(){
	        var $this = $(this),
                $content = $this.find(".wph-cc-shortcode--content"),
                $section = $this.find(".wph-cc-shortcode--content > section"),
                $figure = $content.find("section > figure"),
                $figtwo = $this.find(".wph-cc-shortcode--content > figure"),
                $image = $figure.find("img"),
                $imgtwo = $figtwo.find("img");
                
            var $cabriolet = $this.hasClass("wph-cc-shortcode--cabriolet") && ( $figure.hasClass("wph-cc-shortcode--image_full") || ( $figure.hasClass("wph-cc-shortcode--image") && ( $image.height() < $figure.height() ) ) );
                
            var $simple = $this.hasClass("wph-cc-shortcode--simple") && ( $figtwo.hasClass("wph-cc-shortcode--image_full") || ( $figtwo.hasClass("wph-cc-shortcode--image") && ( $imgtwo.height() < $figtwo.height() ) ) );
                
            var $minimal = $this.hasClass("wph-cc-shortcode--minimal") && ( $figure.hasClass("wph-cc-shortcode--image_full") || ( $figure.hasClass("wph-cc-shortcode--image") && ( $image.height() < $figure.height() ) ) );
                
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
		});
    }
    
    /**
    Relocate submit button if no mailchimp groups
    */
    function relocate_mailchimp_button( popup_data ) {
        if ( typeof popup_data.provider_args === 'undefined' || typeof popup_data.provider_args.group === 'undefined' ) {
            // relocate buttons
            $('.inc_optin_' + popup_data.data.optin_id + ' .wpoi-element .wpoi-button').each(function(){
                var $this = $(this),
                    $clone = $this.clone(),
                    $args_container = $this.closest('.wpoi-element.wpoi-provider-args'),
                    $mc_fields = $args_container.siblings('.wpoi-mcg-common-fields');
                    
                $mc_fields.find('.wpoi-container').append($clone);
                $args_container.remove();
                
            });
        }
    }

    $(doc).on("wpoi:display", _.debounce(add_proper_classes, 100, false));
    $(doc).on("wpoi:cc_display", _.debounce(add_proper_classes, 100, false));
    $(window).on("resize", _.debounce( add_proper_classes, 100, false ) );

    $window.on('scroll resize', _.debounce( check_if_in_view, 100, false ) );
    $window.trigger('scroll');
    
    $(document).on('blur', 'input, textarea, select', function(){
	    var $this = $(this);
	    if($this.is(':input[type=button], :input[type=submit], :input[type=reset]')) return;
	    if($this.val().trim() !== '') {
		    $this.parent().addClass('wpoi-filled');
		} else{
            $this.parent().removeClass('wpoi-filled');
        }
    });

    $(document).on('focus', '.wpoi-optin input.required', function(){
        $(this).next('label').find('i.wphi-font').removeClass('i-error');
    });

    /**
     * Renders provider args and returns html
     *
     *
     * @since 1.0.1
     *
     * @param optin_data
     * @return html
     */
    Optin.render_provider_args = function( optin_data ){
        if( _.isEmpty( optin_data.provider_args ) || _.isEmpty( optin_data.data.optin_provider ) ) return "";

        var provider_args_tpl = Optin.template( "optin-" + optin_data.data.optin_provider + "-args"  );
        optin_data.provider_args.cta_button = optin_data.design.cta_button;
        
        if ( $("#optin-" + optin_data.data.optin_provider + "-args" ).length ) {
            return provider_args_tpl( optin_data.provider_args );
        } else {
            return '';
        }
        
    };

    /**
     * Renders optin front layout based on give optin_data
     *
     * @param optin_data
     */
    Optin.render_optin = function( optin_data, use_compat ){            
        var is_compat = ( typeof use_compat !== 'undefined' && use_compat ) ? true : false,
            current_tpl_settings = _.templateSettings;
        
        // if needs compatibility e.g. upfront which uses another _.templateSettings
        if ( is_compat ) {
            Optin.global_mixin();
            // force our _.templateSettings setup
            _.templateSettings = {
                evaluate:    /<#([\s\S]+?)#>/g,
                interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
                escape:      /\{\{([^\}]+?)\}\}(?!\})/g
            };
        }
        
        var layout = parseInt(optin_data.design.form_location),
            tpl = Optin.get_tpl( layout, is_compat ),
            _show_args = function(){
                //Mailchimp might not always have groups
                if( "mailchimp" === optin_data.data.optin_provider
                    && optin_data.provider_args
                    && ( typeof optin_data.provider_args.group !== 'undefined' )
                )
                return true;

                return false;
            },
            html_data = _.extend({
                    image_style: "",
                    has_args: _show_args()
                }, 
                optin_data.design, 
                optin_data.design.borders, 
                optin_data.data
            ),
            html = tpl(html_data);
            
        // after getting the template, revert back to previous _.templateSettings
        if ( is_compat ) {
            _.templateSettings = current_tpl_settings;
        }

        $(doc).trigger("wpoi:layout:rendered");
        return html;
    };
	
	/**
     * Renders cc shortcode front layout based on given optin_data
     *
     * @param optin_data
     */
    Optin.render_cc_shortcode = function( optin_data, use_compat ){
        var is_compat = ( typeof use_compat !== 'undefined' && use_compat ) ? true : false,
            types = [],
            current_tpl_settings = _.templateSettings;
                
        types[optin_data.type] = {
            add_never_see_link: ''
        };
        
        // if needs compatibility e.g. upfront which uses another _.templateSettings
        if ( is_compat ) {
            Optin.global_mixin();
            // force our _.templateSettings setup
            _.templateSettings = {
                evaluate:    /<#([\s\S]+?)#>/g,
                interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
                escape:      /\{\{([^\}]+?)\}\}(?!\})/g
            };
        }
        
        var tpl = ( is_compat ) ? Optin.template_compat( 'hustle-modal-tpl' ) : Optin.template( 'hustle-modal-tpl' ),
			html = tpl( _.extend({
                type: optin_data.type,
                id: optin_data.content.optin_id,
                position: '',
                animation_in: '',
                fullscreen: '',
                types: types
            }, 
            optin_data.content, 
            optin_data.design,
            cc_handle_custom_size(optin_data.design)
            ) );
        
        // after getting the template, revert back to previous _.templateSettings
        if ( is_compat ) {
            _.templateSettings = current_tpl_settings;
        }

        $(doc).trigger("wpoi:layout:rendered");
        $(doc).trigger("wpoi:cc_display", optin_data.type);
        return html;
    };
    
    function cc_handle_custom_size( data ) {
        var new_data = {};
        new_data.custom_size_attr = '';
        new_data.custom_size_class = '';

        if ( data.customize_size && _.isTrue( data.customize_size ) ) {
            new_data.custom_size_class = 'wph-modal--custom';
            new_data.custom_size_attr += 'data-custom_width='+ data.custom_width +' data-custom_height='+ data.custom_height +'';
        }
        if ( data.border && _.isTrue( data.border ) ) {
            new_data.custom_size_attr += ' data-border='+ data.border_weight;
        }

        return new_data;
    }

    var listening_to_exit_intent = false;
    Optin.listen_to_exit_intend = function(){

        if( listening_to_exit_intent ) return;

        $(doc).on("mouseleave", _.debounce( function(e){
            $(doc).trigger("wpoi:exit_intended", e);
        }, 100, true));

        listening_to_exit_intent = true;
    };

    var checking_adblock = false;
    Optin.is_adblock_enabled = function(){
        if( checking_adblock ) return;
        //
        //var $script = $('<script src="{url}" type="text/javascript"></script>'.replace("{url}", inc_opt.adblock_detector_js) );
        //$script.appendTo( "body" );

        if( $("#hustle_optin_adBlock_detector").length ){
            return false;
        }else{
            return true;
        }

        checking_adblock = true;
    };
}(jQuery, document));
