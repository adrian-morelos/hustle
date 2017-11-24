(function( $ ) {
    "use strict";

    Hustle.Optin = Optin;

    Optin.View.Template_Mixin = {
        events: {
            "change input[type=text]": "set_model_texts",
            "keyup .wpoi_contenteditable": "set_model_contenteditables",
            "change input[type=radio]": "set_model_radios",
            "change select": "set_model_selects",
            "change input[type=checkbox]": "set_model_checkboxes",
            "blur input[type=text]": "set_model_selects",
            "blur input[type=number]": "set_model_selects"
        },
        set_model_texts:function(e){
            var $el = $(e.target),
                attribute = $el.data('attribute');
            console.log( attribute,   e.target.value );
            this.model.set(attribute, e.target.value );
        },
        set_model_contenteditables:function(e){
            var $el = $(e.target),
                attribute = $el.data('attribute');
            this.model.set(attribute, $el.text() );
        },
        set_model_radios: function(e){
            var $el = $(e.target),
                attribute = $el.data('attribute');
            this.model.set(attribute, e.target.value );
        },
        set_model_selects: function(e){
            var $el = $(e.target),
                attribute = $el.data('attribute');
            this.model.set(attribute,  e.target.value );
        },
        set_model_checkboxes: function(e){
            var $el = $(e.target),
                attribute = $el.data('attribute');
            this.model.set(attribute,  $el.is(":checked") );
        }
    };
}(jQuery));