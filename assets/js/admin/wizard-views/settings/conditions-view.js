(function( $ ) {
    "use strict";

    Optin.View.Conditions.View = Backbone.View.extend({
        template: Optin.template("wpoi-wizard-popup-conditions-handle"),
        events: {
            'click .wpoi-conditions-list-handles .wpoi-condition-item:not(.disabled)': 'toggle_condition',
            'click .wpoi-conditions-list-handles .wpoi-condition-item:not(.disabled) span': 'toggle_condition'
        },
        initialize: function(opts){
            this.type = opts.type;
            this.active_conditions = {};
            this.render();
        },
        render: function(){
            var conditions = this.model.get( this.type ).get( "conditions" );

            _.each( Optin.View.Conditions, function(condition, id){
                var handle = this.template({
                    label: this.get_label( id ),
                    id: id,
                    cid: this.get_condition_cid( id ),
                    active_class: conditions[ id ] ? "added" : '',
                    icon_class: conditions[ id ] ? "wpoi-remove" : "wpoi-add"
                });

                // add handle
                this.$('.wpoi-conditions-list-handles').append( handle  );

            }, this);

            _.each( conditions, function(condition, id){
                this.add_condition_panel(id);
            }, this);
        },
        get_condition_cid: function(id){
            return this.type + "_" + id;
        },
        get_label: function(id){
            var type_name = optin_vars.messages.settings[ this.type ] ? optin_vars.messages.settings[ this.type ] : this.type;
            return optin_vars.messages.conditions[ id ] ? optin_vars.messages.conditions[ id].replace("{type_name}", type_name) : id;
        },
        take_care_of_connected_conditions: function(this_condition){
            /**
             * Disable those conditions which can't go with this condition
             */
            if( this_condition.disable && this_condition.disable.length ){
                _.each( this_condition.disable, function(disable_id, index){
                    var $disable_handle = this.$( "#" + this.get_condition_cid( disable_id ) );
                    $disable_handle.toggleClass("disabled");
                }, this) ;
            }
        },
        /**
         * Adds condition to optin type
         *
         * @param id
         * @param this_condition
         * @returns {*|{}}
         */
        add_condition: function (id, $handle) {
            var this_condition = this.add_condition_panel(id);
            /**
             * Add condition element
             */
            $handle.addClass("added");
            $handle.find("span").addClass("wpoi-remove");
            $handle.find("span").removeClass("wpoi-add");

            var conditions = $.isPlainObject( this.model.get(this.type + ".conditions") ) ? this.model.get(this.type + ".conditions") : {};
            conditions[id] = this_condition.get_configs();
            this.model.get(this.type).set("conditions", conditions);
            return conditions;
        },
        /**
         * Removes conditon from optin type
         * @param id
         */
        remove_condition: function (id, this_condition, $handle) {
            this.take_care_of_connected_conditions( this_condition );

            this_condition.remove();
            delete this.active_conditions[ id ];
            $handle.removeClass("added");
            $handle.find("span").removeClass("wpoi-remove");
            $handle.find("span").addClass("wpoi-add");

            var conditions = this.model.get(this.type + ".conditions") || {};
            delete conditions[id];
            this.model.get(this.type).set("conditions", conditions, {silent: true});
        },
        /**
         * Add condition pannel
         *
         * @param id
         * @returns {*}
         */
        add_condition_panel: function ( id ) {
            var this_condition = this.active_conditions[id] = new Optin.View.Conditions[id]({
                model: this.model.get( this.type ),
                type: this.type
            });


            this.take_care_of_connected_conditions( this_condition );

            /**
             * Append condition panel
             */
            this.$('.wpoi-condition-items').append(this_condition.$el);
            return this_condition;
        }, /**
         * Toggles each of the conditions
         *
         * @param e
         */
        toggle_condition: function(e){
            e.stopPropagation();
            var id = this.$(e.target.id).data("id") || this.$(e.target).closest(".wpoi-condition-item").data("id"),
                $handle = this.$('#' + this.get_condition_cid( id ) ),
                this_condition = this.active_conditions[ id ];

            if( this_condition ){
                this.remove_condition(id, this_condition, $handle );
            }else{
                this.add_condition(id, $handle);
            }


        }
    });
})( jQuery );
