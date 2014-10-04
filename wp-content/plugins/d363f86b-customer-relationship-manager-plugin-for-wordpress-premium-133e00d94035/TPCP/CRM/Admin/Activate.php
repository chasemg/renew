<?php
/**
 * TPC_CRM_Admin_Activate
 *
 * Adds the activation settings page
 *
 * @author   Jon Falcon <darkutubuki143@gmail.com>
 * @package Customer Relationship Manager (Premium)
 * @version  1.0
 */
class TPCP_CRM_Admin_Activate implements TPC_Interface_Runnable {
	/**
	 * Page link
	 * @var string
	 */
	private $_page;

	/**
	 * Instance of the WooCommerceLicenser
	 * @var Object
	 */
	private $_licenser;

	/**
	 * Plugin settings
	 * @var Object
	 */
	private $_settings;

	/**
	 * Instantiate this object
	 */
	public function __construct( ) {
		$this->_licenser = new TPCP_Helper_WooCommerceLicenser( );
		$this->_settings = new TPCP_CRM_Model_Settings( );
	}

	/**
	 * Run this module
	 */
	public function run( ) {
		add_action( 'admin_menu', array( $this, 'adminMenu' ) );
		add_action( 'admin_init', array( $this, 'adminInit' ) );
		add_action( 'wp_ajax_tpcp_validate_license_key', array( $this, 'validateLicenseKey' ) );
	}

	/**
	 * Register the options page to the admin menu
	 */
	public function adminMenu( ) {
		$this->_page = add_options_page( 
			__('Customer Relationship Manager (Premium)', TPC_CRM_SLUG ),
			__('CRM', TPC_CRM_SLUG ),
			'manage_options',
			'tpc-crm-settings',
			array( $this, 'adminPage' )
		);

		add_action( 'admin_print_styles-' . $this->_page, array( $this, 'adminStyles' ) );
		add_action( 'admin_print_scripts-' . $this->_page, array( $this, 'adminScripts' ) );
		add_action( 'admin_footer-' . $this->_page, array( $this, 'foot' ), 20 );
	}

	/**
	 * Initializing the admin data
	 */
	public function adminInit( ) {
		/**
		 * jQuery Select Chosen
		 */
		wp_register_style( 'jquery-select-chosen-css'  , TPC_CRM_URL . '/assets/css/jquery-select-chosen.css' );
		wp_register_script( 'jquery-select-chosen'	   , TPC_CRM_URL . '/assets/js/jquery-select-chosen.min.js' );

		// Register the settings group
		register_setting( 'tpc-crm-settings', 'tpc-crm', array( $this, 'sanitize' ) );

		// Add General Information Section
		add_settings_section( 'general_info', 'General Settings', array( $this, 'settingsHeadingGeneral' ), 'tpc-crm-settings' );
		add_settings_field( 'column_set', 'Show columns', array( $this, 'settingsColumnSet' ), 'tpc-crm-settings', 'general_info', array( 'label_for' => 'tpc_crm_column_set') );
		add_settings_field( 'hidden_columns', 'Hidden Columns', array( $this, 'settingsHiddenColumns' ), 'tpc-crm-settings', 'general_info', array( 'label_for' => 'tpc_crm_hidden_columns') );

		// Add License Information Section
		add_settings_section( 'license_info', 'Product License Information', array( $this, 'settingsHeadingLicenseInfo' ), 'tpc-crm-settings' );
		add_settings_field( 'licence_key', 'License Key', array( $this, 'settingsLicenseKey' ), 'tpc-crm-settings', 'license_info', array( 'label_for' => 'tpc_crm_license_key') );
		add_settings_field( 'licence_email', 'Email', array( $this, 'settingsLicenseEmail' ), 'tpc-crm-settings', 'license_info', array( 'label_for' => 'tpc_crm_license_email') );
	}

	/**
	 * Add styles
	 */
	public function adminStyles( ) {
		wp_enqueue_style( 'jquery-select-chosen-css' );
	}

	/**
	 * Add scripts
	 */
	public function adminScripts( ) {
		wp_enqueue_script( 'jquery-select-chosen' );
	}

	/**
	 * Sanitize the submitted settings 
	 */
	public function sanitize( $input ) {
		$input[ 'column-set' ]     = sanitize_text_field( $input[ 'column-set' ] );
		$input[ 'visible-columns'] = (array) ( isset( $input[ 'visible-columns' ] ) ? $input[ 'visible-columns' ] : array( ) );
		$input[ 'license-key']     = sanitize_text_field( $input[ 'license-key'] );
		$input[ 'license-email' ]  = sanitize_email( $input[ 'license-email' ] );
		$input[ 'activated' ]      = $this->_settings->getOption( 'activated' );
		
		$old_license_key           = $this->_settings->getOption( 'license-key' );
		$old_license_email         = $this->_settings->getOption( 'license-email' );

		update_user_meta( get_current_user_id(), 'manageuserscolumnshidden', $input[ 'hidden-columns' ] );
		unset( $input[ 'hidden-columns' ] );

		if( $old_license_email != $input[ 'license-email' ] || $old_license_key != $input[ 'license-key' ] ) {
			$this->_licenser->setKey( $input[ 'license-key' ] );
			$this->_licenser->setEmail( $input[ 'license-email' ] );

			$reply = $this->_licenser->activate( );
			if( $reply->activated ) {
				$input[ 'activated' ] = true;
			} else {
				$input[ 'activated' ] = false;
			}
		}

		return $input;
	}

	/**
	 * General Settings Heading
	 */
	public function settingsHeadingGeneral( ) { }

	public function settingsColumnSet( ) {
		$table   = new TPCP_Helper_UsersListTable( new TPC_CRM_Admin_UsersListTable( ) );
		$columns = $table->getAllColumns( '' );
		$show    = array(
				"default" => "Only show default wordpress columns",
				"all"     => "Show all the user metas",
				"custom"  => "Select which field(s) to be displayed"
			);

		echo '<select id="tpc_crm_column_set" name="tpc-crm[column-set]" class="chosen">';
		foreach( $show as $id => $label ) {
			echo '<option value="' . $id . '"';
			if( $this->_settings->getOption( 'column-set' ) == $id ) {
				echo ' selected';
			}
			echo '>' . $label . '</label>';
		}
		echo '</select>';

		echo '<div id="tpc_crm_visible_columns">';
		echo '<br>';
		echo '<p class="description">Choose the columns to show</p>';
		echo '<select name="tpc-crm[visible-columns][]" class="chosen-multiple" data-placeholder="Select columns to display" multiple>';
		foreach( $columns as $id => $data ) {
			echo '<option value="' . $id . '"';
			if( in_array( $id, $this->_settings->getOption( 'visible-columns' ) ) ) {
				echo ' selected';
			}
			echo '>' . ( $data[ 'title' ] ? $data[ 'title' ] : ucwords( str_replace( '_', ' ', $id ) ) ) . '</option>';
		}
		echo '</select>';
		echo '</div>';
	}

	public function settingsHiddenColumns( ) {
		$hiddenColumns = get_user_meta( get_current_user_id(), 'manageuserscolumnshidden', true );
		$table         = new TPCP_Helper_UsersListTable( new TPC_CRM_Admin_UsersListTable( ) );
		$columns       = $table->getAllColumns( '' );
		echo '<select id="tpc_crm_hidden_columns" name="tpc-crm[hidden-columns][]" class="chosen-multiple" data-placeholder="Select columns to hide" multiple>';
		foreach( $columns as $id => $data ) {
			echo '<option value="' . $id . '"';
			if( in_array( $id, $hiddenColumns ) ) {
				echo ' selected';
			}
			echo '>' . ( $data[ 'title' ] ? $data[ 'title' ] : ucwords( str_replace( '_', ' ', $id ) ) ) . '</option>';
		}
		echo '</select>';
	}

	/**
	 * Enter license key
	 */
	function settingsLicenseKey( ) {
		$val = $this->_settings->getOption( 'license-key' );


		echo '<input type="text" name="tpc-crm[license-key]" id="tpc_crm_license_key"';
		if( !$this->isActive( ) ) {
			echo ' style="border: 1px solid #dd3d36"';
		}
		echo ' value="' . $val . '">';

		if( $this->isActive( ) ) {
			echo '<span id="validation-message" style="color: #3c763d;"><i class="dashicons dashicons-yes"></i> Product Activated</span>';
		} else {
			echo '<span id="validation-message" style="color: #dd3d36;"><i class="dashicons dashicons-dismiss"></i> Invalid license key and email combination.</span>';
		}
	}

	/**
	 * Enter license email
	 */
	function settingsLicenseEmail( ) {
		$val = $this->_settings->getOption( 'license-email' );
		echo '<input type="email" name="tpc-crm[license-email]" id="tpc_crm_license_email" value="' . $val . '">';
		echo '&nbsp;&nbsp; <button type="button" id="validate_license_key" class="button button-primary">Validate</button>';
	}

	/**
	 * Settings Heading
	 */
	public function settingsHeadingLicenseInfo( ) {
		echo '<p class="description">Enter the license key and your email address to activate this plugin.</p>';
	}

	/**
	 * Add some additional footer scripts
	 * @return [type] [description]
	 */
	public function foot( ) {
		?>
			<script type="text/javascript">
				( function( $) {
					var ajax              = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
					var loadingIcon       = "<?php echo TPCP_CRM_URL ?>/assets/img/wpspin_light.gif";
					var columnSet         = $( '#tpc_crm_column_set' );
					var visibleColumns    = $( '#tpc_crm_visible_columns' );
					var validationBtn     = $( '#validate_license_key' );
					var validationMsg     = $( '#validation-message' );
					var licenseKeyInput   = $( '#tpc_crm_license_key' );
					var licenseEmailInput = $( '#tpc_crm_license_email' );
					var validColor        = '#3c763d';
					var invalidColor      = '#dd3d36';

					var toggleVisibleColumnsDropdown = function ( val ) {
						val = val || columnSet.val( );
						if( val == "custom" ) {
							visibleColumns.slideDown( 'fast' );
						} else {
							visibleColumns.slideUp( 'fast' );
						}
					}

					var validateLicenseKey = function( key, email ) {
						return $.post( ajax, { action: 'tpcp_validate_license_key', license_key : key, license_email : email } );
					}

					$( document ).ready( function( ) {
						$( '.chosen' ).chosen( );
						$( '.chosen-multiple' ).chosen( {
							width: '90%'
						} );

						toggleVisibleColumnsDropdown();
						columnSet.change( function( ) {
							toggleVisibleColumnsDropdown( $( this ).val( ) );
						} );

						validationBtn.click(function( ) {
							var oldButtonText = validationBtn.html( );
							validationBtn.html( '<img src="' + loadingIcon + '">' );
							validateLicenseKey( licenseKeyInput.val( ), licenseEmailInput.val( ) )
								.done( function( response ) {
									validationBtn.html( oldButtonText );
									console.log( response, validationMsg );
									if( response.success ) {
										validationMsg.css( { color : validColor } ).html( '<i class="dashicons dashicons-yes"></i> ' + response.message );
									} else {
										validationMsg.css( { color : invalidColor } ).html( '<i class="dashicons dashicons-dismiss"></i> ' +  response.message );
									}
								} )
								.fail( function( ) {
									validationBtn.html( oldButtonText );
									validationMsg.css( { color : invalidColor } ).html( '<i class="dashicons dashicons-dismiss"></i> Unable to connect to the web server. Please check your connection and try again later.' );
								} );
						} );
					} );

				} )( jQuery );
			</script>
		<?php
	}

	public function validateLicenseKey( ) {
		header( 'Content-type: application/json' );
		$return       = array( "success" => false, 'message' => 'Unknown command' );
		$licenseKey   = isset( $_POST[ 'license_key'] ) ? $_POST[ 'license_key' ] : '';
		$licenseEmail = isset( $_POST[ 'license_email' ] ) ? $_POST[ 'license_email' ] : '';
		$settings     = $this->_settings->getOptions( );

		if( $old_license_email != $licenseKey || $old_license_key != $licenseEmail ) {
			$this->_licenser->setKey( $licenseKey );
			$this->_licenser->setEmail( $licenseEmail );
			
			$settings[ 'license-key' ]   = $licenseKey;
			$settings[ 'license-email' ] = $licenseEmail;

			$reply = $this->_licenser->activate( );
			if( $reply->activated ) {
				$return[ 'message' ]     = "Success! License activated.";
				$return[ 'success' ]     = true;
				$settings[ 'activated' ] = true;
			} else {
				$return[ "message"]      = "Invalid license key and email combination.";
				$settings[ 'activated' ] = false;
			}
			update_option( 'tpc-crm', $settings );

		} else {
			$return[ 'success' ] = false;
			$return[ 'message' ] = "There's nothing to do. License and email are not changed.";
		}

		echo json_encode( $return );
		exit( );
	}

	/**
	 * Settings page
	 */
	public function adminPage( ) {
		?>
			<div class="wrap">
				<h2>Free Customer Relationship Manager Settings</h2>
				<form action="options.php" method="POST">
					<?php
						settings_fields( 'tpc-crm-settings' );
						do_settings_sections( 'tpc-crm-settings' );
						submit_button( );
					?>
				</form>
			</div>
		<?php
	}

	/**
	 * Return the settings
	 * @return array
	 */
	public function getSettings( ) {
		return $this->_settings;
	}

	/**
	 * Checks if the license is activated
	 * @return boolean 
	 */
	public function isActive( ) {
		return $this->_settings->getOption( 'activated' );
	}

	/**
	 * Return the admin page url
	 * @return string 
	 */
	public function getPage( ) {
		return $this->_page;
	}
}