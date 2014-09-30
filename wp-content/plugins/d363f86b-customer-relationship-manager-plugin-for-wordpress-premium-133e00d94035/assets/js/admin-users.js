/**
 * Extends the usersCustomListTable
 * @param  {Object} $ jQuery
 * @param  {Object} u usersCustomListTable
 */
var extendCustomListTable = function( $, u ) {
	/**
	 * Preset Name
	 * @type {Object}
	 */
	var _presetName = $( '<input type="text" placeholder="Preset name" class="preset-edit" id="presetName">' );

	/**
	 * Preset ID
	 * @type {Object}
	 */
	var _presetID = $( '<input type="hidden" value="">' );

	/**
	 * Preset help
	 * @type {Object}
	 */
	var _presetHelp = $( '<p class="preset-help description"></p>' );

	/**
	 * Save button
	 * @type {Object}
	 */
	var _saveButton = $( '<button type="button" id="save-preset-button" class="button button-primary"><i class="dashicons dashicons-yes"></i></button>' );

	/**
	 * Delete button
	 * @type {Object}
	 */
	var _deleteButton = $( '<button type="button" id="delete-preset-button" class="button button-secondary hidden"><i class="dashicons dashicons-trash"></i></button>' );

	/**
	 * Cancel button
	 * @type {Object}
	 */
	var _cancelButton = $( '<button type="button" id="cancel-prset-button" class="button button-secondary hidden"><i class="dashicons dashicons-no"></i></button>')

	/**
	 * List of all presets
	 * @type {Object}
	 */
	var presets = [];

	/**
	 * Initialize this object
	 */
	var _init = function(  ) {
		/* Attach the preset buttons to the footer */
		u.searchTabFooter.html( '' );
		u.searchTabFooter.append( _presetHelp );
		u.searchTabFooter.append( _presetName );
		u.searchTabFooter.append( _presetID );
		u.searchTabFooter.append( _saveButton );
		u.searchTabFooter.append( _cancelButton );
		u.searchTabFooter.append( _deleteButton );

		var table = $( '.wp-list-table' ),
			heads = table.find( 'thead, tfoot' );

		var _saveColumnOrder = function( data ) {
			$.post(
				TPC_CRM.ajax,
				{
					action 	: 'save_column_order',
					columns : data
				},
				function( data ) {
					u.userDataTable.fnReloadAjax( );
				}
			);
		}

		if( table.length ) {
			table.sortable( {
				items 		: "th",
				placeholder : "sortable-placeholder",
				update 		: function( event, ui ) {
					var th   = table.find( 'thead th' ),
						aoTh = [ ];

					u.showLoadingScreen( );
					th.each( function( ) {
						aoTh.push( { 
							"id" 	: $( this ).attr( "id" ),
							"class" : $( this ).attr( "class" ),
							"html" 	: $( this ).html( ),
							"text" 	: $( this ).find( 'span:not(.sorting-indicator)' ).html( )
						} )
					} );
					_saveColumnOrder( aoTh );
				}
			} );
		}

		_cancelButton.click( function( e ) {
			e.preventDefault( );
			_cancelPreset( );
		} );

		_deleteButton.click( function( e ) {
			e.preventDefault( );
			var icon = _deleteButton.html();
			_deleteButton.html( '<img src="' + TPC_CRM.url + '/assets/img/wpspin_light.gif" width="16" height="16" />' );

			$.post(
				TPC_CRM.ajax,
				{
					action : 'tpc_delete_preset',
					id     : _presetID.val( )
				},
				function( response ) {
					u.userDataTable.fnReloadAjax( );
					u.notify( response.message );
					_cancelPreset( );
					_deleteButton.html( icon );
				}
			);
		} );

		_saveButton.on( 'click', function( e ) {
			e.preventDefault( );
			_savePreset( );
		} );

		_getPresetsList( );
		_showHelp( );
		$( '#nav-tab-presets-tab a' ).live( 'click', function( e ) {
			_getPresetsList();
		} );
		$( '.preset-item' ).live( 'click', function( e ) {
			var that = $( this );

			e.preventDefault( );
			u.presetsTab.html( '<img src="' + TPC_CRM.url + '/assets/img/wpspin_light.gif" width="16" height="16" /> Adding Preset data..' );
			_getPreset( that.attr( 'href' ).substr( 1 ) );
		} );

		u.on( 'add.filter', function( val ) {
			if( /preset:/.test( val ) ) {
				_getPreset( val.substr( 7 ) );
			}
		} );

		$( '.remove-preset' ).live( 'click', function( e ) {
			e.preventDefault( );
			var presetId = $( this ).data( 'preset-id' );
			var thisEl   = $( this );
			$( this ).html( '<img src="' + TPC_CRM.url + '/assets/img/wpspin_light.gif" width="16" height="16" />' );

			$.post(
				TPC_CRM.ajax,
				{
					action : 'tpc_delete_preset',
					id     : presetId
				},
				function( response ) {
					thisEl.parents( 'li' ).slideUp( 'fast', function( ) {
						thisEl.remove( );
					} );
				}
			);
		} );
	}

	/**
	 * Display the help message
	 * @param  {integer} msg Message Code
	 */
	var _showHelp = function ( msg ) {
		msg = msg || 0;
		msg = parseInt( msg );
		switch( msg ) {
			case 1:
				_presetHelp.html( '' );
				break;
			case 2:
				_presetHelp.html( 'Editing "' + _presetID.val( ) + '" - Click cancel to discard changes and choose other preset' );
				break;
			default:
				_presetHelp.html( 'Save your current filters as preset.' );
				break;
		}
	}

	/**
	 * Adds content to the presets tab
	 */
	var _getPresetsList = function( ) {
		u.presetsTab.html( '<img src="' + TPC_CRM.url + '/assets/img/wpspin_light.gif" width="16" height="16" /> Loading Presets..' );
		$.get( TPC_CRM.ajax, { action 	: 'tpc_get_presets' }, function( response ) {
			var ul  = $( '<ul class="presets-list"></ul>' );
			
			u.presetsTab.html( '' );
			var j = 1;
			$.each( response, function( i, val ) {
				var li = $( '<li><a href="#" class="remove-preset preset-icon" data-preset-id="' + val.id + '"><i class="dashicons dashicons-trash"></i></a><a href="#' + val.id + '" title="' + val.id + '" class="preset-item">#' + j + ' ' + val.id + '</a></li>' );
				ul.append( li );
				_addPreset( val.id );
				j++;
			} );
			u.presetsTab.append( ul );
		} );
	}

	/**
	 * Add the filters to the filter dropdown
	 */
	var _addFilters = function( ) {
		$.get( TPC_CRM.ajax, { action 	: 'tpc_get_presets' }, function( response ) {
			$.each( response, function( i, val ) {
				_addPreset( val.id );
			} );
		} );
	}

	/**
	 * Remove filters
	 */
	var _removeFilters = function( ) {
		u.searchFilterDropdown.find( 'option[value^="preset"]' ).remove( );
		u.searchFilterDropdown.trigger( 'chosen:updated' );
	}

	/**
	 * Gets and adds the preset filters
	 * @param  {String} id  	Filter ID
	 */
	var _getPreset = function( id ) {
		u.searchTabFilters.html( '&nbsp;&nbsp;&nbsp;<img src="' + TPC_CRM.url + '/assets/img/wpspin_light.gif" width="16" height="16" /> Loading Preset Data..' );
		$.get( TPC_CRM.ajax, { 'action': 'tpc_get_preset', 'id' : id }, function( response ) {
			var search = response.data.value.search || "";
			u.searchTabFilters.html( '' );
			if( response.success ) {
				u.filters.flush( );
				u.filters.reset( u );
				u.filters.draw( response.data.value );
				u.searchField.val( search );

				_removeFilters( );
				_presetName.val( response.data.id );
				_presetName.removeClass( 'preset-edit' );
				_presetID.val( response.data.id );
				_deleteButton.removeClass( 'hidden' );
				_cancelButton.removeClass( 'hidden' );
				_showHelp( 1 );
				u.userDataTable.fnReloadAjax( );

				$( '#nav-tab-search-tab a' ).tab( 'show' );
			} else {
				u.notify( response.message );
			}
		} );
	}

	/**
	 * Adds a preset
	 * @param {String} id   Preset ID
	 */
	var _addPreset = function( id ) {
		if( !u.searchFilterDropdown.find( 'option[value="preset:' + id + '"]' ).length ) {
			u.filters.add( 'preset:' + id, id, function( field ) {
				return false;
			}, function( val ) {
				
			} );
		}
	}

	/**
	 * Cancels the preset data
	 */
	var _cancelPreset = function( ) {
		u.filters.flush( );
		u.filters.reset( u );
		u.searchField.val( '' );
		u.userDataTable.fnReloadAjax( );
		_addFilters( );
		_presetName.val( '' );
		_presetName.addClass( 'preset-edit' );
		_presetID.val( '' );
		_deleteButton.addClass( 'hidden' );
		_cancelButton.addClass( 'hidden' );
		_showHelp( 0 );
	}

	/**
	 * Saves the preset
	 */
	var _savePreset = function( ) {
		if( _presetName.val( ) == '' ) {
			u.notify( 'Please enter a preset name' );
			return false;
		}

		var data = {
				action 		: 'tpc_save_preset',
				preset_id   : _presetID.val( ),
				preset_name : _presetName.val( ),
				search     	: u.searchField.val( ),
				saving      : true,
			};
		var icon = _saveButton.html();
		_saveButton.html( '<img src="' + TPC_CRM.url + '/assets/img/wpspin_light.gif" width="16" height="16" />' );
		u.showLoadingScreen( );

		$.post(
			TPC_CRM.ajax + '?' + u.getSerializedForm( ).substr( 1 ),
			data,
			function( response ) {
				u.userDataTable.fnReloadAjax( );
				u.notify( response.message );

				if( !_presetID.val( ) && response.success ) {
					_addPreset( _presetName.val( ) );
				}
				_saveButton.html( icon );
			}
		);
	}

	/**
	 * Public variables
	 */
	return {
		/**
		 * Preset Name
		 * @type {Object}
		 */
		presetName : _presetName,

		/**
		 * Save button
		 * @type {Object}
		 */
		saveButton : _saveButton,

		/**
		 * Delete button
		 * @type {Object}
		 */
		deleteButton : _deleteButton,

		/**
		 * Initialize the object
		 */
		init : _init
	}
}( jQuery, usersCustomListTable );