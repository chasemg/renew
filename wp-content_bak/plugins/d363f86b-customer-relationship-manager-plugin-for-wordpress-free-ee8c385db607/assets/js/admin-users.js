"use strict";
/**
 * UsersCustomListTable
 *
 * Initialize datatables and create the search / filter widget on the WP Users's table.
 *
 * @package  TPC CRM
 * @author   Jon Falcon <darkutubuki143@gmail.com>
 * @version  0.1.8
 */
var usersCustomListTable = function( $ ) {
	/**
	 * Pointer to the root
	 * @type {object}
	 */
	var $root 	 = this;

	/**
	 * List of events attached to this object
	 * @type {Object}
	 */
	var events   = { };

	/**
	 * Lists of filtered fields
	 * @type {array}
	 */
	var filtered = [ ];

	/**
	 * List of inserted in the filters dropdown
	 * @type {Object}
	 */
	var filters = { };

	/**
	 * Load screen
	 * @type {Object}
	 */
	var loadScreen;

	/**
	 * Table Form
	 * @type {Object}
	 */
	var tableForm;

	/**
	 * Initiate this object only once
	 * @type {Boolean}
	 */
	var instance;

	/**
	 * Search buttons
	 * @type {Object}
	 */
	var searchButtons;

	/**
	 * Cached column data
	 * @type {Array}
	 */
	var _cachedColumns = [];

	/**
	 * Default arguments
	 * @type {Object}
	 */
	var defaults = {
			columns 		: { },
			filters 		: { },
			requests 		: { },
			itemRemoved		: function( item ) { },
			itemAdded		: function( item ) { },
			addingItem 		: function( item ) { },
			buildWidget 	: function( id, value ) { }
		};

	/**
	 * List of custom filters callback
	 * @type {Array}
	 */
	var customFilters = [];

	/**
	 * We need a reference to the main object
	 * @type {Object}
	 */
	var that;

	/**
	 * Display the loading icon
	 */
	var _showLoadingScreen = function( ) {
		var wplt   = $( '.wp-list-table' );
		var count  = parseInt( wplt.find( 'tr:first-child th' ).length );

		if( !wplt.find( '#tpcload-column' ).length ) {
			loadScreen = $(  '<td colspan="' + count + '" id="tpcload-column"><img src="' + TPC_CRM.url + '/assets/img/wpspin_light.gif" width="16" height="16" /> Updating the table..</td>' );
			wplt.find( 'tr td' ).remove( );
			wplt.append(loadScreen);
		}
	};

	/**
	 * Hide the loading screen
	 */
	var _hideLoadingScreen = function( ) {
		if( loadScreen ) {
			loadScreen.remove( );
		}
	};

	/**
	 * Gets the table form
	 * @return {object} 
	 */
	var _getForm = function( ) {
		if( !tableForm ) {
			tableForm = $( '.subsubsub ~ form' );
		}
		return tableForm;
	}

	/**
	 * Gets the serialized form string
	 * @return {string} 
	 */
	var _getSerializedForm = function( ) {
		var data = _getForm( ).serialize( ),
			ret  = '';

		if( data ) {
			data = data.replace( /&?action=[^&]+/, '' );
			var ret = '&' + data;
		}

		return ret;
	}

	/**
	 * Show the notification div
	 * @param  {string} msg 
	 */
	var _showNotification = function( msg, isError ) {
		isError = isError || false;
		var div = this ? this.notificationDiv : $( '.notification-div' );

		if( isError ) {
			div.removeClass( 'updated' ).addClass( 'error' );
		} else {
			div.removeClass( 'error' ).addClass( 'updated' );
		}

		div.html( '<p>' + msg + '</p>' );
		div.slideDown( 'fast', function( ) {
			div.delay( 5000 ).slideUp( 'fast' );
		} );
	}

	/**
	 * Extend the Datatable to add custom template and plugins
	 * @param  {Object} $this Pointer to the parent function
	 */
	var _extendDataTable = function( $this ) {
		$.extend( true, $.fn.dataTable.defaults, {
		    oLanguage: {
		        sLengthMenu	: "_MENU_",
		        sSearch		: '<div class="search-input">_INPUT_<span class="search-buttons"><button type="submit" class="user-search-button button button-primary"><i class="dashicons dashicons-search"></i></button> <button type="button" class="button button-secondary reset-users-button"><i class="glyphicon glyphicon-repeat"></i></button><a href="#" class="button button-ternary" id="toggle-filters"><i class="glyphicon glyphicon-chevron-down" id="toggle-filters-icon"></i></a></span></div>',
		        sInfo		: "<strong>_START_</strong>-<strong>_END_</strong> of <strong>_TOTAL_</strong>",
		        oPaginate	: {
		            sPrevious	: "&larr;",
		            sNext		: "&rarr;"
		        }
		    }
		} );

		$.fn.dataTableExt.oApi.fnResetAllFilters = function (oSettings, bDraw) {
	        for(var iCol = 0; iCol < oSettings.aoPreSearchCols.length; iCol++) {
	                oSettings.aoPreSearchCols[ iCol ].sSearch = '';
	        }
	        oSettings.oPreviousSearch.sSearch = '';
	 
	        if(typeof bDraw === 'undefined') bDraw = true;
	        if(bDraw) this.fnDraw();
		}

		$.fn.dataTableExt.oApi.fnReloadAjax = function ( oSettings, sNewSource, fnCallback, bStandingRedraw ) {
		    if ( typeof sNewSource != 'undefined' && sNewSource != null ) {
		        oSettings.sAjaxSource = sNewSource;
		    }
		    this.oApi._fnProcessingDisplay( oSettings, true );
			var that   = this;
			var iStart = oSettings._iDisplayStart;
			var aData  = [];

			if( this.oApi._fnServerParams ) {
		    	this.oApi._fnServerParams( oSettings, aData );
			}

		    oSettings.fnServerData( oSettings.sAjaxSource, aData, function ( json ) {
		        /* Clear the old information from the table */
		        that.oApi._fnClearTable( oSettings );

		        /* Got the data - add it to the table */
		        var aData = ( oSettings.sAjaxDataProp !== "" ) ?
		            that.oApi._fnGetObjectDataFn( oSettings.sAjaxDataProp )( json ) : json;
		        aData     = aData || [];
				aData[ 'bRefreshed' ] = true;

		        for ( var i = 0; i < aData.length; i++ ) {
		            that.oApi._fnAddData( oSettings, aData[ i ] );
		        }

		        oSettings.aiDisplay = oSettings.aiDisplayMaster.slice( );
		        that.fnDraw( );

		        if ( typeof bStandingRedraw != 'undefined' && bStandingRedraw === true ) {
		            oSettings._iDisplayStart = iStart;
		            that.fnDraw( false );
		        }

		        that.oApi._fnProcessingDisplay( oSettings, false );

		        /* Callback user function - for event handlers etc */
		        if ( typeof fnCallback == 'function' && fnCallback != null ) {
		            fnCallback( oSettings );
		        }
		    }, oSettings );
		}
	};

	/**
	 * Get the search button
	 */
	var _searchButtons = function( ) {
		searchButtons = searchButtons || $( '.user-search-button' );
		if( typeof searchButtons == "object" ) {
			return searchButtons;
		}
	}

	/**
	 * Instantiate the datatable on WP Users Table
	 * @param {object} $this Pointer to the parent function
	 */
	var _addDataTable = function( $this ) {
		/**
		 * =========== Pipelining =========================
		 * Pipeline the request so we won't be DDOs'd
		 * ================================================
		 */
		/**
		 * Cached data
		 * @type {Object}
		 */
		var oCache = {
		    iCacheLower: -1
		};

		/**
		 * Sets the column data
		 * @param  {array} aoData 	List of data from the server
		 * @param  {string} sKey   	Column ID
		 * @param  {mixed} mValue 	Column value
		 */
		function fnSetKey( aoData, sKey, mValue ) {
		    for ( var i=0, iLen=aoData.length ; i<iLen ; i++ )
		    {
		        if ( aoData[i].name == sKey )
		        {
		            aoData[i].value = mValue;
		        }
		    }
		}
		 
		/**
		 * Gets the column data
		 * @param  {array} aoData 	List of data from the server
		 * @param  {string} sKey   	Column ID
		 */
		function fnGetKey( aoData, sKey ) {
		    for ( var i=0, iLen=aoData.length ; i<iLen ; i++ )
		    {
		        if ( aoData[i].name == sKey )
		        {
		            return aoData[i].value;
		        }
		    }
		    return null;
		}

		/**
		 * Process the server request and pipeline it
		 * @param  {string} sSource    		Url to the server script
		 * @param  {array} aoData     		List of arguments passed to the server
		 * @param  {function} fnCallback 	Callback function
		 */
		function fnDataTablesPipeline ( sSource, aoData, fnCallback ) {
			var iPipe            = 2;
			var bNeedServer      = false;
			var sEcho            = fnGetKey( aoData, "sEcho" );
			var iRequestStart    = fnGetKey( aoData, "iDisplayStart" );
			var iRequestLength   = fnGetKey( aoData, "iDisplayLength" );
			var iRequestEnd      = iRequestStart + iRequestLength;
			oCache.iDisplayStart = iRequestStart;

			/* Add the serialized form data to the query */
			sSource += _getSerializedForm( );
		     
		    /* outside pipeline? */
		    if ( oCache.iCacheLower < 0 || iRequestStart < oCache.iCacheLower || iRequestEnd > oCache.iCacheUpper )
		    {
		        bNeedServer = true;
		    }
		     
		    /* sorting etc changed? */
		    if ( oCache.lastRequest && !bNeedServer )
		    {
		        for( var i=0, iLen=aoData.length ; i<iLen ; i++ )
		        {
		            if ( aoData[i].name != "iDisplayStart" && aoData[i].name != "iDisplayLength" && aoData[i].name != "sEcho" )
		            {
		                if ( !oCache.lastRequest.length ||aoData[i].value != oCache.lastRequest[i].value )
		                {
		                    bNeedServer = true;
		                    break;
		                }
		            }
		        }
		    }
		     
		    /* Store the request for checking next time around */
		    oCache.lastRequest = aoData.slice();
		     
		    bNeedServer = true;
		    if ( bNeedServer )
		    {
		        if ( iRequestStart < oCache.iCacheLower )
		        {
		            iRequestStart = iRequestStart - (iRequestLength*(iPipe-1));
		            if ( iRequestStart < 0 )
		            {
		                iRequestStart = 0;
		            }
		        }
		         
				oCache.iCacheLower    = iRequestStart;
				oCache.iCacheUpper    = iRequestStart + (iRequestLength * iPipe);
				oCache.iDisplayLength = fnGetKey( aoData, "iDisplayLength" );
		        fnSetKey( aoData, "iDisplayStart", iRequestStart );
		        fnSetKey( aoData, "iDisplayLength", iRequestLength*iPipe );
		         
		        _searchButtons().html( '<img src="' + TPC_CRM.url + '/assets/img/wpspin_light.gif" width="16" height="16" />' );
		        $.getJSON( sSource, aoData, function ( json ) {
		            /* Callback processing */
		            oCache.lastJson = $.extend( true, {}, json );
		             
		            if ( oCache.iCacheLower != oCache.iDisplayStart )
		            {
		                json.aaData.splice( 0, oCache.iDisplayStart - oCache.iCacheLower );
		            }

		            json.aaData.splice( oCache.iDisplayLength, json.aaData.length );
		            fnCallback( json );
		            _searchButtons().html( '<i class="dashicons dashicons-search"></i>' );
		        } );
		    } else {
				var json   = $.extend(true, {}, oCache.lastJson);
				json.sEcho = sEcho; /* Update the echo for each response */
		        json.aaData.splice( 0, iRequestStart-oCache.iCacheLower );
		        json.aaData.splice( iRequestLength, json.aaData.length );
		        fnCallback( json );
		        return;
		    }
		}

		/**
		 * Old Custom server data callback function
		 * @param  {string} sUrl       		Url to the server script
		 * @param  {array} aoData     		List of data passed to the server
		 * @param  {function} fnCallback 	Function called after query
		 * @param  {object} oSettings  		Datatable Settings
		 */
		var fnServerParams = function ( sUrl, aoData, fnCallback, oSettings ) {
			_searchButtons().html( '<img src="' + TPC_CRM.url + '/assets/img/wpspin_light.gif" width="16" height="16" />' );
			oSettings.jqXHR = $.ajax( {
				"url":  sUrl,
				"data": aoData,
				"success": function (json) {
					if ( json.sError ) {
						oSettings.oApi._fnLog( oSettings, 0, json.sError );
					}

					_searchButtons().html( '<i class="dashicons dashicons-search"></i>' );
					
					$(oSettings.oInstance).trigger('xhr', [oSettings, json]);
					fnCallback( json );
				},
				"dataType": "json",
				"cache": false,
				"type": oSettings.sServerMethod,
				"error": function (xhr, error, thrown) {
					_searchButtons().html( '<i class="dashicons dashicons-search"></i>' );
					if ( error == "parsererror" ) {
						oSettings.oApi._fnLog( oSettings, 0, "DataTables warning: JSON data from "+
							"server could not be parsed. This is caused by a JSON formatting error." );
					}
				}
			} );
		};

		/**
		 * Actions taken when the ajax request is done
		 * @param  {object} e        	Event object
		 * @param  {object} settings 	Datatable settings
		 * @param  {object} json     	Reply from the server
		 */
		var fnAjaxCall = function( e, settings, json ) {
			aHidden = json && json.hidden ? json.hidden : [ ];
		}

		/**
		 * Render the table
		 */
		var fnRenderTable = function( ) {
			$( '.dataTables_paginate' ).addClass( 'tablenav' ).wrapInner( '<div class="tablenav-pages"></div>' );
			fnHiddenColumns( );

			if( oCache.lastJson ) {
				var thIndex = parseInt( oCache.lastJson.extras.sort_index );
				var order   = oCache.lastJson.extras.sort_order == 'asc' ? 'desc' : 'asc';

				if( thIndex ) {
					thIndex += 1;
					$this.userDataTable.find( 'th.sorted' ).removeClass( 'sorted asc desc' );
					$this.userDataTable.find( 'tr th:nth-child(' + thIndex + ')' ).addClass( 'sorted ' + order );
				}
			}
		}

		/**
		 * Display the loading column
		 * @param  {Object} e          Event Object
		 * @param  {Object} settings   Table Settings
		 * @param  {Boolean} processing 
		 */
		var fnProcessing = function( e, settings, processing ) {
			if( processing ) {
				_showLoadingScreen( );
			} else if( settings.bDrawing == false ) {
				_hideLoadingScreen( );
			}
		}

		/**
		 * Hides the hidden columns
		 * @param  {object} hidden 		Hidden columns
		 */
		var fnHiddenColumns = function( hidden ) {
			if( !oCache.lastJson ) return;
			var aHidden = oCache.lastJson.hidden;

			for( var i in aHidden ) {
				var hide = aHidden[ i ];
				var j    = parseInt( i ) + 1;
				var sel  = 'tr td:nth-child(' + j + ')';

				if( i ) {
					$this.userDataTable.find( sel ).hide( );
				}
			}
		}

		$this.userDataTable = $( '.wp-list-table' ).dataTable( {
				"iDisplayLength"	: 20,
                "aLengthMenu"		: [ [ 5, 10, 20, 30, 50, 100 -1 ], [ 5, 10, 20, 30, 50, 100, "All" ] ],
				"bStateSave" 		: false,
		        "bProcessing"		: true,
		        "bServerSide"		: true,
		        "sAjaxSource"		: TPC_CRM.ajax + '?action=draw_user_table',
		        "fnServerData"		: fnDataTablesPipeline
		    } );

		$this.userDataTable.on( 'draw.dt', fnRenderTable );
		$this.userDataTable.on( 'xhr.dt', fnAjaxCall );
		$this.userDataTable.on( 'processing.dt', fnProcessing );

		/* Attach events so the table refreshes when the filters are changed. */
		_getForm().on( 'submit', function(e) {
			e.preventDefault( );
			$this.userDataTable.fnReloadAjax( );
		});

		_getForm().on( 'change', '.filter-input', function(e){
			$this.userDataTable.fnReloadAjax( );
		} );

		_getForm().on( 'keydown.input', '.filter-input', function(e){
			$this.userDataTable.fnReloadAjax( );
		} );
	};

	/**
	 * Creates a way to hook to an event
	 * @param  {string}   event    	Event ID
	 * @param  {Function} callback 	Callback function
	 */
	var _addEvent = function ( event, callback ) {
		if( typeof callback == "function" ) {
			if( !events.event ) {
				events[ event ] = [];
			}
			events[ event ].push( callback );
		} else {
			console.log( callback + " must be a function" );
		}
	};

	/**
	 * Adds a way to fire an event
	 * @param  {String} event Event ID
	 */
	var _fireEvent = function( event, param1, param2, param3 ) {
		if( !events[ event ] ) return false;
		param1 = param1 || null;
		param2 = param2 || null;
		param3 = param3 || null;

		$.each( events[ event ], function( i, cb ) {
			if( param1 ) {
				cb( param1 );
			} else if ( param2 ) {
				cb( param1, param2 );
			} else if( param3 ) {
				cb( param1, param2, param3 );
			} else {
				cb();
			}
		} );
	}

	/**
	 * Adds filters from a given data
	 * @param {[type]} filters [description]
	 */
	var _addFilters = function( filters ) {
		$.each( filters, function( i, val ) {
			switch( i ) {
				case "between-dates":
					_checkFilter( 'between_dates' );
					_addBetweenDatesFilter( val.field, val.from, val.to );
					break;
				case "before-date":
					_checkFilter( 'before_date' );
					_addBeforeDate( val.field, val.value );
					break;
				case "after-date":
					_checkFilter( 'after_date' );
					_addAfterDate( val.field, val.value );
					break;
				case "lesser-than":
					_checkFilter( 'field_lesser_than' );
					$.each( val, function( j, opt ) {
						_addLesserThanField( opt.field, opt.value );
					} );
					break;
				case "greater-than":
					_checkFilter( 'field_greater_than' );
					$.each( val, function( j, opt ) {
						_addGreaterThanField( opt.field, opt.value );
					} );
					break;
				case "equals":
					_checkFilter( 'field_equal' );
					$.each( val, function( j, opt ) {
						_addEqualsField( opt.field, opt.value );
					} );
					break;
				case "contains":
					_checkFilter( 'field_contains' );
					$.each( val, function( j, opt ) {
						_addContainsField( opt.field, opt.value );
					} );
					break;
				default:
					break;
			}
		} );
	}

	/**
	 * Add the custom filter
	 * @param {String} id       	Filter ID
	 * @param {Function} fieldCb  	Callback function for creating the field settings
	 */
	var _addCustomFilter = function( optionId, id, fieldCb ) {
		if( !that.searchFilterDropdown.find( 'option[value="' + optionId + '"]' ).length ) {
			var option = $( '<option value="' + optionId + '">' + optionId + '</option>' );
			that.searchFilterDropdown.append( option );
			that.searchFilterDropdown.trigger( "chosen:updated" );
			_createFilterField( id, fieldCb );
		}
	};

	/**
	 * Remove filters
	 */
	var _removeFilters = function( ) {
		$( '#filters-fields .filter-item' ).remove( );
	}

	/**
	 * ================ Helpers ======================================
	 * Helper functions for checking and formatting
	 * ===============================================================
	 */
	/**
	 * Removes removable fields from the filters dropdown
	 * @param  {object} $this 		Pointer to the parent function
	 * @param  {string} id    		Filter id
	 * @return {[boolean|string]} 	Returns the id, if the field can't be removed.
	 */
	var _checkFilter = function ( id ) {
		if( _isRemoved() ) return false;

		if( _isRemovable( id ) ) {
			filtered.push( id );
			that.searchFilterDropdown.find( '[value="' + id + '"]' ).remove( );
			that.searchFilterDropdown.trigger( "chosen:updated" );
		}

		return id;
	};

	/**
	 * Checks if the field is removable
	 * @param  {string}  id Field ID
	 * @return {Boolean}     
	 */
	var _isRemovable = function( id ) {
		return /(field|preset)/.test( id ) === false;
	};

	/**
	 * Checks if the field is already removed
	 * @param  {string}  id Field id
	 * @return {Boolean}     
	 */
	var _isRemoved = function( id ) {
		return ( $.inArray( id, filtered ) >= 0 );
	};

	/**
	 * Formats a date so we can have a unified format
	 * @param  {string|object} dateStr 		Can be a string or a Date Object
	 * @return {object}         
	 */
	var _formatDate	= function( dateStr ) {
		if( typeof dateStr !== "object" ) {
			var chunks = dateStr.split(/(\d{2})\/(\d{2})\/(\d{4})/)
				obj    = new Date( chunks[ 3, 1, 2 ] ),
				str    = dateStr;
		} else {
			var obj    = dateStr,
				str    = ( dateStr.getMonth( ) + 1 ) + '/' + dateStr.getDate( ) + '/' + dateStr.getFullYear( ),
				chunks = [ "", ( dateStr.getMonth( ) + 1 ), dateStr.getDate( ), dateStr.getFullYear( ), "" ];
		}

		return {
			obj 	: obj,
			str 	: str,
			chunks 	: chunks
		}
	};

	/**
	 * Creates the filter field
	 * @param  {string}   id 	Field ID
	 * @param  {function} cb 	Callback function
	 */
	var _createFilterField = function( id, cb ) {
		var wrap 		 = $( '<div class="filter-item clearfix"></div>' ),
			removeButton = $( '<a href="#" class="deleteFilter"><i class="dashicons dashicons-trash"></i></a>' ),
			inputWrap 	 = $( '<span class="filter-inputs"></span>' ),
			filterOpts   = cb( inputWrap );

		if( !filterOpts ) return false;

		wrap
			.append( removeButton )
			.append( filterOpts );

		if( typeof that.options.addingItem === "function" ) {
			that.options.addingItem( wrap );
		}

		wrap.appendTo( that.searchTabFilters );
		if( typeof that.options.itemAdded === "function" ) {
			that.options.itemAdded( wrap );
		}

		removeButton.on( "click", function( e ) {
			e.preventDefault();
			that.userDataTable.fnReloadAjax( );
			$( this ).parents( ".filter-item" ).slideUp( 200, function( ) {
				if( typeof that.options.itemRemoved === "function" ) {
					that.options.itemRemoved( $( this ) );
				}

				if ( _isRemoved( id ) ) {
					var opt;
					for( var i in filters ) {
						if( i == id ) {
							opt = filters[ i ];
						}
					}
					opt.prependTo( that.searchFilterDropdown );
					that.searchFilterDropdown.trigger( "chosen:updated" );
				}

				$( this ).remove( );
			} );
		} );
	};

	/**
	 * Creates the filterable columns
	 * @param  {string} defaultField 	Default field Name
	 * @param  {string} defaultValue 	Default field Value
	 * @param  {string} format       	Data type of the field
	 */
	var _createFilterableColumns = function ( defaultField, defaultValue, format, fixValue ) {
		/* Make the parameters optional */
		defaultField = defaultField || '';
		defaultValue = defaultValue || '';
		fixValue     = fixValue || false;
		format       = format || [ "string" ];
		var firstOpt = '';
		var counter  = 0;

		var fieldInput = $( '<select class="filter-input filter-input-select" name="greater-than[field][]"></select>' );

		if( fixValue ) {
			var fieldValue = $( '<select class="filter-input"name="greater-than[value][]" disabled></selct>' );
		} else {
			var fieldValue = $( '<input class="filter-input" type="text" name="greater-than[value][]" disabled>' );
		}

		$.each( that.options.columns, function( i ) {
			if( i == 'cb' ) return;
			
			var id 	  = i,
				value = that.options.columns[ i ],
				valid = false;

			if( $.inArray( "string", format ) >= 0 && value.isString ) {
				valid = true;
			} else if ( $.inArray( "date", format ) >= 0 && value.isDate ) {
				valid = true;
			} else if( $.inArray( "number", format ) >= 0 && value.isNumeric ) {
				valid = true;
			}

			if( valid ) {
				var opt = $( '<option value="' + id + '">' + value.label + '</option>' );
				opt.appendTo( fieldInput );

				if( !counter ) {
					firstOpt = id;
				}
				counter++;
			}
		});

		if( fieldInput.find( 'option' ).length ) {
			defaultField = defaultField || firstOpt;
			fieldInput.val( defaultField );
			fieldValue.val( defaultValue );

			fieldInput.change( function( ) {
				fieldValue.addClass( 'ui-autocomplete-loading' );
				fieldValue.prop( 'disabled', true );
				fieldValue.find('option').remove( );
				fieldValue.trigger( 'chosen:updated' );
				var col = $( this ).val( );
				_getColumnAutoCompleteData( col )
					.done( function ( response ) {
						if( fixValue ) {
							for( var i in response.assoc ) {
								for( var j in response.assoc[ i ] ) {
									var lbl = response.assoc[ i ][ j ];
									var opt = $( '<option>' + lbl + '</option>' );
									opt.val( i );
									fieldValue.append( opt );
								}
							}
							fieldValue.prop( 'disabled', false );
							fieldValue.trigger( 'chosen:updated' );
						} else {
							fieldValue.autocomplete( "option", "source", response.arr );
							fieldValue.prop( 'disabled', false );
						}
						fieldValue.removeClass( 'ui-autocomplete-loading' );
					 } );
			} );

			_getColumnAutoCompleteData( defaultField )
				.done( function ( response ) {
					fieldValue.addClass( 'ui-autocomplete-loading' );
					fieldValue.prop( 'disabled', true );
					if( fixValue ) {
						for( var i in response.assoc ) {
							for( var j in response.assoc[ i ] ) {
								var lbl = response.assoc[ i ][ j ];
								var opt = $( '<option>' + lbl + '</option>' );
								opt.val( i );
								fieldValue.append( opt );
							}
						}
						fieldValue.prop( 'disabled', false );
						fieldValue.trigger( 'chosen:updated' );
					} else {
						fieldValue.autocomplete( {
							source 	 : response.arr,
							position : {
								my: "right top",
							    at: "right bottom",
								collision: "flipfit flipfit"
							}
						} );
						fieldValue.prop( 'disabled', false );
					}
					fieldValue.removeClass( 'ui-autocomplete-loading' );
				 } );

			return {
				input   : fieldInput,
				value   : fieldValue
			}
		} else {
			return false;
		}
	};

	var _getColumnAutoCompleteData = function ( column ) {
		if( !( column in _cachedColumns ) ) {
			return $.get(
					TPC_CRM.ajax,
					{
						action: 'tpc_get_column_autocomplete',
						column: column
					},
					function( response ) {
						_cachedColumns[ column ] = response;
					}
				);
		} else {
			return {
				done: function( cb ) {
					cb( _cachedColumns[ column ] );
				}
			}
		}
	}

	/**
	 * ================== Filter Fields ===============================
	 * These are functions that'll create the fields in the widget
	 * ================================================================
	 */
	/**
	 * Adds a field for between two dates
	 * @param {string|object} startDate 	Starting Date
	 * @param {string|object} endDate   	End Datek
	 */
	var _addBetweenDatesFilter = function( field, startDate, endDate ) {
		/* Making the parameters optional */
		field              = field || "date_registered";
		startDate          = startDate || new Date( ),
		endDate            = endDate || new Date( startDate.getTime( ) + ( 24 * 60 * 60 * 1000 ) );

		/* reformats the string */
		var startDateFormatted = _formatDate( startDate );
		var endDateFormatted   = _formatDate( endDate );

		startDate          = startDateFormatted.obj;
		endDate            = endDateFormatted.obj;

		var from 		 = $( '<input type="text" name="between-dates[from]" class="filter-input input-date-from input-datepicker">' ),
			to   		 = $( '<input type="text" name="between-dates[to]" class="filter-input input-date-to input-datepicker">' ),
			fromVal      = from.val( ),
			toVal        = to.val ( ),
			fields 		= _createFilterableColumns( field, "date_registered", [ "date" ] );

		if( fields === false ) {
			_showNotification( "No available filters", true );
			return false;
		}

		from.val( startDateFormatted.str );
		from.datepicker()
			.on( 'changeDate', function( ev ) {
				startDate 	= ev.date;

				if( startDate.valueOf( ) > endDate.valueOf( ) ) {
					from.val( fromVal );
					_showNotification( 'The start date should be lesser than the end date', true );
				} else {
					from.datepicker('hide');
					fromVal = from.val( );
				}
			}).data( 'datepicker' );

		to.val( endDateFormatted.str );
		to.datepicker()
			.on( 'changeDate', function( ev ) {
				endDate 	= ev.date;

				if( startDate.valueOf( ) > endDate.valueOf( ) ) {
					to.val( toVal );
					_showNotification( 'The start date should be lesser than the end date', true );
				} else {
					to.datepicker('hide');
					toVal = to.val( );
				}
			}).data( 'datepicker' );

		fields.input.attr( "name", "between-dates[field]" );
		_createFilterField( 'between_dates', function( field ) {
			field
				.append( "If " )
				.append( fields.input )
				.append( ' <br>is between ' )
				.append( from )
				.append( 'and ' )
				.append( to );

			fields.input.chosen( );
			return field;
		});
	};

	/**
	 * Adds a before date filter field
	 * @param {string|object} defaultDate 	Default date
	 */
	var _addBeforeDate = function( field, defaultDate ) {
		/* make the parameter optional */
		field               = field || "date_registered";
		defaultDate         = defaultDate || new Date( );
		
		/* reformat date */
		var defaulDateFormatted = _formatDate( defaultDate );
		defaultDate             = defaulDateFormatted.obj;
		var fields              = _createFilterableColumns( field, "date_registered", [ "date" ] );

		if( fields === false ) {
			_showNotification( "No available filters", true );
			return false;
		}

		var dateInput = $( '<input type="text" name="before-date[value]" class="filter-input input-date-before input-datepicker">' );
		dateInput.val( defaulDateFormatted.str );
		dateInput.datepicker( );

		fields.input.attr( "name", "before-date[field]" );
		_createFilterField( 'before_date', function( field ) {
			field
				.append( "If ")
				.append( fields.input )
				.append( ' is before ')
				.append( dateInput );

			fields.input.chosen( );
			return field;
		} );
	};

	/**
	 * Adds an after date field
	 * @param {string|object} defaultDate 	Default date
	 */
	var _addAfterDate		= function( field, defaultDate ) {
		/* make the parameter optional */
		field               = field || "date_registered";
		defaultDate         = defaultDate || new Date( );
		
		/* reformat date */
		var defaulDateFormatted = _formatDate( defaultDate );
		defaultDate             = defaulDateFormatted.obj;
		var fields              = _createFilterableColumns( field, "date_registered", [ "date" ] );

		if( fields === false ) {
			_showNotification( "No available filters", true );
			return false;
		}

		var dateInput = $( '<input type="text" name="after-date[value]" class="filter-input input-date-after input-datepicker">' );
		dateInput.val( defaulDateFormatted.str );
		dateInput.datepicker( );

		fields.input.attr( "name", "after-date[field]" );
		_createFilterField( 'after_date', function( field ) {
			field
				.append( "If " )
				.append( fields.input )
				.append( ' is after ')
				.append( dateInput );

			fields.input.chosen( );
			return field;
		} );
	};

	/**
	 * Adds a lesser than field
	 * @param {string} defaultField 	Default Field Name
	 * @param {string} defaultValue 	Default Fiel Value
	 */
	var _addLesserThanField	= function ( defaultField, defaultValue ) {
		var fields = _createFilterableColumns( defaultField, defaultValue, [ "number", "date" ] );

		if( fields === false ) {
			_showNotification( "No available filters", true );
			return false;
		}

		fields.input.attr( "name", "lesser-than[field][]" );
		fields.value.attr( "name", "lesser-than[value][]" );
		_createFilterField( 'field_lesser_than', function( field ) {
			field
				.append( 'If ' )
				.append( fields.input )
				.append( 'is lesser than ' )
				.append( fields.value );

			fields.input.chosen( );
			return field;
		} );
	};

	/**
	 * Adds a greater than field
	 * @param {string} defaultField 	Default Field Name
	 * @param {string} defaultValue 	Default Field Value
	 */
	var _addGreaterThanField = function ( defaultField, defaultValue ) {
		var fields = _createFilterableColumns( defaultField, defaultValue, [ "number", "date" ] );

		if( fields === false ) {
			_showNotification( "No available filters", true );
			return false;
		}

		fields.input.attr( "name", "greater-than[field][]" );
		fields.value.attr( "name", "greater-than[value][]" );
		_createFilterField( 'field_greater_than', function( field ) {
			field
				.append( 'If ' )
				.append( fields.input )
				.append( 'is greater than ' )
				.append( fields.value );

			fields.input.chosen( );
			return field;
		} );
	};

	/**
	 * Adds an equals field
	 * @param {string} defaultField 	Default Field Name
	 * @param {string} defaultValue 	Default Field Value
	 */
	var _addEqualsField 	= function ( defaultField, defaultValue ) {
		var fields = _createFilterableColumns( defaultField, defaultValue, [ "number", "date", "string" ], true );

		if( fields === false ) {
			_showNotification( "No available filters", true );
			return false;
		}

		fields.input.attr( "name", "equals[field][]" );
		fields.value.attr( "name", "equals[value][]" );
		_createFilterField( 'field_equal', function( field ) {
			field
				.append( 'If ' )
				.append( fields.input )
				.append( 'is equals to ' )
				.append( fields.value );

			fields.input.chosen( );
			fields.value.chosen( );
			// fields.input.change( function( ) {
			// 	fields.value.trigger( 'chosen:updated' );
			// } );
			return field;
		} );
	};

	/**
	 * Adds a contains field
	 * @param {string} defaultField 	Default Field Name
	 * @param {string} defaultValue 	Default Field Value
	 */
	var _addContainsField = function ( defaultField, defaultValue ) {
		var fields = _createFilterableColumns( defaultField, defaultValue, [ "string" ] );

		if( fields === false ) {
			_showNotification( "No available filters", true );
			return false;
		}

		fields.input.attr( "name", "contains[field][]" );
		fields.value.attr( "name", "contains[value][]" );
		_createFilterField( 'field_contains', function( field ) {
			field
				.append( 'If ' )
				.append( fields.input )
				.append( 'contains ' )
				.append( fields.value );

			fields.input.chosen( );
			return field;
		} );
	}

	/**
	 * Add the default filters
	 */
	var _resetFilters = function( u ) {
		u.searchFilterDropdown.find( '.default-filters' ).remove( );
		filtered = [];

		u.searchFilterDropdown.append( '<option value="0" id="emptyUserFilters" class="default-filters"></option>' );
		var i;
		for( i in u.options.filters ) {
			var id  	= i,
				label 	= u.options.filters[ i ];
			filters[ id ] = $( '<option value="' + id + '" class="default-filters">' + label + '</options>' );
			u.searchFilterDropdown.append( filters[ id ] );
		}
	}

	/**
	 * Create the Filters sidebar widget
	 * @param  {object} $this Pointer to the parent function
	 */
	var _displayFilters = function( $this ) {
		$this.searchForm        = $( '#DataTables_Table_0_filter' );
		$this.searchInput       = $this.searchForm.find( 'label:has(.search-input)' );
		$this.searchField       = $this.searchInput.find( '[type="search"]' );
		$this.toggleFilters     = $( '#toggle-filters' );
		$this.toggleFiltersIcon = $( '#toggle-filters-icon' );
		$this.notificationDiv   = $( '<div class="notification-div updated message hidden"></div>');

		/* Add the notification div */
		$( '.wrap' ).prepend( $this.notificationDiv );

		/* Add the special columns */
		var username = $( '<input class="hide-column-tog" name="username-hide" type="checkbox" id="username-hide" value="username">' );
		var name     = $( '<input class="hide-column-tog" name="name-hide" type="checkbox" id="name-hide" value="name">' );
		$( '#screen-options-wrap #adv-settings .metabox-prefs' )
			.prepend( username )
			.prepend( name );
		username.after( '<label for="username-hide">Username</label>' );
		name.after( '<label for="name-hide">Name</label>' );
		if( $.inArray( 'username', TPC_CRM.hidden ) < 0 ) {
			username.prop( 'checked', true );
		}
		if( $.inArray( 'name', TPC_CRM.hidden ) < 0 ) {
			name.prop( 'checked', true );
		}

		/* add style the search form */
		$this.searchForm
			.addClass( 'filters-box post-box' )
			.prepend( '<div class="metabox-heading"><h3>Search and Filters</h3></div><ul id="search-filters-tabs" class="nav nav-tabs clearfix"><li id="nav-tab-search-tab"><a href="#search-tab">Search &amp; Filters</a></li><li id="nav-tab-presets-tab"><a href="#presets-tab">Presets</a></li></ul>' );
		$( '.wp-list-table' ).addClass( 'has-filters' );
		$( '#search-submit' ).addClass( 'hidden' );
		
		$this.searchInput
			.wrap( '<div id="search-filters-tabs"><div id="search-tab" class="tab clearfix">' );
		$this.searchField.attr( 'placeholder', 'Global Search' )

		$( '#DataTables_Table_0_first' ).html( '&laquo;' );
		$( '#DataTables_Table_0_previous' ).html( '&lsaquo;' );
		$( '#DataTables_Table_0_next' ).html( '&rsaquo;' );
		$( '#DataTables_Table_0_last' ).html( '&raquo;' );
		$( '.wp-list-table th a' ).on( 'click', function( e ) {
			e.preventDefault( );
		} );

		$this.searchFiltersTabs = $( '#search-filters-tabs' );
		$this.toggleFilters.click( function( e ) {
			e.preventDefault( );
			if( $this.searchForm.hasClass( 'active' ) ) {
				$this.searchForm.removeClass( 'active');
				$this.toggleFiltersIcon
					.removeClass( 'glyphicon-chevron-up' )
					.addClass( 'glyphicon-chevron-down' );
			} else {
				$this.searchForm.addClass( 'active');
				$this.toggleFiltersIcon
					.removeClass( 'glyphicon-chevron-down' )
					.addClass( 'glyphicon-chevron-up' );
			}
		} );

		$( document ).click( function ( event ) { 
    		if( !$( event.target ).closest( '#DataTables_Table_0_filter' ).length ) {
				$this.searchForm.removeClass( 'active');
				$this.toggleFiltersIcon
					.removeClass( 'glyphicon-chevron-up' )
					.addClass( 'glyphicon-chevron-down' );
    		}
    	} );

    	$( '.datepicker td' ).click( function() {
    		$this.searchForm.addClass( 'active');
			$this.toggleFiltersIcon
				.removeClass( 'glyphicon-chevron-down' )
				.addClass( 'glyphicon-chevron-up' );
		} );

		$this.searchForm.hover( function( ) {
			$( this ).addClass( 'active');
			$this.toggleFiltersIcon
				.removeClass( 'glyphicon-chevron-down' )
				.addClass( 'glyphicon-chevron-up' );
		}, function( ) {
			// $( this ).removeClass( 'active' );
			// $this.toggleFiltersIcon
			// 	.removeClass( 'glyphicon-chevron-up' )
			// 	.addClass( 'glyphicon-chevron-down' );
		} );

		/* wrap it inside the search tab */
		$this.searchTab 	   = $( '#search-tab' );

		/* Add elements in the search tab */
		$this.searchFilterDropdown = $( '<select tabindex="2" data-placeholder="Select a filter.." id="userFilters" class="select-chosen"></select>' );
		$this.searchFilterDropdown.appendTo( $this.searchTab );
		$this.searchFilterDropdown.wrap( '<div class="filter-field-dropdown"></div>' );
		$this.filters.reset( $this );

		/* Add the footer */
		$this.searchTab.append( '<div id="filters-fields"></div><div class="metabox-footer"><div id="metabox-footer-extra"><em>Upgrade to premium so you can save presets.</em></div></div>');
		$this.searchTabFilters     = $( '#filters-fields' );
		$this.searchTabFooter      = $( $this.searchTab.find( '#metabox-footer-extra' ) );
		$this.resetFilter          = $( '.reset-users-button' );

		/**
		 * Resets the form
		 * @param  {Object} e 		Event Object
		 */
		$this.resetFilter.click( function( e ) {
			e.preventDefault( );
			$this.searchField.val( '' );
			_removeFilters( );
			$this.userDataTable.fnResetAllFilters( );
			$this.userDataTable.fnReloadAjax( );
		} );

		/* Add filters from the request */
		if( $this.options.requests.length ) {
			_addFilters( $this.options.requests );
		}

		/* Actions to the dropdown */
		$this.searchFilterDropdown
			.chosen( )
			.change( function( e ) {
				var val = $( this ).val( );
				$this.userDataTable.fnReloadAjax( );

				$( this ).val( 0 );
				$( this )
					.trigger( 'chosen:updated' )
					.trigger( 'userFiltersChanged', [ val ] );

				val = _checkFilter( val );

				/* check if $this is a preset */
				switch( val ) {
					case "between_dates":
						_addBetweenDatesFilter( );
						break;
					case "before_date":
						_addBeforeDate( );
						break;
					case "after_date":
						_addAfterDate( );
						break;
					case "field_lesser_than":
						_addLesserThanField( );
						break;
					case "field_greater_than":
						_addGreaterThanField( );
						break;
					case "field_equal":
						_addEqualsField( );
						break;
					case "field_contains":
						_addContainsField( );
						break;
					default: break;
				}

				_fireEvent( 'add.filter', val );
			} );

		/* Add the presets tab */
		$this.searchTab.after( '<div id="presets-tab" class="tab clearfix"><div class="inner"></div></div>' );
		$this.presetsTab = $( '#presets-tab .inner' );
		$this.presetsTab.html( 'Presets' );

		$( '#nav-tab-search-tab a' ).tab( 'show' );
		$( '#search-filters-tabs a' ).click( function( e ) {
			e.preventDefault();

			$( this ).tab( 'show' );
		} );
	}

	/**
	 * ============ Public variables and functions =======================
	 * These are variables and function available for public use.
	 * ===================================================================
	 */
	return {
		/**
		 * Initialize the object and build the widget
		 * @param  {Object} options 	Settings to override the default settings
		 */
		init : function( options ) {
			if( instance ) return this;

			var $this   = this;
			that        = this;
			this.options = $.extend( { }, defaults, options );

			_extendDataTable( this );
			_addDataTable( this );
			_displayFilters( this );

			$( '.hide-column-tog' ).on( 'change', function( ) {
				$this.showLoadingScreen( );
				$.post(
					TPC_CRM.ajax,
					{
						action 				: "hidden-columns",
						hidden 				: columns.hidden,
						screenoptionnonce 	: $("#screenoptionnonce").val(),
						page 				: pagenow
					},
					function (data ) {
						$this.userDataTable.fnReloadAjax( );
					}
				);
			} );

			instance = true;
			return this;
		},

		/**
		 * Display the loading icon
		 */
		showLoadingScreen : _showLoadingScreen,

		/**
		 * Hide the loading screen
		 */
		hideLoadingScreen : _hideLoadingScreen,

		/**
		 * Get the table form
		 */
		getForm : _getForm,

		/**
		 * Gets the serialize form
		 */
		getSerializedForm : _getSerializedForm,

		/**
		 * Add a way to access the filters helpers
		 * @type {Object}
		 */
		filters : {
			draw 					: _addFilters,
			flush 					: _removeFilters,
			add 					: _addCustomFilter,
			reset 					: _resetFilters,
			addBetweenDatesFilter 	: _addBetweenDatesFilter,
			addBeforeDate 			: _addBeforeDate,
			addAfterDate 			: _addAfterDate,
			addLesserThanField 		: _addLesserThanField,
			addGreaterThanField 	: _addGreaterThanField,
			addEqualsField 			: _addEqualsField,
			addContainsField 		: _addContainsField,
			checkFilter 			: _checkFilter,
			isRemovable 			: _isRemovable,
			isRemoved 				: _isRemoved
		},

		/**
		 * Show the notification
		 * @type {Function}
		 */
		notify : _showNotification,

		/**
		 * Gives a way to hook to an event
		 * @type {function}
		 */
		on : _addEvent
	}
}( jQuery );