<?php
/**
 * Database
 *
 * Database connection wrapper.
 *
 * @package Kvickt
 * @subpackage System
 * @license http://creativecommons.org/licenses/by-nc-sa/4.0/
 * @author Kenth Hagström <info@kenthhagstrom.se>
 * @version 1.0
 */
class Database extends PDO {

	/**
	 * Database Construct
	 *
	 * @access public
	 * @param $db_type string
	 * @param $db_host string
	 * @param $db_name string
	 * @param $db_user string
	 * @param $db_pass string
	 * @return void
	 */
	public function __construct( $db_type, $db_host, $db_name, $db_user, $db_pass ) {
		parent::__construct( $db_type.':host='.$db_host.';dbname='.$db_name, $db_user, $db_pass );
	}

	/**
	 * DELETE
	 *
	 * @access public
	 * @param $table string
	 * @param $where string
	 * @param $limit integer
	 * @return integer Number of affected rows
	 */
	public function delete( $table, $where, $limit = 1 ) {
		return $this->exec( "DELETE FROM $table WHERE $where LIMIT $limit" );
	}

	/**
	 * INSERT
	 *
	 * @access public
	 * @param $table string
	 * @param $data array An associative array with data to insert
	 * @return void
	 */
	public function insert( $table, $data ) {

		ksort( $data );

		$field_names = implode( '`, `', array_keys( $data ) );
		$field_values = ':' . implode( ', :', array_keys( $data ) );

		$sth = $this->prepare("INSERT INTO $table (`$field_names`) VALUES ($field_values)");

		foreach ( $data as $key => $value ) {
			$sth->bindValue( ":$key", $value );
		}
		$sth->execute();
	}

	/**
	 * SELECT
	 *
	 * @access public
	 * @param $sql string An SQL string
	 * @param $array array Parameters to bind as key => value pairs
	 * @param $fetch_mode constant A PDO fetch mode constant
	 * @return mixed
	 */
	public function select( $sql, $array = array(), $fetch_mode = PDO::FETCH_ASSOC ) {

		$sth = $this->prepare( $sql );

		foreach ( $array as $key => $value ) {
			$sth->bindValue("$key", $value);
		}
		$sth->execute();

		return $sth->fetchAll( $fetch_mode );
	}

	/**
	 * UPDATE
	 *
	 * @access public
	 * @param $table string
	 * @param $data array
	 * @param $where string
	 * @return void
	 */
	public function update( $table, $data, $where ) {

		ksort( $data );

		$field_details = NULL;
		foreach( $data as $key => $value ) {
			$field_details .= "`$key`=:$key,";
		}
		$field_details = rtrim( $field_details, ',' );

		$sth = $this->prepare( "UPDATE $table SET $field_details WHERE $where" );

		foreach( $data as $key => $value ) {
			$sth->bindValue( ":$key", $value );
		}

		$sth->execute();
	}
}