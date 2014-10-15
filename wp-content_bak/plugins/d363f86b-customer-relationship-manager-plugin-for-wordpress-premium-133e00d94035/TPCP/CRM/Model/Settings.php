<?php
/**
 * TPCP_CRM_Model_Options
 * 
 * @package Customer Relationship Manager (Premium)
 * @author 	 : Jon Falcon <darkutubuki143@gmail.com>
 * @version  : 0.1.0
 */
class TPCP_CRM_Model_Settings {
	/**
	 * List of plugin settings
	 * @var array
	 */
	private $_settings;

	/**
	 * Initialize this object
	 */
	public function __construct( ) {
		$this->getOptions( );
	}

	/**
	 * Gets the settings and populate this object
	 * @return array 
	 */
	public function getOptions( ) {
		if( !$this->_settings ) {
			$options  = get_option( 'tpc-crm' );
			$table    = new TPC_CRM_Admin_UsersListTable( );

			$defaults = array(
					'column-set'      => 'default',
					'visible-columns' => array_keys( (array) $table->getColumns( ) ),
					'license-key'     => '',
					'license-email'   => '',
					'activated'       => false
				);

			$this->_settings = array_merge( $defaults, (array) $options );
		}
		return $this->_settings;
	}

	/**
	 * Gets the plugin settings
	 * @param  string $id      
	 * @param  mixed  $default 
	 * @return mixed          
	 */
	public function getOption( $id, $default = null ) {
		if( array_key_exists( $id, $this->_settings ) ) {
			return $this->_settings[ $id ];
		} else {
			return $default;
		}
	}

	/**
	 * Reset the default settings
	 * @return $this   Supports chaining
	 */
	public function flush( ) {
		$this->_settings = array( );
		return $this;
	}
}