Hustle.define( 'Optin.Error_List_Modal', function($) {
	'use strict';

	var ErrorLog = Backbone.View.extend({
		tagName: 'tr',
		template: Optin.template( 'wpoi-error-list-tpl' ),
		controller: false,
		initialize: function(opts) {
			this.controller = opts.controller;
			this.module_fields = opts.module_fields;
			this.render();
		},
		render: function() {
			var me = this,
				html = this.template( {model: this.model, module_fields: this.module_fields} );

			this.$el.html( html );
			this.$el.appendTo( this.controller.$('#wpoi-error-list') );
		}
	});

	return Backbone.View.extend({
		id: 'wpoi-error-list-modal',
		button: false,
		list: [],
		template: Optin.template( 'wpoi-error-list-modal-tpl' ),
		header_template: Optin.template( 'wpoi-error-header-list-tpl' ),
		hasHeader: false,
		events: {
			'click .inc-opt-close-error-list': 'toggleErrorLog',
			'click .button-clear-logs': 'clearLogs',
			'click .button-delete-logs': '_clean',
			'click .button-cancel-delete-logs': 'cancelDelete',
		},

		initialize: function(opts) {
			this.button = opts.button;
			this.render();
		},

		render: function() {
			var me = this,
				html = this.template( this.model );

			this.$el.html( html );
			this.$el.appendTo('body');
			this.clearLogButton = this.$('.button-clear-logs');
			this.exportButton = this.$('.button-download-csv');
			this.deleteConfirmation = this.$('.hustle-delete-logs-confirmation');
			this.header = this.$('.wph-table-header');
			this.button.addClass('loading');

			$.getJSON( window.ajaxurl, {
				optin_id: this.model.optin_id,
				_wpnonce: optin_vars.error_log_nonce,
				action: 'get_error_list'
			}, function( res ) {
				if ( res.success && res.data && res.data.logs ) {
					me.header.html( me.header_template( {headers: res.data.module_fields} ) );

					_.each( res.data.logs, function( log ) {
						var error = new ErrorLog({
							module_fields: res.data.module_fields,
							model: log,
							controller: me
						});
					});
					me.show();
				}
			});
		},

		show: function() {
			this.$el.addClass('show');
		},

		toggleErrorLog: function() {
			this.$el.removeClass('show');
		},

		clearLogs: function() {
			this.deleteConfirmation.show();
			this.clearLogButton.attr('disabled', true);
			this.exportButton.attr('disabled', true);
		},

		_clean: function() {
			var me = this;

			$.get(window.ajaxurl, {
				optin_id: this.model.optin_id,
				_wpnonce: optin_vars.clear_log_nonce,
				action: 'clear_logs'
			}, function( res ) {
				if ( res.success ) {
					me.toggleErrorLog();
					_.delay(function() {
						me.button.remove();
						me.remove();
					}, 350 );
				}
			});
		},

		cancelDelete: function() {
			this.deleteConfirmation.hide();
			this.clearLogButton.removeAttr('disabled');
			this.exportButton.removeAttr('disabled');
		}
	});
});