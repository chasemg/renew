<?php
/**
 * Plugin Name: Customer Relationship Manager (Free)
 * Plugin URI: http://www.theportlandcompany.com/product/customer-relationship-manager-plugin-for-wordpress
 * Description: The CRM Plugin for WordPress is an unobtrusive application that extends the native WordPress Users section to provide better sorting, filtering and search utilities for a variety of purposes such as business professionals who want to track and organize their sales leads with ease.
 * Author: The Portland Company
 * Author URI: http://www.theportlandcompany.com
 * Version: 1.1.2
 */
defined( 'TPC_CRM_ROOT'	 	 ) or define( 'TPC_CRM_ROOT'  	 , dirname( __FILE__ ) );
defined( 'TPC_CRM_URL' 	 	 ) or define( 'TPC_CRM_URL'   	 , plugins_url( basename( TPC_CRM_ROOT ) ) );
defined( 'TPC_CRM_SLUG'   	 ) or define( 'TPC_CRM_SLUG'	 , 'tpc-crm' );
defined( 'TPC_CRM_INSTALLED' ) or define( 'TPC_CRM_INSTALLED', true );

require_once( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'start.php' );

$adminNotices = new TPC_CRM_Admin_Notices( );
$isUserNotified = ( bool ) get_option( '_tpc_is_notified' );

if( !$isUserNotified ) {
	if( !function_exists( 'is_plugin_inactive' ) ) {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	}

	$tpcp_version = get_option( '_tpcp_crm_version' );
	if( !$tpcp_version ) {
		$adminNotices->addError( sprintf( __( 'Upgrade to <a href="%s">Customer Relationship Manager (Premium)</a> to get more features.', TPC_CRM_SLUG ), 'http://www.theportlandcompany.com/product/customer-relationship-manager-plugin-for-wordpress' ) );
	}

	if( !file_exists( dirname( dirname( __FILE__ ) ) . '/advanced-custom-fields/acf.php' ) ) {
		$adminNotices->addError( sprintf( __( 'Install <a href="%s">Advanced Custom Fields</a> to get more features.', TPC_CRM_SLUG ), admin_url( 'plugin-install.php?tab=search&s=Advanced+Custom+Fields&plugin-search-input=Search+Plugins' ) ) );
	} else if( is_plugin_inactive( 'advanced-custom-fields/acf.php' ) ) {
		$adminNotices->addError( sprintf( __( 'Activate <a href="%s">Advanced Custom Fields</a> to get more features.', TPC_CRM_SLUG ), admin_url( 'plugins.php' ) ) );
	}

	update_option( '_tpc_is_notified', 1 );
}
$adminNotices->run();

/**
 * Add a hook to plugins_loaded
 */
function tpc_load( ) {
	do_action( 'tpc_crm_before_load' );

	$adminUsers = new TPC_CRM_Admin_Users();
	$adminUsers->run();

	$featurePointer = new TPC_CRM_Admin_FeaturePointers( );
	$featurePointer->run( );

	$autoupdate = new TPC_Helper_AutoUpdate( 'http://wp-updates.com/api/2/plugin', plugin_basename(__FILE__) );

	do_action( 'tpc_crm_loaded' );
}
add_action( 'plugins_loaded', 'tpc_load' );


// Installation
function tpc_crm_install( ) {
	update_option( '_tpc_crm_version', '1.1.2' );
}
register_activation_hook( __FILE__, 'tpc_crm_install' );

// Deactivation
function tpc_crm_uninstall( ) {
	update_option( '_tpc_crm_version', 0 );
}
register_deactivation_hook( __FILE__, 'tpc_crm_uninstall' );