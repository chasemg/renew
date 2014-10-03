<?php
/**
 * Plugin Name: Customer Relationship Manager (Premium)
 * Plugin URI: http://www.theportlandcompany.com/product/customer-relationship-manager-plugin-for-wordpress
 * Description: Premium CRM
 * Author: The Portland Company
 * Author URI: http://www.theportlandcompany.com
 * Version: 1.1.0
 */
if( class_exists( 'TPC_Autoloader_LoaderClass' ) ):

defined( 'TPCP_CRM_ROOT'      ) or define( 'TPCP_CRM_ROOT'	   , dirname( __FILE__ ) );
defined( 'TPCP_CRM_URL'       ) or define( 'TPCP_CRM_URL' 	   , plugins_url( basename( TPCP_CRM_ROOT ) ) );
defined( 'TPCP_CRM_SLUG'      ) or define( 'TPCP_CRM_SLUG'	   , 'tpcp-crm' );
defined( 'TPCP_CRM_INSTALLED' ) or define( 'TPCP_CRM_INSTALLED', true );

require_once( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'start.php' );

function tpcp_crm_load( ) {
	$activate = new TPCP_CRM_Admin_Activate( );
	$activate->run( );

	if( $activate->getSettings( )->getOption( 'activated' ) ) {
		// Run the Admin Users Module
		$adminUsers = new TPCP_CRM_Admin_Users( );
		$adminUsers->run();

		$autoupdate = new TPC_Helper_AutoUpdate( 'http://wp-updates.com/api/2/plugin', plugin_basename(__FILE__) );
	} else {
		function tpcp_not_activate( ) {
			echo '<div class="error">';
			echo '<p>' . sprintf(
					__( 'Please enter your <a href="%s">license key</a> to activate Customer Relationship Manager (Premium). <a href="%s" class="button button-primary">Click here</a> to get started.', TPCP_CRM_SLUG ),
					admin_url( 'options-general.php?page=tpc-crm-settings' ),
					admin_url( 'options-general.php?page=tpc-crm-settings' )
				) . '</p>';
			echo '</div>';
		}
		add_action( 'admin_notices', 'tpcp_not_activate' );
	}

}
add_action( 'tpc_crm_before_load', 'tpcp_crm_load');

// Installation
function tpcp_crm_install( ) {
	global $wpdb;

	$presetTable = $wpdb->prefix . TPCP_CRM_Model_Preset::TABLE;
	
	$sql         = "CREATE TABLE IF NOT EXISTS `{$presetTable}` (
		  `name` varchar(100) NOT NULL,
		  `value` text NOT NULL,
		  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  PRIMARY KEY (`name`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
	update_option( '_tpcp_crm_version', '1.1.0' );
}
register_activation_hook( __FILE__, 'tpcp_crm_install' );

// Deactivation
function tpcp_crm_uninstall( ) {
	update_option( '_tpcp_crm_version', 0 );
}
register_deactivation_hook( __FILE__, 'tpcp_crm_uninstall' );

else:

endif;
/**
 * Check if TPC CRM is active and/or installed
 */
function tpcp_no_tpc_installed( ) {
	$tpc_version = get_option( '_tpc_crm_version' );
	if( !$tpc_version ) {
		echo '<div class="error">';
		echo '<p>' . sprintf( __( 'You have the Premium version of the Customer Relationship Manager Plugin for WordPress activated but you need to <a href="%s">install and activate the Free version</a> as well.', TPCP_CRM_SLUG ), admin_url( 'plugins.php' ) ) . '</p>';
		echo '</div>';
	}
}
add_action( 'admin_notices', 'tpcp_no_tpc_installed' );
