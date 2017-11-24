Hustle.define("Optin.Display_Tab", function( $ ) {
    "use strict";
    return Hustle.View.extend( _.extend({}, Hustle.get("Mixins.Model_Updater"), {
        template: Optin.template("wpoi-wizard-settings_template"),
        widget_message_tpl: Optin.template("wpoi-wizard-settings_widget_template"),
        el: "#wpoi-wizard-settings",
        events: {
            "click .next-button a.previous": "go_to_design",
            "click .can-open.display-settings-icon span.open i.dev-icon": "toggle_boxes",
            "change #wpoi-after-content-state-toggle": "optin_type_toggle",
            "change #wpoi-popup-state-toggle": "optin_type_toggle",
            "change #wpoi-slide-in-state-toggle": "optin_type_toggle"
        },
        init: function(){
            this.listenTo( this.model, "change:after_content.animate", this.toggle_after_content_animation_select );

            this.listenTo( this.model, "change:popup.enabled", this.render );
            this.listenTo( this.model, "change:slide_in.enabled", this.render );
            this.listenTo( this.model, "change:after_content.enabled", this.render );
            this.listenTo( this.model, "change:slide_in.position", this.update_slide_in_position_label );
            this.listenTo( this.model, "change:shortcode_id", _.bind(this.render_widget_message, this) );

            return this.render();
        },
        move_selects_under_selected_radio: function( key, val, options ){
            var value =  this.model.get( key ),
                block_class = "." + key.replace(".", "_") + "_block",
                select_wrap = block_class + '_select_wrap',
                $second_radio = this.$( block_class ).eq(1),
                $tags_select = this.$( select_wrap );

            if( !$second_radio.length || !$tags_select.length ) return;

            if( _.isTrue( value ) )
                $second_radio.insertAfter( $tags_select );
            else
                $second_radio.insertBefore( $tags_select );
        },
        /**
         * Renders widget message
         */
        render_widget_message: function (){
            var html = this.widget_message_tpl( this.model.toJSON() );
            this.$("#wpoi-wizard-settings-widget-message").html( html );
        },
        render: function(){
			
			var Conditions_View = Hustle.get("Settings.Conditions_View");
            this.popup_conditions_view = new Conditions_View({
                model: this.model.get("popup.conditions"),
                type: "popup"
            });

            this.slide_in_conditions_view = new Conditions_View({
                model: this.model.get("slide_in.conditions"),
                type: "slide_in"
            });

            this.after_content_conditions_view = new Conditions_View({
                model: this.model.get("after_content.conditions"),
                type: "after_content"
            });


            this.model.set('slide_in.position_label', optin_vars.messages.positions[this.model.get('slide_in.position')], { silent:true } );
			
            this.$el.html( this.template( $.extend( true, {}, this.model.toJSON(), {
                popup:{condition_labels: this.popup_conditions_view.get_all_conditions_labels() },
                after_content:{condition_labels: this.after_content_conditions_view.get_all_conditions_labels() },
                slide_in:{condition_labels: this.slide_in_conditions_view.get_all_conditions_labels() }
            } ) ) );

            this.render_widget_message();

			this.popup_conditions_view.delegateEvents();    
			this.popup_conditions_view.on("toggle_condition", this.render_condition_labels);				
			this.popup_conditions_view.on("change:update_view_label", this.render_condition_labels);				
			this.$("#wph-optin--popup_conditions .wph-conditions").html( this.popup_conditions_view.$el );
			
			this.slide_in_conditions_view.delegateEvents();
			this.slide_in_conditions_view.on("toggle_condition", this.render_condition_labels);	
			this.slide_in_conditions_view.on("change:update_view_label", this.render_condition_labels);	
            this.$("#wph-optin--slide_in_conditions .wph-conditions").html( this.slide_in_conditions_view.$el );

			this.after_content_conditions_view.delegateEvents();
			this.after_content_conditions_view.on("toggle_condition", this.render_condition_labels);	
			this.after_content_conditions_view.on("change:update_view_label", this.render_condition_labels);	
            this.$("#wph-optin--after_content_conditions .wph-conditions").html( this.after_content_conditions_view.$el );

            var optin_popup_d_triggers = new Optin.View.Display_Triggers({
                model: this.model,
                el: "#triggers-section-popup",
                type: "popup"
            });

            var optin_slidein_d_triggers = new Optin.View.Display_Triggers({
                model: this.model,
                el: "#triggers-section-slide_in",
                type: "slide_in"
            });

            this.$el.find(".can-open.display-settings-icon span.open i.dev-icon").trigger("click");

        },
        optin_type_toggle: function(e){
            var $this = $(e.target),
                $block = $this.closest(".wpoi-toggle-block"),
                $p = $block.find("p").first(),
                $section = $this.closest(".wpoi-listing-wrap").find("section");
			
            if( $this.is(":checked") ) {
                $p.fadeOut();
                $block.removeClass("inactive");

            } else {
                $p.fadeIn();
                $block.addClass("inactive");
            }

            if( $section.is(".closed") && $this.is(":checked") )
                $this.closest(".wpoi-toggle-mask").find("span.open i.dev-icon").trigger("click");
        },
        toggle_boxes: function(e){
            var $this = $(e.target);
            var classOpen = "dev-icon-caret_up";
            var classClosed = "dev-icon-caret_down";
            var currentClass = $this.hasClass(classOpen) ? classOpen : classClosed;
            var newClass = currentClass == classOpen ? classClosed : classOpen;
            var $section = $this.closest(".wpoi-listing-wrap").find("section");
            //if($section.hasClass("closed") && !$this.closest(".wpoi-toggle-mask").find(".toggle-checkbox").is(":checked") ) return;
            $this.switchClass(currentClass, newClass);
            $section.toggleClass("closed", currentClass == classClosed);
            $section.toggle(newClass == classClosed);
        },
        go_to_design: function(e){
            e.preventDefault();
            Optin.router.navigate("design", true);
        },
        /**
         * Toggles after content animation dropdowns if "No Animation, Optin is always visible" is selected or deselected
         *
         *
         */
        toggle_after_content_animation_select: function(){
            if( _.isTrue( this.model.get("after_content.animate") ) ) {
                this.$("#optin-afterc-animation-block").show(function () {
                    $(this).removeClass("hidden");
                });
            }else{
                this.$("#optin-afterc-animation-block").hide( function(){
                    $(this).addClass("hidden");
                } );
            }
        },
        update_slide_in_position_label: function(e){
          this.$("#wpoi-slide_in-position-label").text( optin_vars.messages.positions[this.model.get('slide_in.position')] );
        },
        render_condition_labels: function( condition_view ){
            var $els = {
                after_content: $("#wph-after-content-condition-labels"),
                popup: $("#wph-popup-condition-labels"),
                slide_in: $("#wph-slide-in-condition-labels")
            };

            if( $els[ condition_view.type ] )
                $els[ condition_view.type ].html( condition_view.get_all_conditions_labels()  );
        }
    }
    ));
});
