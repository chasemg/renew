<?php
/**
 * TPCP_Helper_UserListTable
 *
 * @author  Jon Falcon <darkutubuki143@gmail.com>
 * @package Customer Relationship Manager (Premium)
 * @version  1.0
 */
class TPCP_Helper_UsersListTable {
	/**
	 * Placeholder for the UsersListTable
	 * @var object
	 */
	private $_listTable;

	/**
	 * Plugin settings
	 * @var Object
	 */
	private $_settings;

	/**
	 * List of illegal string
	 * @var array
	 */
	private $_illegal = array(
			 'rich_editing', 'comment_shortcuts', 'admin_color', 'use_ssl', 'show_admin_bar_front', 'wp_capabilities',
			 'wp_user_level', 'dismissed_wp_pointers', 'show_welcome_panel', 'wp_dashboard_quick_press_last_post_id',
			 'manageuserscolumnshidden', 'users_per_page', 'closedpostboxes_post', 'metaboxhidden_post' 
		);

	/**
	 * Initialize this object
	 * @param TPC_CRM_Admin_WPUserListTable $listTable 
	 */
	public function __construct( $listTable = null ) {
		if( $listTable ) {
			$this->addTable( $listTable );
		}
	}

	/**
	 * Add the table
	 * @param PC_CRM_Admin_UsersListTable $listTable 
	 */
	public function addTable( TPC_CRM_Admin_UsersListTable $listTable ) {
		$this->_listTable = $listTable;
		$this->_settings  = new TPCP_CRM_Model_Settings( );
	}

	/**
	 * Get the default columns
	 * @return array Default columns
	 */
	public function getDefaultColumns( ) {
		$table    = new TPC_CRM_Admin_UsersListTable( );
		return array_keys( (array) $table->getColumns( ) );
	}

	/**
	 * Get all the columns
	 * @param  Array|String $callback   Callback function
	 * @return array           
	 */
	public function getAllColumns( $callback, $useSettings = false ) {
		global $wpdb;

		$columnSet = $this->_settings->getOption( 'column-set' );

		if( $useSettings && $columnSet == 'default' ) {
			$addedCols = array( );
			foreach( $this->getDefaultColumns( ) as $id => $title ) {
				$addedCols[ $id ] = array (
						"id"    => $id,
						"title" => null,
						"cb"    => null
					);
			}

			return $addedCols;
		}

		$illegal         = $this->_illegal;
		$possibleColumns = $this->_listTable->getPossibleColumns( );
		$meta_keys       = $wpdb->get_results( sprintf( "SELECT DISTINCT `meta_key` as `key`, `meta_value` as `val` FROM `%s` GROUP BY meta_key", $wpdb->usermeta ), "OBJECT" );
		$addedCols       = array( );

		foreach( $possibleColumns as $id => $title ) {
			$addedCols[ $id ] = array (
						"id"    => $id,
						"title" => null,
						"cb"    => null
					);
		}

		foreach( $meta_keys as $meta ) {
			if( array_key_exists( $meta->key, $possibleColumns ) ) {
				$addedCols[ $meta->key ] = array (
						"id"    => $meta->key,
						"title" => null,
						"cb"    => null
					);
			} else if( preg_match( '/(field_|acf_).*/', $meta->val ) || preg_match( '/_tpc_.*/', $meta->key ) ) {
				continue;
			} else if( !in_array( $meta->key, $illegal ) ) {
				$addedCols[ $meta->key ] = array (
						"id"    => $meta->key,
						"title" => ucwords( str_replace( '_', ' ', $meta->key ) ),
						"cb"    => $callback
					);
			}
		}

		if( $useSettings && $columnSet == 'custom' ) {
			foreach( $addedCols as $id => $data ) {
				if( !in_array( $id, $this->_settings->getOption( 'visible-columns' ) ) ) {
					unset( $addedCols[ $id ] );
				}
			}
		}

		return $addedCols;
	}

	/**
	 * Only get the extended columns
	 * @param  String|Array $callback     Callback function
	 * @return array           
	 */
	public function getExtendedColumns( $callback, $useSettings = false ) {
		$default = $this->getDefaultColumns( );
		$columns = $this->getAllColumns( $useSettings );

		foreach( $default as $id => $name ) {
			if( array_key_exists( $id, $columns ) ) {
				unset( $columns[ $id ] );
			}
		}
		return $columns;
	}

	/**
	 * Get the re-ordered columns
	 * @param  String|Array $callback     Callback function
	 * @return array           
	 */
	public function getOrderedColumns( $callback, $useSettings = false ) {
		$columns = $this->getAllColumns( $callback, $useSettings );
		$user_id = get_current_user_id( );
		$order   = get_user_meta( $user_id, '_tpc_user_table_column_order', true );
		$ordered = array( );

		if( !empty( $order ) && count( $order ) ) {
			foreach( $order as $column ) {
				$id = $column[ 'id' ];
				if( array_key_exists( $id, $columns ) ) {
					$ordered[ $id ] = $columns[ $id ];
					unset( $columns[ $id ] );
				}
			}
		}

		$ordered = array_merge( $ordered, $columns );

		return $ordered;
	}
}