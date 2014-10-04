<?php
/**
 * TPC_Helper_WooCommerceLicenser
 *
 * A class to send and process response from the WooCommerce Licenser
 * API of The Portland Company.
 *
 * @author   Jon Falcon <darkutubuki143@gmail.com>
 * @package Customer Relationship Manager (Premium)
 * @version  1.0
 */
class TPCP_Helper_WooCommerceLicenser {
	/**
	 * License key
	 * @var string
	 */
	private $_key;

	/**
	 * Secret key
	 * @var string
	 */
	private $_secret;

	/**
	 * Email Address
	 * @var string
	 */
	private $_email;

	/**
	 * Instance key
	 * @var string
	 */
	private $_instance;

	/**
	 * Product ID
	 * @var integer
	 */
	private $_productID = 'TPCCRM';

	/**
	 * Additional parameters
	 * @var array
	 */
	private $_additionalParams = array( );

	/**
	 * Request headers
	 * @var array
	 */
	private $_request = array( );


	/**
	 * The API base url
	 * @var string
	 */
	private $_apiUrl = 'http://www.theportlandcompany.com/?wc-api=software-api';

	/**
	 * Instantiate this object
	 * @param string $key    License key
	 * @param string $secret Secret Key
	 * @param string $email  Email address
	 */
	public function __construct( $key = '', $secret = '', $email = '' ) {
		$this->setKey( $key );
		$this->setSecret( $secret );
		$this->setEmail( $email );
	}

	/**
	 * Sets the license key
	 * @param string $key License key
	 * @return  $this     Supports chaining
	 */
	public function setKey( $key ) {
		$this->_key = $key;

		return $this;
	}

	/**
	 * Sets the secret key
	 * @param string $secret Secret key
	 * @return  $this      Supports chaining
	 */
	public function setSecret( $secret ) {
		$this->_secret = $secret;

		return $this;
	}

	/**
	 * Sets the email address
	 * @param string $email Purchaser's email address
	 * @return  $this      	Supports chaining
	 */
	public function setEmail( $email ) {
		$this->_email = $email;

		return $this;
	}

	/**
	 * Sets the instance
	 * @param string $instance Instance of the activation
	 * @return  $this          Supports chaining
	 */
	public function setInstance( $instance ) {
		$this->_instance = $instance;

		return $this;
	}

	/**
	 * Add additional parameters
	 * @param string $id  
	 * @param string $val
	 * @return  $this      Supports chaining
	 */
	public function addParam( $id, $val ) {
		$this->_additionalParams[ $id ] = $val;

		return $this;
	}

	/**
	 * Checks if the parameter exists
	 * @param  string  $id 
	 * @return boolean     
	 */
	public function hasParam( $id ) {
		return isset( $id, $this->_additionalParams );
	}

	/**
	 * Gets the license key
	 * @return string License key
	 */
	public function getKey( ) {
		return $this->_key;
	}

	/**
	 * Gets the secret key
	 * @return string Secret key
	 */
	public function getSecret( ) {
		return $this->_secret;
	}

	/**
	 * Gets the email address
	 * @return string Purhcaser's email address
	 */
	public function getEmail( ) {
		return $this->_email;
	}

	/**
	 * Gets the instance
	 * @return strig 
	 */
	public function getInstance( ) {
		return $this->_instance;
	}

	/**
	 * Generates a random hash
	 * @return string 
	 */
	public function generateInstance( ) {
		return bin2hex( openssl_random_pseudo_bytes( 16 ) );
	}

	/**
	 * Generates a new license key
	 * @return object   			Decoded JSON reply from the server
	 */
	public function generateKey( ) {
		$this->_request                  = array();
		$this->_additionalParams         = array();
		
		$this->_request[ 'email' ]       = $this->_email;
		$this->_request[ 'request' ]    = 'generate_key';
		$this->_request[ 'secret_key' ]  = $this->_secret;
		$this->_request[ 'product_id' ]  = $this->_productID;
		
		$this->_request[ 'version' ]     = $this->_additionalParams[ 'version' ];
		$this->_request[ 'order_id' ]    = $this->_additionalParams[ 'order_id' ];
		$this->_request[ 'key_prefix' ]  = $this->_additionalParams[ 'key_prefix' ];
		$this->_request[ 'activations' ] = $this->_additionalParams[ 'activations' ];

		return $this->_sendRequest( );
	}

	/**
	 * Activates the license key
	 * @return object   			Decoded JSON reply from the server
	 */
	public function activate( ) {
		$this->_request                  = array();
		$this->_additionalParams         = array();
		
		$this->_request[ 'email' ]       = $this->_email;
		$this->_request[ 'request' ]    = 'activation';
		$this->_request[ 'product_id' ]  = $this->_productID;
		$this->_request[ 'licence_key' ] = $this->_key;
		
		$this->_request[ 'version' ]     = $this->_additionalParams[ 'version' ];
		$this->_request[ 'platform' ]    = $this->_additionalParams[ 'platform' ];
		$this->_request[ 'instance' ]    = $this->_additionalParams[ 'instance' ];
		$this->_request[ 'secret_key' ]  = $this->_additionalParams[ 'secret_key' ];

		return $this->_sendRequest( );
	}

	/**
	 * Resets the activation key
	 * @return object   			Decoded JSON reply from the server
	 */
	public function resetActivation( ) {
		$this->_request                  = array();
		$this->_additionalParams         = array();

		$this->_request[ 'email' ]       = $this->_email;
		$this->_request[ 'request' ]    = 'activation_reset';
		$this->_request[ 'product_id' ]  = $this->_productID;
		$this->_request[ 'licence_key' ] = $this->_key;

		return $this->_sendRequest( );
	}

	/**
	 * Deactivate the license
	 * @return object   			Decoded JSON reply from the server
	 */
	public function deactivate( ) {
		$this->_request                 = array();
		$this->_additionalParams        = array();
		
		$this->_request[ 'email' ]      = $this->_email;
		$this->_request[ 'request' ]   = 'deactivation';
		$this->_request[ 'product_id' ] = $this->_productID;
		$this->_request[ 'instance' ]   = $this->_instance;
		
		$this->_request[ 'product_id' ] = $this->_additionalParams[ 'product_id' ];
		$this->_request[ 'version' ]    = $this->_additionalParams[ 'version' ];
		$this->_request[ 'platform' ]   = $this->_additionalParams[ 'platform' ];

		return $this->_sendRequest( );
	}

	/**
	 * Sends the request
	 * @param  string $action Action
	 * @return void         
	 */
	private function _sendRequest( ) {
		$requestUri = $this->_apiUrl;

		foreach( $this->_request as $id => $val ) {
			if( trim( $val ) ) {
				$requestUri .= '&' . trim( $id ) . '=' . urldecode( $val );
			}
		}

		$data = wp_remote_get( $requestUri );

		if( is_wp_error( $data ) ) {
			return array( 'wp_error' => $data );
		} else {
			return @json_decode( $data[ 'body' ] );
		}
	}
}