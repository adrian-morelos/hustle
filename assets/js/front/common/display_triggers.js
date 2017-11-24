"use strict";
(function( $, doc, win ) {

    var time_trigger = function( optin, setting, popup  ){
        if( "immediately" === setting.trigger_on_time  ){
            popup.display();
        }

        if( "time" === setting.trigger_on_time  ){
            var trigger_on_time_delay;
            switch(  setting.appear_after_time_unit ){
                case "minutes":
                    trigger_on_time_delay = parseInt( setting.appear_after_time_val, 10 ) * 60 * 1000;
                    break;
                case "hours":
                    trigger_on_time_delay = parseInt( setting.appear_after_time_val, 10 ) * 60 * 60 * 1000;
                    break;
                default:
                    trigger_on_time_delay = parseInt( setting.appear_after_time_val, 10 ) * 1000;
            }

            _.delay(function(){
                popup.display();
            }, trigger_on_time_delay);
        }
    };

    var scroll_trigger = function( optin, setting, popup  ){
		var popup_shown = false;

        if( "scrolled" === setting.appear_after  ){
            $(win).scroll(_.debounce( function(){
				if ( popup_shown ) return;

                if( (  win.pageYOffset * 100 / $(doc).height() ) >= parseInt( setting.appear_after_page_portion_val, 10 ) ) {
                    popup.display();
					popup_shown = true;
                }

            }, 50) );
        }

        if( "selector" === setting.appear_after  ){
            var $el = $( setting.appear_after_element_val );
            if( $el.length ){
                $(win).scroll(_.debounce( function(){
					if ( popup_shown ) return;

                    if( win.pageYOffset >= $el.position().top ) {
                        popup.display();
						popup_shown = true;
                    }

                }, 50));
            }
        }
    };

    var click_trigger = function( optin, setting, popup ){
        if( "" !== $.trim( setting.trigger_on_element_click )  ){
            var $clickable = $( $.trim( setting.trigger_on_element_click ) );
            if( $clickable.length )
                $(doc).on( "click", $.trim( setting.trigger_on_element_click ),  popup.display);
        }

        /**
         * Clickable button added with shortcode
         */
        $(doc).on("click", ".inc_opt_hustle_shortcode_trigger", function(e){
            e.preventDefault();
            if( $(this).data("id") == optin.data.optin_id ) {
				popup.display();
			}
        });
    };

    var exit_intent_trigger = function( optin, setting, popup  ){
        if(_.isTrue( setting.trigger_on_exit  ) ){
            Optin.listen_to_exit_intend();
            if(_.isTrue( setting.on_exit_trigger_once_per_session  ) ){
                $(doc).one("wpoi:exit_intended", popup.display);
            }else{
                $(doc).on("wpoi:exit_intended", popup.display);
            }
            
        }
    };


    var adblock_trigger = function( optin, setting, popup  ) {
        if(_.isTrue( setting.trigger_on_adblock ) ){

            if( !Optin.is_adblock_enabled() ) return;

            if(  !_.isTrue( setting.trigger_on_adblock_timed ) ){
                popup.display();
            }else{
                var trigger_on_adblock_delay;
                switch(  setting.trigger_on_adblock_timed_unit ){
                    case "minutes":
                        trigger_on_adblock_delay = parseInt( setting.trigger_on_adblock_timed_val, 10 ) * 60 * 1000;
                        break;
                    case "hours":
                        trigger_on_adblock_delay = parseInt( setting.trigger_on_adblock_timed_val, 10 ) * 60 * 60 * 1000;
                        break;
                    default:
                        trigger_on_adblock_delay = parseInt( setting.trigger_on_adblock_timed_val, 10 ) * 1000;
                }

                _.delay(function(){
                    popup.display();
                }, trigger_on_adblock_delay);
            }

        }
    };

    Optin.Triggers = {
        time: time_trigger,
        scroll: scroll_trigger,
        scrolled: scroll_trigger,
        click: click_trigger,
        exit_intent: exit_intent_trigger,
        adblock: adblock_trigger
    };

}(jQuery, document, window));