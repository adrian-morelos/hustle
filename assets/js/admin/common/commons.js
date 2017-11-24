(function($){
    "use strict";
    Hustle.Events.on("view.rendered", function(view){
        if( view instanceof Backbone.View)
            view.$(".wpmuiSelect").wpmuiSelect();
    });
}(jQuery));