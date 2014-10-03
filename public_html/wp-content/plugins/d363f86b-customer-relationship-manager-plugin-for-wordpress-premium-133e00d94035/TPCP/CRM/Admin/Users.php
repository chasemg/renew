<?php
/**
 * TPCP_CRM_Admin_Users
 * 
 * Adds hooks to the WP Users Admin Page
 *
 * @package Customer Relationship Manager (Premium)
 */
class TPCP_CRM_Admin_Users implements TPC_Interface_Runnable {
	/**
	 * @var TPCP_Helper_UsersListTable
	 */
	private $table;

	/**
	 * List of added columns
	 * @var array
	 */
	private $columns;

	/**
	 * List of added cols
	 * @var array
	 */
	private $addedCols;

	/**
	 * First column
	 * @var string
	 */
	private $first;

	public function __construct( ) {
		$this->table = new TPCP_Helper_UsersListTable( );
	}

	/**
	 * Runs this module
	 * @return $this		Supports chaining
	 */
	public function run( ) {
		add_action( 'admin_init', array( $this, 'adminInit' ) );
		add_action( 'admin_menu', array( $this, 'adminMenu' ) );
		add_action( 'wp_ajax_save_column_order', array( $this, 'saveColumns' ) );
		add_action( 'wp_ajax_tpc_save_preset', array( $this, 'savePreset' ) );
		add_action( 'wp_ajax_tpc_get_presets', array( $this, 'getPresets' ) );
		add_action( 'wp_ajax_tpc_get_preset', array( $this, 'getPreset' ) );
		add_action( 'wp_ajax_tpc_delete_preset', array( $this, 'deletePreset' ) );

		add_filter( 'tpc_crm_users_table_columns', array( $this, 'users_custom_columns' ) );
		return $this;
	}

	/**
	 * Actions to be done during initialization
	 */
	public function adminInit( ) {
		/**
		 * CRM styles/scripts
		 */
		wp_register_style( 'tpcp-crm-admin-users-css'	, TPCP_CRM_URL . '/assets/css/admin-users.css' );
		wp_register_script( 'tpcp-crm-admin-users-js'	, TPCP_CRM_URL . '/assets/js/admin-users.js', array( 'jquery', 'jquery-ui-sortable', 'tpc-crm-admin-users-js' )  );

	}

	/**
	 * Register admin menu
	 */
	public function adminMenu( ) {
		$arr = array( "foo" => "bar", "a" => "b" );
		add_action( 'admin_print_styles-users.php', array( $this, 'adminStyles' ) );
		add_action( 'admin_print_scripts-users.php', array( $this, 'adminScripts' ) );
		add_action( 'admin_footer-users.php', array( $this, 'foot' ), 20 );
	}

	/**
	 * Add the footer script
	 */
	public function foot( ) {
		?>
			<script type="text/javascript">
				( function( w, $, u ) {
					extendCustomListTable.init();
				} )( window, jQuery, usersCustomListTable );
			</script>
		<?php
	}

	/**
	 * Add styles
	 */
	public function adminStyles( ) {
		wp_enqueue_style( 'tpcp-crm-admin-users-css' );
	}

	/**
	 * Add scripts
	 */
	public function adminScripts( ) {
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'tpcp-crm-admin-users-js' );
	}

	/**
	 * Adds more columns to the users's table
	 * @param  object $userTable 
	 * @return object            
	 */
	public function users_custom_columns( $userTable ) {
		global $wpdb;

		$this->table->addTable( $userTable );
		$this->columns = $columns = $this->table->getOrderedColumns( array( $this, 'showColumn'), $useSettings  = true );

		$userTable->resetColumns( );
		$hidden    = get_user_meta( get_current_user_id(), 'manageuserscolumnshidden', true );
		$hasNoEdit = in_array( 'username', (array) $hidden );
		$addedCols = array( );
		$counter   = 0;
		foreach( $columns as $id => $data ) {
			if( $counter === 1 ) $this->first = $id;
			$userTable->addColumn( $id, $data[ 'title'], $data[ 'cb' ] );
			$addedCols[] = $id;

			if( $hasNoEdit && !in_array( $id, $hidden ) ) {
				$counter++;
			}
		}
		$this->addedCols = $addedCols;

		$user_id   = get_current_user_id( );
		$viewed    = ( boolean ) get_user_meta( $user_id, '_tpc_user_viewed', true );

		if( !$viewed ) {
			update_user_meta( $user_id, '_tpc_user_viewed', true );
			// update_user_meta( $user_id, 'manageuserscolumnshidden', $addedCols );
		}

		// $this->table 

		return $userTable;
	}

	/**
	 * Saves the column order
	 */
	public function saveColumns( ) {
		header( "Content-type: application/json" );
		$user_id = get_current_user_id( );
		$columns = isset( $_POST['columns'] ) ? $_POST[ 'columns' ] : array( );
		update_user_meta( $user_id, '_tpc_user_table_column_order', $columns );
		echo json_encode( array( "success" => 1 ) );

		exit( 0 );
	}

	/**
	 * Get a preset
	 */
	public function getPreset( ) {
		header( "Content-type: application/json" );
		$request = new TPC_Helper_Array( $_REQUEST );
		$preset  = new TPCP_CRM_Model_Preset( $request->get( "id" ) );
		$result  = array( "success" => true, "message" => "", "data" => $preset->toArray( true ) );

		if( !$preset->exists( ) ) {
			$result[ "success" ] = false;
			$result[ "message" ] = "Unknown preset: " . $preset->getId( );
		}

		echo json_encode( $result );
		exit( 0 );
	}

	/**
	 * Delete a preset
	 */
	public function deletePreset( ) {
		header( "Content-type: application/json" );
		$request = new TPC_Helper_Array( $_REQUEST );
		$preset  = new TPCP_CRM_Model_Preset( $request->get( "id" ) );
		$result  = array( "success" => true, "message" => "" );

		if( !$preset->delete( ) ) {
			$result[ "success" ] = false;
			$result[ "message" ] = "Unable to remove: " . $prest->getId( );
		} else {
			$result[ "message" ] = "Success! Preset is removed.";
		}

		echo json_encode( $result );
		exit( 0 );
	}

	/**
	 * Get the presets
	 */
	public function getPresets( ) {
		header( "Content-type: application/json" );
		$preset  = new TPCP_CRM_Model_Preset( );
		$presets = $preset->all( array( "toarray" => true, "decode" => false ) );
		echo json_encode( $presets );
		exit( 0 );
	}

	/**
	 * Saves the preset
	 */
	public function savePreset( ) {
		header( "Content-type: application/json" );
		$id      = isset( $_REQUEST[ 'preset_id'] ) ? $_REQUEST[ 'preset_id' ] : null;
		$name    = isset( $_REQUEST[ 'preset_name'] ) ? $_REQUEST[ 'preset_name' ] : null;
		$search  = isset( $_REQUEST[ 'search'] ) ? $_REQUEST[ 'search' ] : null;
		$preset  = new TPCP_CRM_Model_Preset( $id );
		$saving  = $preset->exists() ? true : false;
		$found   = $preset->exists( $name );
		$presets = array( );
		$return  = array( "success" => false, "message" => "", "preset" => $preset->toArray( true ) );

		if( !isset( $_REQUEST[ 'preset_name' ] ) || !trim( $_REQUEST[ 'preset_name' ] ) ) {
			$return[ "message" ] = "Please enter a preset name";
			echo json_encode( $return );
			exit( 0 );
		} else if( $id != $name && $found ) {
			$return[ "message" ] = "Preset already exists.";
			echo json_encode( $return );
			exit( 0 );
		}

		$presets[ 'search' ] = $search;

		if( isset( $_REQUEST[ 'between-dates' ] ) && count( $_REQUEST[ 'between-dates' ] ) ) {
			$presets[ "between-dates" ] = $_REQUEST[ 'between-dates' ];
		}

		if( isset( $_REQUEST[ 'before-date' ] ) && count( $_REQUEST[ 'before-date' ] ) ) {
			$presets[ "before-date" ] = $_REQUEST[ 'before-date' ];
		}

		if( isset( $_REQUEST[ 'after-date' ] ) && count( $_REQUEST[ 'after-date' ] ) ) {
			$presets[ 'after-date' ] = $_REQUEST[ 'after-date' ];
		}

		if( isset( $_REQUEST[ 'lesser-than' ] ) && count( $_REQUEST[ 'lesser-than' ] ) ) {
			$presets[ 'lesser-than' ][] = $_REQUEST[ 'lesser-than' ];
		}

		if( isset( $_REQUEST[ 'greater-than' ] ) && count( $_REQUEST[ 'greater-than' ] ) ) {
			$presets[ 'greater-than' ][] = $_REQUEST[ 'greater-than' ];
		}

		if( isset( $_REQUEST[ 'equals' ] ) && count( $_REQUEST[ 'equals' ] ) ) {
			$presets[ 'equals' ][] = $_REQUEST[ 'equals' ];
		}

		if( isset( $_REQUEST[ 'contains' ] ) && count( $_REQUEST[ 'contains' ] ) ) {
			$presets[ 'contains' ][] = $_REQUEST[ 'contains' ];
		}

		$preset->setId( $_REQUEST[ 'preset_name' ] );
		$preset->setValue( json_encode( $presets ) );
		$preset->save( );

		$return[ "success" ] = true;
		$return[ "message" ] = $saving ? "Success! Your changes has been saved." : "Success! Your preset has been saved.";
		$return[ "preset" ]  = $preset->toArray( true );

		echo json_encode( $return );
		exit( 0 );
	}

	/**
	 * Display the user meta data on the table column
	 * @param Object $user     	User Object
	 * @param String $columnID 	Column ID
	 */
	public function showColumn( $user, $columnID ) {
		$val   = get_user_meta( $user->ID, $columnID, true );
		$data  = new TPC_Helper_DataType( $val );
		$table = new TPC_CRM_Admin_WPUserListTable( );
		$hidden = get_user_meta( get_current_user_id(), 'manageuserscolumnshidden', true );

		if( $data->isDate( ) ) {
			$html = date( 'F j, Y', strtotime( $val ) );
		} elseif( $data->isArray( ) ) {
			$html = @implode( ', ', $data->getData( ) );
		} elseif( $trim ) {
			$html = $val;
		} else {
			$html = '<p>&nbsp;</p>';
		}

		if( in_array( 'username', $hidden ) & $this->first == $columnID ) {
			$html .= $table->getEditHtml( $user );
		}
		return $html;
	}
}