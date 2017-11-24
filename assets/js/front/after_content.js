(function( $ ) {
    "use strict";
	if( inc_opt.is_upfront ) return;

	Optin = window.Optin || {};
	Optin.AfterContent = function() {
		var $this = $(this),
			optin_id = $this.data( 'id' ),
			optin, html;

		optin = _.find(Optins, function (opt) {
            return optin_id == opt.data.optin_id;
        });

		$this.data('handle', _.findKey(Optins, optin));
		$this.data('type', 'after_content');

		$this.html( Optin.render_optin(optin) );

		if (optin.settings.after_content.animate
			&& 'true' == optin.settings.after_content.animate ) {

            $this.addClass(optin.settings.after_content.animation);

			_.delay(function() {
				$this.addClass('wpoi-show');
			}, 750 );
        }

		// add provider args
        $this.find(".wpoi-provider-args").html( Optin.render_provider_args( optin )  );

		$(document).trigger("wpoi:display", ["after_content", $this, optin ]);

	};

}(jQuery));