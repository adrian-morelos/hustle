(function( $ ) {
    "use strict";
    return;
    Optin.View.Conditions = Optin.View.Conditions || {};

    var Condition_Base = Backbone.View.extend({
        condition_id: "",
        className: "wph-conditions--item",
        _template: Optin.template('wpoi-wizard-popup-conditions-item'),
        template: false,
        _defaults: {
            type_name: "",
            condition_name: ""
        },
        events:{
            'change input': 'change_input',
            'change textarea': 'change_input',
            'change select': 'change_input'
        },
        initialize: function( opts ){
            this.type = opts.type;
            this.id = this.type + "-" + this.condition_id;
            this.template =  Optin.template('wpoi-condition-' + this.condition_id );

            

            /**
             * Defines type_name and condition_name based on type and id so that it can be used in the template later on
             *
             * @type {Object}
             * @private
             */
            this._defaults = {
                type_name:   optin_vars.messages.settings[ this.type ] ? optin_vars.messages.settings[ this.type ] : this.type,
                condition_name: optin_vars.messages.conditions[ this.condition_id ] ? optin_vars.messages.conditions[ this.condition_id ] : this.condition_id
            };

            this.data = _.extend( {}, this._defaults, this.defaults, this.model.get( "conditions" )[this.condition_id] );
            if( this.init && typeof this.init === "function")
                this.init(arguments);
            this.render();
            this.delegateEvents();
            return this;
        },
        get_title: function(){
            return this.title.replace("{type_name}", this.data.type_name);
        },
        get_body: function(){
            return typeof this.body === "function" ? this.body.apply(this, arguments ) : this.body.replace("{type_name}", this.data.type_name );
        },
        render: function(){
            var html = this._template(_.extend({}, {
                    title: this.get_title(),
                    body: this.get_body()
                },
                    this._defaults
                ) );

            this.$el.html( html );

            if( this.rendered && typeof this.rendered === "function")
                this.rendered(arguments);

            return this;
        },
        /**
         * Updates attribute value into the condition hash
         *
         * @param attribute
         * @param val
         */
        update_attribute: function(attribute, val){
            var conditions = this.model.get("conditions");
            conditions[ this.condition_id ] = _.isObject( conditions[ this.condition_id ] ) ? conditions[ this.condition_id ] : {};
            conditions[ this.condition_id ][ attribute ] = val;
            this.data[ attribute ] = val;
            this.model.set("conditions", conditions);
        },
        get_attribute: function(attribute){
            var conditions = this.model.get("conditions");
            return conditions[ this.condition_id ] && conditions[ this.condition_id ][ attribute ] ? conditions[ this.condition_id ][ attribute ] : false;
        },
        /**
         * Triggered on input change
         *
         * @param e
         * @returns {*}
         */
        change_input: function(e){
            var el = e.target,
                attribute = el.getAttribute("data-attribute"),
                $el = $(el),
                val = $el.is(".js-wpoi-select") ? $el.val() : e.target.value;

            return this.update_attribute( attribute, val );
        },
        /**
         * Returns configs of condition
         *
         * @returns bool true
         */
        get_configs: function(){
            return this.defaults || true;
        }
    });

    Optin.View.Conditions.visitor_logged_in = Condition_Base.extend({
        condition_id: "visitor_logged_in",
        disable: ['visitor_not_logged_in'],
        title: optin_vars.messages.conditions.visitor_logged_in,
        body: optin_vars.messages.conditions_body.visitor_logged_in
    });

    Optin.View.Conditions.visitor_not_logged_in = Condition_Base.extend({
        condition_id: "visitor_not_logged_in",
        disable: ['visitor_logged_in'],
        title: optin_vars.messages.conditions.visitor_not_logged_in,
        body: optin_vars.messages.conditions_body.visitor_not_logged_in
    });

    Optin.View.Conditions.shown_less_than = Condition_Base.extend({
        condition_id: "shown_less_than",
        title: optin_vars.messages.conditions.shown_less_than,
        defaults: {
            less_than: 1
        },
        body: function(){
            return this.template( this.data );
        }
    });

    Optin.View.Conditions.only_on_mobile = Condition_Base.extend({
        condition_id: "only_on_mobile",
        disable: ['not_on_mobile'],
        title: optin_vars.messages.conditions.only_on_mobile,
        body: optin_vars.messages.conditions_body.only_on_mobile
    });

    Optin.View.Conditions.not_on_mobile = Condition_Base.extend({
        condition_id: "not_on_mobile",
        disable: ['only_on_mobile'],
        title: optin_vars.messages.conditions.not_on_mobile,
        body: optin_vars.messages.conditions_body.not_on_mobile
    });

    /**
     * From a specific referrer
     */
    Optin.View.Conditions.from_specific_ref = Condition_Base.extend({
        condition_id: "from_specific_ref",
        disable: ['not_from_specific_ref'],
        title: optin_vars.messages.conditions.from_specific_ref,
        defaults: {
            refs: ""
        },
        body: function(){
            return this.template( this.data );
        }
    });

    /**
     * Not from a specific referrer
     */
    Optin.View.Conditions.not_from_specific_ref = Condition_Base.extend({
        condition_id: "not_from_specific_ref",
        disable: ['from_specific_ref'],
        title: optin_vars.messages.conditions.not_from_specific_ref,
        defaults: {
            refs: ""
        },
        body: function(){
            return this.template( this.data );
        }
    });

    /**
     * Not from an internal link
     */
    Optin.View.Conditions.not_from_internal_link = Condition_Base.extend({
        condition_id: "not_from_internal_link",
        title: optin_vars.messages.conditions.not_from_internal_link,
        body: optin_vars.messages.conditions_body.not_from_internal_link
    });

    /**
     * From a search engine
     */
    Optin.View.Conditions.from_search_engine = Condition_Base.extend({
        condition_id: "from_search_engine",
        title: optin_vars.messages.conditions.from_search_engine,
        body: optin_vars.messages.conditions_body.from_search_engine
    });

    /**
     * Site is not a Pro Site
     */
    //Optin.View.Conditions.not_a_pro_site = Condition_Base.extend({
    //    condition_id: "not_a_pro_site",
    //    title: "Site is not a Pro Site",
    //    body: "Shows the Pop Up if the site is not a Pro Site."
    //});

    /**
     * On specific URL
     */
    Optin.View.Conditions.on_specific_url = Condition_Base.extend({
        condition_id: "on_specific_url",
        disable: ['not_on_specific_url'],
        title:  optin_vars.messages.conditions.on_specific_url,
        defaults: {
            urls: ""
        },
        body: function(){
            return this.template( this.data );
        }
    });

    /**
     * Not on specific URL
     */
    Optin.View.Conditions.not_on_specific_url = Condition_Base.extend({
        condition_id: "not_on_specific_url",
        disable: ['on_specific_url'],
        title: optin_vars.messages.conditions.not_on_specific_url,
        defaults: {
            urls: ""
        },
        body: function(){
            return this.template( this.data );
        }
    });

    /**
     * Visitor has commented before
     */
    Optin.View.Conditions.visitor_has_commented = Condition_Base.extend({
        condition_id: "visitor_has_commented",
        disable: ['visitor_has_never_commented'],
        title: optin_vars.messages.conditions.visitor_has_commented,
        body: optin_vars.messages.conditions_body.visitor_has_commented
    });

    /**
     * Visitor has never commented
     */
    Optin.View.Conditions.visitor_has_never_commented = Condition_Base.extend({
        condition_id: "visitor_has_never_commented",
        disable: ['visitor_has_commented'],
        title: optin_vars.messages.conditions.visitor_has_never_commented,
        body: optin_vars.messages.conditions_body.visitor_has_never_commented
    });

    /**
     * In a specific Country
     */
    Optin.View.Conditions.in_a_country = Condition_Base.extend({
        condition_id: "in_a_country",
        disable: ['not_in_a_country'],
        title: optin_vars.messages.conditions.in_a_country,
        defaults: {
            countries: ""
        },
        body: function(){
            return this.template( this.data );
        },
        rendered: function(){
            this.$('.js-wpoi-select')
                .val( this.get_attribute( "countries" ) )
                .wpmuiSelect();
        }
    });

    /**
     * Not in a specific Country
     */
    Optin.View.Conditions.not_in_a_country = Condition_Base.extend({
        condition_id: "not_in_a_country",
        disable: ['in_a_country'],
        title: optin_vars.messages.conditions.not_in_a_country,
        body: function(){
            return this.template( this.data );
        },
        rendered: function(){
            this.$('.js-wpoi-select')
                .val( this.get_attribute( "countries" ) )
                .wpmuiSelect();
        }
    });


}( jQuery ));