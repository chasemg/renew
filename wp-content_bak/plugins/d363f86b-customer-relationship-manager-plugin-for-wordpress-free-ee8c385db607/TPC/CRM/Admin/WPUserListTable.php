<?php
if( !class_exists( 'WP_Users_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-users-list-table.php' );
}

/**
 * TPC_CRM_Admin_WPUserListTable
 *
 * Extends the WP_Users_List_Table class so we can add our own custom filters.
 *
 * @package  : Customer Relationship Manager (Free)
 * @author   Jon Falcon <darkutubuki143@gmail.com>
 * @version  1.0
 */
class TPC_CRM_Admin_WPUserListTable extends WP_Users_List_Table {
	/**
	 * List of extra info
	 * @var array
	 */
	private $extras = array( );

	/**
	 * Prepare the users list for display.
	 *
	 * @source WP_User_List_Table
	 * @since 3.1.0
	 * @access public
	 */
	function prepare_items( ) {
		global $role, $usersearch, $wpdb;

		// a nifty hack to fix the referrer
		$_SERVER['REQUEST_URI'] = admin_url( 'users.php' );

		$request        = new TPC_Helper_Array( $_REQUEST );
		$usersearch     = $request->get( "sSearch", $request->get( "s" ) );
		$role           = $request->get( "role" );
		$per_page       = ( $this->is_site_users ) ? 'site_users_network_per_page' : 'users_per_page';
		$users_per_page = $this->get_items_per_page( $per_page );
		$paged          = $this->get_pagenum();
		$number         = $request->get( "iDisplayLength", $users_per_page );
		$offset         = $request->get( "iDisplayStart", 0 );
		$totalRecords   = $wpdb->get_var( sprintf( "SELECT COUNT(*) FROM `%s`", $wpdb->users ) );

		// We only allow one sortable column
		list( $columns, $hidden, $sortable ) = $this->get_column_info( );
		$columnsArr                          = array_values( $columns );
		$sortColumnIndex                     = $request->get( "iSortCol_0", 1 );
		$sortColumnOrder                     = $request->get( "sSortDir_0", "asc" );
		$sortColumnName                      = $columnsArr[ $sortColumnIndex ];
		$sortColumnID                        = $columns[ $sortColumnIndex ];
		$isRefreshed                         = $request->get( "bRefreshed" );
		$this->extras[ "refreshed" ]         = $isRefreshed;
		$this->extras[ "columns" ]           = $columnsArr;
		$this->extras[ "sort_index" ]        = $sortColumnIndex;
		$this->extras[ "sort_id" ]           = $sortColumnID;
		$this->extras[ "sort_name" ]         = $sortColumnName;
		$this->extras[ "sort_order"]         = $sortColumnOrder;

		$_REQUEST[ "orderby" ]               = $sortColumnName;
		$_REQUEST[ "order" ]                 = $sortColumnOrder;

		switch( $sortColumnID ) {
			case "username":
				$orderby = "login";
				break;
			case "posts":
				$orderby = "post_count";
				break;
			default:
				$orderby = strtolower( $sortColumnID );
		}
		
		$args = array(
			'number'  => $number,
			'offset'  => $offset,
			'role'    => $role,
			// 'search'  => $usersearch,
			'orderby' => $orderby,
			'order'   => $order,
			'fields'  => 'all_with_meta'
		);

		if ( '' !== $args['search'] )
			$args['search'] = '*' . $args['search'] . '*';

		if ( $this->is_site_users )
			$args['blog_id'] = $this->site_id;

		if ( isset( $_REQUEST['orderby'] ) )
			$args['orderby'] = $_REQUEST['orderby'];

		if ( isset( $_REQUEST['order'] ) )
			$args['order'] = $_REQUEST['order'];


		// Query the user IDs for this page
		$wp_user_search = new WP_User_Query( apply_filters( 'tpc_crm_user_query_args', $args ) );
		$this->items    = $wp_user_search->get_results();

		$this->extras[ "total_records" ] = $totalRecords;
		$this->extras[ "total_items" ]   = $wp_user_search->get_total( );
		$this->extras[ "number"]         = $number;
		$this->extras[ "offset" ]        = $offset;

		$this->set_pagination_args( array(
			'total_items' => $this->extras[ "total_items" ],
			'per_page'    => $users_per_page,
		) );
	}

	/**
	 * Returns the hidden columns
	 * @return array
	 */
	public function getHiddenColumns( ) {
		list( $columns, $hidden ) = $this->get_column_info();
		$keys = array_keys( $columns );
		$hide = array( );
		foreach( $hidden as $h ) {
			$pos          = (string) array_search( $h, $keys );
			$hide[ $pos ] = $h;
		}

		return $hide;
	}

	public function getExtraInfo( ) {
		return $this->extras;
	}

	/**
	 * Return the rows and columns in an array format
	 * @return array 
	 */
	public function getRows( ) {
		ob_start( );
		$this->display_rows( );
		$rows    = ob_get_clean( );
		$columns = array( );
		$hidden  = $this->getHiddenColumns( );
		$hasNoLink = in_array( 'username', $hidden );
		
		preg_match_all( '/\<tr[^\>]*>(.*)\<\/tr\>/', $rows, $matches );
		foreach( $matches[1] as $i => $row ) {
			$row    = preg_replace( '/(\<(th|td)[^\>]*\>)/', '##newline##', $row );
			$row    = preg_replace( '/(\<\/(th|td)>)/', '', $row );
			$column = explode( '##newline##', $row );

			$cb     = array_shift( $column );

			if( $hasNoLink ) {
				if( preg_match( "/value='(\d+)\'/", $column[ 0 ], $value ) ) {
					$column[ 2 ] .= $this->getEditHtml( intval( $value[ 1 ] ) );
				}
			}
			$columns[ $i ] = $column;
		}

		return $columns;
	}

	/**
	 * Create the edit html
	 * @param  Integer|Object $user_object 
	 * @return String         
	 */
	public function getEditHtml( $user_object ) {
		if ( !( is_object( $user_object ) && is_a( $user_object, 'WP_User' ) ) )
			$user_object = get_userdata( (int) $user_object );
		$user_object->filter = 'display';
		$email = $user_object->user_email;

		if ( $this->is_site_users )
			$url = "site-users.php?id={$this->site_id}&amp;";
		else
			$url = 'users.php?';

		// Check if the user for this row is editable
		$edit    = '<div class="row-actions"><p>';
		$actions = array( );
		if ( current_user_can( 'list_users' ) ) {
			// Set up the user editing link
			$edit_link = esc_url( add_query_arg( 'wp_http_referer', urlencode( wp_unslash( $_SERVER['REQUEST_URI'] ) ), get_edit_user_link( $user_object->ID ) ) );

			if ( current_user_can( 'edit_user',  $user_object->ID ) ) {
				$actions[] .= '<a href="' . $edit_link . '">' . __( 'Edit' ) . '</a>';
			}

			if ( !is_multisite() && get_current_user_id() != $user_object->ID && current_user_can( 'delete_user', $user_object->ID ) )
				$actions[] .= "<a class='submitdelete' href='" . wp_nonce_url( "users.php?action=delete&amp;user=$user_object->ID", 'bulk-users' ) . "'>" . __( 'Delete' ) . "</a>";
			if ( is_multisite() && get_current_user_id() != $user_object->ID && current_user_can( 'remove_user', $user_object->ID ) )
				$actions[] = "<a class='submitdelete' href='" . wp_nonce_url( $url."action=remove&amp;user=$user_object->ID", 'bulk-users' ) . "'>" . __( 'Remove' ) . "</a>";

			$edit .= implode( " | ", $actions );
		}
		$edit .= '</p></div>';
		return $edit;
	}
}