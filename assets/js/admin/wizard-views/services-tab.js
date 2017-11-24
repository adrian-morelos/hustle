Hustle.define("Optin.Email_Services_Tab", function( $ ) {
    "use strict";
    return Hustle.View.extend( _.extend({}, Hustle.get("Mixins.Model_Updater"), {
        template: Hustle.template("wpoi-wizard-services_template"),
        el: "#wpoi-wizard-services",
        events: {
            "click .next-button button": "validate",
            'change #optin_new_provider_name': 'provider_change',
            'click .optin_refresh_provider_details': 'refresh_provider_details'
        },
        fields : {
            name:  "#optin_new_name",
            provider:  "#optin_new_provider_name",
            api_key: "#optin_api_key",
            mail_list:  "#optin_email_list",
            test_mode: '#wpoi-test-mode-setup',
            save_to_local: '#wpoi-save-to-local'
        },
        init: function(opts){
            this.render();
            this.provider_args = opts.provider_args;
            this.$details_placeholder =  $("#optin_new_provider_account_details");
            this.$options_placeholder =  $("#optin_new_provider_account_options");
            this.params = this.get_params();
            if( typeof this.params.code != 'undefined' ){
                window.setTimeout(function(){
                    $('#optin_new_provider_name').trigger('change');
                }, 750);

            }

            _.each( Optin.Mixins.get_services_mixins(), function(mix, id){
                if( mix && typeof mix === "function")
                    this[id] = mix( this );

            }, this );

            //this.listenTo( this.model, "change", this.render );
            this.listenTo( this.model, "change:test_mode", this.toggle_optin_provider_settings );
            this.listenTo( this.model, "change:optin_name", this.set_shortcode_id );

            return this;
        },
        render: function(){

            this.$el.html( this.template( this.model.toJSON() ) );
            this.toggle_optin_provider_settings();
            return this;
        },
        toggle_optin_provider_settings: function(){
			var me = this;
			this.$(".wph-label--notice").each( function(){
				var $this = $(this);
				if ( !$this.hasClass('wph-label--persist_notice') ) {
					$this.toggleClass( "hidden",  _.isFalse( me.model.get("test_mode") ) );
					$this.siblings().toggleClass( "hidden",  _.isTrue( me.model.get("test_mode") ) );
				}
			} );
            this.$("#optin_new_provider_name").prop("disabled", _.isTrue( this.model.get("test_mode") ) );
        },
        update_model: function(e){
            if( e )
                e.preventDefault();

            var $container = $('.optwiz-container'),
                self = this;

            Optin.step.model = Optin.step.model || new Optin.Model( optin_vars.current.data );

            Optin.step.model.set("optin_name", this.$( this.fields.name ).val() );

            Optin.step.model.set("optin_provider", this.$( this.fields.provider ).val() ) ;
            if( this.$(this.fields.api_key) )
                Optin.step.model.set("api_key", this.$(this.fields.api_key).val() );
            if( this.$( this.fields.mail_list).length )
                Optin.step.model.set("optin_mail_list", this.$( this.fields.mail_list ).val() ) ;
            Optin.step.model.set("test_mode", this.$( this.fields.test_mode ).is(":checked") ? 1 : 0 ) ;

            Optin.step.model.set("save_to_local", this.$( this.fields.save_to_local ).is(":checked") ? 1 : 0 ) ;
            
            this.toggle_optin_provider_settings();

        },
        set_shortcode_id: function(){
            var shortcode_id = _.isEmpty( Optin.step.model.get("optin_name") ) ? "" : Optin.step.model.get("optin_name").toString().toLowerCase().trim().replace(/\s+/g, "-");
            Optin.step.display.model.set("shortcode_id", shortcode_id );
        },
        validate: function(e){
            if( e !== undefined ) e.preventDefault();

            Optin.Events.trigger("services:validate:before");

            this.update_model();
			Optin.step.services.errors = 0;

            var validation = Optin.step.model.validate_first_step();

            var provider_name = this.$("#optin_new_provider_name").val();
            if( provider_name && this[ provider_name ] && typeof this[ provider_name].validate === "function" ){
                var provider_validation = this[ provider_name].validate.call(this, validation);
                validation = _( validation._wrapped.concat( provider_validation._wrapped ) );

            }

            if( !validation.size()
                ||  ( this.$( this.fields.test_mode ).is(":checked") &&  !_.isEmpty( this.$(this.fields.name).val() ) )
                ||  ( this.$( this.fields.save_to_local ).is(":checked") &&  !_.isEmpty( this.$(this.fields.name).val() ) )
            ){
                // Only perform navigation if a tab was actually clicked. The validate() function may also be called from somewhere else
                if( e !== undefined ) {
                    Optin.router.navigate("design", true);
                }
            }else{
                var _this = this;
                this.$el.find( "span.dashicons-warning" ).remove();
                validation.each(function(error, index){
                    var $icon = $('<span class="dashicons dashicons-warning"></span>'),
                        $field = _this.$( _this.fields[error.name] );
 
					if ( ! $field.length ) {
						// If field element is not found, return
						return;
					}

                    $icon.attr("title", error.message);

                    if( $field.hasClass('wdev-styled') )
                        $field.closest('.select-container').addClass( "wpoi-error" );
                    else
                        $field.addClass( "wpoi-error" );

                    if( $field.closest(".select-container").length )
                        $field.closest(".select-container").before( $icon );
                    else
                        $field.after( $icon );

                });
            }

            Optin.Events.trigger("services:validate:after");
        },
        get_params: function( ) {
            var url = location.search;
            var ampersand = "&";
            return _.chain(url.slice(1).split( ampersand ))
                .map(function (item) { if (item) { return item.split('='); } })
                .compact()
                .object()
                .value();
        },
        provider_change: function(e){

            var self = this,
				serviceId = $(e.currentTarget).val(),
				detailsContainer = $( '#wpoi-email-provider-details-container' );

			if ( ! serviceId ) {
				detailsContainer.hide();
				return;
			} else {
				detailsContainer.show();
			}

            this.$details_placeholder.html("");
            this.$options_placeholder.html("");
            this.remove_prev_provider_args();

            $.ajax({
                url: ajaxurl,
                type: "get",
                async: true,
                data: {
                    action: "render_provider_account_options",
                    provider_id: e.target.value,
                    _ajax_nonce: $(e.target).data("nonce"),
                    optin: self.model.get("optin_id")
                },
                success: function(response){
                    if( response.success === true ){

                        self.$details_placeholder.html( response.data );

                        if( e.target.value == 'constantcontact' && typeof self.params.code != 'undefined' ) {
                            $('#optin_api_key').val(self.params.code);
                            $('.optin_refresh_provider_details').trigger('click');
                        }
                        self.delegateEvents();
						Hustle.Events.trigger("view.rendered", self);

                    }else{
                        var html = "";
                        if( response.data && _.isArray( response.data ) )
                            html = response.data.join(", ");

                        self.$details_placeholder.html( html );
                    }

                }

            });
        },
        /**
         * Gets provider account option details, eg api key and etc and update #optin_new_provider_account_options content
         */
        refresh_provider_details: function(e){
            var self = this,
                $this = this.$(e.target),
                $form = $this.closest("form"),
                $box = this.$(".wpoi-box"),
                data = $form.serialize(),
                $input = $this.closest("#wpoi-get-lists").find("input"),
                $placeholder = this.$("#optin_new_provider_account_options");

            if(_.isEmpty( $input.val() ) ){
                return e.preventDefault();
            }

            this.remove_prev_provider_args();

            $placeholder.html( this.$( "#wpoi_loading_indicator" ).html() );

            data += "&action=refresh_provider_account_details";
            if( typeof self.model.attributes.optin_id !== 'undefined') data += "&optin=" + self.model.attributes.optin_id;

            $box.find("input,select,button").attr("disabled", true);

            /**
             * Silently clear the args untill they are filled again
             */
            Optin.step.services.provider_args.clear({silent: true});
            Optin.step.services.model.set( "optin_mail_list", "none" );

            $.post(ajaxurl, data, function( response ){

                $box.find("input,select,button").attr("disabled", false);

                if( response.success === true ){

                    if( response.data.redirect_to ){
                        window.location.href = response.data.redirect_to;
                    }else {
						if ( ! response.data ) {
							$placeholder.html( optin_vars.messages.something_went_wrong );
						} else {
							$placeholder.html( response.data );
						}
                        self.$("select").wpmuiSelect();
                    }
                }else{
					if ( ! response.data ) {
						$placeholder.html( optin_vars.messages.something_went_wrong );
					} else {
						$placeholder.html( response.data  );
					}
                }

            }).fail(function( response ) {
                $placeholder.html( optin_vars.messages.something_went_wrong );
            });
        },
        remove_prev_provider_args: function(){
            var $prev_provider_args = $("#wpoi-mailchimp-prev-group-args");
            $prev_provider_args.empty();
        }
    })
    );
});
