<?php
/**
 * TPCP_CRM_Model_Preset
 *
 * A model class for the presets.
 *
 * @package Customer Relationship Manager (Premium)
 * @author 	 : Jon Falcon <darkutubuki143@gmail.com>
 * @version  : 0.1.0
 */
class TPCP_CRM_Model_Preset {
	/**
	 * A container for the $wpdb object
	 * @var object
	 */
	private $wpdb;

	/**
	 * Table name
	 * @var string
	 */
	private $tableName;

	/**
	 * Unique Identifier
	 * @var string
	 */
	private $id;

	/**
	 * Value
	 * @var JSON
	 */
	private $value;

	/**
	 * Date created and/or updated
	 * @var date
	 */
	private $date;

	/**
	 * A constant for the table name
	 */
	const TABLE = "users_filter_presets";

	/**
	 * Initialize the object
	 * @param string $id    	Optional. Preset Unique ID
	 */
	public function __construct( $id = '' ) {
		global $wpdb;
		$this->wpdb = $wpdb;

		$this->tableName = $this->wpdb->prefix . self::TABLE;

		if( $id instanceof stdClass ) {
			$this->populateByObject( $id );
		} elseif( trim( $id ) ) {
			$this->find( $id );
		}
	}

	/**
	 * Return the table name
	 * @return string   		Table Name
	 */	
	public function getTableName( ) {
		return $this->tableName;
	}

	/**
	 * Fetches all presets
	 * @param  array $option
	 * @return array         
	 */
	public function all( $option ) {
		$opt = new TPC_Helper_Array( $option );
		$sql = sprintf( "SELECT * FROM `%s`", $this->tableName );
		$res = $this->wpdb->get_results( $sql );
		$arr = array( );

		foreach( $res as $item ) {
			$preset = new TPCP_CRM_Model_Preset( $item );

			if( $opt->get( "toarray" ) == true ) {
				if( $opt->get( "decode" ) == true ) {
					$arr[ $item->name ] = $preset->toArray( true );
				} else {
					$arr[ $item->name ] = $preset->toArray( false );
				}
			} else {
				$arr[ $item->name ] = $preset;
			}
		}
		return $arr;
	}

	/**
	 * Finds the preset and return false if not found
	 * @param  string $id 			Preset Unique Identifier
	 * @return boolean|object     	Return this object if found, otherwise return false
	 */
	public function find( $id ) {
		$sql = sprintf( "SELECT * FROM `%s` WHERE `name` = '%s'", $this->tableName, $id );
		$res = $this->wpdb->get_row( $sql );

		if( $res->name ) {
			$this->populateByObject( $res );

			return $this;
		} else {
			return false;
		}
	}

	/**
	 * Populates this object from wpdb results
	 * @param  stdClass $obj
	 * @return $this        
	 */
	public function populateByObject( stdClass $obj ) {
		$this->id    = $obj->name;
		$this->value = $obj->value;
		$this->date  = $obj->date;

		return $this;
	}

	/**
	 * Sets the id
	 * @param string $id 	Unique identifier
	 * @return  $this    	Supports chaining
	 */
	public function setId( $id ) {
		$this->id = $id;
		return $this;
	}

	/**
	 * Sets the value
	 * @param string $value 	Preset Value
	 * @return  $this    		Supports chaining
	 */
	public function setValue( $value ) {
		$this->value = $value;
		return $this;
	}

	/**
	 * Gets the id
	 * @return  $this    	Supports chaining
	 */
	public function getId( ) {
		return $this->id;
	}

	/**
	 * Gets the value
	 * @param  boolean $decode 	Do you want to decode the value
	 * @return  $this    		Supports chaining
	 */
	public function getValue( $decode = false ) {
		return $decode ? json_decode( $this->value, true ) : $this->value;
	}

	/**
	 * Gets the date
	 * @return  $this    	Supports chaining
	 */
	public function getDate( ) {
		return $this->date;
	}

	/**
	 * Checks if the preset exists
	 * @param  string $id 	Unique identifier
	 * @return boolean     
	 */
	public function exists( $id = null ) {
		if( !$id ) {
			$id = $this->id;
		}

		return ( bool ) $this->wpdb->get_var( sprintf( "SELECT COUNT(*) FROM `%s` WHERE `name` = '%s'", $this->getTableName( ), $id ) );
	}

	/**
	 * convert this object to string
	 * @param  boolean $decode 	Do you want to decode the value?
	 * @return array          
	 */
	public function toArray( $decode = false ) {
		$id    = $this->getId( );
		$value = $this->getValue( $decode );
		$date  = $this->getDate( );

		return array(
				"id"    => $id,
				"value" => $value,
				"date"  => $date
			);
	}

	/**
	 * Saves the preset
	 */
	public function save( ) {
		$data = array(
				"name"  => $this->getId( ),
				"value" => $this->getValue( )
			);

		if( $this->exists( ) ){
			$this->wpdb->update( $this->getTableName( ), $data, array( "name" => $this->getId( ) ) );
		} else {
			$this->wpdb->insert( $this->getTableName( ), $data );
		}
	}

	/**
	 * Deletes the preset
	 * @return boolean
	 */
	public function delete( ) {
		if( $this->exists( ) ) {
			$this->wpdb->query( sprintf( "DELETE FROM `%s` WHERE `name` = '%s'", $this->getTableName(), $this->getId( ) ) );
			return true;
		}
		return false;
	}
}