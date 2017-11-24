/**
 * Hubspot email integration
 */
(function($,doc,win){
    'use strict';

    Optin.Mixins.add_services_mixin( 'hubspot', function() {
        return new Optin.Provider({id: 'hubspot'});
    });

    var resetReferrer = function() {
        var target = $(this),
            optin_id = target.data('optin'),
            location = target.attr('href'),
            timer, data;

        if ( ! optin_id ) {
            var button = $('.next-button button.wph-button-save', '#wpoi-wizard-services');
            button.trigger( 'click' );

            timer = setInterval(function() {
                optin_id = Optin.step.services.model.get('optin_id');

                if ( parseInt( optin_id ) > 0 ) {
                    clearInterval(timer);
                    data = {optin_id: optin_id, _wpnonce: window.optin_vars.hubspot_nonce, action: 'update_hubspot_referrer' };

                    // Update referrer in the background
                    $.get(ajaxurl, data);

                    _.delay(function() {
                        win.location = location;
                    }, 300 );
                }
            }, 100 );
        }

        return;
    };

    $(doc).on( 'click', '.hubspot-authorize', resetReferrer );

}(jQuery,document,window));
