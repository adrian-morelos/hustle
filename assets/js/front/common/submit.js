(function( $ ) {


    function validate_form( $form, is_test ){
        var requireds = $form.find(".required"),
            $icon = $('<i class="wphi-font wphi-error"></i>'),
            errors = [];
        $('.wpoi-field-error').remove();
        requireds.each(function(){
            var $this = $(this),
                error_class = $this.attr("name") + "_" + "error";

            if( is_test ){
                //$icon = $icon.clone().addClass( error_class ).attr("title", inc_opt.l10n.test_cant_submit );
                //$this.after( $icon );
                $this.next('label').find('i.wphi-font').addClass('wphi-error');
                errors.push( $this );
                return errors;
            }

            if( _.isEmpty( this.value ) || ( $this.is("[type='email']") && !this.value.trim().match( /^[\S]+\@[a-zA-Z0-9\-]+\.[\S]{2,}$/gi ) ) ){
                //$icon = $icon.clone().addClass( error_class ).attr("title", $this.data("error") );
                //$this.next('label').find('i.wphi-email').after($icon);
                $this.next('label').find('i.wphi-font').addClass('wphi-error');
                errors.push( $this );
            }else{
                $("." + error_class).remove();
            }

        });

        return errors.length === 0;
    }

    $(document).on("submit", '.inc_optin form',function(e){
        e.preventDefault();
        var $form = $(e.target),
            $button = $form.find("button"),
            $popup = $form.closest( '.inc_optin'),
            handle = $popup.data( 'handle'),
            delay_id = $popup.data("delay_id"),
            optin = Optins[ handle ],
            self = this,
            $wrap = $(this).closest('.wpoi-optin > .wpoi-container'),
            type = $form.closest(".inc_optin").data("type"),
            is_test = type && optin.settings[type].is_test,
            get_success_message = function(){
                return optin.design.success_message.replace("{name}", optin.data.optin_name);
            },
            $failure = $("<span class='wpoi-submit-failure'>" + inc_opt.l10n.submit_failure +  "</span>")
            ;


        $form.parent().find('.wpoi-submit-failure').remove();

        if( !_.isUndefined( delay_id ) )
            clearTimeout( delay_id );

        if( $form.data("sending") || !validate_form( $form, is_test ) ) return;

        $button.attr("disabled", true);
        $button.addClass("loading");
        $form.addClass("loading");

        $form.data("sending", true);

        $.ajax({
            type: "POST",
            url: inc_opt.ajaxurl,
            dataType: "json",
            data: {
                action: "inc_opt_submit_opt_in",
                data: {
                    form: $form.serialize(),
                    optin_id: optin.data.optin_id,
                    page_type: inc_opt.page_type,
                    page_id: inc_opt.page_id,
                    uri: encodeURI( window.location.href ),
                    type: type
                }
            },
            success: function(res){
                if( res && res.success ){
                    //$form.html( "" );
                    var $formParent = $form.closest(".wpoi-hustle");
                    //$formParent.find(".wpoi-form-title").fadeOut();

                    if( optin.design.hasOwnProperty("on_submit") && optin.design.on_submit === "page_redirect" ){
                        window.location.replace( optin.design.page_redirect_url );
                    }else{
                        if(optin.data.optin_provider === 'mailchimp' && typeof res.data.existing !== 'undefined' ){
                            $formParent.find(".wpoi-success-message .wpoi-content p").html(res.data.message);
                        }
                        $formParent.find(".wpoi-success-message").addClass("wpoi-show-message");

						if ( optin.design.hasOwnProperty('on_success') && 'autoclose' === optin.design.on_success ) {
							var on_success_time = parseInt( optin.design.on_success_time ),
								on_success_unit = optin.design.on_success_unit;

							if ( 'm' === on_success_unit ) {
								on_success_time *= 60;
							}

							on_success_time *= 1000;
							_.delay(function(){
								var popup_close = $(self).closest(".inc_optin").find(".inc-opt-close-popup");

								if ( popup_close.length > 0 ) {
									popup_close.trigger("click");
								} else {
									$formParent.find( '.wpoi-success-message' ).removeClass( 'wpoi-show-message' );
								}
							}, on_success_time );
						}
                    }

                }else{
					var message = '';
					if ( res.data ) {
						message = $.isArray( res.data ) ? res.data.pop() : res.data;
					} else {
						message = inc_opt.l10n.submit_failure;
					}

					$failure.html( message ? message : inc_opt.l10n.submit_failure );

                    $form.after( $failure );
                }
            },
            error: function(){
                $form.after( $failure );
            },
            complete: function(){
                $button.attr("disabled", false);
                $form.removeClass("loading");
                $button.removeClass("loading");
                $form.data("sending", false);
            }
        });

    });

	var closeSuccessContent = function() {
		var target = $(this),
			parentDiv = target.parents( '.wpoi-hustle' ),
			$form = $( 'form', parentDiv ),
			$successDiv = $( '.wpoi-success-message', parentDiv );
		$successDiv.removeClass( 'wpoi-show-message' );
	};

	$(document).on( 'click', '.wpoi-success-close', closeSuccessContent );

}(jQuery));