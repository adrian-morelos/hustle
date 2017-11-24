(function( $ ) {
	"use strict";
	/**
     * Functions for saving conversion data
     */
	Optin = Optin || {};
	Optin.handle_cc_shortcode_conversion = function(cc_id, type){
        var $win =  $(window),
            $doc = $(document);
		
		$($doc).on("click", "a.wph-cc-shortcode--cta", function(e){
            if ( typeof Optin.CC_log_conversion != 'undefined' ) {
                Optin.CC_log_conversion.set( 'id', cc_id );
                Optin.CC_log_conversion.set( 'type', type );
                Optin.CC_log_conversion.set( 'source', 'cta' );
                Optin.CC_log_conversion.save();
            }
		});
    };
	
    /**
     * Render inline optins ( widget )
     */
    Optin.inc_opt_render_widgets = function(use_compat){        
		// rendering widgets, shortcodes for Custom Content
		$(".inc_cc_widget_wrap, .inc_cc_shortcode_wrap").each(function () {
            var $this = $(this),
                id = $this.data("id"),
                type = $this.is(".inc_cc_widget_wrap") ? "widget" : "shortcode";

            if( !id ) return;
			
            var cc = _.find(Hustle_Custom_Contents, function (opt) {
                return id == opt.content.optin_id;
            });
            
            if (!cc) return;
            
            var settings = $.parseJSON(cc.settings);
            if ( settings === null ) return;
            if ( !_.isTrue( settings[type].enabled ) ) return;
			
			$this.data("handle", _.findKey(Hustle_Custom_Contents, cc));
            $this.data("type", type);
			
			// sanitize cta_url 
			if ( cc.design.cta_url ) {
				if (!/^(f|ht)tps?:\/\//i.test(cc.design.cta_url)) {
					cc.design.cta_url = "http://" + cc.design.cta_url;
				}
			}
			cc.type = type;
			var html = Optin.render_cc_shortcode( cc, use_compat );
			// Optin.handle_cc_scroll( $this, type, id );
			$this.html(html);
            
            if ( cc.tracking_types !== null && _.isTrue( cc.tracking_types[type] ) ) {
                _.delay(function(){
                    $(document).trigger("wpoi:cc_shortcode_or_widget_viewed", [type, id]);
                }, _.random(0, 300));
                
                Optin.handle_cc_shortcode_conversion(id, type);
            }
        });
		
		// rendering widgets, shortcodes for Opt-in
        $(".inc_opt_widget_wrap, .inc_opt_shortcode_wrap").each(function () {
            var $this = $(this),
                id = $this.data("id"),
                type = $this.is(".inc_opt_widget_wrap") ? "widget" : "shortcode";
            
            if( !id ) return;
			
            var optin = _.find(Optins, function (opt) {
                return id == opt.data.optin_id;
            });

            if (!optin) return;

            $this.data("handle", _.findKey(Optins, optin));
            $this.data("type", type);
            
            var html = Optin.render_optin( optin, use_compat );

            // Optin.handle_scroll( $this, type, optin );


            $this.html(html);

            // add provider args
            $this.find(".wpoi-provider-args").html( Optin.render_provider_args( optin )  );

            _.delay(function(){
                $(document).trigger("wpoi:display", [type, $this, optin ]);
            }, _.random(0, 300));

        });
        
        // rendering social sharing modules widget and shortcode
        $(".inc_social_sharing_widget_wrap, .inc_social_sharing_shortcode_wrap").each( function() {
            var $this = $(this),
                id = $this.data("id"),
                type = $this.is(".inc_social_sharing_widget_wrap") ? "widget" : "shortcode";
                
                if( !id ) return;
			
                var ss = _.find(Hustle_SS_Modules, function (opt) {
                    return id == opt.optin_id;
                });
               
                if (!ss) return;
                
                var settings = $.parseJSON(ss.settings);
                if ( settings === null ) return;
                if ( !_.isTrue( settings[type].enabled ) ) return;
                
                ss.parent = $this;
                if ( typeof use_compat !== 'undefined' && use_compat ) {
                    ss.is_compat = true;
                }
                
                $this.html('');
                if ( type == 'widget' ) {
                    new Optin.SS_widget(ss);
                } else {
                    new Optin.SS_shortcode(ss);
                }
        });
		
    };

    Optin.inc_opt_render_widgets(false);
    
    Hustle.Events.on("upfront:editor:widget:render", function(widget) {
        Optin.inc_opt_render_widgets(true);
    });
    Hustle.Events.on("upfront:editor:shortcode:render", function(shortcode) {
        Optin.inc_opt_render_widgets(true);
    });

}(jQuery));